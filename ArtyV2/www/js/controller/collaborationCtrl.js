app.controller('collaborationCtrl', ['$scope', '$stateParams', '$ionicModal', '$ionicPopup',
	'UserService', '$http', 'InviteService',
// The following is the constructor function for this page's controller. See https://docs.angularjs.org/guide/controller
// You can include any angular dependencies as parameters for this function
// TIP: Access Route Parameters for your page via $stateParams.parameterName
function ($scope, $stateParams, $ionicModal, $ionicPopup, UserService, $http, InviteService) {
	$ionicModal.fromTemplateUrl('templates/modal-add.html', {
	   scope: $scope,
	   animation: 'slide-in-up'
	 }).then(function(modal) {
	   $scope.modal = modal;
	 });

	 $scope.location = appConfig.location;
	 $scope.userForm = {};

	 UserService.getUsers()
	 	.then(function(response) {
	 		$scope.users = response;
	 	}, function(errorResponse) {
	 		console.log(errorResponse);
	 	})

	 $scope.openModal = function() {
	   $scope.modal.show();
	 };
	 $scope.closeModal = function() {
	 	console.log('Collab close');

	   $scope.modal.hide();
	 };

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

	 // Cleanup the modal when we're done with it!
	 $scope.$on('$destroy', function() {
	   $scope.modal.remove();
	 });
	 // Execute action on hide modal
	 $scope.$on('modal.hidden', function() {
	   // Execute action
	 });
	 // Execute action on remove modal
	 $scope.$on('modal.removed', function() {
	   // Execute action
	 });

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

	  	 $scope.showPopup = function(index) {
	   		 $scope.data = {};

	    // An elaborate, custom popup
	  		  var myPopup = $ionicPopup.show({
	  		    template: '<input type="text" ng-model="data.wifi">',
	  		    title: 'Request for collab',
	  		    subTitle: 'Send a short message :)',
	  		    scope: $scope,
	  		    buttons: [
	  		      { text: 'Cancel' },
	  		      {
	  		        text: '<b>Send</b>',
	  		        type: 'button-balanced',
	  		        onTap: function(e) {
	  		          if (!$scope.data.wifi) {
	  		            //don't allow the user to close unless he enters wifi password
	  		            e.preventDefault();
	  		          } else {
	  		            return $scope.data.wifi;
	  		          }
	  		        }
	  		      }
	  		    ]
	  		  });

	  		  myPopup.then(function(res) {
	  		      if(res) {
	  		      	InviteService.sendInvite($scope.users[index].int_user_id, {
	  		      		str_collab_request_message: res
	  		      	})
	  		      		.then(function(response) {
	  		      			console.log(response);
	  		      		}, function(responseError) {
	  		      			console.log(responseError);
	  		      		});
	  		      } else {
	  		      	console.log('Pakshit!');
	  		      }
	  		    });
	  	}
}]);