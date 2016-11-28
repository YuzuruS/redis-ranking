<?php
require __DIR__ . '/../vendor/autoload.php';
/**
 * RankingTest
 *
 * @version $id$
 * @copyright Yuzuru Suzuki
 * @author Yuzuru Suzuki <navitima@gmail.com>
 * @license PHP Version 3.0 {@link http://www.php.net/license/3_0.txt}
 */
use YuzuruS\Redis\Ranking;
class RankingTest extends \PHPUnit_Framework_TestCase
{
    public function testGetAccessRanking()
    {
        $redis = new \Redis();
        $redis->connect('127.0.0.1', 6379);

        $ranking = new Ranking($redis);

        $article_ids_of_accessed = [1,1,1,2,3,4,5,3,4,5,5,4,1,1,5];


        // count up pv of access ids
        foreach ($article_ids_of_accessed as $a) {
            $ranking->cntUpPv($a);
        }

        // make ranking
        $ranking->makeAccessRanking(1);
        $ranking = $ranking->getAccessRanking(1);

        $correct = [1,5,4,3,2];
        foreach ($ranking as $k => $v) {
            $this->assertEquals($v, $correct[$k]);
        }
    }

    public function tearDown()
    {
    }
}
