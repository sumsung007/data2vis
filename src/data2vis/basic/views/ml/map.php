<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'ML';
?>

<script type="text/javascript" src="/data2vis/web_lib/openlayers2/OpenLayers.js"></script>

<script type="text/javascript">
    function goDrawMt()
    {
        xi = document.getElementById("minx").value;
        xx = document.getElementById("maxx").value;
        yi = document.getElementById("miny").value;
        yx = document.getElementById("maxy").value;

        para1 = "&minx=" + xi + "&maxx=" + xx + "&miny=" + yi + "&maxy=" + yx;
        //alert(para1);
        url0 = "./index.php?r=ml/map2mt" + para1;
        window.open(url0, "_blank");
    }

    function goDrawDepth()
    {
        xi = document.getElementById("minx").value;
        xx = document.getElementById("maxx").value;
        yi = document.getElementById("miny").value;
        yx = document.getElementById("maxy").value;

        para1 = "&minx=" + xi + "&maxx=" + xx + "&miny=" + yi + "&maxy=" + yx;
        //alert(para1);
        url0 = "./index.php?r=ml/map2depth" + para1;
        window.open(url0, "_blank");

    }
</script>

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

            <div class="col-lg-7">
                <h2>空间分布</h2>
                操作：ctrl+鼠标左键拖动选择区域，shift+鼠标左键拖动放大选择区域，鼠标左键双击放大，鼠标左键按下拖动移动地图显示范围。
                <br /><br />
                <form name="inpForm" action="./index.php?r=app/drawMt" method="POST" target="_blank">
                    经度范围：
                    <?php
                    echo "<input type='text' name='minx' id='minx' value='65.0' size='6'> </input>-<input  type='text' name='maxx' id='maxx' value='140.0' size='6'> </input>";
                    ?>
                    纬度范围：
                    <?php
                    echo "<input  type='text' name='miny' id='miny' value='15.0' size='6'> </input>-<input  type='text' name='maxy'  id='maxy' value='60.0' size='6'> </input>";
                    ?>
                    <input type="button" value="绘图 M-T" onClick='goDrawMt()' />
                    <input type="button" value="绘图 深度3D" onClick='goDrawDepth()' />
                    <br />
                    <br />
                </form>
                <div id="syc_map" style="width: 100%; height: 600px; border: 1px solid #000;margin:0 auto">
                </div>
                <br />
                <div id="dataInfo"></div>
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
                    echo "var point = new OpenLayers.Geometry.Point(" . $s1['sc_lon'] . "," . $s1['sc_lat'] . ");
                  pmss[$i]=" . $s1['sc_m'] . ";
                  pts[$i]=point;
                  //ptxts[$i]='" . $s1['sc_m'] . "-" . $s1['sc_place'] . "';
                  ptxts[$i]='发震时刻：" . $s1['sc_datetime'] . "\\n地震震级：Ms" . $s1['sc_m'] . "\\n震源深度：" . $s1['sc_depth'] . "(km)\\n参考位置：" . $s1['sc_place'] . "';
            ";
                    $i++;
                }
                echo "</script>";
                ?>

                <script type="text/javascript">
                    var map;
                    function init_1()
                    {
                        map = new OpenLayers.Map("syc_map", {
                            eventListeners: {
                                'zoomend': map_on_zoomend,
                                'moveend': map_on_moveend
                            }
                        });

                        //map.addControl(new OpenLayers.Control.PanZoomBar());
                        //map.addControl(new OpenLayers.Control.MousePosition());
                        var ctlPos = new OpenLayers.Control.MousePosition();
                        ctlPos.title = "鼠标位置的经纬度数值";  //ok
                        ctlPos.numDigits = 4;
                        ctlPos.prefix = "当前位置(经度,纬度)：";
                        //ctlPos.suffix="&nbsp;&nbsp;&nbsp;&nbsp;<p style='width:400px;height:600px'></p><br /><br />"; //html有效,style部分有效，比如width就无效
                        ctlPos.suffix = "&nbsp;&nbsp;"; //html有效,style部分有效，比如width就无效
                        map.addControl(ctlPos); //ok

                        map.addControl(new OpenLayers.Control.LayerSwitcher());
                        //map.addControl(new OpenLayers.Control.Scale());
                        map.addControl(new OpenLayers.Control.ScaleLine());

                        boxLayer=new OpenLayers.Layer.Boxes("矩形选择区域");
                        boxLayer.displayInLayerSwitcher=false;
                        map.addLayer(boxLayer);
                        var control = new OpenLayers.Control();
                        OpenLayers.Util.extend(control, {
                            draw: function () {
                                // this Handler.Box will intercept the shift-mousedown
                                // before Control.MouseDefault gets to see it
                                this.box = new OpenLayers.Handler.Box(control,
                                        {
                                            "done": this.notice
                                        },
                                        {
                                            keyMask: OpenLayers.Handler.MOD_CTRL
                                        }); //和 NavToolbar冲突
                                this.box.activate();
                            },
                            notice: function (bounds) {
                                var ll = map.getLonLatFromPixel(new OpenLayers.Pixel(bounds.left, bounds.bottom));
                                var ur = map.getLonLatFromPixel(new OpenLayers.Pixel(bounds.right, bounds.top));
                                document.getElementById('minx').value = ll.lon.toFixed(4);
                                document.getElementById('maxx').value = ur.lon.toFixed(4);
                                document.getElementById('miny').value = ll.lat.toFixed(4);
                                document.getElementById('maxy').value = ur.lat.toFixed(4);

                                var sel_ext = [ll.lon.toFixed(4), ll.lat.toFixed(4), ur.lon.toFixed(4), ur.lat.toFixed(4)];
                                var sel_bounds = OpenLayers.Bounds.fromArray(sel_ext);
                                var sel_box = new OpenLayers.Marker.Box(sel_bounds);
                                sel_box.setBorder("red") //ok

                                //先清除已经有的，只保留最后创建的一个
                                if (boxLayer.markers.length > 0)
                                {
                                    //oldSelBox=boxLayer.Markers[0]; not
                                    boxLayer.removeMarker(oldSelBox); //oldSelBox
                                }
                                boxLayer.addMarker(sel_box);
                                oldSelBox = sel_box;
                            }
                        });

                        map.addControl(control);


                    }
                    function setViewCenter(lon1, lat1, zoom1)
                    {
                        map.setCenter(new OpenLayers.LonLat(lon1, lat1), zoom1);
                    }

                    init_1();

                    var lyr0;
                    lyr0 = new OpenLayers.Layer.WMTS({name: "天地图-地形", url: "http://t0.tianditu.com/ter_c/wmts/", layer: "ter", matrixSet: "c", format: "tiles", style: "default", isBaseLayer: true});
                    map.addLayer(lyr0);
                    lyr0 = new OpenLayers.Layer.WMTS({name: "天地图-影像", url: "http://t0.tianditu.com/img_c/wmts/", layer: "img", matrixSet: "c", format: "tiles", style: "default", opacity: 1, isBaseLayer: true});
                    map.addLayer(lyr0);
                    lyr0 = new OpenLayers.Layer.WMTS({name: "天地图-地图", url: "http://t0.tianditu.com/vec_c/wmts/", layer: "vec", matrixSet: "c", format: "tiles", style: "default", opacity: 1, isBaseLayer: true});
                    map.addLayer(lyr0);

                    var lyr1;
                    lyr1 = new OpenLayers.Layer.WMTS({name: "天地图-地形-标注", url: "http://t0.tianditu.com/cta_c/wmts/", layer: "cta", matrixSet: "c", format: "tiles", style: "default", isBaseLayer: false});
                    map.addLayer(lyr1);
                    lyr1.setVisibility(false); //默认关闭显示

                    setViewCenter(103.0, 37.0, 4);
                    //map.refresh();
                    {
                        /*
                         var vl_data_point = new OpenLayers.Layer.Vector('数据(point)');
                         map.addLayer(vl_data_point);

                         var point, feature_point;
                         point = new OpenLayers.Geometry.Point(98.5, 32.0);
                         feature_point = new OpenLayers.Feature.Vector(point, {
                         'title': 'Ms5.0',
                         'description': '地震位置显示测试',
                         label: '左上角点',
                         size: 5.0*2.0,
                         });
                         vl_data_point.addFeatures([feature_point]);
                         */
                        var vl_data_point = new OpenLayers.Layer.Vector('数据(point)');
                        vl_data_point.displayInLayerSwitcher=false;
                        map.addLayer(vl_data_point);

                        var point, feature_point;
                        for (i = 0; i < pts.length; i++)
                        {
                            point = pts[i];
                            feature_point = new OpenLayers.Feature.Vector(point, {
                                'title': pmss[i],
                                'description': ptxts[i],
                                label: pmss[i],
                                size: pmss[i] * 1.6,
                            });
                            vl_data_point.addFeatures([feature_point]);
                        }
                        map.addLayer(vl_data_point);

                        var vector_style = new OpenLayers.Style({
                            'cursor': 'pointer',
                            'fillColor': 'yellow',
                            'fillOpacity': 0.8,
                            'strokeColor': 'red', //'#aaee77',
                            'strokeWidth': 1,
                            'pointRadius': '${size}', //6
                            'graphicName': 'circle'
                        });

                        var vector_style2 = new OpenLayers.Style({
                            'fillColor': 'blue', //'#669933',
                            'fillOpacity': 0.3,
                            'strokeColor': 'red', //'#0000ff', //'#aaee77',
                            'strokeWidth': 2,
                            'pointRadius': '${size}', //8
                            'graphicName': 'circle',
                            'labelAlign': 'lt', //好像与一般理解是反的，针对的不是icon，而是text的位置定义，测试后确定
                            'label': '${label}',
                            'labelXOffset': 10, //默认的规则是cc，
                            'labelYOffset': -10  //向下移动??
                        });

                        var vector_style_map = new OpenLayers.StyleMap({
                            'default': vector_style,
                            'select': vector_style2
                        });

                        //设置当时无效果，需要刷新
                        vl_data_point.styleMap = vector_style_map;
                        vl_data_point.redraw(); //ok

                        vl_data_point.events.register('featureselected', this, selected_feature);
                        vl_data_point.events.register('featureunselected', this, on_unselect_feature);
                        var select_feature_control = new OpenLayers.Control.SelectFeature(vl_data_point,
                                {
                                    multiple: false,
                                    toggle: true,
                                    multipleKey: 'shiftKey'
                                }
                        );
                        map.addControl(select_feature_control);
                        select_feature_control.activate();

                    }


                    // Needed only for interaction, not for the display.
                    function onPopupClose(evt) {
                        // 'this' is the popup.
                        var feature = this.feature;
                        if (feature.layer) { // The feature is not destroyed
                            selectControl.unselect(feature);
                        } else { // After "moveend" or "refresh" events on POIs layer all
                            //     features have been destroyed by the Strategy.BBOX
                            this.destroy();
                        }
                    }
                    //ok
                    function selected_feature(event) {
                        //var display_text = '当前选择数据对象：' + event.feature.attributes.title + ' \n 描述：' + event.feature.attributes.description;
                        //ok，div中可以选择，即：当前只显示名称，如果有需要可以点击link，单独查看其详细信息，不需要先总是search，也不总是点击就显示，会多了很多不需要的

                        //ok
                        //var display_text = '当前选择数据对象：<a href="http://www.sohu.com" target="_dataInfo">' + event.feature.attributes.title + '</a> \n 描述：' + event.feature.attributes.description;//
                        var display_text = event.feature.attributes.description;
                        //
                        //ok,2 input
                        //var info_div = document.getElementById('dataSel');
                        //info_div.value = display_text;
                        var info_div = document.getElementById('dataInfo');
                        info_div.innerHTML = display_text;

                        feature = event.feature;
                        popup = new OpenLayers.Popup.FramedCloud("featurePopup",
                                feature.geometry.getBounds().getCenterLonLat(),
                                new OpenLayers.Size(100, 100),
                                "<h2>" + feature.attributes.title + "</h2>" +
                                feature.attributes.description,
                                null, true, onPopupClose);
                        feature.popup = popup;
                        popup.feature = feature;
                        //map.addPopup(popup, true); //ok，但是显示效果不漂亮

                        //类似qz台站的方式显示数据  ??
                    }
                    function on_unselect_feature(event) {
                        //Store a reference to the element
                        var info_div = document.getElementById('dataInfo');
                        //Clear out the div
                        info_div.innerHTML = '';

                        feature = event.feature;
                        if (feature.popup) {
                            popup.feature = null;
                            map.removePopup(feature.popup);
                            feature.popup.destroy();
                            feature.popup = null;
                        }

                    }

                    function map_on_zoomend(event) {
                        //alert('You finished zooming');

                        //内容过滤没有问题，但是就是不显示地震符号了？？

                        //处理当前map空间范围
                        var mb=map.getExtent();
                        var x0=mb.left;
                        var x1=mb.right;
                        var y0=mb.bottom;
                        var y1=mb.top;
                        //url0 = './index.php?r=ml/ajax2sc2list';
                        url0 = './index.php?r=ml/ajax2sc2list&minx='+x0+'&maxx='+x1+
                                '&miny='+y0+'&maxy='+y1;
                        //alert(url0);
//??影响了map绘制地震符号？？
/* ？？ drag应该可以代替zoom的一些操作
                        jQuery.ajax({
                            'url': url0,
                            'cache': false,
                            'success': function (html) {
                                jQuery("#scList").html(html);
                            }
                        });
                        */
                    }
                    //map.events.register('zoomend', map, alert_on_zoom);

