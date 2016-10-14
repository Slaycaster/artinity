app.controller('requestsCtrl', ['$scope', '$stateParams', 'InviteService',
// The following is the constructor function for this page's controller. See https://docs.angularjs.org/guide/controller
// You can include any angular dependencies as parameters for this function
// TIP: Access Route Parameters for your page via $stateParams.parameterName
function ($scope, $stateParams, InviteService) {
	InviteService.getInvites()
		.then(function(response) {
			console.log(response);

			$scope.requests = response;
		}, function(responseError) {
			console.log(responseError);
		});
}]);