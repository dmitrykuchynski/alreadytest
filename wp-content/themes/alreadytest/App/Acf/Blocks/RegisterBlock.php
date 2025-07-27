<?php

namespace App\Acf\Blocks;

use App\Acf\Acf;
use App\Acf\Blocks\Helpers\Block;

final class RegisterBlock {
	/**
	 * @var Block[]
	 */
	private static array $blocks;

	public static function init() {
		if ( Acf::isAcfPluginActivated() ) {
			add_action( 'acf/init', array( self::class, 'registerBlocks' ) );
			add_action( 'enqueue_block_editor_assets', array( self::class, 'add_block_editor_assets' ) );
		}
	}

	public static function registerBlocks() {
		foreach ( self::$blocks as $block ) {
			acf_register_block_type( $block->getArgs() );
		}
	}

	public static function addBlock( Block $block ) {
		self::$blocks[] = $block;
	}

	/**
	 * Load default styles for gutenberg acf
	 */
	public static function add_block_editor_assets() {
		wp_enqueue_script( 'defined-script', get_template_directory_uri() . '/dist/scripts/script.js', array( 'jquery' ), null, true );
		wp_enqueue_style( 'defined-style', get_template_directory_uri() . '/dist/styles/style.css', '' );
	}

}