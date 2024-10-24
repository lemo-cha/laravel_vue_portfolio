<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Maker extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'custom_id',
        'company_type',
        'name',
        'brand',
    ];
}
