angular.module('app.services', [])

.factory('BlankFactory', [function(){

}])

.service('LocationService', [function() {
	var cityNameDetails;

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
            deferred.resolve(response.data);
        }, function(error) {
            deferred.reject(error.data.message);
        });

        return deferred.promise;
    }

    this.getUsers = function() {
        var deferred = $q.defer();

        $http.get(appConfig.baseUrl + 'api/v1/users')
            .then(function(response) {
                deferred.resolve(response.data.userList);
            }, function(error) {
                deferred.reject(error.data.message);
            });

        return deferred.promise;
    }
}])

.service('InviteService', ['$http', '$q', function($http, $q) {
    this.sendInvite = function(receiverId, collabDesc, id) {
        console.log(appConfig.userId);
        var deferred = $q.defer();

        $http({
            url: appConfig.baseUrl + 'api/v1/users/' + appConfig.userId + '/invites/' + (id == 1 ? receiverId : 'groups/' + receiverId),
            method: 'POST',
            data: $.param(collabDesc),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(response) {
            deferred.resolve(response.data.message);
        }, function(error) {
            deferred.reject(error.data.message);
        });

        return deferred.promise;
    };

    this.getInvites = function() {
        var deferred = $q.defer();

        $http.get(appConfig.baseUrl + 'api/v1/users/' + appConfig.userId + '/invites')
            .then(function(response) {
                deferred.resolve(response.data.inviteList);
            }, function(error) {
                deferred.reject(error.data);
            });

        return deferred.promise;
    }
}])

.service('GroupService', ['$http', '$q', function($http, $q) {
    this.getGroups = function() {
        var deferred = $q.defer();

        $http.get(appConfig.baseUrl + 'api/v1/groups')
            .then(function(response) {
                deferred.resolve(response.data.groupList);
            }, function(error) {
                deferred.reject(error.data);
            });

        return deferred.promise;
    }
}])

.service('CollabService', ['$http', '$q', function($http, $q) {
    var collabName;
    var collabId;

    this.setCollabId = function(id) {
        this.collabId = id;
    }   

    this.getCollabId = function() {
        return this.collabId;
    }

    this.getCollabs = function() {
        var deferred = $q.defer();

        $http.get(appConfig.baseUrl + 'api/v1/users/' + appConfig.userId + '/collabs')
            .then(function(response) {
                deferred.resolve(response.data.collabList);
            }, function(error) {
                deferred.reject('Error occurred');
            });

            return deferred.promise;
    }

    this.setCollabName = function(name) {
        this.collabName = name;
    }

    this.getCollabName = function() {
        return this.collabName;
    }

    this.updateCollabName = function(nameObject) {
        var deferred = $q.defer();

        $http({
            url: appConfig.baseUrl + 'api/v1/collabs/' + this.getCollabId(),
            method: 'PUT',
            data: $.param(nameObject),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }    
        })
        .then(function(response) {
            deferred.resolve(response.data.message);
        }, function(error) {
            deferred.reject(error.data.message);
        });

        return deferred.promise;
    }
}]);