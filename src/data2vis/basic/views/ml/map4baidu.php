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
                    $ks = array_keys($tree);
                    foreach ($ks as $k1)
                    {
                        echo "<h5><a href='./index.php?r=ml/" . $k1 . "' >" . $tree[$k1] . "</a></h5>";
                    }
                ?>
            </div>

            <div class="col-lg-10">
                <h2>空间分布</h2>
                                <div id="syc_map" style="width:100%; height:700px; border: 2px solid #000;">
                                </div>
                                <?php
                                echo '<script type="text/javascript">';
                                echo "
            var pts=new Array();
            var ptxts=new Array();
            var pmss=new Array();
            ";
                                $i = 0;
                                foreach ($sc0 as $s1)
                                {
                                    echo "var point = new BMap.Point(" . $s1['sc_lon'] . "," . $s1['sc_lat'] . ");
                  pmss[$i]=" . $s1['sc_m'] . ";
                  pts[$i]=point;
                  ptxts[$i]='发震时刻：" . $s1['sc_datetime'] ."\\n地震震级：Ms". $s1['sc_m'] . "\\n震源深度：". $s1['sc_depth']."(km)\\n参考位置：" . $s1['sc_place'] . "';
            ";
                                    $i++;
                                }
                                echo "</script>";
                                ?>

                                <script  type="text/javascript">
                                    var map = new BMap.Map("syc_map");          // 创建地图实例
                                    var point = new BMap.Point(103.0, 37.0);  // 创建点坐标
                                    map.centerAndZoom(point,5);                 // 初始化地图，设置中心点坐标和地图级别
                                    map.addControl(new BMap.MapTypeControl());
                                    map.addControl(new BMap.NavigationControl());

                                    function addMarker(pt0, ms0, sLab0, index) {  // 创建图标对象

                                        //ok，但是创建的是单一大小的，并且位置有偏移
                                        //var marker = new BMap.Marker(pt0, {title: sLab0});        // 创建标注

                                        //var marker;
                                        if (index == 0)
                                        {
                                            var marker = new BMap.Marker(pt0, {
                                                title: sLab0,
                                                // 指定Marker的icon属性为Symbol
                                                //圆形，默认半径为1px。
                                                icon: new BMap.Symbol(BMap_Symbol_SHAPE_STAR, {
                                                    scale: ms0 * 0.3, //图标缩放大小，原始默认是10px，所以要缩小
                                                    strokeColor: 'red', //线颜色
                                                    strokeWeight: 2, //线宽度
                                                    fillColor: 'yellow', //填充颜色 ??好像无法设置为透明
                                                    fillOpacity: 0.8//填充透明度
                                                })
                                            });

                                            var lab2 = new BMap.Label(sLab0, {offset: new BMap.Size(20, -20)});
                                            //marker.setLabel(lab2); //ok
                                            marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画 ok

                                            map.addOverlay(marker);                     // 将标注添加到地图中
                                        } else
                                        {
                                            var marker = new BMap.Marker(pt0, {
                                                title: sLab0,
                                                // 指定Marker的icon属性为Symbol
                                                //圆形，默认半径为1px。
                                                icon: new BMap.Symbol(BMap_Symbol_SHAPE_CIRCLE, {
                                                    scale: ms0 * 1.5, //图标缩放大小 zzxx=3.5,index=1.5
                                                    strokeColor: 'red', //线颜色
                                                    strokeWeight: 1, //线宽度
                                                    fillColor: 'yellow', //填充颜色 ??好像无法设置为透明
                                                    fillOpacity: 0.8//填充透明度
                                                })
                                            });

                                            map.addOverlay(marker);                     // 将标注添加到地图中
                                        }

                                    }

                                    for (i = 0; i < pts.length; i++)
                                    {
                                        var pt = pts[i];
                                        addMarker(pt, pmss[i], ptxts[i], i);
                                    }
                                    /*
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
                                     */

                                </script>
                <br />
                <?PHP
                //print_r($sc0);
                echo "<ol>";
                foreach ($sc0 as $s1)
                {
                    $sp = sprintf("%s，Ms %.1f，%s", $s1['sc_datetime'], $s1['sc_m'], $s1['sc_place']);
                    //echo "<li>" . $sp . "</li>";
                }
                echo "</ol>";
                ?>
            </div>

        </div>

    </div>
</div>
