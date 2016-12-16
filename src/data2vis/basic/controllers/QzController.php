<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

function getQzTree()
{
    $ma = array(
        "index" => "介绍",
        "sta2list&pageNum=1" => "前兆台站列表",
        "sta2map4baidu" => "前兆台站分布(百度地图)",
        "sta2map4tdt" => "前兆台站分布(天地图)",
        "spi2list&pageNum=1" => "测项列表",
        "draw1test" => "时序图形(分钟值)",
        //"spi2map4tdt" => "测项分布(天地图)",  地图显示不合适，因为不同测项是重复位置的，不同于station
//            "qz2graph" => "时序图形(分钟值/日)",
            //"qz2graph" => "时序异常检测时间线",
            //"qz2graph" => "测项小时值空间比对", 热力度，可以看出某点的值高
            //"qz2graph" => "测项值空间等值线绘图", 绘制等值线？必要性？

    );
    return $ma;
}

function getSpi()
{
    $connection = Yii::$app->db;  //Yii2格式
    //$sql = "select * from tb_data_qz_spi order by stationid,itemid";
    $sql = "select stationid,itemid,stationname,itemname from tb_qz_stationpointitem order by stationid,itemid";
    $command = $connection->createCommand($sql);
    $res = $command->queryAll();
    return $res;
}

function getSta()
{
    $sql="select DISTINCT stationid,stationname,unitcode,unitname from tb_qz_stationpointitem order by stationid";
    $connection = Yii::$app->db;
    $command = $connection->createCommand($sql);
    $res = $command->queryAll();
    return $res;
}

function getSta4map()
{
    $sql="select DISTINCT stationid,stationname,lon,lat from tb_qz_stationpointitem where stationid!='53057' order by stationid";
    $connection = Yii::$app->db;
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

class QzController extends Controller
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

    public function actionDraw1test()
    {
        /*
        $res="远程处理进行中...";
        //$file="/var/www/html/rds_data/qz/dyu01-53001_2_4112.dat.png";
        //not
        //if(is_file($file))
        //    $res="ok";
        $file="http://www.ncepe.cn/data2vis/basic/web/qz/dyu01-53001_2_4112.dat.png";
        if(file_exists($file))
            $res="ok";
        
        echo $res;
*/

        $scs['tree']=  getQzTree();
        return $this->render('draw1test',$scs);
    }

    public function actionIndex()
    {
        $scs['tree']=  getQzTree();
        return $this->render('index',$scs);
    }

    public function actionSta2list($pageNum)
    {
        //$m['qzSta']=  getSta();
        $pageSize = 50;
        $sqlData = "select DISTINCT stationid,stationname,unitcode,unitname from tb_qz_stationpointitem order by stationid";
        $sqlCount= "select DISTINCT stationid,stationname,unitcode,unitname from tb_qz_stationpointitem";
        $mi = getPagingData_sql2($pageSize, $pageNum, $sqlData,$sqlCount);
        $mi['tree']=  getQzTree();
        return $this->render('sta2list', $mi);
    }

    public function actionSta2map4baidu()
    {
        $m['tree']=  getQzTree();
        $m['qzSta']=  getSta4map();
        return $this->render('sta2map4baidu', $m);
    }

    public function actionSta2map4tdt()
    {
        $m['ddsSta'] = getSta4map();
        $m['tree']=  getQzTree();
        return $this->render('sta2map4tdt', $m);
    }

    public function actionSpi2list($pageNum)
    {
        //$m['spi0'] = getSpi();
        //$m['tree']=  getQzTree();
        $pageSize = 50;
        $sqlData = "select stationid,itemid,stationname,itemname from tb_qz_stationpointitem order by stationid,itemid";
        $sqlCount= "select stationid,itemid,stationname,itemname from tb_qz_stationpointitem";
        $mi = getPagingData_sql2($pageSize, $pageNum, $sqlData,$sqlCount);
        $mi['tree']=  getQzTree();
        return $this->render('spi2list', $mi);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    //LogLine等提示找不到？？而用js2log2line就可以
    public function actionAjax2log2line($rnd)
    {
        //echo "ok";

        $res="远程处理进行中...";
        //$file="/var/www/html/rds_data/qz/dyu01-53001_2_4112.dat.png";
        //$file="http://www.ncepe.cn/rds_data/qz/dyu01-53001_2_4112.dat.png";
        //$file="/home/_syc-rds/qz/dyu01/dyu01-53001_2_4112.dat.png";
        //$file="/home/_syc-rds/qz/dyu01/1.dat.png";
        //$file="/home/_dss/t1/test1.txt";
        //if(is_file($file)==true)
        //    $res="ok";

        //$url = 'http://www.ncepe.cn/rds_data/qz/dyu01-53001_2_4112.'.$rnd.'.dat.png';
        $url = 'http://www.ncepe.cn/rds_data/qz/'.$rnd.'.ok';

        if( @fopen( $url, 'r' ) ) 
        { 
//            echo 'File Exits';
            $res='ok';
        }         

        //$res='ok';
        echo $res;
    }




}
