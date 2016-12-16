<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'ML';
?>

<script src="/data2vis/web_lib/vis/moment-with-locales.min.js"></script>
<script type="text/javascript" src="/data2vis/web_lib/vis/vis.min.js"></script>
<link rel="stylesheet" type="text/css" href="/data2vis/web_lib/vis/vis.min.css" />

<div class="site-index">
    <div class="body-content">        
        <div class="row">
            <div class="col-lg-2">
                <?PHP
                    $ks = array_keys($tree);
                    foreach ($ks as $k1)
                    {
                        echo "<h5><a href='./index.php?r=ml/" . $k1 . "' >" . $tree[$k1] . "</a></h5>";
                    }
                ?>
            </div>

            <div class="col-lg-10">
                <h2>M-T</h2>
            说明：<br /><br />
            1.图形可以使用鼠标滚轮缩放时间轴，可以使用鼠标拖动时间轴；<br /><br />
            2.大于6.0的地震标注了震级和地名。<br /><br />

                <div id="visualization" style="width: 99%; height: 320px; margin-left: 20px;">
                </div>
                <?php
                echo "
            <script type='text/javascript'>
                var container = document.getElementById('visualization');
              var items = [
              ";
                foreach ($sc0 as $a1)
                {
                    $mag = $a1['sc_m'];
                    $sdt = $a1['sc_datetime'];
                    $label = $a1['sc_m'] . " " . $a1['sc_place'];
                    if ($mag > 6.0)
                    {
                        echo "
                    {x: '$sdt', y: $mag,label: { content: '$label',xOffset: -8,yOffset: -6 } },";
                    }
                    else
                    {
                        echo "
                        {x: '$sdt', y: $mag },";
                    }

                    //$dt=strtotime($sdt); //有24小时问题，会将23使用为11
                    //$dt=date_create_from_format('Y-m-d H:i:s',$sdt);  ok
                    //$vt=mktime(date('H',$dt),date('i',$dt),date('s',$dt),date('m',$dt),date('d',$dt),date('Y',$dt));
                    //$s1= date('Y-m-d  H:i:s', $vt0);
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
                      min: 0, max: 10
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
