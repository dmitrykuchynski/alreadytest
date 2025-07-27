<?php

namespace App\Base;

final class DisableXmlRPC {

    public function __construct() {
        add_filter('xmlrpc_methods', [self::class, 'remove_xmlrpc']);
    }

    public static function remove_xmlrpc( $methods ) {
        $methods = array(); //empty the array
        return $methods;
    }

}