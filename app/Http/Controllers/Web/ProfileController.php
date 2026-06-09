<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'avatar' => 'nullable|string',
        ]);

        if ($request->filled('avatar')) {
            try {
                $avatarData = $request->input('avatar');
                if (preg_match('/^data:image\/(\w+);base64,/', $avatarData, $matches)) {
                    if ($user->avatar) {
                        Storage::disk('public')->delete($user->avatar);
                    }
                    $imageData = base64_decode(substr($avatarData, strpos($avatarData, ',') + 1));
                    $filename = 'avatars/'.\Illuminate\Support\Str::random(40).'.webp';
                    $image = \imagecreatefromstring($imageData);
                    if ($image) {
                        $tempPath = sys_get_temp_dir().'/'.\Illuminate\Support\Str::random(40).'.webp';
                        \imagewebp($image, $tempPath, 80);
                        \imagedestroy($image);
                        Storage::disk('public')->put($filename, file_get_contents($tempPath));
                        unlink($tempPath);
                        $data['avatar'] = $filename;
                    }
                }
            } catch (\Exception $e) {
                return redirect('/profile')->with('error', 'Gagal mengupload foto profil: '.$e->getMessage());
            }
        } else {
            unset($data['avatar']);
        }

        $user->update($data);

        return redirect('/profile')->with('success', 'Profil berhasil diperbarui!');
    }

    public function editSecurity()
    {
        return view('profile.security', ['user' => Auth::user()]);
    }

    public function updateSecurity(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'current_password' => 'required|string|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update(['password' => Hash::make($data['password'])]);

        return redirect('/profile/security')->with('success', 'Password berhasil diperbarui!');
    }
}
