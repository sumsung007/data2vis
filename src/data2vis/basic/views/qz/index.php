<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'QZ';
?>
<div class="site-index">
    <div class="body-content">        
        <div class="row">
            <div class="col-lg-2">
                <?PHP
                    $ks = array_keys($tree);
                    foreach ($ks as $k1)
                    {
                        echo "<h5><a href='./index.php?r=qz/" . $k1 . "' >" . $tree[$k1] . "</a></h5>";
                    }
                ?>
            </div>

            <div class="col-lg-10">
                <h2>地震前兆</h2>

            </div>

        </div>

    </div>
</div>
