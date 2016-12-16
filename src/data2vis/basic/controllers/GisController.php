<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

function getGisClassTree()
{
    $cts=array(
        '基础地图'=>100,
        '空间数据'=>200,
        '综合应用'=>300,
    );

    return $cts;
}

function getGisClassTree2()
{
    $cts2=array(
        '基础地图'=>array(
            "jc2baidu" => "百度地图",
            "jc2tdt" => "天地图",
            "jc2earth" => "三维",
        ),
        '空间数据'=>array(
            "sj2fault" => "断裂(天地图)",
            "sj2zone" => "地震带(天地图)",
        ),
        '综合应用'=>array(
            "zh2d" => "二维(天地图)",
            "zh3d" => "三维",
        ),

    );

    return $cts2;
}

class GisController extends Controller
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
        $m['tree']=  getGisClassTree();
        $m['tree2']=  getGisClassTree2();
        return $this->render('index',$m);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionJc2baidu()
    {
        $m['tree']=  getGisClassTree();
        $m['tree2']=  getGisClassTree2();
        return $this->render('jc2baidu', $m);
    }
    public function actionJc2tdt()
    {
        $m['tree']=  getGisClassTree();
        $m['tree2']=  getGisClassTree2();
        return $this->render('jc2tdt', $m);
    }
    public function actionJc2earth()
    {
        $m['tree']=  getGisClassTree();
        $m['tree2']=  getGisClassTree2();
        return $this->render('jc2earth', $m);
    }




}
