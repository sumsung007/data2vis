<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'QZ';
?>
<script type="text/javascript">
    var timeId4check; //定时检查handle
    var checkTime=0;
    var rnd0;

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
        //alert("get data, draw graph...");
        //timeId = setTimeout("alert('ok');",2000); //ok

        var y0=document.getElementById("year0").value;
        var m0=document.getElementById("mon0").value;
        var d0=document.getElementById("day0").value;
        var y1=document.getElementById("year1").value;
        var m1=document.getElementById("mon1").value;
        var d1=document.getElementById("day1").value;
        var dt0=y0+"-"+m0+"-"+d0;
        var dt1=y1+"-"+m1+"-"+d1;
//        alert(dt0+","+dt1);
        document.getElementById("jobGraph").src="";
        document.getElementById("jobGraph").hidden=true; //ok有效
        checkTime=0;

        timeId4check = setInterval("checkGraph();",1000);
        //timeId4check = setTimeout("checkGraph();",1000);  //暂时测试用

        //ajax 绘图调用  ok
//        url0 = 'http://www.ncepe.cn:8081/qz2/53001_2_4112@2012-01-01@2015-12-31@dyu01';
        //url0 = 'http://www.ncepe.cn:8081/qz2/53001_2_4112@'+dt0+'@'+dt1+'@dyu01';
        var rnd=GetRandomNum(100000,999999);
        rnd0=rnd;
        url0 = 'http://www.ncepe.cn:8081/qz2/53001_2_4112@'+dt0+'@'+dt1+'@dyu01@'+rnd;
        //alert(url0);
        jQuery.ajax({
            'url': url0,
            'cache': false,
            'success': function (html) {
                //jQuery("#jobEnd").html(html) ??无效？？
                //document.getElementById("jobInfo").innerHTML="处理结束"; 仍然没有显示
                //结论：没有得到success，应该是没有发回200的原因
                //???? 应该不是，直接有返回就行，不过反正不正确
                //**** 不处理了，反正用不到
                //alert(html); 没有弹出，更确定此event没有执行
            }
        });

    }
    function checkGraph()
    {
        //检查graph？？

        //检查log,每次显示最后1行，如果是ok，则整个工作结束了
        var lineLog="not";
        url0 = './index.php?r=qz/ajax2log2line&rnd='+rnd0;
        jQuery.ajax({
            'url': url0,
            'cache': false,
            'success': function (html) {
                //jQuery("#jobEnd").html(html); //ok
                var sLog="处理信息："+html;
                jQuery("#jobEnd").html(sLog); //ok
                lineLog=html; //?无效
                //alert(lineLog);
                
                if(lineLog=="ok")
                {
                    endDataDraw();
                    document.getElementById("jobInfo").innerHTML="绘制图形："+checkTime+"(秒)";
                    document.getElementById("jobGraph").src="http://www.ncepe.cn/rds_data/qz/dyu01-53001_2_4112."+rnd0+".dat.png";
                    document.getElementById("jobGraph").hidden=false; //ok有效
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
            var sInfo="处理进行中...如果请求数据较多，可能处理时间会长，请耐心等待..."+checkTime;
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
                        echo "<h5><a href='./index.php?r=qz/" . $k1 . "' >" . $tree[$k1] . "</a></h5>";
                    }
                ?>
            </div>

            <div class="col-lg-10">
                <h3>时序绘图测试</h3>                
                <h4>测试数据：53001-2-4112 云南 昆明 静水位 01-分值 2007-05-22 2015-12-28</h4>
                开始日期：
                <input type="text" id="year0" name="year0" value="2015" size="4">
                <input type="text" id="mon0" name="mon0" value="4" size="2">
                <input type="text" id="day0" name="day0" value="1" size="2">
                &nbsp;&nbsp;&nbsp;&nbsp;
                结束日期：
                <input type="text" id="year1" name="year1" value="2015" size="4">
                <input type="text" id="mon1" name="mon1" value="5" size="2">
                <input type="text" id="day1" name="day1" value="1" size="2">
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="button" id="toDraw" onclick="toDataDraw()" value="获取数据并绘图">
                <hr style="margin:1 0 1 0;height: 1px;width:100%;border:1px dotted;color:#000000;">
                <div id="jobInfo">
                </div>
                <br />
                <img src="#" id="jobGraph" alt="绘图显示..." hidden="1" />
                <br />
                <br />
                <div id="jobEnd">
                </div>
                <br />
                
            </div>

        </div>

    </div>
</div>
