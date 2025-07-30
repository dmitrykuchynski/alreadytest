<?php


/**
 * Init theme class
 */

namespace App;


use App\Base\Menu;

final class init {
	/**
	 * Store all the classes inside an array
	 * @return array Full list of classes
	 */
	private static function get_services(): array {
		// Array of classes needed to init
		return array(
			Options\Options::class,
			Base\Theme::class,
			Menu::class,
			Base\DisableXmlRPC::class,
			Base\Enqueue::class,
			Base\SvgSupport::class,
			Base\Deregister::class,
			CF7\CF7Init::class,
			Acf\Blocks\Init::class,
            Cars\Cars::class,
            Cars\CarsSearch::class,
        );
	}

	/**
	 * Loop through the classes, initialize them,
	 * and call the register() method if it exists
	 */
	public static function register_services() {
		// Init theme classes
		foreach ( self::get_services() as $class ) {
			new $class;
		}
	}
}
