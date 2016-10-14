app.controller('logoutCtrl', function($scope, $state) {
	$scope.logoutOnClick = function() {
		var userId = appConfig.userId = '';

		if(!userId) {
			$state.go('login');
		}
	}
});