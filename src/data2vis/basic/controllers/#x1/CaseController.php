<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

function getCaseClassTree()
{
    $cts=array(
        '地震烈度'=>100,
        '震源机制'=>200,
        'WebGIS'=>800,
    );

    return $cts;
}

function getCaseClassTree2()
{
    $cts2=array(
        '地震烈度'=>array(
            "ld2index" => "介绍",
            "ld2event" => "地震事件",
            "ld2map" => "综合显示",
        ),
        '震源机制'=>array(
            "zy2index" => "介绍",
            "zy2map" => "WebGIS显示",
            "zy2page" => "综合显示",
        ),
        'WebGIS'=>array(
            //"gis4baidu" => "基于百度地图",
            //"gis4qq" => "基于QQ地图",
            //"gis4google" => "基于Google地图",
            //"gis4tdt" => "基于天地图",
            "gis4vis" => "综合显示",
            "gis4mon" => "实时监控",
            "gis4data" => "数据分析",
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






}
