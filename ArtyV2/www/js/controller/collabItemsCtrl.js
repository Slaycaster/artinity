app.controller('collabItemsCtrl', ['$scope', '$stateParams', '$ionicModal', '$ionicPopup',
	'CollabService',
// The following is the constructor function for this page's controller. See https://docs.angularjs.org/guide/controller
// You can include any angular dependencies as parameters for this function
// TIP: Access Route Parameters for your page via $stateParams.parameterName
function ($scope, $stateParams, $ionicModal, $ionicPopup, CollabService) {


	$ionicModal.fromTemplateUrl('templates/modal-addItem.html', {
	   scope: $scope,
	   animation: 'slide-in-up'
	 }).then(function(modal) {
	   $scope.modal = modal;
	 });
	 $scope.openModal = function() {
	   $scope.modal.show();
	 };
	 $scope.closeModal = function() {
	   $scope.modal.hide();
	 };

	 $scope.collabName = CollabService.getCollabName();

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

 	 $scope.showPopup = function(index) {
  		 $scope.data = {};

   // An elaborate, custom popup
 		  var myPopup = $ionicPopup.show({
 		    template: '<input type="text" ng-model="data.wifi">',
 		    title: 'Rename Collab',
 		    subTitle: 'Enter a cool name.',
 		    scope: $scope,
 		    buttons: [
 		      { text: 'Cancel' },
 		      {
 		        text: '<b>Set</b>',
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
 		      	CollabService.updateCollabName({
 		      		str_collab_name: res
 		      	}).then(function(response) {
 		      		$scope.collabName = res;

 		      		console.log(response);
 		      	}, function(errorResponse) {
 		      		console.log(errorResponse);
 		      	});
 		      } else {
 		      	console.log('Empty input!');
 		      }
 		    });
 	}
}])