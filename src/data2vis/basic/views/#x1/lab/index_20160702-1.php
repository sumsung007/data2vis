<?php
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'Data2Vis 技术Blog';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>实验室 Lab !</h1>

        <p class="lead">用于技术学习记录。</p>
    </div>
    
    <div class="body-content">        
        <div class="row">
            <div class="col-lg-2">
                <h2>Web相关</h2>

                <p>
                    <li>Javascript</li>
                    <li>CSS</li>
                    <li>jQuery</li>
                    <li>Bootstrap</li>
                    <li>PHP</li>
                    <li>Yii</li>
                    <li>Html5</li>
                    <li>Apache</li>
                    <li>Nginx</li>
                </p>

                <p><a class="btn btn-default" href="<?PHP echo Url::toRoute('lab/about'); ?>">About</a></p>
            </div>
            <div class="col-lg-3">
                <h2>Database相关</h2>

                <ul>
                    <li>MySQL</li>
                    <li>Ms SqlServer</li>
                    <li>Oracle</li>
                    <li>Mongodb</li>
                    <li>Redis</li>
                    <li>Memcached</li>
                    <li>PostgreSQL</li>
                </ul>
            </div>

            <div class="col-lg-2">
                <h2>GIS相关</h2>

                <ul>
                    <li>MapServer</li>
                    <li>OpenLayer</li>
                    <li>PostGIS</li>
                    <li>QGis
                </ul>
            </div>
            <div class="col-lg-2">
                <h2>Graphic相关</h2>

                <ul>
                    <li>OSG</li>
                    <li>OpenGL</li>
                    <li>WebGL</li>
                    <li>AGG</li>
                </ul>

            </div>
            <div class="col-lg-2">
                <h2>语言相关</h2>

                <ul>
                    <li>VC/MFC</li>
                    <li>QT</li>
                    <li>Python</li>
                    <li>Ruby</li>
                </ul>
            </div>

        </div>

    </div>
</div>
