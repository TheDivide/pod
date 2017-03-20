angular.module('module.users').config(function($stateProvider, $urlRouterProvider) {

  $stateProvider.state('login', {
    url: '/login',
    views: {
      '': {
        controller: 'usersCtrl',
        templateUrl: 'app/module/users/users.login.tpl.html'
      }
    }
  })
});
