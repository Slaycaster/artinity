app.controller('homeCtrl', ['$scope', '$stateParams', '$ionicModal', 'LocationService',
// The following is the constructor function for this page's controller. See https://docs.angularjs.org/guide/controller
// You can include any angular dependencies as parameters for this function
// TIP: Access Route Parameters for your page via $stateParams.parameterName
function ($scope, $stateParams, $ionicModal, LocationService) {
	$ionicModal.fromTemplateUrl('templates/modal-location.html', {
	   scope: $scope,
	   animation: 'slide-in-up'
	 }).then(function(modal) {
	   $scope.modal = modal;
	 });
	 $scope.openModal = function() {
	   $scope.location = appConfig.location;

	   console.log(LocationService.getCityNames('location-input'));

	   $scope.modal.show();
	 };
	 $scope.closeModal = function() {
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

}]);