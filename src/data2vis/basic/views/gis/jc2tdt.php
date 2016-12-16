<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'ML';
?>

<script type="text/javascript" src="/data2vis/web_lib/openlayers2/OpenLayers.js"></script>

<style>
    div.olControlMousePosition {
        font-family: Verdana;
        font-size: 1.2em;
        color: red;
    }

    div.olControlScaleLine {
        font-size: 12px;
        color:red;

    }
</style>

<script type="text/javascript">
    function intMap()
    {
        //map.setCenter(new OpenLayers.LonLat(101.0, 27.5), 6);
        map.setCenter(new OpenLayers.LonLat(105.0, 38.5), 4);
    }
</script>

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
                <h3>天地图</h3>
                <div id="sycmap" style="width: 100%; height: 600px; border: 1px solid #000;margin:0 auto">
                </div>

                <script type="text/javascript">
                    var map, lyr0, vlayer06;
                    map = new OpenLayers.Map("sycmap");
                    map.addControl(new OpenLayers.Control.LayerSwitcher()); //ok
                    map.addControl(new OpenLayers.Control.ScaleLine());

                    lyr0 = new OpenLayers.Layer.WMTS({name: "天地图-地形", url: "http://t0.tianditu.com/ter_c/wmts/", layer: "ter", matrixSet: "c", format: "tiles", style: "default", isBaseLayer: true});
                    map.addLayer(lyr0);
                    lyr0 = new OpenLayers.Layer.WMTS({name: "天地图-影像", url: "http://t0.tianditu.com/img_c/wmts/", layer: "img", matrixSet: "c", format: "tiles", style: "default", opacity: 1, isBaseLayer: true});
                    map.addLayer(lyr0);
                    lyr0 = new OpenLayers.Layer.WMTS({name: "天地图-地图", url: "http://t0.tianditu.com/vec_c/wmts/", layer: "vec", matrixSet: "c", format: "tiles", style: "default", opacity: 1, isBaseLayer: true});
                    map.addLayer(lyr0);

                    lyr0 = new OpenLayers.Layer.WMTS({name: "天地图-地形-标注", url: "http://t0.tianditu.com/cta_c/wmts/", layer: "cta", matrixSet: "c", format: "tiles", style: "default", isBaseLayer: false});
                    map.addLayer(lyr0);
                    //lyr0.setVisibility(false);

                    map.setCenter(new OpenLayers.LonLat(105.0, 38.5), 4);

                    //var permalink_control = new OpenLayers.Control.Permalink();
                    var ctlPos = new OpenLayers.Control.MousePosition();
                    ctlPos.title = "鼠标位置的经纬度数值";  //ok
                    ctlPos.numDigits = 4;
                    ctlPos.prefix = "当前位置(经度,纬度)：";
                    //ctlPos.suffix="&nbsp;&nbsp;&nbsp;&nbsp;<p style='width:400px;height:600px'></p><br /><br />"; //html有效,style部分有效，比如width就无效
                    ctlPos.suffix = "&nbsp;&nbsp;"; //html有效,style部分有效，比如width就无效
                    map.addControl(ctlPos); //ok

                </script>

            </div>
        </div>
    </div>
</div>
