<?php

namespace app\controllers;

use Yii;
//use yii\filters\AccessControl;
//use yii\web\Controller;
//use yii\filters\VerbFilter;

function getJsdxTree()
{
    $ma = array(
        "index" => "介绍",
        "app" => "应用",
    );
    return $ma;
}

class JsdxController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $m['tree']=  getJsdxTree();
        return $this->render('index',$m);
    }

    public function actionApp()
    {
        //$m['spi0'] = getSpi();
        $m['tree']=  getJsdxTree();

        return $this->render('app', $m);
    }


}
