<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/data_dz1.css" />        
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/left_bar_2.css" />        

<script type="text/javascript" src="./3rd/olyr/OpenLayers.js"></script>
<script type="text/javascript" src="./mycode1/map/syc_dtjs.js"></script> 
<?php
Yii::app()->clientScript->registerCoreScript('jquery');
?>

<!--内容区左边-->
<div class="dataDz_con_left">
    <!--侧栏导航条-->
    <div class="dataDz_list">
        <ul class="dataDz_list_ul1">
            <?php
            showMenu_data();
            part_data::showMenu_data_syc($resTop, $resSub, Yii::app()->request->getUrl(), 0);
            ?>
        </ul>
    </div>
</div>

<?php
$htmlData = '';
$minx = $modeSet->s_syc_minx;
$maxx = $modeSet->s_syc_maxx;
$miny = $modeSet->s_syc_miny;
$maxy = $modeSet->s_syc_maxy;
?>

<?php
//var_dump($ddsData11);

echo '<script type="text/javascript">';
echo "
            var ptsx06=new Array();
            var ptsy06=new Array();            
            var ptxts06=new Array();
            ";
$i = 0;
foreach ($ddsData06 as $d1)
{
    echo "        ptsx06[$i]=" . $d1['dip_lon'] . ";
                  ptsy06[$i]=" . $d1['dip_lat'] . ";
                  ptxts06[$i]='" . $d1['dip_name'] . "';
            ";
    $i++;
}

echo "
            var ptsx11=new Array();
            var ptsy11=new Array();            
            var ptxts11=new Array();
            ";
$i = 0;
foreach ($ddsData11 as $d1)
{
    echo "        ptsx11[$i]=" . $d1['dip_lon'] . ";
                  ptsy11[$i]=" . $d1['dip_lat'] . ";
                  ptxts11[$i]='" . $d1['dip_name'] . "';
            ";
    $i++;
}

echo "
        </script>";
?>


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

