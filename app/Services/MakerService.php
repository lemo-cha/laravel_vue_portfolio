<?php
namespace App\Services;

use App\Enums\CompanyType;
use App\Models\Maker;

class MakerService
{
    public function getSortedMakers()
    {
        $makers = Maker::select('id', 'custom_id', 'company_type', 'name', 'brand')->get();

        $sortOrder = [
            'a', 'i', 'u', 'e', 'o','ka', 'ki', 'ku', 'ke', 'ko','sa', 'shi', 'su', 'se', 'so',
            'ta', 'chi', 'tsu', 'te', 'to','na', 'ni', 'nu', 'ne', 'no','ha', 'hi', 'fu', 'he', 'ho',
            'ma', 'mi', 'mu', 'me', 'mo','ya', 'yu', 'yo','ra', 'ri', 'ru', 're', 'ro','wa', 'wo','n'
        ];
        
        // アルファベットと数字部分でソート
        $sortedMakers = $makers->sort(function ($a, $b) use ($sortOrder) {
            // アルファベット部分を抽出
            $alphaA = preg_replace('/[^a-z]/', '', strtolower($a->custom_id));
            $alphaB = preg_replace('/[^a-z]/', '', strtolower($b->custom_id));
        
            // アルファベット部分でのソート
            $alphaCompare = array_search($alphaA, $sortOrder) <=> array_search($alphaB, $sortOrder);
            
            if ($alphaCompare !== 0) {
                return $alphaCompare;
            }
        
            // 数字部分を抽出
            $numberA = substr($a->custom_id, strlen($alphaA));
            $numberB = substr($b->custom_id, strlen($alphaB));
        
            // 最初の3桁と次の3桁を分割
            $firstPartA = intval(substr($numberA, 0, 3));
            $firstPartB = intval(substr($numberB, 0, 3));
        
            // 最初の3桁でソート
            if ($firstPartA !== $firstPartB) {
                return $firstPartA <=> $firstPartB;
            }
        
            // 次の3桁でソート
            $secondPartA = intval(substr($numberA, 3, 3));
            $secondPartB = intval(substr($numberB, 3, 3));
        
            return $secondPartA <=> $secondPartB;
        });
        
        // 2. 並び替え結果を配列に変換
        $sortDates = $sortedMakers->map(function ($maker) {
            return [
                'id' => $maker->id,
                'custom_id' => $maker->custom_id,
                'company_type' => $maker->company_type,
                'name' => $maker->name, // 会社形態なしのname
                'brand' => $maker->brand,
                'abbr_name' => CompanyType::getAbbrName($maker->company_type,$maker->name), // 例 (株)〇〇
            ];
        })->values();

        return $sortDates;
    }
}