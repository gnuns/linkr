<?php

class GamesData 
{
	
	public static function searchForGames($query, $offset) {
		Core::connectDB();
		global $Db;
		$q = "SELECT G.g_id AS id, G.g_name AS name, GM.gi_gamepage_top AS bgimg,  ROUND((GS.gst_current_price - (GS.gst_current_price * ((GS.gst_discount_percent * 0.01))) * GS.gst_in_promotion), 2) AS price, (CASE WHEN GS.gst_in_promotion > 0 AND GS.gst_discount_percent > 0 THEN 1 ELSE 0 END)  AS withdiscount,
GS.gst_discount_percent AS percent, GS.gst_current_price AS originalprice, GP.p_name AS devname
FROM games AS G
INNER JOIN game_store AS GS ON G.g_id = GS.gst_game_id
INNER JOIN game_media AS GM ON G.g_id = GM.gi_game_id
INNER JOIN publisher AS GP ON G.g_id = GP.p_id /*G.g_dev_id*/
WHERE G.g_name LIKE :search OR G.g_about LIKE :search  OR GP.p_name LIKE :search
GROUP BY G.g_id
ORDER BY G.g_name ASC
LIMIT 1000 OFFSET " . $offset;
		$r = $Db->select($q,
										 array(':search' => '%'. $query . '%'));
		$array = array(	'results.total' => count($r),
											'results' => array_slice($r, 0, 10));
		printf(json_encode($array));
	}
	
	public static function getFeaturedGames() {
		Core::connectDB();
		global $Db;
		/* Game points: Pageviews - Current price + Discount*/
		$q = "SELECT G.g_id AS gameId, G.g_name AS gameName, (CASE WHEN GS.gst_coming_date > ".time()." THEN 0 ELSE 1 END) AS released, 
ROUND((GS.gst_current_price - (GS.gst_current_price * ((GS.gst_discount_percent * 0.01))) * GS.gst_in_promotion), 2) AS gamePrice,
(case when GS.gst_in_promotion = 1 then CONCAT('<span class=\"original-price\">R$ ', GS.gst_current_price, '</span> R$ ', ROUND((GS.gst_current_price - (GS.gst_current_price * ((GS.gst_discount_percent * 0.01))) * GS.gst_in_promotion), 2))
             else CONCAT('R$ ', ROUND((GS.gst_current_price - (GS.gst_current_price * ((GS.gst_discount_percent * 0.01))) * GS.gst_in_promotion), 2))
             end) AS priceCode, 
(case when GS.gst_in_promotion = 1 then CONCAT('<div class=\"game-tag discount\">-', GS.gst_discount_percent, '%</div>')
             else ('')
             end) AS gamePromoCode,
GM.gi_homepage AS gameImage
FROM games AS G
INNER JOIN game_store AS GS ON G.g_id = GS.gst_game_id
LEFT JOIN game_audience ON game_audience.ga_game_id = G.g_id 
INNER JOIN game_media AS GM ON G.g_id = GM.gi_game_id
ORDER BY (game_audience.ga_pagehits - ROUND(GS.gst_current_price) + (GS.gst_discount_percent * GS.gst_in_promotion)) DESC LIMIT 8 OFFSET 6";
		$games = $Db->select($q);
		return $games;
		
	}
	
