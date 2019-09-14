<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailingList extends Model
{
    protected $table = 'mailing_list';

    protected $fillable = [
        'email'
    ];
}
