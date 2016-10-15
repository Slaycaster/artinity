app.controller('groupViewCtrl', ['$scope', '$stateParams', '$ionicModal', 'UserService', 'InviteService',// The following is the constructor function for this page's controller. See https://docs.angularjs.org/guide/controller
// You can include any angular dependencies as parameters for this function
// TIP: Access Route Parameters for your page via $stateParams.parameterName
function ($scope, $stateParams, $ionicModal, UserService, InviteService) {

	UserService.getUsers()
		.then(function(response) {
			$scope.users = response;
		}, function(errorResponse) {
			console.log(errorResponse);
		})

	$scope.createGroupOnClick = function() {
		$http({
			url: appConfig.baseUrl + 'api/v1/groups',
			method: 'POST',
			data: $.param({
				str_group_name: $scope.userForm.groupName,
				int_owner_id_fk: appConfig.userId,
				str_group_desc: ''
			}),
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			}
		}).then(function(response) {
			console.log(response.data.message);
		}, function(error) {
			console.log(error.data.message);
		});
	}

	$ionicModal.fromTemplateUrl('templates/modal-addGroup.html', {
	   scope: $scope,
	   animation: 'slide-in-up'
	 }).then(function(modal) {
	   $scope.modal2 = modal;
	 });

	 $scope.location = appConfig.location;

	 $scope.openModal2 = function() {
	   $scope.modal2.show();
	 };
	 $scope.closeModal2 = function() {
	 	console.log('Collab close');

	   $scope.modal2.hide();
	 };
	 // Cleanup the modal when we're done with it!
	 $scope.$on('$destroy', function() {
	   $scope.modal2.remove();
	 });
	 // Execute action on hide modal
	 $scope.$on('modal.hidden', function() {
	   // Execute action
	 });
	 // Execute action on remove modal
	 $scope.$on('modal.removed', function() {
	   // Execute action
	 });
}])