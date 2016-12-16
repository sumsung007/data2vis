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
                <h2>空间分布</h2>
                <div id="syc_map" style="width:100%; height:700px; border: 2px solid #000;">
                </div>
    <?php
    //原代码用地名，需要改为用id，否则如果是震群时候回出现问题，因为会有很多地名是相同的
        echo "<script type='text/javascript'>
            var data = [
            ";
        foreach ($sc0 as $s1)
        {
            $info="{name: '".$s1['sc_place']."', value: ".sprintf("%3.1f",$s1['sc_m']).",datetime: '".$s1['sc_datetime']."',depth:  ".sprintf("%3d",round($s1['sc_depth'])).",sid:'".$s1['sc_id']."' },";
            echo "$info
                ";
        }
        echo "        ];
            ";

        $lon0=0.0;
        $idx=0;
        echo "geoCoordMap = {";
        foreach ($sc0 as $s1)
        {
            if($idx==0)
                $lon0=$s1['sc_lon'];

            $info="'".$s1['sc_place']."':[".$s1['sc_lon'].",".$s1['sc_lat']."],";
            echo "$info
                ";
            $idx++;
        }
        echo "        };
            ";
        echo "</script>
            ";
    ?>

    <script type='text/javascript'>
        var convertData = function (data) {
            var res = [];
            for (var i = 0; i < data.length; i++) {
                var geoCoord = geoCoordMap[data[i].name];
                if (geoCoord) {
                    res.push({
                        name: data[i].name,
                        value: geoCoord.concat(data[i].value).concat(data[i].datetime).concat(data[i].depth).concat(data[i].sid) //组合数据内容
                    });
                }
            }
            return res;
        };
    </script>

    <?php
    echo "
    <script type='text/javascript'>
        option = {
            backgroundColor:  '#404a59',
            title: {
                text: '最新地震震中位置图',
                subtext: '数据来源：中国地震台网中心',
                sublink: 'http://www.csi.ac.cn',
                left: 'center',
                textStyle: {
                    color: '#fff'
                }
            },
            tooltip : {
                trigger: 'item',
                formatter: function (params) {  //从别的例子移植，ok
                    return  '时间：'+params.value[3]+
                        '<br />震级：'+params.value[2]+
                        '<br />深度：'+params.value[4]+' km'+
                        '<br />位置：' + params.name;
                }
            },
            geo: {
                map: 'china',
                label: {
                    emphasis: {
                        show: false
                    }
                },
                roam: true,  //地图拖动、缩放
                itemStyle: {
                    normal: {
                        areaColor:  '#323c48',  //填充颜色
                        borderColor: '#111' //'#808080'
                    },
                    emphasis: {
                        areaColor: '#2a333d'
                    }
                }
            },
            series : [
                {
                    name: '地震信息',
                    type: 'scatter',
                    coordinateSystem: 'geo',
                    data: convertData(data),
                    symbolSize: function (val) {
                        return val[2] *3.0;
                    },
                    label: {
                        normal: {
                            formatter: '{b}',
                            position: 'right',
                            show: false  //低值是否标注
                        },
                        emphasis: {
                            show: true //高值是否标注，即大的地震标注  ??如何改为标注震级
                        }
                    },
                    itemStyle: {
                        normal: {
                            color: '#ddb926'
                        }
                    }
                },
                {
                    name: '最新地震1',
                    type: 'effectScatter',  //最新地震特殊显示
                    coordinateSystem: 'geo',
                    /* 原来是大小排序
                    data: convertData(data.sort(function (a, b) {
                        return b.value - a.value;
                    }).slice(0, 1)),
                     */
                    //倒序数据的第一个
                    data: convertData(data.slice(0, 1)),
                    symbolSize: function (val) {
                        return val[2]*3.0;
                    },
                    showEffectOn: 'render',
                    rippleEffect: {
                        brushType: 'stroke'
                    },
                    hoverAnimation: true,
                    label: {
                        normal: {
                            //formatter: '{b}', //应该是数据列，有a，b，c
                            formatter: function (params) {  //从别的例子移植，ok
                                return  'Ms'+params.value[2]+ ',' + params.name;
                            },";
                            //position: 'right',
    if($lon0<110.0)
    {
echo "
            position: 'right',  //$lon0  ";
    }
    else
    {
echo "
            position: 'bottom',    ";
    }
echo "
                            show: true
                        }
                    },
                    itemStyle: {
                        normal: {
                            color: '#f4e925',//'#f4e925',
                            shadowBlur: 10,
                            shadowColor: '#333'
                        }
                    },
                    zlevel: 1
                }
            ]
        };

        var chart = echarts.init(document.getElementById('syc_map'));
        chart.setOption(option);
        chart.on('click', function (params) {
            //ok
            //window.open('https://www.baidu.com/s?wd=' + encodeURIComponent(params.name));
            window.open('./index.php?r=app/zzxx&sid=' + encodeURIComponent(params.value[5]));
        });
    </script>
";
?>
            </div>

        </div>

    </div>
</div>
