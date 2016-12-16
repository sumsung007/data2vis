<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

function getZyTree()
{
    $ma = array(
        "index" => "介绍",
        "map4baidu" => "综合显示(百度地图)",
        "map" => "综合显示(天地图)",
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

class ZyController extends Controller
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
        $scs['tree']=  getZyTree();
        return $this->render('index',$scs);
    }

    public function actionList()
    {
        $scs['sc0'] = getScCat0();
        $scs['tree']=  getScTree();
        return $this->render('list', $scs);
    }

    public function actionMap()
    {
        $scs['sc0'] = getScCat0();
        $scs['tree']=  getScTree();
        return $this->render('map', $scs);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

}
