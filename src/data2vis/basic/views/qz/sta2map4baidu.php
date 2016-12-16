<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'QZ';
?>
<?PHP
//Yii::$app->getView()->registerJsFile('jquery');
// 没有效果？
//Yii::$app->getView()->registerJsFile('/data2vis/web_lib/jquery/jquery-1.11.1.min.js');
?>
<script src="/data2vis/web_lib/jquery/jquery-1.11.1.js" ></script>

<script src="http://api.map.baidu.com/api?v=2.0&ak=0C7e2a27fde760e933c1887048490999" type="text/javascript"></script>

<div class="site-index">
    <div class="body-content">        
        <div class="row">
            <div class="col-lg-2">
                <?PHP
                    $ks = array_keys($tree);
                    foreach ($ks as $k1)
                    {
                        echo "<h5><a href='./index.php?r=qz/" . $k1 . "' >" . $tree[$k1] . "</a></h5>";
                    }
                ?>
            </div>

            <div class="col-lg-10">
                <h3>台站分布</h3>
                <script type="text/javascript">
//alert('yes');
                </script>
                <?php
//初始化
                //print_r($qzSta);
                echo "<script type='text/javascript'>";
                echo "
                    //alert('????');  ok                    
                    var pts=new Array();
                    var ptxts=new Array();                   
                    //alert('YYYY');  ok
                ";
                $i = 0;
                foreach ($qzSta as $s1)
                {
                    echo "pts[$i] = new BMap.Point(" . $s1['lon'] . "," . $s1['lat'] . ");
                  ptxts[$i]='" . $s1['stationname'] . "(" . $s1['stationid'] . ")';
            ";
                    $i++;
                }
                echo "
        </script>";
                ?>


                <div id="syc_map" style="width: 100%; height: 650px; border: 1px solid #000;margin:0 auto">
                </div>
                <script  type="text/javascript">
                    var map = new BMap.Map("syc_map");          // 创建地图实例
                    //var point = new BMap.Point(101.5, 27.5);  // 创建点坐标syc zoom=7
                    var point = new BMap.Point(105, 38.0);
                    map.centerAndZoom(point, 5);                 // 初始化地图，设置中心点坐标和地图级别
                    map.addControl(new BMap.NavigationControl());
                    map.addControl(new BMap.MapTypeControl());
                    map.enableScrollWheelZoom();

                    function addMarker(pt0, sLab0) {  // 创建图标对象
                        var sIconColor="#FF0000";
                        var icon1= new BMap.Symbol(BMap_Symbol_SHAPE_FORWARD_OPEN_ARROW, {
                                                scale: 0.6, //图标缩放大小 zzxx=3.5,index=1.5
                                                strokeColor: sIconColor, //线颜色
                                                strokeWeight: 2, //线宽度
                                                fillColor: sIconColor, //填充颜色 ??好像无法设置为透明
                                                fillOpacity: 0.90//填充透明度
                                            })

                        var marker = new BMap.Marker(pt0, {title: sLab0});        // 创建标注
//                        var lab2 = new BMap.Label(sLab0, {offset: new BMap.Size(10, -10)});
                        //marker.setLabel(lab2); //ok
                        //marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画 ok
                        marker.setIcon(icon1);

                        marker.addEventListener("click", function (e) {

                            //台名
                            //var sLab = this.getLabel().content; //ok

                            //ok
                            //var sid=this.stationid;
                            //alert("自定义附加数据测试："+sid);
                            //return;

                            var sLab = this.getTitle();
                            var s1 = sLab.substr(sLab.indexOf('(') + 1, 5);
                            //alert("open");
                            //360中会弹出新的浏览器实例，并非tab
                            //window.open('http://www.ncepe.cn','qzInfoWin','alwaysRaised=yes');
                            //window.open("about:blank","","fullscreen=1")  打开全屏
                            var tmp = window.open('./index.php?r=data/twqztz&scode=' + s1, 'qzInfoWin');
                            tmp.focus(); //如此采用浏览器一致，否则总是不切换到新tab
                        });

                        map.addOverlay(marker);
                    }

                    for (i = 0; i < pts.length; i++)
                    {
                        var pt = pts[i];
                        addMarker(pt, ptxts[i]);
                    }

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

                    function deletePoint() {
                        var allOverlay = map.getOverlays();
                        for (var i = 0; i < allOverlay.length - 1; i++) {
                            if (allOverlay[i].getLabel().content == "我是id=1") {
                                map.removeOverlay(allOverlay[i]);
                                return false;
                            }
                        }
                    }

                    function showLabel() {
                        //alert("show...");
                        var allOverlay = map.getOverlays();
                        for (var i = 0; i < allOverlay.length - 1; i++) {
                            var sTitle = allOverlay[i].getTitle();
                            var lab2 = new BMap.Label(sTitle, {offset: new BMap.Size(10, -10)});
                            allOverlay[i].setLabel(lab2);
                        }
                    }

                    function hideLabel() {
                        var allOverlay = map.getOverlays();
                        for (var i = 0; i < allOverlay.length - 1; i++) {
                            //ok??，有效果，但是显示效果不好
                            //allOverlay[i].getLabel().setContent('');
                            map.removeOverlay(allOverlay[i].getLabel()); //ok，网络方法
                        }
                        //map.refresh(); xx 没有此函数
                    }
                </script>

                <input type="button" onclick="showLabel()" value="显示标签" hidden="1" />
                <input type="button" onclick="hideLabel()" value="隐藏标签" hidden="1" />

                <br />

            </div>

        </div>

    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        //alert("loaded js...");
        //ok
        //$("li").filter(':odd').css('background','#e3f4ef');
        $("tr").filter(':odd').css('background', '#e3f4ef');
    });
</script>