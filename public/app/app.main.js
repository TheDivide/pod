var PATH = {
  _modules:'app/module/',
  _globals:'app/global/'
}

var VIEW ={
  _modules:function(path){
    return PATH._modules+path+'.tpl.html'
  },
  _globals:function(path){
    return PATH._globals+path+'.tpl.html'
  }
}

angular.module("laravel_angular", [
  'ui.router',
  'restangular',
  'smart-table',
  'textAngular',
  'angularMoment',
  'ui.bootstrap',
  'slick',
  'permission',
  'LocalStorageModule',
  'angularValidator',
  'btford.socket-io',
  'angular-loading-bar',
  'module.home',
  'module.users'
]);


/**
 * @ngdoc run
 * @name Main
 * @requires $http
 * @requires $rootScope
 * @memberof ClientApp
 */
angular.module("laravel_angular").run(['$http', '$rootScope', '$state', function($http,
  rootScope,
  state) {
  rootScope.date = new Date();
  rootScope.title = 'pod';
  rootScope.messages = [];
  rootScope.menu = [];
  rootScope.errors = [];
  rootScope.state = state;
}]);

angular.module("laravel_angular").config(['$httpProvider', function($httpProvider) {

      delete $httpProvider.defaults.headers.common['X-Requested-With'];
      $httpProvider.defaults.headers.common['Access-Control-Allow-Origin'] = "*";
      $httpProvider.defaults.headers.post['Accept'] = 'application/json, text/javascript';
      $httpProvider.defaults.headers.post['Content-Type'] = 'application/json; charset=utf-8';

      $httpProvider.defaults.headers.common['Accept'] = 'application/json, text/javascript';
      $httpProvider.defaults.headers.common['Content-Type'] = 'application/json; charset=utf-8';
      $httpProvider.defaults.useXDomain = true;
      }
  ]);

angular.module("laravel_angular").controller('appCtrl', ['$location', function(
  $location) {
    console.log('Hello');
}]);
