<?php

namespace App\Base;

final class Enqueue
{

    public function __construct()
    {
        add_action('wp_enqueue_scripts', [self::class, 'enqueueStyles']);
        add_action('wp_enqueue_scripts', [self::class, 'enqueueScripts']);
    }

    public static function enqueueStyles()
    {
	    wp_enqueue_style('global', get_template_directory_uri() . '/assets/css/global.min.css', array(), filemtime(get_template_directory() . '/assets/css/global.min.css'));

//	    if( is_404() ) {
//	       wp_enqueue_style( '404', get_template_directory_uri() . '/assets/css/404.min.css', array(), filemtime( get_template_directory() . '/assets/css/404.min.css' ) );
//       }
    }

    public static function enqueueScripts()
    {
	    wp_enqueue_script('global', get_template_directory_uri() . '/assets/js/global.min.js', array(), filemtime(get_template_directory() . '/assets/js/global.min.js'), [ 'in_footer' => true ]);

//	   if (is_404()) {
//            wp_enqueue_script('404-js', get_template_directory_uri() . '/assets/js/404.min.js', array(), filemtime(get_template_directory() . '/assets/js/404.min.js'), [ 'in_footer' => true ]);
//        }
    }
}
