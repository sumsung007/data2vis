<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'Qz';


function showPagingBar($pageCount0, $pageSize0, $pageNum0, $postCount0, $url0,$para='')
    {
//    echo "检索结果数量：" . $postCount;
        //echo "&nbsp;&nbsp;&nbsp;&nbsp;页码：";
        //$url0="./index.php?r=fruit/thesis&pageNum";

        echo "<p style='line-height:30px;margin:5px 0px 10px 0px'>";
        if ($postCount0 <= $pageSize0)
        {
            echo "检索到 $postCount0 个结果";
            return;
        }

        echo "<span style='font-size:12px'> $postCount0 个结果分 $pageCount0 页显示：</span>";

        //显示9个数字，
        $numCount = 9;
        if ($pageCount0 <= $numCount)
        {
            //页数少的直接显示
            for ($i = 1; $i <= $pageCount0; $i++)
            {
                //echo "&nbsp;&nbsp;_-$i-_&nbsp;&nbsp;";
                if ($pageNum0 == $i)
                    echo "<span style='border: #808080 solid 1px;font-weight:bold;background-color:#B0B0B0;font-size:12px;padding:5px 10px 5px 5px'>
                    <a href='$url0=$i$para'>$i</a></span>&nbsp;";
                else
                    echo "
                    <a href='$url0=$i$para'><span style='border: #808080 solid 1px;font-size:12px;padding:5px 10px 5px 5px'>$i</span></a>&nbsp;";
//                echo "<span style='border: #808080 solid 1px;font-size:12px;padding:5px 10px 5px 5px'>
//                    <a href='$url0=$i'>$i</a></span>&nbsp;";
            }
        }
        else
        {
            echo "<span style='border: #808080 solid 1px;font-size:12px;padding:5px 10px 5px 5px'>
            <a href='$url0=1$para'>&nbsp;第一页&nbsp;</a></span>......";
            /* xx，应该也可以实现判断，但是太复杂
              if($pageNum0<=($numCount-1)/2)
              {
              //显示开头数字，从1开始
              $pn1=1;
              $pn2=$pageCount;
              }
             */
            $pn1 = $pageNum0 - 4;
            $pn2 = $pageNum0 + 4;
            if ($pn1 < 1)
            {
                $pn1 = 1;
                $pn2 = $numCount;
            }
            if ($pn2 > $pageCount0)
            {
                $pn2 = $pageCount0;
                $pn1 = $pageCount0 - $numCount;
            }

            for ($i = $pn1; $i <= $pn2; $i++)
            {
                //echo "&nbsp;&nbsp;_-$i-_&nbsp;&nbsp;";
                if ($pageNum0 == $i)
                    echo "<span style='border: #808080 solid 1px;font-weight:bold;background-color:#B0B0B0;font-size:12px;padding:5px 10px 5px 5px'>
                    <a href='$url0=$i$para'>$i</a></span>&nbsp;";
                else
                    echo "<span style='border: #808080 solid 1px;font-size:12px;padding:5px 10px 5px 5px'>
                    <a href='$url0=$i$para'>$i</a></span>&nbsp;";
            }
            echo "......<span style='border: #808080 solid 1px;font-size:12px;padding:5px 10px 5px 5px'>
            <a href='$url0=$pageCount0$para'>&nbsp;最后页&nbsp;</a></span>";
        }
        echo "</p>";
    }
    
?>
<?PHP
    //Yii::$app->getView()->registerJsFile('jquery');
    // 没有效果？
    //Yii::$app->getView()->registerJsFile('/data2vis/web_lib/jquery/jquery-1.11.1.min.js');
?>
<script src="/data2vis/web_lib/jquery/jquery-1.11.1.js" ></script>

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
                <h3>台站列表</h3>
                <?PHP
                $url0 = "./index.php?r=qz/sta2list&pageNum";
                $para = '';
                showPagingBar($pageCount, $pageSize, $pageNum, $postCount, $url0, $para);
                $idx = $pageSize * ($pageNum - 1) + 1;

                echo "<table style='width:96%'>";
                echo "<tr><td>台站编码</td><td>台站名</td><td>台网编码</td><td>台网名</td></tr>";
                foreach ($data1 as $s1)
                {
                    $sp=sprintf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td>",$s1['stationid'],$s1['stationname'],$s1['unitcode'],$s1['unitname']);

                    echo "<tr>
                            $sp
                          </tr>";
                }
                echo "</table>";
            if ($postCount > 0)
            {
                echo "<hr>";
                //echo "选择页码：";
                showPagingBar($pageCount, $pageSize, $pageNum, $postCount, $url0, $para);
            }
                ?>
            </div>

        </div>

    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        //alert("loaded js...");
        //ok
        //$("li").filter(':odd').css('background','#e3f4ef');
        $("tr").filter(':odd').css('background','#e3f4ef');
    });
</script>