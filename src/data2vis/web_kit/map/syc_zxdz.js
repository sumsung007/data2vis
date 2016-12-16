/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 
var map;  
var measureControls;
/*	
function initView4eq(lons,lats)        
{
    //震中周围
    var zooms=9;
    map.setCenter(new OpenLayers.LonLat(lons,lats),zooms);	                        
}
        
function initView()
{
    //实验区范围
    var lat=28.0;
    var lon=100.0;		
    var zoom=5;  //研究使用范围，尽量大，充分利用屏幕    
    map.setCenter(new OpenLayers.LonLat(lon,lat),zoom);	                        
}
		
function initView0()
{
    //初始化显示
    var lon=105.0;  
    var lat=35.0;     
    var zoom0=4;      
    map.setCenter(new OpenLayers.LonLat(lon,lat),zoom0);	
}
*/		        
function init_1()   
{  		
    map = new OpenLayers.Map("syc_map");  
  								
    //map.addControl(new OpenLayers.Control.PanZoomBar());  
    map.addControl(new OpenLayers.Control.MousePosition());  
    map.addControl(new OpenLayers.Control.LayerSwitcher());  
    map.addControl(new OpenLayers.Control.ScaleLine());  
		  
    //for 测量
    // style the sketch fancy
    var sketchSymbolizers = {
        "Point": {
            pointRadius: 4,
            graphicName: "square",
            fillColor: "white",
            fillOpacity: 1,
            strokeWidth: 1,
            strokeOpacity: 1,
            strokeColor: "#333333"
        },
        "Line": {
            strokeWidth: 3,
            strokeOpacity: 1,
            strokeColor: "#666666",
            strokeDashstyle: "dash"
        },
        "Polygon": {
            strokeWidth: 2,
            strokeOpacity: 1,
            strokeColor: "#666666",
            fillColor: "white",
            fillOpacity: 0.3
        }
    };
    var style = new OpenLayers.Style();
    style.addRules([
        new OpenLayers.Rule({
            symbolizer: sketchSymbolizers
        })
        ]);
    var styleMap = new OpenLayers.StyleMap({
        "default": style
    });
            
    // allow testing of specific renderers via "?renderer=Canvas", etc
    var renderer = OpenLayers.Util.getParameters(window.location.href).renderer;
    renderer = (renderer) ? [renderer] : OpenLayers.Layer.Vector.prototype.renderers;

    measureControls = {
        line: new OpenLayers.Control.Measure(
            OpenLayers.Handler.Path, {
                persist: true,
                handlerOptions: {
                    layerOptions: {
                        renderers: renderer,
                        styleMap: styleMap
                    }
                }
            }
            ),
        polygon: new OpenLayers.Control.Measure(
            OpenLayers.Handler.Polygon, {
                persist: true,
                handlerOptions: {
                    layerOptions: {
                        renderers: renderer,
                        styleMap: styleMap
                    }
                }
            }
            )
    };
            
    var control;
    for(var key in measureControls) {
        control = measureControls[key];
        control.events.on({
            "measure": handleMeasurements,
            "measurepartial": handleMeasurements
        });
        map.addControl(control);
    }  
}  

function handleMeasurements(event) {
    var geometry = event.geometry;
    var units = event.units;
    var order = event.order;
    var measure = event.measure;
    var element = document.getElementById('output');
    var out = "";
    if(order == 1) {
        out += "测量结果: " + measure.toFixed(3) + " " + units;
    } else {
        out += "测量结果: " + measure.toFixed(3) + " " + units + "<sup>2</" + "sup>";
    }
    element.innerHTML = out;
}

function toggleControl(element) {
    for(key in measureControls) {
        var control = measureControls[key];
        if(element.value == key && element.checked) {
            control.activate();
        } else {
            control.deactivate();
        }
    }
}
        
function toggleGeodesic(element) {
    for(key in measureControls) {
        var control = measureControls[key];
        control.geodesic = element.checked;
    }
}
        
function toggleImmediate(element) {
    for(key in measureControls) {
        var control = measureControls[key];
        control.setImmediate(element.checked);
    }
}

//point
function showSeis(lon0,lat0)
{
    var Feature = OpenLayers.Feature.Vector;
    var Geometry = OpenLayers.Geometry;
    var features = [    new Feature(new Geometry.Point(lon0,lat0))    ];
                   
    var layer = new OpenLayers.Layer.Vector("最新地震1", {
        styleMap: new OpenLayers.StyleMap({
            "default": 
            {
                pointRadius: 12,
                strokeWidth: 3,
                //strokeOpacity: 1.0,
                strokeColor: "#ff0000", //navy
                fillColor: "#0000ff"  //#ffcc66
            //fillOpacity: 1                
            },
            select: {
                fillColor: "red",
                pointRadius: 13,
                strokeColor: "yellow",
                strokeWidth: 3
            }
        }),
        isBaseLayer: false
    });

    layer.addFeatures(features); 
    map.addLayer(layer);                
}
