<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarketingRoom extends Model
{


    protected $fillable = [
        'date_from', 'date_to', 'single_price_wd', 'single_price_we', 'dbl_price_wd', 'dbl_price_we', 'triple_price_wd', 'triple_price_we', 'quad_price_wd', 'quad_price_we', 'options', 'description', 'display', 'marketing_hotel_id'
    ];
}
