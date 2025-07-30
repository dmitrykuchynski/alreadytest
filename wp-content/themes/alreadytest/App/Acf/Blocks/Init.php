<?php

namespace App\Acf\Blocks;

final class Init {
	/**
	 * @var Helpers\BlockItem[]
	 */
	private static array $blocks = [
        General\Hero::class,
        General\LatestCars::class,
	];

	public function __construct()
	{
		/*
		** More info about acf bocks here: https://www.advancedcustomfields.com/resources/acf_register_block_type/
		*/
		foreach (self::$blocks as $block) {
			$block::setBlockParams();
		}
		RegisterBlock::init();

        add_action('enqueue_block_assets', [self::class, 'enqueueAssets']);
    }

    public static function enqueueAssets(): void
    {
        foreach (self::$blocks as $block) {
            if (method_exists($block, 'enqueueAssets')) {
                $block::enqueueAssets();
            }
        }
    }
}
