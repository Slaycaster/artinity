angular.module('app.services', [])

.factory('BlankFactory', [function(){

}])

.service('LocationService', [function(){
	this.getCityNames = function(inputName) {
		var input = /** @type {!HTMLInputElement} */(
            document.getElementById(inputName));
        var autocomplete = new google.maps.places.Autocomplete(input);

        autocomplete.addListener('place_changed', function() {
        	return autocomplete.getPlace();
        });
	}
}]);