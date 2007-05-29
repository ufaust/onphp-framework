<?php
/***************************************************************************
 *   Copyright (C) 2007 by Ivan Khvostishkov                               *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   (at your option) any later version.                                   *
 *                                                                         *
 ***************************************************************************/
/* $Id$ */

	/**
	 * based on CPAN's Lingua::DetectCharset.
	 * Thanks to John Neystadt, http://www.neystadt.org/john/
	**/
	class CyrillicPairs extends StaticFactory
	{
		private static $table = array(
			'ст' => 21815, 'ен' => 19276, 'на' => 16528, 'ов' => 15172,
			'го' => 15161, 'но' => 14457, 'ни' => 14151, 'ог' => 13562,
			'пр' => 13327, 'ре' => 11067, 'ал' => 10935, 'ан' => 10268,
			'ра' => 10059, 'ло' => 9899, 'та' => 9785, 'то' => 9712,
			'ны' => 9281, 'ли' => 9040, 'нн' => 8956, 'тв' => 8956,
			'ат' => 8884, 'по' => 8786, 'де' => 8713, 'ос' => 8626,
			'ед' => 8332, 'те' => 8202, 'ел' => 8125, 'од' => 7820,
			'ия' => 7815, 'ри' => 7582, 'ль' => 7487, 'ва' => 7418,
			'ор' => 7308, 'во' => 7277, 'за' => 7005, 'ер' => 6823,
			'ро' => 6767, 'от' => 6679, 'ко' => 6609, 'ет' => 6596,
			'ом' => 6329, 'ле' => 6066, 'ии' => 5903, 'ой' => 5834,
			'ес' => 5705, 'ве' => 5465, 'ла' => 5440, 'до' => 5347,
			'ти' => 5253, 'ци' => 5193, 'не' => 5075, 'из' => 5064,
			'ас' => 5043, 'ых' => 4998, 'тс' => 4966, 'об' => 4868,
			'ме' => 4818, 'че' => 4731, 'ть' => 4693, 'им' => 4656,
			'ие' => 4628, 'ав' => 4563, 'ка' => 4402, 'ол' => 4400,
			'со' => 4388, 'ще' => 4290, 'ся' => 4197, 'га' => 4191,
			'мо' => 4078, 'да' => 4049, 'щи' => 3968, 'вл' => 3853,
			'ац' => 3797, 'сл' => 3732, 'ск' => 3716, 'ин' => 3708,
			'ар' => 3706, 'ми' => 3684, 'оп' => 3632, 'пл' => 3612,
			'ам' => 3465, 'же' => 3459, 'ит' => 3398, 'тр' => 3392,
			'ис' => 3354, 'ьн' => 3296, 'ил' => 3261, 'ий' => 3242,
			'ем' => 3209, 'вы' => 3182, 'ак' => 3162, 'аз' => 3090,
			'ви' => 2962, 'ей' => 2958, 'он' => 2878, 'ые' => 2847,
			'ля' => 2830, 'ус' => 2808, 'ик' => 2804, 'су' => 2792,
			'ки' => 2724, 'ег' => 2694, 'ым' => 2657, 'рг' => 2653,
			'ят' => 2587, 'тн' => 2577, 'ож' => 2573, 'пе' => 2500,
			'ру' => 2482, 'оя' => 2374, 'ек' => 2366, 'бо' => 2334,
			'ча' => 2304, 'уч' => 2289, 'уп' => 2263, 'хо' => 2227,
			'ящ' => 2209, 'их' => 2180, 'си' => 2176, 'лу' => 2139,
			'иц' => 2134, 'сс' => 2118, 'ма' => 2073, 'йс' => 2066,
			'ае' => 2064, 'ше' => 2054, 'ющ' => 2041, 'ую' => 1930,
			'оо' => 1911, 'нт' => 1893, 'ок' => 1881, 'чи' => 1873,
			'ум' => 1778, 'ив' => 1769, 'ая' => 1744, 'дс' => 1738,
			'це' => 1695, 'му' => 1684, 'ио' => 1658, 'сп' => 1639,
			'ьщ' => 1633, 'ич' => 1628, 'зн' => 1570, 'кт' => 1558,
			'ои' => 1551, 'ди' => 1530, 'ач' => 1515, 'ья' => 1501,
			'са' => 1493, 'дп' => 1488, 'ты' => 1483, 'ду' => 1460,
			'дн' => 1459, 'уд' => 1452, 'мы' => 1424, 'ое' => 1391,
			'эт' => 1382, 'ьс' => 1379, 'ют' => 1342, 'ущ' => 1336,
			'кс' => 1323, 'оз' => 1322, 'жд' => 1303, 'еж' => 1286,
			'Фе' => 1284, 'Ро' => 1272, 'бы' => 1257, 'ги' => 1248,
			'ию' => 1245, 'яз' => 1224, 'аю' => 1197, 'уг' => 1192,
			'ый' => 1192, 'зв' => 1191, 'ср' => 1185, 'Ст' => 1184,
			'дл' => 1182, 'ид' => 1161, 'Ко' => 1153, 'нс' => 1150,
			'рс' => 1139, 'ву' => 1126, 'ба' => 1117, 'ук' => 1098,
			'мм' => 1094, 'ез' => 1093, 'зо' => 1076, 'яе' => 1070,
			'ку' => 1049, 'вн' => 1048, 'ря' => 1045, 'ах' => 1039,
			'св' => 1033, 'зи' => 999, 'вк' => 999, 'лн' => 949,
			'оч' => 944, 'ры' => 938, 'см' => 938, 'ца' => 935, 'бл' => 924,
			'чн' => 921, 'ее' => 911, 'ня' => 911, 'ох' => 909, 'аб' => 891,
			'ир' => 882, 'яд' => 878, 'кл' => 876, 'зд' => 869, 'яю' => 847,
			'нк' => 840, 'На' => 838, 'ту' => 836, 'бя' => 836, 'Пр' => 835,
			'бр' => 832, 'фи' => 803, 'оц' => 799, 'жа' => 796, 'ке' => 782,
			'ош' => 778, 'еч' => 767, 'яв' => 766, 'ям' => 765, 'иб' => 755,
			'ды' => 743, 'уж' => 743, 'др' => 741, 'лю' => 741, 'зм' => 739,
			'аж' => 716, 'ну' => 711, 'ьи' => 700, 'сн' => 693, 'рт' => 683,
			'гр' => 678, 'кц' => 677, 'па' => 671, 'дк' => 660, 'бе' => 652,
			'кр' => 651, 'аг' => 646, 'рм' => 638, 'еа' => 635, 'се' => 633,
			'жи' => 632, 'бъ' => 629, 'жн' => 620, 'иа' => 609, 'ъе' => 599,
			'ад' => 594, 'фо' => 591, 'ащ' => 591, 'сх' => 590, 'уш' => 559,
			'ев' => 525, 'сч' => 522, 'еб' => 516, 'юч' => 505, 'ыт' => 503,
			'рв' => 496, 'ье' => 496, 'рн' => 490, 'ьз' => 487, 'ея' => 483,
			'ях' => 482, 'нд' => 474, 'пу' => 471, 'цо' => 461, 'ут' => 452,
			'шл' => 438, 'лж' => 434, 'тк' => 433, 'рр' => 431, 'зу' => 430,
			'кж' => 416, 'еш' => 414, 'пи' => 409, 'бс' => 403, 'По' => 401,
			'ыв' => 400, 'зе' => 400, 'ун' => 398, 'ши' => 397, 'ью' => 395,
			'вр' => 394, 'жб' => 390, 'фе' => 376, 'вя' => 370, 'гл' => 369,
			'зы' => 368, 'бу' => 365, 'ып' => 363, 'бщ' => 358, 'еп' => 346,
			'дя' => 344, 'гу' => 337, 'рж' => 326, 'уе' => 325, 'эк' => 311,
			'ыч' => 305, 'ул' => 301, 'ща' => 297, 'вш' => 286, 'вт' => 286,
			'ещ' => 286, 'ео' => 285, 'вс' => 280, 'ап' => 277, 'ыр' => 273,
			'ыд' => 272, 'фа' => 272, 'нь' => 271, 'тч' => 270, 'пп' => 268,
			'пы' => 266, 'уб' => 260, 'Об' => 259, 'ыш' => 255, 'ех' => 255,
			'рш' => 254, 'ур' => 254, 'дв' => 242, 'вп' => 241, 'сы' => 239,
			'юд' => 237, 'Ес' => 231, 'кв' => 225, 'ыл' => 224, 'ын' => 219,
			'сб' => 218, 'цу' => 216, 'сд' => 213, 'ъя' => 207, 'дж' => 206,
			'бю' => 206, 'аш' => 205, 'ыс' => 205, 'бн' => 204, 'мн' => 204,
			'зл' => 204, 'Гл' => 201, 'ша' => 200, 'нв' => 199, 'чк' => 198,
			'тд' => 197, 'вз' => 197, 'би' => 194, 'ьт' => 193, 'Не' => 192,
			'нз' => 192, 'чр' => 191, 'яц' => 184, 'ец' => 183, 'вв' => 183,
			'Го' => 178, 'нц' => 176, 'Су' => 174, 'нф' => 174, 'ьк' => 171,
			'иж' => 169, 'аи' => 166, 'ьш' => 165, 'ге' => 162, 'хс' => 161,
			'оу' => 161, 'лы' => 157, 'Ос' => 156, 'рь' => 156, 'сь' => 154,
			'лк' => 153, 'Ра' => 152, 'ай' => 152, 'ян' => 151, 'иг' => 151,
			'оф' => 145, 'ею' => 141, 'ув' => 140, 'дм' => 138, 'чу' => 134,
			'Ин' => 134, 'ощ' => 129, 'Ре' => 127, 'Ук' => 124, 'тя' => 122,
			'рк' => 122, 'иф' => 120, 'мп' => 119, 'чт' => 114, 'ьг' => 113,
			'аф' => 112, 'шт' => 112, 'зя' => 112, 'шн' => 108, 'еф' => 108,
			'До' => 107, 'уа' => 104, 'ип' => 104, 'ха' => 102, 'хр' => 101,
			'Та' => 100, 'лл' => 97, 'йн' => 96, 'иш' => 96, 'бх' => 92,
			'хн' => 92, 'За' => 92, 'яй' => 90, 'дъ' => 90, 'лг' => 89,
			'зр' => 89, 'мл' => 89, 'пя' => 87, 'нч' => 84, 'От' => 83,
			'вм' => 82, 'яс' => 81, 'ау' => 79, 'ьм' => 78, 'зъ' => 77,
			'еи' => 76, 'щу' => 70, 'Со' => 70, 'мв' => 68, 'мс' => 68,
			'гд' => 68, 'йо' => 67, 'Пе' => 64, 'дт' => 63, 'бж' => 63,
			'юб' => 62, 'рб' => 62, 'мя' => 61, 'Оп' => 60, 'Ми' => 59,
			'Уп' => 56, 'Вы' => 56, 'тм' => 53, 'Ср' => 52, 'яж' => 51,
			'вх' => 51, 'Це' => 51, 'ух' => 51, 'вц' => 51, 'дш' => 51,
			'юр' => 50, 'фф' => 50, 'дг' => 49, 'ищ' => 48, 'цы' => 47,
			'Ор' => 46, 'зк' => 46, 'Ис' => 46, 'еу' => 45, 'уз' => 45,
			'Ме' => 41, 'пн' => 38, 'ыз' => 38, 'жк' => 37, 'зг' => 37,
			'Уч' => 36, 'ыб' => 36, 'кн' => 35, 'Дл' => 35, 'оэ' => 34,
			'щн' => 33, 'чл' => 33, 'Но' => 33, 'ык' => 33, 'дч' => 33,
			'Из' => 33, 'Во' => 32, 'зц' => 32, 'зб' => 32, 'нг' => 31,
			'Ли' => 31, 'фы' => 31, 'рх' => 30, 'ьч' => 30, 'рч' => 30,
			'мк' => 30, 'эф' => 29, 'ыя' => 29, 'Тр' => 28, 'вщ' => 28,
			'фн' => 28, 'оа' => 27, 'ыг' => 27, 'тц' => 27, 'дд' => 27,
			'хи' => 27, 'сф' => 26, 'дз' => 26, 'ял' => 26, 'Вз' => 26,
			'пк' => 26, 'тп' => 25, 'жу' => 25, 'бм' => 25, 'сш' => 25,
			'вь' => 24, 'Де' => 24, 'Ма' => 24, 'тх' => 24, 'фт' => 24,
			'ою' => 23, 'Сп' => 22, 'дц' => 22, 'ьц' => 22, 'Фо' => 22,
			'рд' => 21, 'дб' => 20, 'яч' => 20, 'яр' => 20, 'йш' => 20,
			'гш' => 19, 'Эк' => 19, 'эм' => 19, 'фу' => 19, 'шк' => 19,
			'яг' => 19, 'дь' => 19, 'ню' => 18, 'яя' => 18, 'уц' => 18,
			'Фи' => 18, 'як' => 18, 'рц' => 17, 'Ге' => 17, 'сю' => 17,
			'Ба' => 17, 'Ус' => 17, 'лт' => 16, 'Вн' => 16, 'Мо' => 16,
			'юз' => 16, 'иу' => 16, 'эл' => 16, 'жп' => 15, 'фл' => 15,
			'щь' => 15, 'пт' => 15, 'хг' => 15, 'ху' => 15, 'еэ' => 15,
			'Вт' => 14, 'рл' => 14, 'мщ' => 14, 'Ве' => 13, 'кш' => 13,
			'Па' => 13, 'мб' => 13, 'пс' => 13, 'Cт' => 13, 'тл' => 12,
			'пц' => 12, 'йм' => 12, 'кВ' => 12, 'Те' => 12, 'тг' => 12,
			'Се' => 12, 'То' => 12, 'гн' => 12, 'Ар' => 12, 'чь' => 12,
			'Да' => 11, 'жг' => 11, 'эн' => 11, 'Св' => 11, 'Ви' => 11,
			'Ка' => 11, 'йт' => 11, 'гч' => 11, 'юв' => 10, 'Че' => 10,
			'кк' => 10, 'Уб' => 10, 'эв' => 10, 'мь' => 10, 'эр' => 10,
			'вд' => 10, 'юс' => 9, 'цв' => 9, 'аэ' => 9, 'рп' => 9, 'ьф' => 9,
			'бш' => 9, 'гк' => 8, 'Вв' => 8, 'Ам' => 8, 'лс' => 8, 'юц' => 8,
			'Ас' => 8, 'нж' => 8, 'пь' => 7, 'Гр' => 7, 'Ан' => 7, 'Ав' => 7,
			'чш' => 7, 'Од' => 7, 'фь' => 7, 'хт' => 7, 'уя' => 7, 'Бл' => 7,
			'Ак' => 7, 'хк' => 6, 'ьб' => 6, 'мч' => 6, 'рф' => 6, 'йк' => 6,
			'уи' => 6, 'уф' => 6, 'Им' => 6, 'Бе' => 6, 'фр' => 6, 'Си' => 6,
			'Оц' => 6, 'ао' => 5, 'Сд' => 5, 'Пи' => 5, 'Ди' => 5, 'цк' => 5,
			'хе' => 5, 'бз' => 5, 'тз' => 5, 'юж' => 5, 'Кр' => 5, 'Зн' => 4,
			'въ' => 4, 'Пл' => 4, 'Ни' => 4, 'Ог' => 4, 'Сл' => 4, 'Ры' => 4,
			'лм' => 4, 'шр' => 4, 'Ув' => 4, 'тт' => 4, 'шь' => 4, 'Фа' => 4,
			'Дн' => 4, 'Жа' => 4, 'Ле' => 4, 'Уг' => 4, 'Ту' => 4, 'бк' => 4,
			'Ал' => 3, 'йф' => 3, 'тш' => 3, 'зь' => 3, 'сц' => 3, 'шу' => 3,
			'Лю' => 3, 'тъ' => 3, 'эс' => 3, 'Вс' => 3, 'Эт' => 3, 'Са' => 3,
			'сг' => 3, 'Вр' => 3, 'яб' => 3, 'Др' => 3, 'Бю' => 3, 'съ' => 3,
			'йе' => 3, 'Цв' => 2, 'еc' => 2, 'гт' => 2, 'Ку' => 2, 'Кн' => 2,
			'Ль' => 2, 'юш' => 2, 'Ут' => 2, 'юл' => 2, 'Же' => 2, 'Ду' => 2,
			'кз' => 2, 'рю' => 2, 'чв' => 2, 'cк' => 2, 'cл' => 2, 'Ап' => 2,
			'бп' => 2, 'кг' => 2, 'мЗ' => 2, 'нщ' => 2, 'эп' => 2, 'пч' => 2,
			'Сч' => 2, 'Зв' => 2, 'хв' => 2, 'Он' => 2, 'cн' => 2, 'Зе' => 2,
			'зч' => 2, 'фм' => 2, 'cт' => 2, 'фс' => 2, 'хл' => 2, 'Бр' => 2,
			'Яз' => 1, 'Ид' => 1, 'Уд' => 1, 'жф' => 1, 'йд' => 1, 'Ум' => 1,
			'Юв' => 1, 'eй' => 1, 'мр' => 1, 'жр' => 1, 'юн' => 1, 'лд' => 1,
			'Тв' => 1, 'Дв' => 1, 'Фл' => 1, 'вг' => 1, 'Жи' => 1, 'юю' => 1,
			'Ру' => 1, 'Вк' => 1, 'Вм' => 1, 'Ев' => 1, 'Сб' => 1, 'Ел' => 1,
			'щр' => 1, 'ьe' => 1, 'Еc' => 1, 'бв' => 1, 'ыи' => 1, 'пф' => 1,
			'зж' => 1, 'Оф' => 1, 'Иж' => 1, 'зт' => 1, 'cр' => 1, 'oт' => 1,
			'хм' => 1, 'цл' => 1, 'цм' => 1, 'Еж' => 1, 'уc' => 1, 'cо' => 1,
			'Бу' => 1, 'йп' => 1, 'Ск' => 1, 'Ит' => 1,
		);
		
		public static function getTable()
		{
			return self::$table;
		}
	}
?>