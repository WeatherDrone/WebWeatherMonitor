function initMap() {
    // Create a map. 
    var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 25.649268, lng: -100.289174},
        zoom: 14, 
		zoomControl: true, 
		zoomControlOptions: { 
			position: google.maps.ControlPosition.RIGHT_BOTTOM, 
			style: google.maps.ZoomControlStyle.LARGE }, 
		scaleControl: true,
		mapTypeControl: true,
		mapTypeControlOptions: { 
			style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR, 
			position: google.maps.ControlPosition.BOTTOM_CENTER
		}
    });
	
/* 	GPS
	var lat0 = document.getElementById('lat0').innerHTML;
	var lng0 = document.getElementById('lng0').innerHTML;	
	var lat1 = document.getElementById('lat1').innerHTML;
	var lng1 = document.getElementById('lng1').innerHTML;	
	var lat2 = document.getElementById('lng2').innerHTML;	*/
	
	var latlngArr = [];
	var msgsArr = [];
	var i = 0;
	var latcte = 'lat';
	var lngcte = 'lng';
	var msgcte = 'msg';
	
	// Get GPS data. 
	while(document.getElementById(latcte.concat(i.toString())) != null) {
		latlngArr[i] = {};
		latlngArr[i][0] = document.getElementById(latcte.concat(i.toString())).innerHTML;
		latlngArr[i][1] = document.getElementById(lngcte.concat(i.toString())).innerHTML;
		i++;
	}
	
	console.log(latlngArr[0][0]);
	console.log(latlngArr[0][1]);
	
