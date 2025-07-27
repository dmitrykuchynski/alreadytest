<?php

namespace App\CF7;

class CF7Init
{
    public function __construct()
    {
        new DeferRecaptchaCF7();
        new CF7CustomFields();

        remove_action('wpcf7_swv_create_schema', 'wpcf7_swv_add_select_enum_rules', 20, 2);
    }
}
