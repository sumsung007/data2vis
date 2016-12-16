var map;  
/*	
function initView4eq(lons,lats)        
{
    //震中周围
    var zooms=8; //国外的可能6更好
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
    map.addControl(new OpenLayers.Control.Scale());      
}  

function showSeis(lon0,lat0)
{
    var Feature = OpenLayers.Feature.Vector;
    var Geometry = OpenLayers.Geometry;
    var features = [    new Feature(new Geometry.Point(lon0,lat0))    ];
                   
    var layer = new OpenLayers.Layer.Vector("指定地震", {
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
    
    //指定地震的位置周围  ??好像没有效果
    //initView4eq(lon0,lat0);    
}