angular.module('app.services', [])

.factory('BlankFactory', [function(){

}])

.service('LocationService', [function() {
	var cityNameDetails = 'Pakshet';

	this.getCityNames = function(inputName) {
		var input = /** @type {!HTMLInputElement} */(
            document.getElementById(inputName));
        var autocomplete = new google.maps.places.Autocomplete(input);

        autocomplete.addListener('place_changed', function() {
        	cityNameDetails = autocomplete.getPlace().address_components[0].long_name;
        });

        return cityNameDetails;
	}
}]);