<?php

namespace app\controllers;
//namespace app\models; //增加会出错？？

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

use app\models\TbLabPost;

function getLabClassTree()
{
    $cts=array(
        'Web'=>100,
        'VC/MFC'=>200,
        'QT'=>300,
        'Python'=>400,
    );

    return $cts;
}

function getLabClassTree2()
{
    $cts2=array(
        'Web'=>array(
            'data2vis(*)'=>101,
        ),
        'VC/MFC'=>array(
            'Pde（VC6)'=>201,
            'dotPde(VS2012)'=>202,
            'You(Image)'=>203,
            'He(Vision)'=>204,
        ),
        'QT'=>array(
            'qtDt'=>301,
//            'qtPdeX'=>302,
            //'qtDrawer'=>303,
            'qtDrawerX'=>304
        ),
        'Python'=>array(
            'pyEdk'=>401,
        )
    );

    return $cts2;
}

class LabController extends Controller
{
    public $enableCsrfValidation = false;

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
        $m['tree']=  getLabClassTree();
        $m['tree2']=  getLabClassTree2();

        /* ok
        $sql="select * from tb_lab_post order by lpid";
        //$rs = TbLabPost::findBySql($sql)->orderBy('lpid');//->all();
        $rs = TbLabPost::findBySql($sql)->all(); //**必须有 all
        */

        $connection = Yii::$app->db;  //Yii2格式
        $sql = "select * from tb_lab_post order by lpid";
        $command = $connection->createCommand($sql);
        $res = $command->queryAll();

        $m['rs']=$res;

        return $this->render('index',$m);
    }

    public function actionAdd()
    {
        $m['tree']=  getLabClassTree();
        $m['tree2']=  getLabClassTree2();

        return $this->render('add',$m);
    }

    public function actionAdd2done()   //好像AddDone不行，提示找不到
    {
        $m['tree']=  getLabClassTree();
        $m['tree2']=  getLabClassTree2();

        //调用gii
        //http://localhost/data2vis/basic/web/index.php?r=gii
        
        $sql='select * from tb_lab_post';
        $rs=TbLabPost::findBySql($sql);

// 获取 country 表的所有行并以 name 排序
//$countries = Country::find()->orderBy('name')->all();
// 获取主键为 “US” 的行
//$country = Country::findOne('US');
// 输

        if ($_POST == NULL)
        {
            $this->redirect(Yii::app()->request->getUrlReferrer());
        }
        else
        {
            //处理内容
            //$lpid = $_POST["bid"];
            $d_title = $_POST["d_title"];
            //$d_class = $_POST["d_class"];
            $d_class =100;
            $d_class2 =0;
            $d_text = $_POST["d_text"];

            //echo $d_title;
            //return;

            $dr1 = new TbLabPost();
            $dr1->lp_datetime = date('Y-m-d H:i:s', time());
            //$dr1->a_poster = Yii::app()->user->id;
            $dr1->lp_class = $d_class;
            $dr1->lp_title = $d_title;
            $dr1->lp_content = $d_text;

            if ($dr1->save() > 0)
            {
                //ok
            }
            else
            {
                //not
            }

            $this->redirect("./index.php?r=lab/index");
        }        
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
