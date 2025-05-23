<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $fillable = [
        'title',
        'description',
        'mission',
        'vision',
        'company_infor',
        'image',
    ];
}