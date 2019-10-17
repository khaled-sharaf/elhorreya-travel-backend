<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'slug', 'name', 'value', 'type', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public static function getSettings() {
        $settings = self::where('name', '!=', 'data_tabel_settings_view_columns')->get()->pluck('value', 'name')->toArray();
        return $settings;
    }
}
