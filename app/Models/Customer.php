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
        'billing_zip',
        'billing_address',
        'closing_date',
        'bank_name',
        'bank_number',
        'remarks',
        'is_active',
    ];

    public function getRemarksAttribute($value)
    {
        return $value ?? '';
    }
}
