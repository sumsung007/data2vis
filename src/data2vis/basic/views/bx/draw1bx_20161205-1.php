<?php

use yii\helpers\Url;
use yii\helpers\Html;

//ok
//srand((double)microtime()*1000000);
//srand(time());
//echo rand(10000,99999);

srand(time());
$rnd=rand(10000,99999);

/* @var $this yii\web\View */
$this->title = 'BX';
?>
<script type="text/javascript">
    var timeId4check; //定时检查handle
    var checkTime=0;
    var rnd0;
    //alert('go on ...');
    
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

    function toDataDraw()
    {
        var y0=document.getElementById("year0").value;
        var m0=document.getElementById("mon0").value;
        var d0=document.getElementById("day0").value;
        var y1=document.getElementById("year1").value;
        var m1=document.getElementById("mon1").value;
        var d1=document.getElementById("day1").value;
//        var dt0="2015-11-25_"+(y0-8)+":"+m0+":"+d0;  //需要折算到UTC，**应该处理日期的，否则hour<8就出现问题了
//        var dt1="2015-11-25_"+(y1-8)+":"+m1+":"+d1;
        var dt0=(y0-8)+":"+m0+":"+d0;  //需要折算到UTC，**应该处理日期的，否则hour<8就出现问题了
        var dt1=(y1-8)+":"+m1+":"+d1;

        var rnd=GetRandomNum(100000,999999);
        rnd0=rnd;

        //document.getElementById("jobGraph").src="";
        //document.getElementById("jobGraph").src="http://www.ncepe.cn/rds_data/bx/"+rnd0+".png";
        //document.getElementById("jobGraph").hidden=true; //ok有效
        //document.getElementById("jobGraph").src="http://www.ncepe.cn/rds_data/bx/rds00.png";
        checkTime=0;
        timeId4check = setInterval("checkGraph();",1000);

        //ajax 绘图调用  ok
        url0 = 'http://www.ncepe.cn:8082/bx/SC@CD2@'+dt0+'@'+dt1+'@'+rnd;
        //alert(url0);
        //return;
        jQuery.ajax({
            'url': url0,
            'cache': false,
            'success': function (html) {
                //alert(html); 没有弹出，更确定此event没有执行
            }
        });

    }
    function checkGraph()
    {
        //检查log,每次显示最后1行，如果是ok，则整个工作结束了
        var lineLog="not";
        url0 = './index.php?r=bx/ajax2log2line&rnd='+rnd0;
        jQuery.ajax({
            'url': url0,
            'cache': false,
            'success': function (html) {
                var sLog="处理信息："+html;
                jQuery("#jobEnd").html(sLog); //ok
                lineLog=html;

                document.getElementById("jobGraph").hidden=false; //开始是hidden的，执行后就show
                if(lineLog=="ok")
                {
                    endDataDraw();
                    document.getElementById("jobInfo").innerHTML="绘制图形："+checkTime+"(秒)";
                    //document.getElementById("jobGraph").src="";
                    //document.getElementById("jobGraph").hidden=true;
                    document.getElementById("jobGraph").src="http://www.ncepe.cn/rds_data/bx/"+rnd0+".png";                    
                    document.getElementById("jobGraph").src="";
                    document.getElementById("jobGraph").src="http://www.ncepe.cn/rds_data/bx/"+rnd0+".png";
                    //为了引动刷新
                    //document.getElementById("jobGraph").hidden=false; //ok有效
                }
                else
                {
                    document.getElementById("jobGraph").src="http://www.ncepe.cn/rds_data/bx/rds00.png";
                }
            }
        });
        //alert(lineLog); //?? 一直是not
        if(lineLog=="ok")
        {
        }
        else
        {
            //自己理解：input是value，其他html tag就是innerHTML
            var sInfo="请耐心等待..."+checkTime;
            document.getElementById("jobInfo").innerHTML=sInfo;
            checkTime++;
        }
    }

    function endDataDraw() //stop too
    {
        clearInterval(timeId4check);
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
                        echo "<h5><a href='./index.php?r=bx/" . $k1 . "' >" . $tree[$k1] . "</a></h5>";
                    }
                ?>
            </div>

            <div class="col-lg-10">
                <div>波形绘图测试：新疆阿克陶M6.7发震时刻：2016-11-25 22:24&nbsp;&nbsp;&nbsp;&nbsp;测试数据：SC.CD2.00.BHZ/BHE/BHN.D.2016.330
                </div>
                开始日期时间：2016-11-25
                <input type="text" id="year0" name="year0" value="22" size="2">
                <input type="text" id="mon0" name="mon0" value="25" size="2">
                <input type="text" id="day0" name="day0" value="0" size="2" hidden="1">
                &nbsp;&nbsp;&nbsp;&nbsp;
                结束日期时间：2016-11-25
                <input type="text" id="year1" name="year1" value="23" size="2">
                <input type="text" id="mon1" name="mon1" value="45" size="2">
                <input type="text" id="day1" name="day1" value="0" size="2" hidden="1">
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="button" id="toDraw" onclick="toDataDraw()" value="获取数据并绘图">
                <hr style="margin:1 0 1 0;height: 1px;width:100%;border:1px dotted;color:#000000;">
                <div id="jobInfo">
                </div>
                <img src="#" id="jobGraph" alt="绘图显示..." hidden="1" />
                <br />
                <div id="jobEnd">
                </div>
                <br />
                
            </div>

        </div>

    </div>
</div>
