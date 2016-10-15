app.controller('requestsCtrl', ['$scope', '$stateParams', 'InviteService', '$http', '$state', '$ionicPopup',
// The following is the constructor function for this page's controller. See https://docs.angularjs.org/guide/controller
// You can include any angular dependencies as parameters for this function
// TIP: Access Route Parameters for your page via $stateParams.parameterName
function ($scope, $stateParams, InviteService, $http, $state, $ionicPopup) {
	InviteService.getInvites()
		.then(function(response) {
			console.log('fhdkjsfjdsklfjdsklfjkldsjfklds ', response);

			$scope.requests = response;
			console.log($scope.requests);
		}, function(responseError) {
			console.log(responseError);
		});

	$scope.acceptOnClick = function(requestId) {
		$http({
			url: appConfig.baseUrl + 'api/v1/users/' + appConfig.userId + '/invites/' + requestId + '/accept',
			method: 'POST',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			}
		}).then(function(response) {
			console.log(response.data.message);
			$scope.showAlert();
		}, function(errorResponse) {
			console.log(errorResponse.data.message);	
		})
	};

	$scope.showAlert = function() {
	   var alertPopup = $ionicPopup.alert({
	     title: 'Invitation Accepted!',
	     template: 'Have some fun!'
	   });

	   alertPopup.then(function(res) {
	     console.log('Thank you for not eating my delicious ice cream cone');
	     $state.go('tabsController.collaboration');
	   });
	 };
}]);