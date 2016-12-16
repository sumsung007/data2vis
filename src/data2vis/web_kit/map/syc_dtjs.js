var map;  
var oldSelBox;
/*
function initView4eq(lons,lats)        
{
    //震中周围
    var zooms=7; //国外的可能6更好
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
    map = new OpenLayers.Map("sycmap");  

    boxLayer=new OpenLayers.Layer.Boxes("矩形选择区域");
    boxLayer.displayInLayerSwitcher=false;   
    map.addLayer(boxLayer);
							
    //map.addControl(new OpenLayers.Control.PanZoomBar());  
    map.addControl(new OpenLayers.Control.MousePosition());  
    map.addControl(new OpenLayers.Control.LayerSwitcher());  
    map.addControl(new OpenLayers.Control.Scale());  
    //map.addControl(new OpenLayers.Control.NavToolbar());  
		     
    var control = new OpenLayers.Control();
    OpenLayers.Util.extend(control, {
        draw: function () {
            // this Handler.Box will intercept the shift-mousedown
            // before Control.MouseDefault gets to see it
            this.box = new OpenLayers.Handler.Box( control,
            {
                "done": this.notice
                },

                {
                keyMask: OpenLayers.Handler.MOD_CTRL
                }); //和 NavToolbar冲突
            this.box.activate();
        },

        notice: function (bounds) {
            var ll = map.getLonLatFromPixel(new OpenLayers.Pixel(bounds.left, bounds.bottom)); 
            var ur = map.getLonLatFromPixel(new OpenLayers.Pixel(bounds.right, bounds.top)); 
            document.getElementById('minx').value = ll.lon.toFixed(4);
            document.getElementById('maxx').value = ur.lon.toFixed(4);
            document.getElementById('miny').value = ll.lat.toFixed(4);
            document.getElementById('maxy').value = ur.lat.toFixed(4);

            var sel_ext=[ll.lon.toFixed(4),ll.lat.toFixed(4),ur.lon.toFixed(4),ur.lat.toFixed(4)];
            var sel_bounds=OpenLayers.Bounds.fromArray(sel_ext);
            var sel_box = new OpenLayers.Marker.Box(sel_bounds);
            sel_box.setBorder("red") //ok

            //先清除已经有的，只保留最后创建的一个						
            if(boxLayer.markers.length>0)
            {
                //oldSelBox=boxLayer.Markers[0]; not
                boxLayer.removeMarker(oldSelBox); //oldSelBox
            }
            boxLayer.addMarker(sel_box);
            oldSelBox=sel_box;
        }
    });

    map.addControl(control);
}  


