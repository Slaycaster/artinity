angular.module('app.routes', [])

.config(function($stateProvider, $urlRouterProvider) {

  // Ionic uses AngularUI Router which uses the concept of states
  // Learn more here: https://github.com/angular-ui/ui-router
  // Set up the various states which the app can be in.
  // Each state's controller can be found in controllers.js
  $stateProvider
    
  

      .state('tabsController.home', {
    url: '/home',
    views: {
      'tab1': {
        templateUrl: 'templates/home.html',
        controller: 'homeCtrl'
      }
    }
  })

  .state('tabsController.collaboration', {
    url: '/myClass',
    views: {
      'tab2': {
        templateUrl: 'templates/collaboration.html',
        controller: 'collaborationCtrl'
      }
    }
  })

  .state('tabsController.requests', {
    url: '/requests',
    views: {
      'tab3': {
        templateUrl: 'templates/requests.html',
        controller: 'requestsCtrl'
      }
    }
  })

  .state('tabsController', {
    url: '/page1',
    templateUrl: 'templates/tabsController.html',
    abstract:true
  })

  .state('login', {
    url: '/page5',
    templateUrl: 'templates/login.html',
    controller: 'loginCtrl'
  })

  .state('signup', {
    url: '/page6',
    templateUrl: 'templates/signup.html',
    controller: 'signupCtrl'
  })

  .state('tutorView', {
    url: '/tutorView',
    templateUrl: 'templates/tutorView.html',
    controller: 'tutorViewCtrl'
  })

  .state('tabsController.collabView', {
    url: '/collab',
    views: {
      'tab2': {
        templateUrl: 'templates/collabView.html',
        controller: 'collabViewCtrl'
      }
    }
  })

  .state('tabsController.collabItems', {
    url: '/collabItems',
    views: {
      'tab2': {
        templateUrl: 'templates/collabItems.html',
        controller: 'collabItemsCtrl'
      }
    }
  })

$urlRouterProvider.otherwise('/page5')

  

});