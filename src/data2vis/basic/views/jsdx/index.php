<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'jsDawerx';
?>
<div class="site-index">
    <div class="body-content">        
        <div class="row">
            <div class="col-lg-2">
                <?PHP
                    $ks = array_keys($tree);
                    foreach ($ks as $k1)
                    {
                        echo "<h4><a href='./index.php?r=jsdx/" . $k1 . "' >" . $tree[$k1] . "</a></h4>";
                    }
                ?>

            </div>
            <div class="col-lg-10">
                <h2>jsDrawerX</h2>

            </div>

        </div>

    </div>
</div>