<script type="text/javascript">
    //需要用js实现，因为要活的鼠标操作拾取的经纬度范围
    //2016-06-04
    function filterMap()
    {
        //alert("filter"); ok

        xi = document.getElementById("minx").value;
        xx = document.getElementById("maxx").value;
        yi = document.getElementById("miny").value;
        yx = document.getElementById("maxy").value;
        //para1="&minx="+xi+"&maxx="+xx+"&miny="+yi+"&maxy="+yx;

        url0 = './index.php?r=data/jsMap_ajaxList&minx=' + xi + '&maxx=' + xx + '&miny=' + yi + '&maxy=' + yx;

        jQuery.ajax({
//                'url':'/syccn/index.php?r=data/jsMap_ajaxList&minx=98.5&maxx=104.5&miny=23.0&maxy=32.0',
            'url': url0,
            'cache': false,
            'success': function (html) {
                jQuery("#my01").html(html)
            }
        });
    }
    /* ok
     jQuery(function($) {
     jQuery('body').on('click','#searchMap',
     function(){jQuery.ajax({
     'url':'/syccn/index.php?r=data/jsMap_ajaxList&minx=98.5&maxx=104.5&miny=23.0&maxy=32.0',
     'cache':false,
     'success':function(html){jQuery("#my01").html(html)}});
     return false;});
     });
     */

    function intMap()
    {
        map.setCenter(new OpenLayers.LonLat(101.0, 27.5), 6);
    }

    function initSelBox()
    {
        boxLayer = new OpenLayers.Layer.Boxes("矩形选择区域");
//    boxLayer.displayInLayerSwitcher=false;
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
</script>

<script type="text/javascript">
    function showLabel06()
    {
        var vector_style = new OpenLayers.Style({
            'cursor': 'pointer',
            'fillColor': '#0000ff',
            'fillOpacity': 0.8,
            'strokeColor': '#0000ff', //'#aaee77',
            'strokeWidth': 2,
            'pointRadius': 4,
            'graphicName': 'triangle',
            //'label': 'seis',
            'label': '${label}',
            'fontColor': '#0000ff',
            'labelOutlineColor': '#FFFFFF',
            'labelOutlineWidth': 3,
            'labelAlign': 'lt', //好像与一般理解是反的，针对的不是icon，而是text的位置定义，测试后确定
            'labelXOffset': 5, //默认的规则是cc，
            'labelYOffset': 10  //-5向下移动??
        });

        var vector_style_map = new OpenLayers.StyleMap({
            'default': vector_style
        });

        //设置当时无效果，需要刷新
        vlayer06.styleMap = vector_style_map;
        vlayer06.redraw(); //ok
    }
    function hideLabel06()
    {
        //alert("hide");
        var vector_style = new OpenLayers.Style({
            'cursor': 'pointer',
            'fillColor': '#0000ff',
            'fillOpacity': 0.8,
            'strokeColor': '#0000ff', //'#aaee77',
            'strokeWidth': 2,
            'pointRadius': 4,
            'graphicName': 'triangle',
        });

        var vector_style_map = new OpenLayers.StyleMap({
            'default': vector_style
        });

        //设置当时无效果，需要刷新
        vlayer06.styleMap = vector_style_map;
        vlayer06.redraw(); //ok
    }

    function showLabel11()
    {
        var vector_style = new OpenLayers.Style({
            'cursor': 'pointer',
            'fillColor': '#FF0000',
            'fillOpacity': 0.8,
            'strokeColor': '#FF0000', //'#aaee77',
            'strokeWidth': 1,
            'pointRadius': 4,
            'graphicName': 'circle', //circle ok,square ok,diamond-not,支持”circle” , “square”, “star”, “x”, “cross”, “triangle”， 默认为”circle”
            //'label': 'seis',
            'label': '${label}',
            'fontColor': '#FF0000',
            'labelOutlineColor': '#FFFFFF',
            'labelOutlineWidth': 3,
            'labelAlign': 'lt', //好像与一般理解是反的，针对的不是icon，而是text的位置定义，测试后确定
            'labelXOffset': 5, //默认的规则是cc，
            'labelYOffset': -8  //-5向下移动??
        });

        var vector_style_map = new OpenLayers.StyleMap({
            'default': vector_style
        });

        //设置当时无效果，需要刷新
        vlayer11.styleMap = vector_style_map;
        vlayer11.redraw(); //ok
    }
    function hideLabel11()
    {
        var vector_style = new OpenLayers.Style({
            'cursor': 'pointer',
            'fillColor': '#FF0000',
            'fillOpacity': 0.8,
            'strokeColor': '#FF0000', //'#aaee77',
            'strokeWidth': 1,
            'pointRadius': 4,
            'graphicName': 'circle'  //circle ok,square ok,diamond-not,支持”circle” , “square”, “star”, “x”, “cross”, “triangle”， 默认为”circle”
        });

        var vector_style_map = new OpenLayers.StyleMap({
            'default': vector_style
        });

        //设置当时无效果，需要刷新
        vlayer11.styleMap = vector_style_map;
        vlayer11.redraw(); //ok
    }
</script>

<!--内容区右边-->
<div class="dataDz_con_right">
    <!--内容区右边上面显示当前路径-->
    <div class="dataDz_breadcrumbs">
        <a href="#" class="dataDz_desc" >您现在的位置：首页</a>--
        <span class="dataDz_desc" >数据共享</span>--
        <span class="dataDz_desc1">空间位置检索</span>
        <hr>                    
    </div>
    <!--内容区右边内容区-->
    <div class="dataDz_con_right_info">
        <div class="dataDz_con_right_info_con1">
            <input type="button" id='toShowLabel06' onclick="showLabel06()" value="测震-显示标签"  />
            &nbsp;&nbsp;
            <input type="button" id='toHideLabel06' onclick="hideLabel06()" value="测震-隐藏标签" />
            &nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" id='toShowLabel11' onclick="showLabel11()" value="GNSS-显示标签"  />
            &nbsp;&nbsp;
            <input type="button" id='toHideLabel11' onclick="hideLabel11()" value="GNSS-隐藏标签" />
            &nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" value="-初始化地图显示范围-" id="initMap" onClick='intMap()' />
            <br /><br />

            <table style="width:100%;border: 1px solid #000">
                <tr>
                    <td>
                        <div id="sycmap" style="width: 98%; height: 600px; border: 1px solid #000;margin:0 auto">
                        </div>
                    </td>
                    <td style='width:240px;text-align: left;vertical-align: top' >
                        <p style='margin: 10px 0px 5px 0px'>
                            地图图层显示控制：
                        </p>
                        <div id='lyrs' style='margin: 0px 0px 10px 0px'>
                        </div>
                        <svg width='12' height='12'><rect x='1' y='1' width='11' height='11' stroke='blue' fill='blue'></rect></svg>
                        测震数据
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <svg width='12' height='12'><rect x='1' y='1' width='11' height='11' stroke='red' fill='red'></rect></svg>
                        GNSS数据
                        <br /><br />
                        <hr>
                        操作提示：
                        <ul style=' list-style-type:  none;line-height: 22px;'>
                            <li>-在地图上ctrl+鼠标左键拖动选择区域</li>
                            <li>-shift+鼠标左键拖动放大选择区域</li>
                            <li>-鼠标左键双击放大</li>
                            <li>-鼠标左键按下拖动移动地图显示范围</li>
                        </ul>
                        <hr>
                        <br />
                        经度范围：<br />
                        <?php
                        echo "<input type='text' name='minx' id='minx' value=" . $minx . " size='8'> </input>-<input  type='text' name='maxx' id='maxx' value=" . $maxx . " size='8'> </input>";
                        ?>
                        <br /><br />
                        纬度范围：<br />
                        <?php
                        echo "<input  type='text' name='miny' id='miny' value=" . $miny . " size='8'> </input>-<input  type='text' name='maxy'  id='maxy' value=" . $maxy . " size='8'> </input>";
                        ?>
                        <br /><br />
                        <?php
                        /* ok
                          echo CHtml::ajaxButton(
                          '检索(ajaxButton)', array('data/ajaxTest1', 'name' => "wjb01"), // Yii URL
                          array('update' => '#my01') // jQuery selector
                          );
                         */
                        /* ok
                          echo CHtml::ajaxButton(
                          '检索(ajaxButton)', array('data/jsMap_ajaxList', 'minx' => "98.5",'maxx'=>'104.5','miny'=>'23.0','maxy'=>'32.0'), // Yii URL
                          array('update' => '#my01') // jQuery selector
                          );
                         */
                        ?>
                        <input type="button" value="检  索" id="searchMap" onClick='filterMap()' style="width:170px;height: 22px" />
                        <br />
                        <br />
                        <hr >
                    </td>
                </tr>
            </table>
            <?php
            echo '<script type="text/javascript">';
            echo "</script>";
            ?>
        </div>
        <div class="dataDz_con_right_info_title">
            <div id='dataInfo'>
            </div>
        </div>
        <br />
        <script type="text/javascript">
            var map, lyr0, vlayer06, vlayer11;
            var oldSelBox;
            map = new OpenLayers.Map("sycmap", {
                eventListeners: {
                    'zoomend': alert_on_zoom
                }
            });
            //map.addControl(new OpenLayers.Control.PanZoomBar()); //ok
            //map.addControl(new OpenLayers.Control.Navigation({})); //??看不到效果
            //map.addControl(new OpenLayers.Control.MousePosition()); //ok
            //map.addControl(new OpenLayers.Control.LayerSwitcher()); //ok
            //map.addControl(new OpenLayers.Control.Scale()); //数值显示scale
            map.addControl(new OpenLayers.Control.ScaleLine());

            lyr0 = new OpenLayers.Layer.WMTS({name: "天地图-地形", url: "http://t0.tianditu.com/ter_c/wmts/", layer: "ter", matrixSet: "c", format: "tiles", style: "default", isBaseLayer: true});
            map.addLayer(lyr0);
            //lyr0 = new OpenLayers.Layer.WMTS({name: "天地图-影像", url: "http://t0.tianditu.com/img_c/wmts/", layer: "img", matrixSet: "c", format: "tiles", style: "default", opacity: 1, isBaseLayer: true});
            //map.addLayer(lyr0);
            lyr0 = new OpenLayers.Layer.WMTS({name: "天地图-地形-标注", url: "http://t0.tianditu.com/cta_c/wmts/", layer: "cta", matrixSet: "c", format: "tiles", style: "default", isBaseLayer: false});
            map.addLayer(lyr0);
            lyr0.setVisibility(false);

            map.setCenter(new OpenLayers.LonLat(101.0, 27.5), 6);
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
            map.addControl(new OpenLayers.Control.LayerSwitcher({div: document.getElementById('lyrs'), roundedCorner: false})); //ok

            //ok
            function alert_on_zoom(event) {
                //alert('You finished zooming'); 
            }
            //map.events.register('zoomend', map, alert_on_zoom);

            //ok
            function alert_on_movestart(event) {
                //alert('You begin to move.'); 
            }
            map.events.register('movestart', map, alert_on_movestart);

            {
                var vl_syc_area = new OpenLayers.Layer.Vector('试验场范围');
                map.addLayer(vl_syc_area);

                var pt01 = new OpenLayers.Geometry.Point(98.5, 32.0);
                var pt02 = new OpenLayers.Geometry.Point(104.5, 32.0);
                var pt03 = new OpenLayers.Geometry.Point(104.5, 23.0);
                var pt04 = new OpenLayers.Geometry.Point(98.5, 23.0);

                var line_geom = new OpenLayers.Geometry.LinearRing([pt01, pt02, pt03, pt04, pt01]);
                vl_syc_area.addFeatures([new OpenLayers.Feature.Vector(line_geom)]);

                var vector_style5 = new OpenLayers.Style({
                    'fillOpacity': 0.0,
                    'strokeColor': '#ff0000',
                    'strokeWidth': 2,
                    'strokeDashstyle': 'longdash'
                });

                var vector_style_map5 = new OpenLayers.StyleMap({
                    'default': vector_style5
                });

                vl_syc_area.styleMap = vector_style_map5;
                vl_syc_area.redraw();
            }

            {
                vlayer06 = new OpenLayers.Layer.Vector('测震数据');
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
            
            {
                vlayer11 = new OpenLayers.Layer.Vector('GNSS数据');
                map.addLayer(vlayer11);
                var point, feature_point;
                for (i = 0; i < ptsx11.length; i++)
                {
                    //addMarker(pts[i], ptxts[i], ids[i], dcodes[i], icons[i]);
                    point = new OpenLayers.Geometry.Point(ptsx11[i], ptsy11[i]);
                    feature_point = new OpenLayers.Feature.Vector(point, {label: ptxts11[i]});
                    vlayer11.addFeatures([feature_point]);
                }
                hideLabel11();
            }

            initSelBox();

        </script>
        <div id="my01">
            **检索结果显示
        </div>
    </div>
</div>

<div class="clear">
</div>

