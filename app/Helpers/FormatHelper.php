<?php
namespace App\Helpers;

class FormatHelper
{
	//郵便番号の整形
	public static function formatZipCode($zip)
	{
		return '〒' . substr($zip,0,3) . '-' . substr($zip,3);
	}

	//電話番号の整形
	public static function formatTelNumber($tel)
	{
		return substr($tel,0,3) . '-' . substr($tel,3,4) . '-' . substr($tel,7);
	}

	//日付の整形
	public static function formatDateYmd($date)
	{
		return $date->format('Y年m月d日');
	}

	//締日の一覧・整形・select用
	public static function getClosingDate()
	{
		return [10,15,19,20,25,31];
	}

	public static function formatClosingDate($date)
	{
		return $date.'日';
	}

	public static function getClosingLabelList()
	{
		return collect(self::getClosingDate())->map(function($date){
			return [
				'value' => $date,
				'label' => self::formatClosingDate($date),
			];
		});
	}

	//取引状態の整形・select用
	public static function formatActive($bool)
	{
		return $bool ? '有効' : '無効';
	}
	public static function getActiveLabelList()
	{
		return [
			[
				'value' => 1,
				'label' => '有効',
			],
			[
				'value' => 0,
				'label' => '無効',
			],
		];
	}
}