<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'ML';
?>

<script src="/data2vis/web_lib/echart/echarts.min.js"></script>
<script src="/data2vis/web_lib/echart/china.js"></script>

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
                <h2>热力图分布</h2>
                                <div id="map2" style="margin: 0px 0px 0px 0px;width:100%;height:600px;background-color: #fff;border: 1px #000 solid"></div>
                                <?php
                                //原代码用地名，需要改为用id，否则如果是震群时候回出现问题，因为会有很多地名是相同的

                                echo "<script>
                  var data = [
                  ";
                                foreach ($sc0 as $s1)
                                {
                                    $info = "{name: '" . $s1['sc_place'] . "', value: " . sprintf("%.4f", pow(10.0, 4.8 + 1.5 * $s1['sc_m'])) . ",datetime: '" . $s1['sc_datetime'] . "',depth:  " . sprintf("%3d", round($s1['sc_depth'])) . ",sid:'" . $s1['sc_id'] . "' },";
                                    echo "$info
                  ";
                                }
                                echo "        ];
                  ";

                                echo "geoCoordMap = {";
                                foreach ($sc0 as $s1)
                                {
                                    $info = "'" . $s1['sc_place'] . "':[" . $s1['sc_lon'] . "," . $s1['sc_lat'] . "],";
                                    echo "$info
                  ";
                                }
                                echo "        };
                  ";
                                echo "</script>";
                                ?>
                                <script>

                                    var convertData = function (data) {
                                        var res = [];
                                        for (var i = 0; i < data.length; i++) {
                                            var geoCoord = geoCoordMap[data[i].name];
                                            if (geoCoord) {
                                                res.push({
                                                    name: data[i].name,
                                                    value: geoCoord.concat(data[i].value) //组合数据内容
                                                });
                                            }
                                        }
                                        return res;
                                    };

                                    option = {
                                        backgroundColor: '#404a59', //'#404a59',
                                        visualMap: {
                                            min: 0,
                                            max: Math.round(Math.pow(10.0, 4.8 + 1.5 * 5.0)),
                                            splitNumber: 10,
                                            inRange: {
                                                color: ['#d94e5d', '#eac736', '#50a3ba'].reverse()
                                            },
                                            textStyle: {
                                                color: '#fff'
                                            }},
                                        geo: {
                                            map: 'china',
                                            label: {
                                                emphasis: {
                                                    show: false
                                                }
                                            },
                                            roam: true,
                                            itemStyle: {
                                                normal: {
                                                    areaColor: '#323c48',
                                                    borderColor: '#111'
                                                },
                                                emphasis: {
                                                    areaColor: '#2a333d'
                                                }
                                            }
                                        },
                                        series: [{
                                                name: '地震信息',
                                                type: 'heatmap', //scatter
                                                coordinateSystem: 'geo',
                                                data: convertData(data)
                                            }]

                                    };

                                    var chart = echarts.init(document.getElementById('map2'));
                                    chart.setOption(option);
                                    chart.on('click', function (params) {
                                        //ok
                                        //window.open('https://www.baidu.com/s?wd=' + encodeURIComponent(params.name));
                                        window.open('./index.php?r=app/zzxx&sid=' + encodeURIComponent(params.value[5]));
                                    });
                                </script>

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
