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
                <h2>深度3D</h2>
                说明信息<br /><br />
                1.可用鼠标拖动旋转显示。<br /><br />
                2.X轴为经度，Y轴为纬度，Z轴为深度。<br /><br />

                <div id="mygraph" style="width: 100%; height: 600px; margin-left: 20px;border: 1px solid red">
                </div>

                <?php
                echo "
<script type='text/javascript'>
    var data = null;
    var graph = null;

    // Called when the Visualization API is loaded.
    function drawVisualization() {
      var style ='dot' ; //document.getElementById('style').value;
      var withValue = ['bar-color', 'bar-size', 'dot-size', 'dot-color'].indexOf(style) != -1;
      //alert(withValue); //false,true
      //alert(style); ok
      // Create and populate a data table.
      data = new vis.DataSet();

    ";

                foreach ($sc0 as $a1)
                {
                    $x = $a1['sc_lon'];
                    $y = $a1['sc_lat'];
                    $mag = $a1['sc_m'];
                    $z = $a1['sc_depth'] * (-1);

                    echo "
                    x=$x;
                    y=$y;
                    z=$z;
                    v=$mag;
                    data.add({x:x, y:y, z: z,style: v});
                    //必须用变量设置，不能直接用数值
                    //data.add({ $x: $x,$y : $y,$z : $z,style: $mag});
                ";
                }

                echo "
      // specify options
      var options = {
        width:  '100%',
        height: '600px',
        //style: style,
        style: 'dot-size',
        showPerspective: false,
        showGrid: true,
        showShadow: false,

        // Option tooltip can be true, false, or a function returning a string with HTML contents
        //tooltip: true,
        tooltip: function (point) {
          // parameter point contains properties x, y, z
          return '深度: <b>' + point.z*(-1) + ' 公里</b>';
        },
        legendLabel: '震级符号直径',
        xLabel: '经度',
        yLabel: '纬度',
        zLabel: '深度',
        zMax: 0,
        axisColor: '#4D4D4D',
        dataColor:{fill: '#7DC1FF', stroke: '#3267D2', strokeWidth: 1},
        dotSizeRatio: 0.015,
        xValueLabel: function(value) {
            //return vis.moment().add(value, 'days').format('DD MMM');
            return value+'°';
        },

        yValueLabel: function(value) {
            return value + '°';
        },
        zValueLabel: function(value) {
            return value*(-1) + 'km';
        },
        keepAspectRatio: true,
        verticalRatio: 0.5
      };

      var camera = graph ? graph.getCameraPosition() : null;

      // create our graph
      var container = document.getElementById('mygraph');
      graph = new vis.Graph3d(container, data, options);

      if (camera) graph.setCameraPosition(camera); // restore camera position
    }
  </script>
              ";
                ?>

                <script type="text/javascript">
                    drawVisualization();
                </script>


            </div>

        </div>

    </div>
</div>
