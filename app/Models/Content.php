<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $fillable = [
        'title',
        'name',
        'body',
        'Status',
        'media',
    ];

    protected $casts = [
        'media' => 'array',
    ];





    //
}
