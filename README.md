Simple Ranking library for Redis and PHP
=============================

[![Coverage Status](https://coveralls.io/repos/github/YuzuruS/redis-ranking/badge.svg?branch=master)](https://coveralls.io/github/YuzuruS/redis-ranking?branch=master)
[![Build Status](https://travis-ci.org/YuzuruS/redis-ranking.png?branch=master)](https://travis-ci.org/YuzuruS/redis-ranking)
[![Stable Version](https://poser.pugx.org/yuzuru-s/redis-ranking/v/stable)](https://packagist.org/packages/yuzuru-s/redis-ranking)
[![Download Count](https://poser.pugx.org/yuzuru-s/redis-ranking/downloads.png)](https://packagist.org/packages/yuzuru-s/redis-ranking)
[![License](https://poser.pugx.org/yuzuru-s/redis-ranking/license)](https://packagist.org/packages/yuzuru-s/redis-ranking)

Abstracting Redis's `Sorted Set` APIs and PHP to use as a ranking system.

Requirements
-----------------------------
- Redis
  - >=2.4
- PhpRedis extension
  - https://github.com/nicolasff/phpredis
- PHP
  - >=5.5 >=5.6, >=7.0
- Composer



Installation
----------------------------

* Using composer

```
{
    "require": {
       "yuzuru-s/redis-ranking": "1.0.*"
    }
}
```

```
$ php composer.phar update yuzuru-s/redis-ranking --dev
```

How to use
----------------------------
Please check [sample code](https://github.com/YuzuruS/redis-ranking/blob/master/sample/usecase.php)

```php
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
```


How to run unit test
----------------------------

Run with default setting.
```
% vendor/bin/phpunit -c phpunit.xml.dist
```

Currently tested with PHP 7.0.0 + Redis 2.6.12.


History
----------------------------
- 1.0.2
  - Bug fix
- 1.0.0
  - Published



License
----------------------------
Copyright (c) 2016 YUZURU SUZUKI. See MIT-LICENSE for further details.

Copyright
-----------------------------
- Yuzuru Suzuki
  - http://yuzurus.hatenablog.jp/
