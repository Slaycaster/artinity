function initMap() {     
	var geocoder = new google.maps.Geocoder;
	var latLng = {};

	if(navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {
			latLng = {
				lat: position.coords.latitude,
				lng: position.coords.longitude
			}

			appConfig.latLng = latLng;

			console.log(appConfig.latLng);

			geocoder.geocode({
				location: latLng
			}, function(results, status) {
				if(status == 'OK') {
					appConfig.location = results[0].address_components[2].long_name;
				} else {
					console.log('No results found');
				}
			});
		});
	} else {
		console.log('App does not support geolocation.');
	}
}