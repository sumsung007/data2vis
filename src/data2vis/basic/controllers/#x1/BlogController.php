<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

function getBlogClassTree()
{
    $cts=array(
        'Web'=>100,
        'Database'=>200,
        'Gis'=>300,
        'Graphic'=>400,
        'Language'=>500,
        //'Lib/Kit'=>600,
        'Image/Vision'=>700,
        'Soft'=>800,
    );

    return $cts;
}

function getBlogClassTree2()
{
    $cts2=array(
        'Web'=>array(
            'Other'=>101,
            'Javascript'=>102,
            'Html5'=>103,
            'PHP/Yii'=>104
        ),
        'Database'=>array(
            'Db'=>201,
            //'MySQL'=>202,
            'noSQL'=>203,
        ),
        'Gis'=>array(
            'Other'=>301,
            'OpenLayers'=>302,
            'Cesium'=>303,
            'MapServer'=>304,
            'mapnik'=>305,
        ),
        'Graphic'=>array(
            'Other'=>401,
            'WebGL'=>402,
            'OSG'=>403,
            'OpenGL'=>404,
            'CGAL'=>405
        ),
        'Language'=>array(
            'Other'=>501,
            'C/C++'=>502,
            'QT'=>503,
            'Python'=>504,
            'C#'=>505,
            'golang'=>506,
        ),
        'Lib/Kit'=>array(
            'other'=>601,
            'OpenCL'=>602,
            'CUDA'=>603,
        ),
        'Image/Vision'=>array(
            'Other'=>700,
            'Image'=>701,
            'Vision'=>702,
            'OpenCV'=>703,
        ),
        'Soft'=>array(
            'Other'=>801,
            //'Matlab'=>802,
            'Linux'=>803,
            'CINEMA 4D'=>804,
            'Houdini'=>805,
            'Unity3D'=>806,
        )

    );

    return $cts2;
}

class BlogController extends Controller
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
        $m['tree']=  getBlogClassTree();
        $m['tree2']=  getBlogClassTree2();
        return $this->render('index',$m);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
