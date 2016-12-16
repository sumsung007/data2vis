<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'Data2Vis 实验室 Lab';
?>

<?php
//Yii::$app->getView()->registerJsFile($url, $params, $key);
//Yii v1.1格式
//Yii::$app->clientScript->registerCssFile('./keditor4/themes/default/default.css');
Yii::$app->getView()->registerCssFile('/data2vis/web_lib/kindeditor4/themes/default/default.css');
?>
<script charset="utf-8" src="/data2vis/web_lib/kindeditor4/kindeditor-min.js"></script>
<script type="text/javascript">
    KindEditor.ready(function(K) {
        editor = K.create('#d_text', {
            allowFileManager: true,
            resizeType: 1,
            newlineTag: 'p'
        });
    });
</script>

<div class="site-index">
    <div class="body-content">        
        <div class="row">
            <div class="col-lg-2">

            <?PHP
                $tks=array_keys($tree);
                foreach ($tks as $k1)
                {
                    echo "<h4>$k1</h4>";

                    $t2s=$tree2[$k1];
                    //print_r($t2s);
                    $tks2=array_keys($t2s);
                    echo "<ul>";
                    foreach ($tks2 as $k2)
                    {
                        echo "<li>$k2</li>";
                    }
                    echo "</ul>";
                }

                ?>
            </div>

            <div class="col-lg-10">
                <h2>实验室 Lab</h2>
                <p>
                    New Post：
                </p>
                <form name="inpForm" action="./index.php?r=lab/add2done" method="POST">
                <?php
                echo '<p>
                    标题：<input type="text" name="d_title" id="d_title" size="100" value=""></input>
                    </p>';
                echo '<p>
                    <span class="inputTitle">类别：</span>
                        <select id="d_class" name="d_class" >';
//                foreach ($class1 as $r1) {
//                    echo "<option value='" . $r1 . "' >" . $r1 . "</option>";
//                }
                echo "</select>
                    </p>";
/*
                echo "<br /><br /><span class='inputTitle'>数据组织位置：</span>";
                echo CHtml::dropDownList(
                        'dc', //name
                        $dc0, //selected
                        $dcis //items
                );
*/
                echo "<p>文字：</p>";
                echo '<textarea  name="d_text" id="d_text" value="" style="width:100%;height:500px"></textarea>';
                echo "<br />";
                ?>
                <input type="submit" value="创建..." />
                <br /><br />
            </form>
            </div>

        </div>

    </div>
</div>
