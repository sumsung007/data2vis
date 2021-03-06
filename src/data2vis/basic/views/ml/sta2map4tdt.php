<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'ML';
?>

<script type="text/javascript" src="/data2vis/web_lib/openlayers2/OpenLayers.js"></script>


<?php
//var_dump($ddsData11);
//var_dump($ddsNet);

echo '<script type="text/javascript">';
echo "
            var ptsx06=new Array();
            var ptsy06=new Array();
            var ptxts06=new Array();
            var pnet=new Array();
            var nets=new Array();
            ";
$i = 0;
foreach ($ddsSta as $d1)
{
    echo "        ptsx06[$i]=" . $d1['lon'] . ";
                  ptsy06[$i]=" . $d1['lat'] . ";
                  ptxts06[$i]='" . $d1['stationname'] . "';
                  pnet[$i]='" . $d1['netcode'] . "';
            ";
    $i++;
}
$i = 0;
foreach ($ddsNet as $d1)
{
    echo "        nets[$i]='" . $d1['netcode'] . "';
            ";
    $i++;
}

echo "
        </script>";
?>

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
    function GetRandomNum(Min, Max)
    {
        var Range = Max - Min;
        var Rand = Math.random();
        return(Min + Math.round(Rand * Range));
    }
    //var num = GetRandomNum(1,10);
    var getRandomColor = function () {
        return '#' + (Math.random() * 0xffffff << 0).toString(16);
    }
</script>

<script type="text/javascript">
    function showLabel06()
    {
        var i;
        for(i=0;i<staLyrs.length;i++)
        {
            var lyr1=staLyrs[i];
            var color1=staLyrColor[i];

            var vector_style = new OpenLayers.Style({
                'cursor': 'pointer',
                'fillColor': color1,
                'fillOpacity': 0.8,
                'strokeColor': color1, //'#aaee77',
                'strokeWidth': 2,
                'pointRadius': 4,
                'graphicName': 'triangle',
                //'label': 'seis',
                'label': '${label}',
                'fontSize': 12,
                'fontColor': color1,
                'labelOutlineColor': '#FFFFFF',
                'labelOutlineWidth': 2,
                'labelAlign': 'lt', //好像与一般理解是反的，针对的不是icon，而是text的位置定义，测试后确定
                'labelXOffset': 5, //默认的规则是cc，
                'labelYOffset': 10  //-5向下移动??
            });

            var vector_style_map = new OpenLayers.StyleMap({
                'default': vector_style
            });

            //设置当时无效果，需要刷新
            lyr1.styleMap = vector_style_map;
            lyr1.redraw(); //ok
        }
    }
    function hideLabel06()
    {
        var i;
        for(i=0;i<staLyrs.length;i++)
        {
            var lyr1=staLyrs[i];
            var color1=staLyrColor[i];
            var vector_style = new OpenLayers.Style({
                'cursor': 'pointer',
                'fillColor': color1,
                'fillOpacity': 0.8,
                'strokeColor': color1, //'#aaee77',
                'strokeWidth': 2,
                'pointRadius': 4,
                'graphicName': 'triangle',
            });

            var vector_style_map = new OpenLayers.StyleMap({
                'default': vector_style
            });

            //设置当时无效果，需要刷新
            lyr1.styleMap = vector_style_map;
            lyr1.redraw(); //ok
        }
    }
</script>

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
                <h3>台站分布</h3>
                <input type="button" id='toShowLabel06' onclick="showLabel06()" value="显示标签"  />
                &nbsp;&nbsp;
                <input type="button" id='toHideLabel06' onclick="hideLabel06()" value="隐藏标签" />
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="button" value="-初始化地图显示范围-" id="initMap" onClick='intMap()' />
                <br />

                <div id="sycmap" style="width: 100%; height: 600px; border: 1px solid #000;margin:0 auto">
                </div>

                <script type="text/javascript">
                    var map, lyr0;
                    var staLyrs=new Array();
                    var staLyrColor=new Array();
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
                    lyr0.setVisibility(false);

                    map.setCenter(new OpenLayers.LonLat(105.0, 38.5), 4);
                    //map.setCenter(new OpenLayers.LonLat(101.0, 27.5), 6);
                    //initMap();

                    //var permalink_control = new OpenLayers.Control.Permalink();
                    var ctlPos = new OpenLayers.Control.MousePosition();
                    ctlPos.title = "鼠标位置的经纬度数值";  //ok
                    ctlPos.numDigits = 4;
                    ctlPos.prefix = "当前位置(经度,纬度)：";
                    //ctlPos.suffix="&nbsp;&nbsp;&nbsp;&nbsp;<p style='width:400px;height:600px'></p><br /><br />"; //html有效,style部分有效，比如width就无效
                    ctlPos.suffix = "&nbsp;&nbsp;"; //html有效,style部分有效，比如width就无效
                    map.addControl(ctlPos); //ok

                    //ok,展开的
                    //map.addControl(new OpenLayers.Control.LayerSwitcher({div: document.getElementById('lyrs'), roundedCorner: false})); //ok
                    /*
                    {
                        vlayer06 = new OpenLayers.Layer.Vector('测震台站分布');
                        map.addLayer(vlayer06);
                        var point, feature_point;
                        for (i = 0; i < ptsx06.length; i++)
                        {
                            //addMarker(pts[i], ptxts[i], ids[i], dcodes[i], icons[i]);
                            point = new OpenLayers.Geometry.Point(ptsx06[i], ptsy06[i]);
                            feature_point = new OpenLayers.Feature.Vector(point, {label: ptxts06[i]});
                            vlayer06.addFeatures([feature_point]);
                        }
                        hideLabel06();
                    }
*/
                    {
                        //alert(nets.length); //33 ??
                        var j,sNet;
                        var point, feature_point;
                        for ( j= 0; j < nets.length; j++)
                        {
                            sNet = nets[j];
                            //var vlayer = new OpenLayers.Layer.Vector(sNet);
                            staLyrs[j] = new OpenLayers.Layer.Vector(sNet);
                            var vlayer=staLyrs[j]; //为了方便操作
                            map.addLayer(vlayer);

                            for (i = 0; i < ptsx06.length; i++)
                            {
                                if(sNet!=pnet[i])
                                    continue;
                                
                                //addMarker(pts[i], ptxts[i], ids[i], dcodes[i], icons[i]);
                                point = new OpenLayers.Geometry.Point(ptsx06[i], ptsy06[i]);
                                feature_point = new OpenLayers.Feature.Vector(point, {label: ptxts06[i]});
                                vlayer.addFeatures([feature_point]);
                            }
                            staLyrColor[j]=getRandomColor();                            
                        }
                        hideLabel06(); //每层都设置指定颜色
                    }

                </script>

            </div>
        </div>
    </div>
</div>
