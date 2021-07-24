<?php

namespace App\Helpers;

class Helpers
{
    public static function complements_path($file='') {
        
        return "/storage/complements/$file";
    }

    public static function format_price($price=0) {
        
        return '$'.number_format($price,2);
    }

}