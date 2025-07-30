<?php

namespace App\Acf\Blocks\General;

use App\Acf\Blocks\Helpers\Block;
use App\Acf\Blocks\RegisterBlock;

final class OffersSection implements \App\Acf\Blocks\Helpers\BlockItem
{
    public static function setBlockParams(): void
    {
        RegisterBlock::addBlock(new Block(
            'offers-section',
            'Offers Section',
            'Displays the bookie offers section',
            'templates/gutenberg/offers-section.php',
            '/assets/css/gutenberg/offers-section.min.css',
            '/assets/js/gutenberg/offers-section.min.js',
            [
                'align' => false,
                'mode' => true,
                'jsx' => true,
                'anchor' => true,
            ],
            [
                'title' => "Offer Section",
                'description' => "Displays the bookie offer section"
            ],
            '',
            'custom',
        ));
    }
}