//还需要处理pan，否则不更新地震列表
/*
 BROWSER_EVENTS: [
        "mouseover", "mouseout",
        "mousedown", "mouseup", "mousemove", 
        "click", "dblclick", "rightclick", "dblrightclick",
        "resize", "focus", "blur"
    ],
查到map类中的这个常量 EVENT_TYPES: [
        "preaddlayer", "addlayer", "removelayer", "changelayer", "movestart",
        "move", "moveend", "zoomend", "popupopen", "popupclose",
        "addmarker", "removemarker", "clearmarkers", "mouseover",
        "mouseout", "mousemove", "dragstart", "drag", "dragend",
        "changebaselayer"],
            */
                    function map_on_moveend(event)
                    {
                        //alert('You finished zooming');

                        //内容过滤没有问题，但是就是不显示地震符号了？？

                        //处理当前map空间范围
                        var mb=map.getExtent();
                        var x0=mb.left;
                        var x1=mb.right;
                        var y0=mb.bottom;
                        var y1=mb.top;
                        //url0 = './index.php?r=ml/ajax2sc2list';
                        url0 = './index.php?r=ml/ajax2sc2list&minx='+x0+'&maxx='+x1+
                                '&miny='+y0+'&maxy='+y1;
                        //alert(url0);
                        /* ok，有效果，但是也影响 seis符号显示
                        $.get(
                                url0,
                                function(data,status){
                                    alert("Data: " + data + "\nStatus: " + status);
                                  }
                               );
                       */
//??影响了map绘制地震符号？？
/*
                        jQuery.ajax({
                            'url': url0,
                            'cache': false,
                            'success': function (html) {
                                jQuery("#scList").html(html);
                            }
                        });
                        */
                    }
                //map.events.register('dragend', map, map_on_moveend);无效果，在map中定义就可以

                </script>
            </div>
            <div class="col-lg-3" >
                <div id="scList">
                <?PHP
                //初始化显示：以后显示是不刷新page，而只是map zoom响应
                    echo "<ol style='font-size:12px'>";
                    $scIdx=0;
                    foreach ($sc0 as $s1)
                    {
                        if($scIdx>15)
                            break;

                        //$sp = sprintf("%s，Ms %.1f，%s", $s1['sc_datetime'], $s1['sc_m'], $s1['sc_place']);
                        $sp = sprintf("Ms %.1f<br />%s<br />%s",  $s1['sc_m'],$s1['sc_datetime'], $s1['sc_place']);
                        //echo "<li>" . $sp . "</li>";

                        $scIdx++;
                    }
                    echo "</ol>";
                ?>
                    </div>
            </div>
        </div>
    </div>
</div>
