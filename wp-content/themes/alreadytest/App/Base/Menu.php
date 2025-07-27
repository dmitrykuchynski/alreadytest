<?php

namespace App\Base;

use App\Acf\Acf;
use App\Helpers\Link;
use App\SVG\SVG;

final class Menu {
	public const MENUS = [
		'header'  => 'header-menu',
		'footer'       => 'footer-menu',
	];

	public function __construct() {
		add_action( 'init', [ self::class, 'registerMenus' ] );
	}

	public static function registerMenus() {
		register_nav_menus(
			array(
				self::MENUS['header']  => __( 'Header Menu', TM_TEXTDOMAIN ),
				self::MENUS['footer']       => __( 'Footer Menu', TM_TEXTDOMAIN ),
			)
		);
	}

	public static function get_header_menu() {
		wp_nav_menu( array(
			'theme_location' => self::MENUS['header'],
			'container'      => 'nav',
		) );
	}

	public static function get_header_btn($class = '', $icon = '') {
		if ( ! Acf::isAcfPluginActivated() ) {
			return '';
		}

		$btn_args = get_field( 'header_btn', 'option' );

    if( ! $btn_args ) {
      return '';
    }
		$btn_html = Link::get_acf_link( $btn_args, $class, $icon );

		return $btn_html;
	}

	public static function get_footer_menu() {
		wp_nav_menu( array(
			'theme_location' => self::MENUS['footer'],
			'container'      => 'nav',
			'container_class'=> 'footer__menu-nav'
		) );
	}
}
