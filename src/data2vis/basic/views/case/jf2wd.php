<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = '机房温度';
?>

<script src="/data2vis/web_lib/vis/moment-with-locales.min.js"></script>
<script type="text/javascript" src="/data2vis/web_lib/vis/vis.min.js"></script>
<link rel="stylesheet" type="text/css" href="/data2vis/web_lib/vis/vis.min.css" />

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
                <h2>当日机房温度</h2>
                <div id="visualization" style="width: 99%; height: 320px; margin-left: 20px;">
                </div>
                <?php
                echo "
            <script type='text/javascript'>
                var container = document.getElementById('visualization');
              var items = [
              ";
                foreach ($data1 as $a1)
                {
                    $mag = $a1['t_value'];
                    $sdt = $a1['t_dt'];
                    $label = $a1['t_value'];
                    if ($mag > 32.0)
                    {
                        echo "
                    {x: '$sdt', y: $mag,label: { content: '$label',xOffset: -8,yOffset: -6 } },";
                    }
                    else
                    {
                        echo "
                        {x: '$sdt', y: $mag },";
                    }
                }
                echo"
              ];

              var dataset = new vis.DataSet(items);
              var options = {
                style: 'bar',
                barChart: {width:1, align:'center'}, // align: left, center, right
                drawPoints: {
                  style: 'circle',
                  size: 0.5,
                },
                //drawPoints: false,
                dataAxis: {
                  left: {
                    range: {
                      min: 20, max: 35
                    }
                  }
                },
                width: '100%',
                height: '300px',
                locale: 'zh-cn',
              };
              var graph2d = new vis.Graph2d(container, dataset, options);
            </script>
            ";

                ?>


            </div>

        </div>

    </div>
</div>
