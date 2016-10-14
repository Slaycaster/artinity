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
}])

.service('UserService', ['$http', '$q', function($http, $q) {
    this.login = function(loginDetails) {
        var deferred = $q.defer();

        $http({
            url: appConfig.baseUrl + 'api/v1/auth/login',
            method: 'POST',
            data: $.param(loginDetails),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(response) {
            deferred.resolve(response.data.message);
        }, function(error) {
            deferred.reject(error.data.message);
        });

        return deferred.promise;
    }
}]);