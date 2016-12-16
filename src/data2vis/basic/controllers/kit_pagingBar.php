<?php

namespace app\controllers;

use Yii;

class kit_pagingBar extends CController
{

    //xxxx
    public static function showPagingBar_test($str)
    {
        echo "$str";
        echo "<br />";
    }

    //ok,文献thesis的代码，原始的完整代码，
    public static function showPagingBar($pageCount0, $pageSize0, $pageNum0, $postCount0, $url0,$para='')
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


}

?>
