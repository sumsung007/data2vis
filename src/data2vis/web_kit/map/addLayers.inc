<?php

//function addLayers($mapBase2, $mapOverlay2) {
function addLayers($mapBase2, $mapOverlay2,$msUrl,$msDir) {
    $jsCode_TdtLabel = 'new OpenLayers.Layer.WMTS({ name: "天地图-地形-标注",url: "http://t0.tianditu.com/cta_c/wmts/",layer: "cta",matrixSet: "c",format: "tiles",style: "default",isBaseLayer: false  });';
    $jsCode_TdtTer = 'new OpenLayers.Layer.WMTS({ name: "天地图-地形", url: "http://t0.tianditu.com/ter_c/wmts/",layer: "ter",matrixSet: "c",format: "tiles",style: "default",isBaseLayer: true });';
    $jsCode_TdtImg = 'new OpenLayers.Layer.WMTS({name: "天地图-影像",url: "http://t0.tianditu.com/img_c/wmts/",layer: "img",matrixSet: "c",format: "tiles",style: "default",opacity: 1,isBaseLayer: true });';
    $jsCode_TdtVec = 'new OpenLayers.Layer.WMTS({name: "天地图-地图",url: "http://t0.tianditu.com/vec_c/wmts/",layer: "vec",matrixSet: "c",format: "tiles",style: "default",opacity: 1,isBaseLayer: true });';
    $jsCode_TdtTerLabel = 'new OpenLayers.Layer.WMTS({ name: "天地图-地形-标注",url: "http://t0.tianditu.com/cta_c/wmts/",layer: "cta",matrixSet: "c",format: "tiles",style: "default",isBaseLayer: false  });';

    $jsCode_hide = '
        lyr0.setVisibility(false);       ';
    //$jsCode_show='lyr0.setVisibility(true);';

    $jsCode_handle_hide = '
        lyr0.displayInLayerSwitcher=false;       ';
    //$jsCode_handle_show='lyr0.displayInLayerSwitcher=true;';

    $jsCode_Add = '
        map.addLayer(lyr0);  ';

    $jsCode_getInfoPre0='
        OpenLayers.ProxyHost = "/cgi-bin/proxy.cgi?url=";
        ';
    
    //单引号应该支持多行                           ';
    $jsCode_getInfo2='    
        var featureInfo = new OpenLayers.Control.WMSGetFeatureInfo({
            url: sSvrUrl,
            title: "Identify features by clicking",
            queryVisible: true,
                layers: [lyr0],
                maxFeatures: 50,
                vendorParams: {
                 map: sMapfile 
             },					
            eventListeners: {
                "getfeatureinfo": function(event) {
                    document.getElementById("res1").innerHTML="查询结果：<br />"+event.text;
                }
            }
        });
        map.addControl(featureInfo);  
        featureInfo.activate();        ';
    
    //基础层
    foreach ($mapBase2 as $a3) {
        
        if(($a3->ml_visibility_default=="0")&&($a3->ml_handle_default=="0"))
        {
            //并显示内容且不显示handle的就不add
            continue;
        }
        
        switch ($a3->ml_server_type) {
            case "tdt-vec":
                echo '
                    var lyr0=' . $jsCode_TdtVec;
                echo $jsCode_Add;
                break;

            case "tdt-img":
                echo '
                    var lyr0=' . $jsCode_TdtImg;
                echo $jsCode_Add;
                break;

            case "tdt-ter":
                echo '
                    var lyr0=' . $jsCode_TdtTer;
                echo $jsCode_Add;
                break;

            case "mapserver":                
                echo '
                    var lyr0= new OpenLayers.Layer.WMS("' . $a3->ml_layer_title . '","' .$msUrl . '",{
                        layers: "' . $a3->ml_layer_name . '",map:"' .$msDir.'/'. $a3->ml_ms_mapfile . '",
                            format: "png",transparent: "true" },{ gutter: 15,buffer: 0,isBaseLayer:true });';
                echo $jsCode_Add;                
                break;

            case "geoserver":
                break;
        }
    }

    //覆盖层        
    foreach ($mapOverlay2 as $a4) {
        
        if(($a4->ml_visibility_default=="0")&&($a4->ml_handle_default=="0"))
        {
            //并显示内容且不显示handle的就不add
            continue;
        }        
        
        switch ($a4->ml_server_type) {
            case "tdt-label":
                echo '
                    var lyr0=' . $jsCode_TdtLabel;
                echo $jsCode_Add;
                break;

            case "mapserver":
                //gutter: 15,buffer: 0
                //echo 'var lyr0= new OpenLayers.Layer.WMS("'.$a4->ml_layer_title.'","'.$a4->ml_server_url.'",{ layers: "'.$a4->ml_layer_name.'",map:"'.$a4->ml_mapfile.'",format: "png",transparent: "true" },{ isBaseLayer:false });';         
                echo '
                    var lyr0= new OpenLayers.Layer.WMS("' . $a4->ml_layer_title . ' ","' . $msUrl . '",{ 
                        layers: "' . $a4->ml_layer_name . '", map:"' .$msDir.'/'.$a4->ml_ms_mapfile . '",
                                format: "png",transparent: "true" },{ gutter: 15,buffer: 0,isBaseLayer:false });';
                echo $jsCode_Add;
                break;

            case "geoserver":
                break;
        }

        if ($a4->ml_visibility_default == "1") {
            //echo $jsCode_show;
        } else {
            echo $jsCode_hide;
        }
        if ($a4->ml_handle_default == "0") {
            echo $jsCode_handle_hide;
        }
        
        //proxy.cgi未处理
        //if ($a4->ml_layer_name=="seis_1month")
        if($a4->ml_get_info=="1")
        {
            $jsCode_getInfo0='
                var sSvrUrl="'.$msUrl.'";'; //只针对mapserver了
            $jsCode_getInfo1='
            var sMapfile="'.$msDir.'/'.$a4->ml_ms_mapfile.'";';
                    
            echo $jsCode_getInfoPre0;
            echo $jsCode_getInfo0;
            echo $jsCode_getInfo1;
            echo $jsCode_getInfo2;            
        }
        
    }
}

?>
