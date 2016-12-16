<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'jsDawerx';
?>
<div class="site-index">
    <div class="body-content">        
        <div class="row">
            <div class="col-lg-2">
                <?PHP
                $ks = array_keys($tree);
                foreach ($ks as $k1)
                {
                    echo "<h4><a href='./index.php?r=jsdx/" . $k1 . "' >" . $tree[$k1] . "</a></h4>";
                }
                ?>

            </div>
            <div class="col-lg-10">
                <h2>jsDrawerX</h2>
                jsDrawerX v0.01 (2016.07.17-*)
                <input type='text' id='locX' value='x' />
                <input type='text' id='locY' value='y' />
                <br />
                <table style='width:100%'>
                    <tr>
                        <td style='width:50%;border: #000000 solid 2px'>
                            <canvas id='cvDraw'  style='width:100%; height:400px;border: #FF0000 solid  1px'></canvas>
                        </td>
                        <td style='width:50%; border: #000000 solid 2px'>
                            <canvas id='cvNet' style='width:100%; height:400px; border: #FF0000 solid  1px'></canvas>
                        </td>
                    </tr>
                </table>

                <script>
                    //书上不对
                    function windowToCanvas_old(canvas, x, y)
                    {
                        var bbox = canvas.getBoundingClientRect();
                        return {x: x - bbox.left * (canvas.width / bbox.width),
                            y: y - bbox.top * (canvas.height / bbox.height)};
                    }
                    //经过验证，数值是正确的 cvDraw
                    function windowToCanvas(canvas, x, y)
                    {
                        var bbox = canvas.getBoundingClientRect();
                        return {x: x - bbox.left,
                            y: y - bbox.top};
                    }

                    var cvNet = document.getElementById('cvNet');
                    if (cvNet)
                    {
                        cvNet.onmousemove = function (e)
                        {
                            //e.clientX是针对窗口的client区域的，左边还好，clientY很明显

                            var loc = windowToCanvas(cvNet, e.clientX, e.clientY);
                            //document.write(loc.x);
                            //alert(loc.y);
                            var oX = document.getElementById("locX");
                            oX.value = loc.x;
                            var oY = document.getElementById("locY");
                            oY.value = loc.y;

                        }

                        cvNet.onmousedown = function (e)
                        {
                            //alert("mouse down");
                        }

                        cvNet.onmouseup = function (e)
                        {
                            alert("mouse up");
                        }
                    }


                    var cvDraw = document.getElementById('cvDraw');
                    if (cvDraw)
                    {
                        cvDraw.onmousemove = function (e)
                        {
                            //e.clientX是针对窗口的client区域的，左边还好，clientY很明显

                            var loc = windowToCanvas(cvDraw, e.clientX, e.clientY);
                            //document.write(loc.x);
                            //alert(loc.y);
                            var oX = document.getElementById("locX");
                            oX.value = loc.x;
                            var oY = document.getElementById("locY"); //?? 在Edge中显示有小数，但是是固定的.670等，应该是有问题
                            oY.value = loc.y;

                        }

                        cvDraw.onmousedown = function (e)
                        {
                            //alert("mouse down");
                        }

                        cvDraw.onmouseup = function (e)
                        {
                            alert("mouse up");
                        }
                    }
                    if (cvDraw.getContext)
                    {
                        var ctDraw = cvDraw.getContext('2d');
                        ctDraw.fillStyle = 'rgb(255,0,0)';
                        ctDraw.fillRect(20, 30, 64, 36);
                    }


                </script>


            </div>

        </div>

    </div>
</div>
