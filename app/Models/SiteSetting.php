<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $primaryKey = 'key';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['key', 'value'];

    public static function get(string $key, ?string $default = null): ?string
    {
        $setting = static::find($key);
        return $setting ? $setting->value : $default;
    }

    public static function set(string $key, ?string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public static function getJson(string $key, array $default = []): array
    {
        $raw = static::get($key);
        if (empty($raw)) {
            return $default;
        }
        $decoded = static::decodeCleanJson($raw);
        return is_array($decoded) ? $decoded : $default;
    }

    public static function setJson(string $key, array $data): void
    {
        $encoded = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        static::set($key, $encoded);
    }

    public static function decodeCleanJson(?string $raw): ?array
    {
        if (empty($raw)) {
            return null;
        }
        $decoded = json_decode($raw, true);
        if (is_array($decoded)) {
            return $decoded;
        }

        $stripped = stripslashes($raw);
        $d = json_decode($stripped, true);
        if (is_array($d)) {
            return $d;
        }

        // Robust normalization for literal escaped chars and unescaped control chars
        $len = strlen($raw);
        $inString = false;
        $escaped = false;
        $buf = '';
        for ($i = 0; $i < $len; $i++) {
            $ch = $raw[$i];
            if ($escaped) {
                $buf .= $ch;
                $escaped = false;
                continue;
            }
            if ($ch === '\\') {
                if ($inString) {
                    $buf .= $ch;
                    $escaped = true;
                } else {
                    $next = $i + 1 < $len ? $raw[$i + 1] : '';
                    if ($next === 'n' || $next === 'r' || $next === 't') {
                        $buf .= ' ';
                        $i++;
                    } else {
                        $buf .= $ch;
                    }
                }
                continue;
            }
            if ($ch === '"') {
                $inString = !$inString;
                $buf .= $ch;
                continue;
            }
            if ($inString) {
                $ord = ord($ch);
                if ($ord < 32) {
                    if ($ch === "\n") $buf .= '\n';
                    elseif ($ch === "\r") $buf .= '\r';
                    elseif ($ch === "\t") $buf .= '\t';
                    continue;
                }
            }
            $buf .= $ch;
        }

        $res = json_decode($buf, true);
        return is_array($res) ? $res : null;
    }
}