/*	console.log(latlngArr[1][0]);
	console.log(latlngArr[1][1]);	*/
	
	var Latlng = new google.maps.LatLng(parseFloat(latlngArr[0][0]),parseFloat(latlngArr[0][1])); 
	var flightPlanCoordinates = [];
	
	// Set coordinate data to create a polyline.
	for (j = 0; j < i; j++){
		flightPlanCoordinates[j] = {lat: parseFloat(latlngArr[j][0]), lng: parseFloat(latlngArr[j][1])};
	}
	
	//Create polyline. 
	var flightPath = new google.maps.Polyline({
		path: flightPlanCoordinates,
		geodesic: true,
		strokeColor: '#ff976e',
		strokeOpacity: 1.0,
		strokeWeight: 3,
		map: map
	});
	//flightPath.setMap(map);
	
	//Map style. 
	//var style = [{"elementType":"labels","stylers":[{"visibility":"off"},{"color":"#f49f53"}]},{"featureType":"landscape","stylers":[{"color":"#f9ddc5"},{"lightness":-7}]},{"featureType":"road","stylers":[{"color":"#813033"},{"lightness":43}]},{"featureType":"poi.business","stylers":[{"color":"#645c20"},{"lightness":38}]},{"featureType":"water","stylers":[{"color":"#1994bf"},{"saturation":-69},{"gamma":0.99},{"lightness":43}]},{"featureType":"road.local","elementType":"geometry.fill","stylers":[{"color":"#f19f53"},{"weight":1.3},{"visibility":"on"},{"lightness":16}]},{"featureType":"poi.business"},{"featureType":"poi.park","stylers":[{"color":"#645c20"},{"lightness":39}]},{"featureType":"poi.school","stylers":[{"color":"#a95521"},{"lightness":35}]},{},{"featureType":"poi.medical","elementType":"geometry.fill","stylers":[{"color":"#813033"},{"lightness":38},{"visibility":"off"}]},{},{},{},{},{},{},{},{},{},{},{},{"elementType":"labels"},{"featureType":"poi.sports_complex","stylers":[{"color":"#9e5916"},{"lightness":32}]},{},{"featureType":"poi.government","stylers":[{"color":"#9e5916"},{"lightness":46}]},{"featureType":"transit.station","stylers":[{"visibility":"off"}]},{"featureType":"transit.line","stylers":[{"color":"#813033"},{"lightness":22}]},{"featureType":"transit","stylers":[{"lightness":38}]},{"featureType":"road.local","elementType":"geometry.stroke","stylers":[{"color":"#f19f53"},{"lightness":-10}]},{},{},{}];
	//var style = [{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#e0efef"}]},{"featureType":"poi","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"hue":"#1900ff"},{"color":"#c0e8e8"}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":100},{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"visibility":"on"},{"lightness":700}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#7dcdcd"}]}];
	//var style = [{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#165c64"},{"saturation":34},{"lightness":-69},{"visibility":"on"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"hue":"#b7caaa"},{"saturation":-14},{"lightness":-18},{"visibility":"on"}]},{"featureType":"landscape.man_made","elementType":"all","stylers":[{"hue":"#cbdac1"},{"saturation":-6},{"lightness":-9},{"visibility":"on"}]},{"featureType":"road","elementType":"geometry","stylers":[{"hue":"#8d9b83"},{"saturation":-89},{"lightness":-12},{"visibility":"on"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"hue":"#d4dad0"},{"saturation":-88},{"lightness":54},{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"hue":"#bdc5b6"},{"saturation":-89},{"lightness":-3},{"visibility":"simplified"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"hue":"#bdc5b6"},{"saturation":-89},{"lightness":-26},{"visibility":"on"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"hue":"#c17118"},{"saturation":61},{"lightness":-45},{"visibility":"on"}]},{"featureType":"poi.park","elementType":"all","stylers":[{"hue":"#8ba975"},{"saturation":-46},{"lightness":-28},{"visibility":"on"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"hue":"#a43218"},{"saturation":74},{"lightness":-51},{"visibility":"simplified"}]},{"featureType":"administrative.province","elementType":"all","stylers":[{"hue":"#ffffff"},{"saturation":0},{"lightness":100},{"visibility":"simplified"}]},{"featureType":"administrative.neighborhood","elementType":"all","stylers":[{"hue":"#ffffff"},{"saturation":0},{"lightness":100},{"visibility":"off"}]},{"featureType":"administrative.locality","elementType":"labels","stylers":[{"hue":"#ffffff"},{"saturation":0},{"lightness":100},{"visibility":"off"}]},{"featureType":"administrative.land_parcel","elementType":"all","stylers":[{"hue":"#ffffff"},{"saturation":0},{"lightness":100},{"visibility":"off"}]},{"featureType":"administrative","elementType":"all","stylers":[{"hue":"#3a3935"},{"saturation":5},{"lightness":-57},{"visibility":"off"}]},{"featureType":"poi.medical","elementType":"geometry","stylers":[{"hue":"#cba923"},{"saturation":50},{"lightness":-46},{"visibility":"on"}]}];
	var style = [{"stylers":[{"saturation":-100},{"gamma":1}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"off"}]},{"featureType":"poi.business","elementType":"labels.text","stylers":[{"visibility":"off"}]},{"featureType":"poi.business","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"poi.place_of_worship","elementType":"labels.text","stylers":[{"visibility":"off"}]},{"featureType":"poi.place_of_worship","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"geometry","stylers":[{"visibility":"simplified"}]},{"featureType":"water","stylers":[{"visibility":"on"},{"saturation":50},{"gamma":0},{"hue":"#50a5d1"}]},{"featureType":"administrative.neighborhood","elementType":"labels.text.fill","stylers":[{"color":"#333333"}]},{"featureType":"road.local","elementType":"labels.text","stylers":[{"weight":0.5},{"color":"#333333"}]},{"featureType":"transit.station","elementType":"labels.icon","stylers":[{"gamma":1},{"saturation":50}]}];
	map.setOptions({styles:style});
  
	//Funcion para crear control personalizado. 
	function CustomControl(controlDiv, map) {

	// Set CSS for the control border.
	var controlUI = document.createElement('div');
	controlUI.style.backgroundColor = '#fff';
	controlUI.style.border = 'solid #fff';
	controlUI.style.borderRadius = '30px';
	controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
	controlUI.style.cursor = 'pointer';
	controlUI.style.marginBottom = '22px';
	controlUI.style.textAlign = 'center';
	controlUI.title = 'Click to open menu';
	controlDiv.appendChild(controlUI);

	/* // Set CSS for the control interior.
	var controlText = document.createElement('div');
	controlText.style.color = 'rgb(25,25,25)';
	controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
	controlText.style.fontSize = '16px';
	controlText.style.lineHeight = '38px';
	controlText.style.paddingLeft = '5px';
	controlText.style.paddingRight = '5px';
	controlText.innerHTML = 'Menu';
	controlUI.appendChild(controlText); */
	
	var imgLogo = document.createElement("img");
	imgLogo.setAttribute("src", "http://image.flaticon.com/icons/png/512/52/52152.png");
	imgLogo.setAttribute("height", "40");
	imgLogo.setAttribute("width", "40");
	imgLogo.setAttribute("alt", "Menu");
	
	controlUI.appendChild(imgLogo);

  // Setup the click event listeners: simply set the map to Chicago.
	/* controlUI.addEventListener('click', function(e) {
		e.preventDefault();
        $("#wrapper").toggleClass("toggled");
	});*/
   } 
   //Button Show log.
   var show = true;
   var markers = [];
   var infowindow = new google.maps.InfoWindow();
   var showlog = document.getElementById('showlog');
   
   showlog.addEventListener('click', function() {
	   //Create infowindows.
	   if (show) {
			for (i = 0; i < flightPlanCoordinates.length; i++){
			//Marker icon.
			var image = {
				//url: 'https://d30y9cdsu7xlg0.cloudfront.net/png/156824-200.png',
				//url: 'https://d30y9cdsu7xlg0.cloudfront.net/png/118021-200.png',
				//url: 'http://dronecstasy.com/image/catalog/article/DronEcstasy_vector_IconOnly_PS.png',
				//url: 'http://dronezie.com/wp-content/uploads/2015/11/15-1.png',
				url: 'http://rcstreetshop.com/wp-content/uploads/2015/08/icon_drone-filming.png',
				scaledSize: new google.maps.Size(25, 25),
			};
			//Create marker. 
			markers[i] = new google.maps.Marker({
				position: new google.maps.LatLng(parseFloat(latlngArr[i][0]),parseFloat(latlngArr[i][1])),
				map: map,
				icon: image
			});
			//Open infowindow on click event. 
			google.maps.event.addListener(markers[i],'click',(function(markers, i){ 
				return function() {
					var content = '<div id="content">'+ '<div id="siteNotice">'+
						'</div>'+ '<h3 id="firstHeading" class="firstHeading"> Log '+ i + '</h3>' + 
						'<div id="bodyContent">'+ '<b> latitude: </b>' + flightPlanCoordinates[i].lat + 
						'</div>'+ '<b> longitude: </b>' + flightPlanCoordinates[i].lng + '</div>';
					infowindow.setContent(content);
					infowindow.open(map, markers[i]);
				}
			})(markers, i));
			//Close infowindow after 5 seconds. 
			setInterval(function() {infowindow.close();}, 5000);	
			show = false;
		}
	  } else {
		for (i = 0; i < flightPlanCoordinates.length; i++) {
			markers[i].setMap(null);
		}
		show = true;
	  }
   });
   map.controls[google.maps.ControlPosition.RIGHT].push(showlog);
   
   
   //---------------------------------------------------
   var menuArrow = document.getElementById('arrow_bar');
   menuArrow.addEventListener('click', function() {
		/*e.preventDefault();
        $("#wrapper").toggleClass("toggled");*/
		
       $('.col_bar').css('pointer-events', 'none');
       var overlay_navigation = $('.overlay-navigation'),
         top_bar = $('.bar-top'),
         middle_bar = $('.bar-middle'),
         bottom_bar = $('.bar-bottom');

       overlay_navigation.toggleClass('overlay-active');
       if (overlay_navigation.hasClass('overlay-active')) {

         top_bar.removeClass('animate-out-top-bar').addClass('animate-top-bar');
         middle_bar.removeClass('animate-out-middle-bar').addClass('animate-middle-bar');
         bottom_bar.removeClass('animate-out-bottom-bar').addClass('animate-bottom-bar');
         overlay_navigation.removeClass('overlay-slide-up').addClass('overlay-slide-down')
         overlay_navigation.velocity('transition.slideLeftIn', {
           duration: 300,
           delay: 0,
           begin: function() {
             $('nav ul li').velocity('transition.perspectiveLeftIn', {
               stagger: 150,
               delay: 0,
               complete: function() {
                 $('nav ul li a').velocity({
                   opacity: [1, 0],
                 }, {
                   delay: 10,
                   duration: 140
                 });
                 $('.col_bar').css('pointer-events', 'auto');
               }
             })
           }
         })

       } else {
         $('.col_bar').css('pointer-events', 'none');
         top_bar.removeClass('animate-top-bar').addClass('animate-out-top-bar');
         middle_bar.removeClass('animate-middle-bar').addClass('animate-out-middle-bar');
         bottom_bar.removeClass('animate-bottom-bar').addClass('animate-out-bottom-bar');
         overlay_navigation.removeClass('overlay-slide-down').addClass('overlay-slide-up')
         $('nav ul li').velocity('transition.perspectiveRightOut', {
           stagger: 150,
           delay: 0,
           complete: function() {
             overlay_navigation.velocity('transition.fadeOut', {
               delay: 0,
               duration: 300,
               complete: function() {
                 $('nav ul li a').velocity({
                   opacity: [0, 1],
                 }, {
                   delay: 0,
                   duration: 50
                 });
                 $('.col_bar').css('pointer-events', 'auto');
               }
             });
           }
         })
       }
	});
   map.controls[google.maps.ControlPosition.RIGHT_TOP].push(menuArrow);
   
   //---------------------------------------------------
   /* var ControlDiv = document.createElement('div');
   var menuControl = new CustomControl(ControlDiv, map); 

   ControlDiv.index = 1;
   map.controls[google.maps.ControlPosition.RIGHT_TOP].push(ControlDiv);*/
  }