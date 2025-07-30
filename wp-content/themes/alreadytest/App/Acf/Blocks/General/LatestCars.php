<?php

namespace App\Acf\Blocks\General;

use App\Acf\Blocks\Helpers\Block;
use App\Acf\Blocks\RegisterBlock;

final class LatestCars implements \App\Acf\Blocks\Helpers\BlockItem
{
    public static function setBlockParams(): void
    {
        RegisterBlock::addBlock(new Block(
            'latest-cars',
            'Latest Cars',
            'Displays the latest cars with filter',
            'templates/gutenberg/latest-cars.php',
            '/assets/css/gutenberg/latest-cars.min.css',
            '',
            [
                'align' => false,
                'mode' => true,
                'jsx' => true,
                'anchor' => true,
            ],
            [
                'title' => "Latest Cars",
                'description' => "Show last 4 cars with filter"
            ],
            '',
            'custom',
        ));
    }

    public static function enqueueAssets()
    {
        wp_enqueue_script(
            'latest-cars',
            get_template_directory_uri() . '/assets/js/gutenberg/latest-cars.min.js',
            ['jquery'],
            filemtime(get_template_directory() . '/assets/js/gutenberg/latest-cars.min.js'),
            true
        );

        wp_localize_script('latest-cars', 'localizeAlreadymedia', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('alreadymedia_nonce'),
        ]);
    }

}
