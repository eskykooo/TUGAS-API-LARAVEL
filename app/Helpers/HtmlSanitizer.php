<?php

namespace App\Helpers;

class HtmlSanitizer
{
    public static function sanitize(string $html): string
    {
        $allowed = '<p><br><b><i><u><s><em><strong><sub><sup>';
        $allowed .= '<h1><h2><h3><h4><h5><h6>';
        $allowed .= '<ul><ol><li>';
        $allowed .= '<blockquote><pre><code>';
        $allowed .= '<a><img>';
        $allowed .= '<table><thead><tbody><tr><th><td>';
        $allowed .= '<div><span><hr>';

        $html = strip_tags($html, $allowed);

        $html = preg_replace_callback('/<(\w+)([^>]*)>/', function ($m) {
            $tag = strtolower($m[1]);
            $attrs = trim($m[2]);
            if (! $attrs) {
                return "<$tag>";
            }

            $safe = [];
            $hasTargetBlank = false;

            if (preg_match('/href\s*=\s*"([^"]*)"/i', $attrs, $h)) {
                $href = $h[1];
                if (! preg_match('/^\s*(?:javascript|data|vbscript|blob|file)\s*:/i', $href)) {
                    $safe[] = 'href="'.htmlspecialchars($href, ENT_QUOTES, 'UTF-8').'"';
                }
            }
            if (preg_match('/src\s*=\s*"([^"]*)"/i', $attrs, $s)) {
                $src = $s[1];
                if (! preg_match('/^\s*(?:javascript|data|vbscript|blob|file)\s*:/i', $src)) {
                    $safe[] = 'src="'.htmlspecialchars($src, ENT_QUOTES, 'UTF-8').'"';
                }
            }
            if (preg_match('/alt\s*=\s*"([^"]*)"/i', $attrs, $a)) {
                $safe[] = 'alt="'.htmlspecialchars($a[1], ENT_QUOTES, 'UTF-8').'"';
            }
            if (preg_match('/target\s*=\s*"([^"]*)"/i', $attrs, $t)) {
                $target = strtolower($t[1]);
                $safe[] = 'target="'.htmlspecialchars($target, ENT_QUOTES, 'UTF-8').'"';
                if ($target === '_blank') {
                    $hasTargetBlank = true;
                }
            }
            if ($hasTargetBlank) {
                $safe[] = 'rel="noopener noreferrer"';
            } elseif (preg_match('/rel\s*=\s*"([^"]*)"/i', $attrs, $r)) {
                $safe[] = 'rel="'.htmlspecialchars($r[1], ENT_QUOTES, 'UTF-8').'"';
            }

            return '<'.$tag.($safe ? ' '.implode(' ', $safe) : '').'>';
        }, $html);

        return $html;
    }
}
