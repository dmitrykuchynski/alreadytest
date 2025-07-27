<?php

namespace App\Base;


use SimpleXMLElement;

final class SvgSupport {

	public function __construct() {
		add_filter( 'upload_mimes', array( self::class, 'enableSvg' ) );
		add_action( 'admin_head', array( self::class, 'fixSvg' ) );
		add_filter( 'wp_get_attachment_image_src', array( self::class, 'fixWpGetAttachmentImageSvg' ), 10, 4 );

	}

	public static function enableSvg( $mimes ) {
		$mimes['svg'] = 'image/svg+xml';
		$mimes['svgz'] = 'image/svg+xml';

		return $mimes;
	}

	/**
	 * Fix svg image from being inserted with 1px width and 1px height
	 */
	public static function fixSvg()
    {
        echo '<style>
		  .attachment-266x266, .thumbnail img {
			   width: 100% !important;
			   height: auto !important;
		  }
		  </style>';
    }

	public static function fixWpGetAttachmentImageSvg( $image, $attachment_id, $size, $icon ) {
		if ( is_array( $image ) && preg_match( '/\.svg$/i', $image[0] ) && $image[1] <= 1 ) {
			if ( is_array( $size ) ) {
				$image[1] = $size[0];
				$image[2] = $size[1];
            }elseif ( ini_get( 'allow_url_fopen' ) && ( $xml = @simplexml_load_file( $image[0], SimpleXMLElement::class,  LIBXML_NOWARNING  ) ) !== false ) {
                $attr     = $xml->attributes();
				$viewbox  = explode( ' ', $attr->viewBox );
				$image[1] = isset( $attr->width ) && preg_match( '/\d+/', $attr->width, $value ) ? (int) $value[0] : ( count( $viewbox ) == 4 ? (int) $viewbox[2] : null );
				$image[2] = isset( $attr->height ) && preg_match( '/\d+/', $attr->height, $value ) ? (int) $value[0] : ( count( $viewbox ) == 4 ? (int) $viewbox[3] : null );
			} else {
				$image[1] = $image[2] = null;
			}
		}

		return $image;
	}

    /*
     * Returns inline svg by attachment id
     */

    public static function get_inline_svg_by_id( $attachment_id ) {
        $attachment_file = get_attached_file( $attachment_id );

        if ( ! $attachment_file ) {
            return '';
        }

        $parsed = parse_url( wp_get_attachment_url( $attachment_id ) );
        $url    = dirname( $parsed['path'] ) . '/' . rawurlencode( basename( $parsed['path'] ) );

        return file_get_contents( substr(ABSPATH, 0, -1) . $url );
    }

}
