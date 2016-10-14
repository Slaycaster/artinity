app.controller('collaborationCtrl', ['$scope', '$stateParams', '$ionicModal', '$ionicPopup',// The following is the constructor function for this page's controller. See https://docs.angularjs.org/guide/controller
// You can include any angular dependencies as parameters for this function
// TIP: Access Route Parameters for your page via $stateParams.parameterName
function ($scope, $stateParams, $ionicModal, $ionicPopup) {
	$ionicModal.fromTemplateUrl('templates/modal-add.html', {
	   scope: $scope,
	   animation: 'slide-in-up'
	 }).then(function(modal) {
	   $scope.modal = modal;
	 });

	 $scope.location = appConfig.location;

	 $scope.openModal = function() {
	   $scope.modal.show();
	 };
	 $scope.closeModal = function() {
	 	console.log('Collab close');

	   $scope.modal.hide();
	 };
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