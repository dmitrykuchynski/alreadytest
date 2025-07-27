<?php

namespace App\Options;

use App\Acf\Acf;

class Options {
	public function __construct() {
		if(Acf::isAcfPluginActivated()) {
			acf_set_options_page_menu( __('Theme options', TM_TEXTDOMAIN) );
			acf_add_options_page();
			acf_add_options_sub_page( __('Header & Footer options', TM_TEXTDOMAIN) );
			acf_add_options_sub_page( __('Contacts', TM_TEXTDOMAIN) );
		}
	}
}
