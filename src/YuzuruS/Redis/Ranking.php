<?php
namespace YuzuruS\Redis;
/**
 * Ranking
 *
 * @author Yuzuru Suzuki <navitima@gmail.com>
 * @license MIT
 */
class Ranking
{
    /** @var mixed Redis instance */
    private $redis;

    /** @var string redis's key prefix name. */
    private $prefix;

    /** @var int redis's expiration date. */
    private $expiration_date;

    /**
     * Ranking constructor.
     * @param null $redis
     * @param string $prefix
     * @param int $expiration_date 60*60*24*30 30 day
     */
    public function __construct($redis = null, $prefix = 'app:', $expiration_date = 2592000)
    {
        if (!$redis) {
            $redis = new \Redis();
            $redis->pconnect('127.0.0.1', 6379);
        }
        $this->redis = $redis;
        $this->prefix = $prefix;
        $this->expiration_date = $expiration_date;
    }

    /**
     * count up pv of article id
     *
     * @param $article_id
     * @return bool
     */
    public function cntUpPv($article_id)
    {
        $key = $this->prefix . date('Ymd') . ":article:pv";
        $this->redis->zincrby($key, 1, $article_id);

        // set redis's expiration date
        $this->redis->setTimeout($key, $this->expiration_date);
        return true;
    }

    /**
     * make access ranking for the specified date
     *
     * @param $day
     * @return bool
     */
    public function makeAccessRanking($day)
    {
        $keys = [];
        for ($i = 0; $i < $day; $i++) {
            $keys[] = $this->prefix . date('Ymd', strtotime("-{$i} day")) . ':article:pv';
        }
        $this->redis->zUnion($this->prefix . "{$day}_article_pv", $keys);
        return true;
    }

    /**
     * get access ranking for the specified date
     *
     * @param $day
     * @return array
     */
    public function getAccessRanking($day)
    {
        return $this->redis->zRevRange($this->prefix . "{$day}_article_pv", 0, -1);
    }
}