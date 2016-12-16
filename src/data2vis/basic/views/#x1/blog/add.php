<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'Data2Vis 博客 Blog';
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
                <h2>博客 Blog</h2>

            </div>

        </div>

    </div>
</div>
