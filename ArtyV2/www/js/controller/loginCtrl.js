app.controller('loginCtrl', ['$scope', '$stateParams', 'UserService',
// The following is the constructor function for this page's controller. See https://docs.angularjs.org/guide/controller
// You can include any angular dependencies as parameters for this function
// TIP: Access Route Parameters for your page via $stateParams.parameterName
function ($scope, $stateParams, UserService) {
	$scope.loginOnSubmit = function() {
		$scope.userForm = {};

		UserService.login({
			str_email: $scope.userForm.username,
			str_password: $scope.userForm.password
		}).then(function(response) {
			console.log(response);
		}, function(errorResponse) {
			console.log(errorResponse);
		})
	}

}]);