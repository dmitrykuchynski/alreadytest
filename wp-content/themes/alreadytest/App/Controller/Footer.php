<?php

namespace App\Controller;

use App\Acf\Acf;
use App\Helpers\Link;
use App\SVG\SVG;

final class Footer {

	public static function getCopyright(): string {
		if ( ! Acf::isAcfPluginActivated() ) {
			return '';
		}
		$text = get_field( 'footer_copyright', 'option' );
		return sprintf( '<p class="footer__copyright-text">© %s %s</p>', date("Y"), esc_html__( $text, TM_TEXTDOMAIN ) );
	}

	public static function getLogo(): string {
		if ( ! Acf::isAcfPluginActivated() ) {
			return '';
		}
		$logo_id = get_field( 'footer_logo', 'option' );
		return  SVG::get_image( $logo_id, 'full' );
	}

	public static function getFooterContacts(): string {
		if ( ! Acf::isAcfPluginActivated() ) {
			return '';
		}
		$data = get_field( 'footer_contacts', 'option' );
		$html = '';
		if ( !empty( $data['title'] ) ) {
			$title ='<h4 class="footer__contacts-title">' . $data['title'] . '</h4>';
			$html .= $title;
		}

		if( !empty( $data['contact_groups']) && !empty( $data['contact_groups'][0] ) ) {
			$contact_list = '<ul class="footer__contacts-list">';
			foreach ( $data['contact_groups'] as $contact ) {
				if( empty( $contact['title'] ) && empty( $contact['link'] ) ) continue;
				$contact_list .= '<li>';
				if( ! empty( $contact['title'] ) ) $contact_list .= '<h4 class="footer__contact-title">' . $contact['title'] . '</h4>';
				if( ! empty( $contact['link'] ) ) $contact_list .= Link::get_acf_link($contact['link'], 'footer__contact-link footer__contact-phone');
				$contact_list .= '</li>';
			}
			$contact_list .= '</ul>';

			$html .= $contact_list;
		}

		return $html;
	}

	public static function getFooterSocialLinks(): string {
		if ( ! Acf::isAcfPluginActivated() ) {
			return '';
		}

		$data = get_field( 'footer_social_links', 'option' );

		if( !empty( $data ) ) {
			$social_list = '<ul class="footer__social-list">';
			foreach ( $data as $social ) {
				$color = !empty($social['color']) ? 'style="--footer-social-color:' . $social['color']. '"': '';
				$social_list .= sprintf('<li %s>', $color);
				if( ! empty( $social['link'] ) ) $social_list .= Link::get_acf_link($social['link'], 'footer__contact-link', SVG ::get_image($social['image']));
				$social_list .= '</li>';
			}
			$social_list .= '</ul>';

			return $social_list;
		}
		return '';
	}

	public static function getCompanyAddress(): string {
		if ( ! Acf::isAcfPluginActivated() ) {
			return '';
		}
		$address = get_field( 'address', 'option' );
		return  esc_html__( $address, TM_TEXTDOMAIN );
	}

	public static function getCompanyEmail(): string {
		if ( ! Acf::isAcfPluginActivated() ) {
			return '';
		}
		$email = get_field( 'email', 'option' );

    if( empty( $email ) ) return '';
		return  Link::get_acf_link($email, 'footer__email-link');
	}
}
