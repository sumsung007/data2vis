<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

/* Yii中是可以调用的，而Yii2中不行了，改在view中可以

 */
function getBxTree()
{
    $ma = array(
        "index" => "介绍",
        "sta2map4tdt" => "测震台站分布(天地图)",
        //"event2list" => "地震事件列表（有seed的）",
        //"bx10min" => "最新波形显示（单台三分向，最新10min）",
        //"bx2cut" => "截取波形（单台三分向，指定长度）",
        //"bx4event" => "拾取事件（单台三分向，自动计算范围）",
        "draw1bx" => "波形截取绘制",
    );
    return $ma;
}

function getScCat0($order='asc')
{
    //$scs = array();
    //$connection = Yii::app()->db;  Yii格式
    $connection = Yii::$app->db;  //Yii2格式
    $sql = "select * from tb_data_seis_cat_3 order by scid $order";
    $command = $connection->createCommand($sql);
    $res = $command->queryAll();
    return $res;
}
//暂时是ml台站的复制
function getBxStaNet()
{
    //$connection = Yii::app()->db;  Yii格式
    $connection = Yii::$app->db;  //Yii2格式
    $sql = "select distinct netcode from tb_bx_station";
    $command = $connection->createCommand($sql);
    $res = $command->queryAll();
    return $res;
}

function getBxSta()
{
    //$connection = Yii::app()->db;  Yii格式
    $connection = Yii::$app->db;  //Yii2格式
    $sql = "select * from tb_bx_station";
    $command = $connection->createCommand($sql);
    $res = $command->queryAll();
    return $res;
}

class BxController extends Controller
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
        $m['tree']=  getBxTree();
        return $this->render('index',$m);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSta2map4tdt()
    {
        //台网
        $m['ddsNet']=getBxStaNet();
        //台站列表
        $m['ddsSta']= getBxSta();

        $m['tree']=  getBxTree();
        return $this->render('sta2map4tdt', $m);
    }

    public function actionDraw1bx()
    {
        $scs['tree']=  getBxTree();
        return $this->render('draw1bx',$scs);
    }

    public function actionAjax4rand()
    {
        // xxxx 不能用，因为ajax是异步执行的，获得的内容无法在后续使用
        srand(time());
        $rnd=rand(1000,99999);
        echo $rnd;
    }
    public function actionAjax2rand($rnd)
    {
        Yii::$app->session['bxRnd']=$rnd;
        echo '200';
    }

    public function actionAjax2log2line($rnd)
    {
        $res="远程处理进行中...";
        //$url = 'http://www.ncepe.cn/rds_data/bx/'.$rnd.'.png';
        $url = 'http://www.ncepe.cn/rds_data/bx/'.$rnd.'.ok';

        if( @fopen( $url, 'r' ) )
        {
//            echo 'File Exits';
            $res='ok';
        }

        //$res='ok';
        echo $res;
    }

}
