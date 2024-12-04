<?php

namespace App\Enums;

const KK = '株式会社';
const YK = '有限会社';
const LLC = '合同会社';
const LP = '合資会社';
const GP = '合名会社';

const ABBR_KK = '(株)';
const ABBR_YK = '(有)';
const ABBR_LLC = '(合同)';
const ABBR_LP = '(合資)';
const ABBR_GP = '(合名)';

const PRE = '前';
const POST = '後';

const SPACE_Y = 'スペース有';
const SPACE_N = 'スペース無';

enum CompanyType: int
{
    case NO = 0; //なし

    case KK_PRE_SPACE_Y  = 1;
    case KK_PRE_SPACE_N  = 2;
    case KK_POST_SPACE_Y = 3;
    case KK_POST_SPACE_N = 4;

    case YK_PRE_SPACE_Y  = 5;
    case YK_PRE_SPACE_N  = 6;
    case YK_POST_SPACE_Y = 7;
    case YK_POST_SPACE_N = 8;

    case LLC_PRE_SPACE_Y  = 9;
    case LLC_PRE_SPACE_N  = 10;
    case LLC_POST_SPACE_Y = 11;
    case LLC_POST_SPACE_N = 12;

    case LP_PRE_SPACE_Y  = 13;
    case LP_PRE_SPACE_N  = 14;
    case LP_POST_SPACE_Y = 15;
    case LP_POST_SPACE_N = 16;

    case GP_PRE_SPACE_Y  = 17;
    case GP_PRE_SPACE_N  = 18;
    case GP_POST_SPACE_Y = 19;
    case GP_POST_SPACE_N = 20;

    // 例) KK_PRE_SPACE = "株式会社/前/スペース有"
    public static function getLabelList() : Array
    {
        return array_map(function($type){
            if($type->name === 'NO'){
                return [
                    'id' => $type->value,
                    'value' => 'なし',
                ];
            }

            $companyType = match(true){
                str_contains($type->name,'KK') => KK,
                str_contains($type->name,'YK') => YK,
                str_contains($type->name,'LLC') => LLC,
                str_contains($type->name,'LP') => LP,
                str_contains($type->name,'GP') => GP,
                default => "-",
            };
            $prefixPostfix = str_contains($type->name,'PRE') ? PRE : POST;
            $space = str_contains($type->name,'SPACE_Y') ? SPACE_Y : SPACE_N;

            return [
                'id' => $type->value,
                'value' => "$companyType/$prefixPostfix/$space",
            ];
        },self::cases());
    }

    // 例) KK_PRE_SPACE = "株式会社 〇〇"
    public static function getFullName(int $companyTypeValue,$companyName) : String
    {
        $type = CompanyType::from($companyTypeValue);

        if($type->name === 'NO'){
            return $companyName;
        }

        $companyType = match(true){
            str_contains($type->name,'KK') => KK,
            str_contains($type->name,'YK') => YK,
            str_contains($type->name,'LLC') => LLC,
            str_contains($type->name,'LP') => LP,
            str_contains($type->name,'GP') => GP,
        };

        $prefixPostfix = str_contains($type->name,'PRE') ? PRE : POST;

        $space = str_contains($type->name,'SPACE_Y') ? SPACE_Y : SPACE_N;

        return match(true){
            $prefixPostfix === PRE  && $space === SPACE_Y => "$companyType $companyName",
            $prefixPostfix === PRE  && $space === SPACE_N => "$companyType$companyName",
            $prefixPostfix === POST && $space === SPACE_Y => "$companyName $companyType",
            $prefixPostfix === POST && $space === SPACE_N => "$companyName$companyType",
        };
    }
    // 例) KK_PRE_SPACE = "(株)〇〇"
    public static function getAbbrName(int $companyTypeValue,$companyName) : String
    {
        $type = CompanyType::from($companyTypeValue);

        if($type->name === 'NO'){
            return $companyName;
        }

        $companyType = match(true){
            str_contains($type->name,'KK') => ABBR_KK,
            str_contains($type->name,'YK') => ABBR_YK,
            str_contains($type->name,'LLC') => ABBR_LLC,
            str_contains($type->name,'LP') => ABBR_LP,
            str_contains($type->name,'GP') => ABBR_GP,
        };

        $prefixPostfix = str_contains($type->name,'PRE') ? PRE : POST;

        return match(true){
            $prefixPostfix === PRE  => "$companyType$companyName",
            $prefixPostfix === POST => "$companyName$companyType",
        };
    }
}
