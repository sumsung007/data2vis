<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

/* Yii中是可以调用的，而Yii2中不行了，改在view中可以
  function showScMenu2($mid)
  {
  $m="
  <h4>首页</h4>
  <h4>列表*</h4>
  <h4>2D 代码实现</h4>
  <h4>3D 功能设计</h4>
  <h4>3D 代码实现</h4>
  ";
  echo $m;
  }
 */
function getScTree()
{
    $ma = array(
        "index" => "介绍",
        "sta2map4baidu" => "台站分布(百度地图)",
        //"sta2map4tdt" => "台站分布(天地图)",
        "list&pageNum=1" => "地震目录列表",
        "map4baidu" => "空间分布(百度地图)",
        "map" => "空间分布(天地图)",
        "map4echart" => "空间分布(中国范围)",
        "heat" => "空间热度图",
    );
    return $ma;
}

function getMlStaNet()
{
    //$connection = Yii::app()->db;  Yii格式
    $connection = Yii::$app->db;  //Yii2格式
    $sql = "select distinct netcode from tb_ml_station";
    $command = $connection->createCommand($sql);
    $res = $command->queryAll();
    return $res;
}

function getMlSta()
{
    //$connection = Yii::app()->db;  Yii格式
    $connection = Yii::$app->db;  //Yii2格式
    $sql = "select * from tb_ml_station";
    $command = $connection->createCommand($sql);
    $res = $command->queryAll();
    return $res;
}

function getPagingData_sql2($pageSize, $pageNum, $sqlData,$sqlCount)
    {
        //****无_post，即直接过滤显示内容，比如thesis，也不需要session，每次直接使用sql
        $mi["pageNum"] = $pageNum;  //当前页码
        $mi["pageSize"] = $pageSize; //每页显示row的数量
        $mi["postCount"] = 0; //每页显示row的数量
        $mi["pageCount"] = 0; //页数

        $pn0 = $pageNum;
        //limit操作的起始
        $pn1 = ($pn0 - 1) * $pageSize;

        $sql0 = "";
        $postCount = 0;

        //查询最少数据，应该速度更快
        $sql0count = $sqlCount;
        $result0count = Yii::$app->db->createCommand($sql0count)->queryAll();
        $postCount = count($result0count);

        $sql0 = $sqlData;
        $sql = "$sql0 limit $pn1,$pageSize";
        $result = Yii::$app->db->createCommand($sql)->queryAll();
        $pages = ceil($postCount / $pageSize);

        $mi["data1"] = $result;  //当前页row数据
        $mi["pageCount"] = $pages;  //总页数
        $mi["postCount"] = $postCount;  //row总数量

        return $mi;
    }

function getScCat0($order='asc')
{
    //$scs = array();
    //$connection = Yii::app()->db;  Yii格式
    $connection = Yii::$app->db;  //Yii2格式
    //$sql = "select * from tb_data_seis_cat_3 order by scid $order";
    $sql = "select * from tb_ml_china3 order by scid $order";
    $command = $connection->createCommand($sql);
    $res = $command->queryAll();
    return $res;
}

function getScCat5($minx,$maxx,$miny,$maxy)
{
    $connection = Yii::$app->db;  //Yii2格式
    $sql = "select * from tb_ml_china3 where (sc_lon>$minx and sc_lon<$maxx and sc_lat>$miny and sc_lat<$maxy) order by scid";
    $command = $connection->createCommand($sql);
    $res = $command->queryAll();
    return $res;
}

function getScCat0Top10($order='asc')
{
    //$scs = array();
    //$connection = Yii::app()->db;  Yii格式
    $connection = Yii::$app->db;  //Yii2格式
    $sql = "select * from tb_ml_china3 order by scid $order limit 10";
    $command = $connection->createCommand($sql);
    $res = $command->queryAll();
    return $res;
}

