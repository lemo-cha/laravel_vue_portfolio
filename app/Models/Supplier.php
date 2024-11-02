<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'custom_id',
        'company_type',
        'name',
        'kana',
        'tel',
        'zip',
        'address',
        'billing_zip',
        'billing_address',
        'bank_name',
        'bank_number',
        'remarks',
        'is_active',
    ];
}
