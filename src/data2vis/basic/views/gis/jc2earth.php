<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'ML';
?>

<script src="/data2vis/web_lib/cesium/Build/Cesium/Cesium.js"></script>
<style>
    @import url(/data2vis/web_lib/cesium/Build/Cesium/Widgets/widgets.css);
    html, body, #cesiumContainer {
        width: 100%; height: 100%; margin: 0; padding: 0; overflow: hidden;
    }
</style>

<style>
    div.olControlMousePosition {
        font-family: Verdana;
        font-size: 1.5em;
        color: red;
    }

    div.olControlScaleLine {
        font-size: 14px;        
        color:red;
    }   
</style>

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
                <h2>地球</h2>
                <div id="cesiumContainer" style="width: 99%; height: 450px; margin-left: 20px;">
                </div>
                <script>
                    var viewer = new Cesium.Viewer('cesiumContainer');

                    var wyoming = viewer.entities.add({
                        name: 'Wyoming',
                        polygon: {
                            hierarchy: Cesium.Cartesian3.fromDegreesArray([
                                98.5, 32.0,
                                104.5, 32.0,
                                104.5, 23.0,
                                98.5, 23.0]),
                            material: Cesium.Color.BLUE.withAlpha(0.32),
                            outline: true,
                            outlineColor: Cesium.Color.BLACK
                        }
                    });
                    wyoming.polygon.height = -2000;
                    wyoming.polygon.extrudedHeight = 50000;

                    var redBox = viewer.entities.add({
                        name: 'Red box with black outline',
                        position: Cesium.Cartesian3.fromDegrees(104.0, 30.0, 300000.0),
                        box: {
                            dimensions: new Cesium.Cartesian3(20000.0, 20000.0, 150000.0),
                            material: Cesium.Color.RED.withAlpha(0.8),
                            outline: true,
                            outlineColor: Cesium.Color.BLACK
                        }
                    });

                    var greenCylinder = viewer.entities.add({
                        name: 'Green cylinder with black outline',
                        position: Cesium.Cartesian3.fromDegrees(100.0, 25.0, 20000.0),
                        cylinder: {
                            length: 400000.0,
                            topRadius: 20000.0,
                            bottomRadius: 20000.0,
                            material: Cesium.Color.GREEN.withAlpha(0.5),
                            outline: true,
                            outlineColor: Cesium.Color.DARK_GREEN
                        }
                    });

                    var redCone = viewer.entities.add({
                        name: 'Red cone',
                        position: Cesium.Cartesian3.fromDegrees(105.0, 30.0, 20000.0),
                        cylinder: {
                            length: 400000.0,
                            topRadius: 0.0,
                            bottomRadius: 20000.0,
                            material: Cesium.Color.RED
                        }
                    });

                    //viewer.zoomTo(wyoming);
                </script>
            </div>

        </div>

    </div>
</div>