function getScCat0Rect($minx,$maxx,$miny,$maxy)
{
    //SET @g0 = GeomFromText('Polygon((4 4,4 5,5 5,5 4,4 4))');
    //SELECT did,d_title,MBRIntersects(@g0,d_geom) as y from tb_data
    //顺时针
    $p1 = $minx . ' ' . $miny;
    $p2 = $minx . ' ' . $maxy;
    $p3 = $maxx . ' ' . $maxy;
    $p4 = $maxx . ' ' . $miny;
    $p5 = $p1;
    $k5 = "MBRIntersects(sc_geom,GeomFromText('Polygon((" . $p1 . "," . $p2 . "," . $p3 . "," . $p4 . "," . $p5 . "))'))=1";
    //$k5="1=1"; #临时
//    $sql = "select * from tb_seis where (" . $k5 . ") order by sc_id "; //按照时间倒序, order by aid,order by a_time desc
//    $model = TbSeis::model()->findAllBySql($sql);

    //$scs = array();
    //$connection = Yii::app()->db;  Yii格式
    $connection = Yii::$app->db;  //Yii2格式
    $sql = "select * from tb_ml_china3 where (" . $k5 . ") order by scid asc";
    $command = $connection->createCommand($sql);
    $res = $command->queryAll();
    return $res;
}

class MlController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $scs['tree']=  getScTree();
        return $this->render('index',$scs);
    }

    public function actionList($pageNum)
    {
//        $scs['sc0'] = getScCat0();

        $pageSize = 50;
        $sqlData = "select * from tb_ml_china3 order by scid desc";
        $sqlCount= "select * from tb_ml_china3";
        $mi = getPagingData_sql2($pageSize, $pageNum, $sqlData,$sqlCount);

        $mi['tree']=  getScTree();
        return $this->render('list', $mi);
    }

    public function actionMap()
    {
        $scs['sc0'] = getScCat0();
        $scs['tree']=  getScTree();
        return $this->render('map', $scs);
    }

    public function actionAjax2sc2list($minx,$maxx,$miny,$maxy)
    {
        $sc = getScCat5($minx,$maxx,$miny,$maxy);

        echo "<ol style='font-size:12px'>";
        $scIdx=0;
        foreach ($sc as $s1)
        {
            if($scIdx>15)
                break;

            //$sp = sprintf("%s，Ms %.1f，%s", $s1['sc_datetime'], $s1['sc_m'], $s1['sc_place']);
            $sp = sprintf("Ms %.1f<br />%s<br />%s",  $s1['sc_m'],$s1['sc_datetime'], $s1['sc_place']);
            echo "<li>" . $sp . "</li>";

            $scIdx++;
        }
        echo "</ol>";
    }

    public function actionMap2mt($minx,$maxx,$miny,$maxy)
    {
        $m["sc0"] = getScCat0Rect($minx, $maxx, $miny, $maxy); //一直显示目录
        $m['tree']=  getScTree();
        //$m["sc0"]=[];
        //print_r($m['sc0']);
        return $this->render('map2mt', $m);
    }

    public function actionMap2depth($minx,$maxx,$miny,$maxy)
    {
        $m["sc0"] = getScCat0Rect($minx, $maxx, $miny, $maxy); //一直显示目录
        $m['tree']=  getScTree();
        //$m["sc0"]=[];
        //print_r($m['sc0']);
        return $this->render('map2depth', $m);
    }

    public function actionMap4baidu()
    {
        $scs['sc0'] = getScCat0('desc');
        $scs['tree']=  getScTree();
        return $this->render('map4baidu', $scs);
    }

    public function actionMap4echart()
    {
        $m['sc0'] = getScCat0();
        $m['tree']=  getScTree();
        return $this->render('map4echart', $m);
    }

    public function actionSta2map4baidu()
    {
        $m['sta0'] = getMlSta();
        $m['tree']=  getScTree();
        return $this->render('sta2map4baidu', $m);
    }

    public function actionSta2map4tdt()
    {
        //台网
        $m['ddsNet']=getMlStaNet();
        //台站列表
        $m['ddsSta']= getMlSta();

        $m['tree']=  getScTree();
        return $this->render('sta2map4tdt', $m);
    }

    public function actionHeat()
    {
        $scs['sc0'] = getScCat0();
        $scs['tree']=  getScTree();
        return $this->render('heat', $scs);
    }


    public function actionAbout()
    {
        return $this->render('about');
    }

}
