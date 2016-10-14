app.controller('signupCtrl', ['$scope', '$stateParams', '$http',
// The following is the constructor function for this page's controller. See https://docs.angularjs.org/guide/controller
// You can include any angular dependencies as parameters for this function
// TIP: Access Route Parameters for your page via $stateParams.parameterName
function ($scope, $stateParams, $http) {

	$scope.userForm = {};

	$scope.signUpOnSubmit = function() {
		$http({
			url: appConfig.baseUrl + 'api/v1/users',
			method: 'POST',
			data: $.param({
				str_first_name: $scope.userForm.firstName,
				str_middle_name: $scope.userForm.middleName,
				str_last_name: $scope.userForm.lastName,
				date_birth: '1996/08/02',
				dbl_location_lat: appConfig.latLng.lat,
				dbl_location_long: appConfig.latLng.lng,
				str_email: $scope.userForm.email,
				str_password: $scope.userForm.password,
				int_gender: 'Male'
			}),
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			}
		}).then(function() {
			console.log('Yey!');

			$scope.userForm = {};
		}, function(error) {
			console.log('Error!');
		})
	}
}])