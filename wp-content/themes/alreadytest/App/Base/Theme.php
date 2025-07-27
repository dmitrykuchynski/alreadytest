<?php

namespace App\Base;

final class Theme {


	public function __construct() {
		add_theme_support( 'menus' );
        add_theme_support( 'post-thumbnails' );
		add_filter('upload_mimes', [self::class, 'allowUploadSvg']);
        add_filter( 'show_admin_bar', '__return_false' );
	}


    public static function allowUploadSvg($file_types) {
        $new_filetypes = array();
        $new_filetypes['svg'] = 'image/svg+xml';
        $file_types = array_merge($file_types, $new_filetypes );
        return $file_types;
    }
}