	public static function getUpdatedGamesData() {
		Core::connectDB();
		global $Db;

		$games = $Db->select('SELECT G.g_id AS gameId, G.g_name AS gameName, GB.gb_post_id AS postId, 
GM.gi_homepage AS gameImage, CONCAT(LEFT(GB.gb_post_body, 190), \' [...]\') AS postPreview, 
ROUND((GS.gst_current_price - (GS.gst_current_price * ((GS.gst_discount_percent * 0.01))) * GS.gst_in_promotion), 2) AS gamePrice
FROM game_blog AS GB
INNER JOIN games AS G ON GB.gb_game_id = G.g_id 
INNER JOIN game_store AS GS ON GB.gb_game_id = GS.gst_game_id
INNER JOIN game_media AS GM ON GB.gb_game_id = GM.gi_game_id
WHERE gb_post_time IN (
	SELECT MAX(gb_post_time)
	FROM game_blog GROUP BY gb_game_id
) ORDER BY GB.gb_post_id DESC LIMIT 4');
		//print_r(array_values($games));
		return $games;
		
	}
	
	public static function getSlideshowGames() 
	{
		Core::connectDB();
		global $Db;
		$uId = 1;
		/*g_id AS*/
		$games = $Db->select('SELECT G.g_id AS id, G.g_name AS name, GG.name AS genre, (CASE WHEN GS.gst_coming_date > '.time().' THEN 0 ELSE 1 END) AS released, GS.gst_current_price AS originalprice, (CASE WHEN GS.gst_in_promotion > 0 AND GS.gst_discount_percent > 0 THEN 1 ELSE 0 END)  AS withdiscount, GS.gst_discount_percent AS percent, GS.gst_coming_date AS releasedate, ROUND((GS.gst_current_price - (GS.gst_current_price * ((GS.gst_discount_percent * 0.01))) * GS.gst_in_promotion), 2) AS price, GM.gi_homepage_slideshow AS image '.
										 'FROM games AS G '.
										 'INNER JOIN game_genres AS GG '.
										 'ON G.g_genre = GG.id '.
										 'INNER JOIN game_media AS GM '.
										 'ON G.g_id = GM.gi_game_id '.
										 'LEFT JOIN game_audience ON game_audience.ga_game_id = G.g_id '.
										 'INNER JOIN game_store AS GS '.
										 'ON G.g_id = GS.gst_game_id ' . 
										 'ORDER BY game_audience.ga_pagehits DESC LIMIT 6');
		return json_encode($games);
	}
	
	public static function getShowcaseGames() 
	{
		Core::connectDB();
		global $Db;
		$uId = 1;
		/*g_id AS*/
		$latest = $Db->select('SELECT G.g_id AS id, G.g_name AS name, GG.name AS genre, (CASE WHEN GS.gst_coming_date > '.time().' THEN 0 ELSE 1 END) AS released, ROUND((GS.gst_current_price - (GS.gst_current_price * ((GS.gst_discount_percent * 0.01))) * GS.gst_in_promotion), 2) AS price, (CASE WHEN GS.gst_in_promotion > 0 AND GS.gst_discount_percent > 0 THEN 1 ELSE 0 END)  AS withdiscount, GS.gst_discount_percent AS percent, GS.gst_coming_date AS releasedate, GM.gi_homepage AS img '.
										 'FROM games AS G '.
										 'INNER JOIN game_genres AS GG '.
										 'ON G.g_genre = GG.id '.
										 'INNER JOIN game_media AS GM '.
										 'ON G.g_id = GM.gi_game_id '.
										 'INNER JOIN game_store AS GS '.
										 'ON G.g_id = GS.gst_game_id ' . 
										 'WHERE (CASE WHEN GS.gst_coming_date > '.time().' THEN 0 ELSE 1 END) = \'1\'' .
										 'ORDER BY G.g_id DESC LIMIT 5');
		$topHit = $Db->select('SELECT G.g_id AS id, G.g_name AS name, GG.name AS genre, (CASE WHEN GS.gst_coming_date > '.time().' THEN 0 ELSE 1 END) AS released, ROUND((GS.gst_current_price - (GS.gst_current_price * ((GS.gst_discount_percent * 0.01))) * GS.gst_in_promotion), 2) AS price, (CASE WHEN GS.gst_in_promotion > 0 AND GS.gst_discount_percent > 0 THEN 1 ELSE 0 END)  AS withdiscount, GS.gst_discount_percent AS percent, GS.gst_coming_date AS releasedate, GM.gi_homepage AS img '.
										 'FROM games AS G '.
										 'INNER JOIN game_genres AS GG '.
										 'ON G.g_genre = GG.id '.
										 'INNER JOIN game_media AS GM '.
										 'ON G.g_id = GM.gi_game_id '.
										 'INNER JOIN game_store AS GS '.
										 'ON G.g_id = GS.gst_game_id ' .
										 'LEFT JOIN game_audience ON game_audience.ga_game_id = G.g_id ' .
										 'WHERE (CASE WHEN GS.gst_coming_date > '.time().' THEN 0 ELSE 1 END) = \'1\'' .
										 'ORDER BY game_audience.ga_pagehits DESC LIMIT 5');
		$soon = $Db->select('SELECT G.g_id AS id, G.g_name AS name, GG.name AS genre, (CASE WHEN GS.gst_coming_date > '.time().' THEN 0 ELSE 1 END) AS released, ROUND((GS.gst_current_price - (GS.gst_current_price * ((GS.gst_discount_percent * 0.01))) * GS.gst_in_promotion), 2) AS price, (CASE WHEN GS.gst_in_promotion > 0 AND GS.gst_discount_percent > 0 THEN 1 ELSE 0 END)  AS withdiscount, GS.gst_discount_percent AS percent, GS.gst_coming_date AS releasedate, GM.gi_homepage AS img '.
										 'FROM games AS G '.
										 'INNER JOIN game_genres AS GG '.
										 'ON G.g_genre = GG.id '.
										 'INNER JOIN game_media AS GM '.
										 'ON G.g_id = GM.gi_game_id '.
										 'INNER JOIN game_store AS GS '.
										 'ON G.g_id = GS.gst_game_id ' . 
										 'WHERE (CASE WHEN GS.gst_coming_date > '.time().' THEN 0 ELSE 1 END) = \'0\'' .
										 'ORDER BY GS.gst_coming_date DESC LIMIT 5');
		$recom = $Db->select('SELECT G.g_id AS id, G.g_name AS name, GG.name AS genre, (CASE WHEN GS.gst_coming_date > '.time().' THEN 0 ELSE 1 END) AS released, ROUND((GS.gst_current_price - (GS.gst_current_price * ((GS.gst_discount_percent * 0.01))) * GS.gst_in_promotion), 2) AS price, (CASE WHEN GS.gst_in_promotion > 0 AND GS.gst_discount_percent > 0 THEN 1 ELSE 0 END)  AS withdiscount, GS.gst_discount_percent AS percent, GS.gst_coming_date AS releasedate, GM.gi_homepage AS img '.
										 'FROM games AS G '.
										 'INNER JOIN game_genres AS GG '.
										 'ON G.g_genre = GG.id '.
										 'INNER JOIN game_media AS GM '.
										 'ON G.g_id = GM.gi_game_id '.
										 'INNER JOIN game_store AS GS '.
										 'ON G.g_id = GS.gst_game_id ' .
										 'LEFT JOIN game_audience ON game_audience.ga_game_id = G.g_id ' .
										 'LEFT JOIN game_audience AS GSH '.
										 'ON G.g_id = GSH.ga_game_id ' . 
										 'WHERE (CASE WHEN GS.gst_coming_date > '.time().' THEN 0 ELSE 1 END) = \'1\'' .
										 'ORDER BY GSH.ga_likes DESC LIMIT 5');
		/*$latest = $Db->select('SELECT G.g_id AS id, G.g_name AS name, GG.name AS genre, (CASE WHEN GS.gst_coming_date > ".time()." THEN 0 ELSE 1 END) AS released, GS.gst_current_price AS originalprice, (CASE WHEN GS.gst_in_promotion > 0 AND GS.gst_discount_percent > 0 THEN 1 ELSE 0 END)  AS withdiscount, GS.gst_discount_percent AS percent, GS.gst_coming_date AS releasedate, GM.gi_homepage AS img '.
										 'FROM games AS G '.
										 'INNER JOIN game_genres AS GG '.
										 'ON G.g_genre = GG.id '.
										 'INNER JOIN game_media AS GM '.
										 'ON G.g_id = GM.gi_game_id '.
										 'INNER JOIN game_store AS GS '.
										 'ON G.g_id = GS.gst_game_id ' . 
										 'WHERE (CASE WHEN GS.gst_coming_date > ".time()." THEN 0 ELSE 1 END) = \'1\'' .
										 'ORDER BY GS.gst_coming_date DESC LIMIT 5');*/
		$array = array('latest' => $latest, 'topHit' => $topHit, 'soon' => $soon, 'recom' => $recom);
		return json_encode($array);
	}
}
