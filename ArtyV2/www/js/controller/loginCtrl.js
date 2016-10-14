app.controller('loginCtrl', ['$scope', '$stateParams', '$state', 'UserService',
// The following is the constructor function for this page's controller. See https://docs.angularjs.org/guide/controller
// You can include any angular dependencies as parameters for this function
// TIP: Access Route Parameters for your page via $stateParams.parameterName
function ($scope, $stateParams, $state, UserService) {
	$scope.userForm = {};

	$scope.loginOnSubmit = function() {
		UserService.login({
			str_email: $scope.userForm.email,
			str_password: $scope.userForm.password
		}).then(function(response) {
			appConfig.userId = response.userId;

			$state.go('tabsController.home');
		}, function(errorResponse) {
			console.log(errorResponse);
		})
	}

}]);