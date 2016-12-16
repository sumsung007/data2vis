<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'ML';
?>

<script src="http://api.map.baidu.com/api?v=2.0&ak=0C7e2a27fde760e933c1887048490999" type="text/javascript"></script>

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
                        echo "<li><a href='./index.php?r=gis/".$k2."' >".$t2s[$k2]."</a></li>";
                    }
                    echo "</ul>";
                }
                ?>
            </div>

            <div class="col-lg-10">
                <h2>台站分布</h2>
                                <div id="syc_map" style="width:100%; height:700px; border: 2px solid #000;">
                                </div>

                                <script  type="text/javascript">
                                    var map = new BMap.Map("syc_map");          // 创建地图实例
                                    var point = new BMap.Point(103.0, 37.0);  // 创建点坐标
                                    map.centerAndZoom(point,5);                 // 初始化地图，设置中心点坐标和地图级别
                                    map.addControl(new BMap.MapTypeControl());
                                    map.addControl(new BMap.NavigationControl());

                                     //实验场范围
                                     var polyline = new BMap.Polyline([
                                     new BMap.Point(98.5, 32.0),
                                     new BMap.Point(104.5, 32.0),
                                     new BMap.Point(104.5, 23.0),
                                     new BMap.Point(98.5, 23.0),
                                     new BMap.Point(98.5, 32.0),
                                     ],
                                     {strokeColor: "red", strokeWeight: 2, strokeOpacity: 0.9, strokeStyle: "dashed"}
                                     );
                                     map.addOverlay(polyline);

                                </script>
                <br />
            </div>
        </div>
    </div>
</div>
