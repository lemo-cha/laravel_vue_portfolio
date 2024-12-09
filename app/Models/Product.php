<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'custom_id',
        'category_id',
        'maker_id',
        'unit_id',
        'name',
        'size',
        'product_number',
        'description',
        'image_1',
        'image_2',
        'image_3',
        'remarks',
        'status',
    ];

    //画像カラムを変更するなら定数も変更する
    public const IMAGE_COLUMNS = ['image_1','image_2','image_3'];

    public function getSizeAttribute($value)
    {
        return $value ?? '';
    }

    public function getProductNumberAttribute($value)
    {
        return $value ?? '';
    }

    public function getDescriptionAttribute($value)
    {
        return $value ?? '';
    }

    public function getImage2Attribute($value)
    {
        return $value ?? '';
    }

    public function getImage3Attribute($value)
    {
        return $value ?? '';
    }

    public function getRemarksAttribute($value)
    {
        return $value ?? '';
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function maker(){
        return $this->belongsTo(Maker::class);
    }

    public function unit(){
        return $this->belongsTo(Unit::class);
    }

    public function storeImagePath(&$data,$column,$file) //画像の登録、配列に画像URLを代入
    {
        $path = $file->store('images','public');
        $data[$column] = $path;
    }

    public function deleteImagePath(&$data,$column) //画像の削除、配列にnullを代入
    {
        Storage::disk('public')->delete($this->$column);
        $data[$column] = null;
    }
}
