<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'Data2Vis 实验室 Lab';
?>

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
                    <a href='./index.php?r=lab/add'>New Post...</a>
                </p>
                <div>
                    <?PHP
                    //print_r($rs);
                    //return;
                                    foreach ($rs as $r1)
                                    {
                                        echo "<h2>".$r1['lp_title']."</h2>";
                                        echo "<em>".$r1['lp_datetime']."</em>";
                                        echo "<p style='font-size:18px'>".$r1['lp_content']."</p>";
                                        echo "<hr>";
                                    }
                    ?>
                </div>
            </div>

        </div>

    </div>
</div>
