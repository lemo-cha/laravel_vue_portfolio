<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'custom_id',
        'name',
    ];

    public function products(){
        return $this->hasMany(Product::class);
    }
}
