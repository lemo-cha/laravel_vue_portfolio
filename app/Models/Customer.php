<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
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
        'claim_zip',
        'claim_address',
        'invoice_date',
        'bank_name',
        'bank_number',
        'remarks',
        'is_active',
    ];
}
