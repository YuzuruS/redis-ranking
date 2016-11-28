<?php
require __DIR__ . '/../vendor/autoload.php';

use YuzuruS\Redis\Ranking;

$redis = new \Redis();
$redis->connect('127.0.0.1', 6379);

$ranking = new Ranking($redis);

$article_ids_of_accessed = [1,1,2,3,4,5,3,4,5,1];


// count up pv of access ids
foreach ($article_ids_of_accessed as $a) {
	$ranking->cntUpPv($a);
}

// make ranking
$ranking->makeAccessRanking(1);

// get ranking
var_dump($ranking->getAccessRanking(1));

/**
array(5) {
[0] =>
string(1) "1"
[1] =>
string(1) "5"
[2] =>
string(1) "4"
[3] =>
string(1) "3"
[4] =>
string(1) "2"
}
 */