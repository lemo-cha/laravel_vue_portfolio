<?php

namespace App\Enums;

enum ProductStatus: int
{
	case NOT_SELLING = 0;
	case SELLING = 1;
	case DISCONTINUED = 2;
	case PRE_ORDER = 3;
	case LIMITED_EDITION = 4;
	case BACK_ORDERED = 5;
	case OUT_OF_STOCK = 6;
	case PRE_ORDER_CLOSED = 7;
	case PROTOTYPE = 8;
	case ON_SALE = 9;
	case WILL_BE_DISCONTINUED = 10;
	case NO_RESTOCK = 11;

	public static function getProductStatus($statusValue) : String
	{
		return match($statusValue){
			self::NOT_SELLING->value => '販売停止中',
			self::SELLING->value => '販売中',
			self::DISCONTINUED->value => '廃盤',
			self::PRE_ORDER->value => '予約受付中',
			self::LIMITED_EDITION->value => '限定品',
			self::BACK_ORDERED->value => '取寄中',
			self::OUT_OF_STOCK->value => '在庫切れ',
			self::PRE_ORDER_CLOSED->value => '予約受付終了',
			self::PROTOTYPE->value => '試作品',
			self::ON_SALE->value => 'セール中',
			self::WILL_BE_DISCONTINUED->value => '廃盤予定',
			self::NO_RESTOCK->value => '再入荷無し',
		};
	}

	public static function getProductStatusDescription($statusValue) : String
	{
		return match($statusValue){
			self::NOT_SELLING->value => '諸事情につき、販売を停止しております',
			self::SELLING->value => '販売しております',
			self::DISCONTINUED->value => 'メーカー廃盤につき、再販売の予定はありません',
			self::PRE_ORDER->value => '即納不可商品です',
			self::LIMITED_EDITION->value => '在庫がなくなり次第、販売致しません',
			self::BACK_ORDERED->value => '納期は別途お問い合わせください',
			self::OUT_OF_STOCK->value => '一時的に在庫を切らしております',
			self::PRE_ORDER_CLOSED->value => '購入をご検討の方はお問い合わせください',
			self::PROTOTYPE->value => '詳細はお問い合わせください',
			self::ON_SALE->value => 'セール中につき、特価で販売しております',
			self::WILL_BE_DISCONTINUED->value => 'メーカー廃盤予定の商品です',
			self::NO_RESTOCK->value => '弊社では取扱い予定はございません',
		};
	}

	public static function getLabelList() : Array
	{
		return array_map(function($status){
			return [
				'id' => $status->value,
				'value' => self::getProductStatus($status->value),
			];
		}, self::cases());
	}

}

// 1.	販売中 (Active)
// 	•	商品が現在販売されていて、通常通り購入できる状態です。
// 	2.	販売停止中 (Inactive)
// 	•	商品が一時的に販売停止中で、販売はされていないが、在庫があったり、将来的に再販売の可能性がある状態です。
// 	3.	廃盤 (Discontinued)
// 	•	商品が完全に販売停止されており、再入荷や再販の予定がない状態です。通常、製造終了や供給元の都合で使われます。
// 	4.	予約販売 (Pre-order)
// 	•	商品はまだ入荷していないが、予約を受け付けている状態です。予約販売の期間が終了すると「販売中」に切り替わります。
// 	5.	限定商品 (Limited Edition)
// 	•	数量限定や特定の条件で販売されている商品です。残りの在庫が少ない場合や、一定期間だけ販売されることが多いです。
// 	6.	取り寄せ中 (Backordered)
// 	•	商品が一時的に在庫切れで、取り寄せ対応中の状態です。再入荷後に発送される予定です。
// 	7.	売り切れ (Out of Stock)
// 	•	現在在庫がない状態で、再入荷予定があるかどうかが不明な場合。
// 	8.	予約終了 (Pre-order Closed)
// 	•	予約受付が終了し、通常の販売状態に戻るか、商品が完売した状態です。
// 	9.	試作品 (Prototype)
// 	•	商品がまだテスト段階にあり、限られた数しか販売されていない状態です。
// 	10.	セール中 (On Sale)
// 	•	特定の期間内に割引価格で販売されている状態です。セール終了後は通常の価格に戻ります。