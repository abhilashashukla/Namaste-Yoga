  if ("geolocation" in navigator){ //check geolocation available
                                                                 //try to get user current location using getCurrentPosition() method
                                                                 navigator.geolocation.getCurrentPosition(function(position){
																	 //console.log(position.coords.latitude+ ''+ position.coords.longitude)
                                                                   $('#current_lat').val(position.coords.latitude);
                                                                   $('#current_lng').val(position.coords.longitude);
                                                                   });
                                                               }else{
                                                                 console.log("Browser doesn't support geolocation!");
                                                               }
      



	   function initialize() {
		   $(document).ready(function (){
			  var current_lat = $("#current_lat").val();
              var current_lng = $("#current_lng").val();
			  //alert(current_lat);
			  //alert(current_lng);
            // Creating map object
			/* $(document).ready(function () {
				map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
			}); */
            var map = new google.maps.Map(document.getElementById('map_canvas'), {
                zoom: 6,
                center: new google.maps.LatLng(current_lat * 1, current_lng * 1),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });
            // creates a draggable marker to the given coords
            var vMarker = new google.maps.Marker({
                position: new google.maps.LatLng(current_lat * 1, current_lng * 1),
                draggable: true
            });
            // adds a listener to the marker
            // gets the coords when drag event ends
            // then updates the input with the new coords
            google.maps.event.addListener(vMarker, 'dragend', function (evt) {
               var lang=$("#current_lat").val(evt.latLng.lat().toFixed(6));
               var lat=$("#current_lng").val(evt.latLng.lng().toFixed(6));
				$("#address_input").val(evt.latLng.lat().toFixed(6)+','+evt.latLng.lng().toFixed(6));
				$("#lat_lng").val(evt.latLng.lat().toFixed(6)+','+evt.latLng.lng().toFixed(6));
                map.panTo(evt.latLng);
            });
            // centers the map on markers coords
            map.setCenter(vMarker.position);
            // adds the marker on the map
            vMarker.setMap(map);
		   });
        }
		

