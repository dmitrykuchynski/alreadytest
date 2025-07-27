<?php

namespace App\SVG;

class SVG
{
    public static function get_svg_code($url): string
    {
        if(!self::is_svg($url)) {
            trigger_error("This image is not in svg format: $url", E_USER_NOTICE);
            return '';
        }

        $parsed = parse_url( $url );
        $path    = ABSPATH . dirname( $parsed['path'] ) . '/' . rawurlencode( basename( $parsed['path'] ) );
        $svg_file = file_get_contents($path);
        $find_string = '<svg';
        $position = strpos($svg_file, $find_string);
        return substr($svg_file, $position);
    }

    public static function is_svg($url): bool
    {
        return strpos($url, '.svg');
    }

    public static function get_image($image_id, $args = 'full') {
        if (empty($image_id)) return '';

        $image_url = wp_get_attachment_url( $image_id );
        if (empty($image_url)) return '';

        if (self::is_svg($image_url)) {
            return self::get_svg_code($image_url);
        } else {
            return wp_get_attachment_image($image_id, $args);
        }
    }
}
