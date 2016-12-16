<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'jk';
?>
<div class="site-index">
    <div class="body-content">        
        <div class="row">
            <div class="col-lg-2">
                <?PHP
                $tks=array_keys($tree);
                foreach ($tks as $k1)
                {
                    echo "<h5>$k1</h5>";

                    $t2s=$tree2[$k1];
                    //print_r($t2s);
                    $tks2=array_keys($t2s);
                    echo "<ul>";
                    foreach ($tks2 as $k2)
                    {
                        //echo "<li>$k2</li>";
                        //echo "<li>".$t2s[$k2]."</li>";
                        echo "<li><a href='./index.php?r=case/".$k2."' >".$t2s[$k2]."</a></li>";
                    }
                    echo "</ul>";
                }
                ?>
            </div>

            <div class="col-lg-10">
                <h2>监控</h2>

            </div>

        </div>

    </div>
</div>
