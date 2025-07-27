<?php

namespace App\Acf;

final class Acf {

	public static function isAcfPluginActivated() {
		if ( ! function_exists( 'is_plugin_active' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}

		if ( is_plugin_active( 'acf_pro/acf.php' ) ) {
			return true;
		}

		return false;
	}
}
