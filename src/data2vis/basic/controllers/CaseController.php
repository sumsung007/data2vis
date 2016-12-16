<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

function get_wd()
{
    $connection = Yii::$app->db;  //Yii2格式
    $sql = "select t_dt,t_value from tb_ups_t order by t_dt";
    $command = $connection->createCommand($sql);
    $res = $command->queryAll();
    return $res;
}
function get_dy()
{
    $connection = Yii::$app->db;  //Yii2格式
    $sql = "select v_dt,v_value from tb_ups_v order by v_dt";
    $command = $connection->createCommand($sql);
    $res = $command->queryAll();
    return $res;
}

function getCaseClassTree()
{
    $cts=array(
        '机房环境监控'=>100,
        '波形系统'=>200,
        '实验场平台'=>300,
    );

    return $cts;
}

function getCaseClassTree2()
{
    $cts2=array(
        '机房环境监控'=>array(
            "jf2wd" => "温度",
            "jf2dy" => "电压",
        ),
        '波形系统'=>array(
            "bx2backup" => "备份日志",
            "bx2disk" => "存储空间",
        ),
        '实验场平台'=>array(
            "syc2server" => "服务器",
            "syc2service" => "服务",
            "syc2zt" => "状态",
        ),

    );

    return $cts2;
}

class CaseController extends Controller
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
        $m['tree']=  getCaseClassTree();
        $m['tree2']=  getCaseClassTree2();
        return $this->render('index',$m);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionJf2wd()
    {
        $m['tree']=  getCaseClassTree();
        $m['tree2']=  getCaseClassTree2();
        $m['data1']=  get_wd();
        return $this->render('jf2wd', $m);
    }

    public function actionJf2dy()
    {
        $m['tree']=  getCaseClassTree();
        $m['tree2']=  getCaseClassTree2();
        $m['data1']=  get_dy();
        //var_dump($m['data1']);
        return $this->render('jf2dy', $m);
    }



}
