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

/**
 * @ngdoc directive
 * @name isActiveNav
 * @param $location
 * @memberof ClientApp
 */
angular.module("laravel_angular").directive('isActiveNav', ['$location', function(
  $location) {
  return {
    restrict: 'A',
    link: function(scope, element) {
      scope.location = $location;
      scope.$watch('location.path()', function(currentPath) {
        if ('#' + currentPath == element[0].hash) {
          element.parent().addClass('active');
        } else {
          element.parent().removeClass('active');
        }
      });
    }
  };
}]);

/**
 * @ngdoc directive
 * @name isActiveLink
 * @param $location
 * @memberof ClientApp
 */
angular.module("laravel_angular").directive('isActiveLink', ['$location', function(
  $location) {
  return {
    restrict: 'A',
    link: function(scope, element) {
      scope.location = $location;
      scope.$watch('location.path()', function(currentPath) {
        if ('#' + currentPath == element[0].hash) {
          element.addClass('active');
        } else {
          element.removeClass('active');
        }
      });
    }
  };
}]);

/**
 * @ngdoc config
 * @name mainRouteConfig
 * @memberof ClientApp
 * @param $stateProvider {service}
 * @param $urlRouterProvider {service}
 */
 angular.module("laravel_angular").config(function($stateProvider, $urlRouterProvider) {
   $urlRouterProvider.otherwise("/home/all");
 });

angular.module("laravel_angular").factory('errorInterceptor', ['$q', '$log',
  '$rootScope', '$timeout',
  '$injector',
  function(q, log, rootScope, timeout, injector) {
    rootScope.error = null;
    return {
      // optional method
      'requestError': function(rejection) {
        // do something on error
        if (canRecover(rejection)) {
          return responseOrNewPromise
        }
        return $q.reject(rejection);
      },
      // optional method
      'response': function(response) {
        if (response.data.success) {
          var success = {
            "icon": "ion-check",
            "type": "success",
            "code": response.status,
            "msg": response.statusText,
            "message": response.data.message
          };
          rootScope.success = success;
          rootScope.showSuccess = true;
          timeout(function() {
            rootScope.showSuccess = false;
          }, 2000);
        }
        return response;
      },


      // optional method
      'responseError': function(response) {
        console.log(response);
        if (!response.data.success) {
          var error = {
            "icon": "ion-android-alert",
            "type": "danger",
            "code": response.status,
            "msg": response.statusText,
            "message": response.data.message
          };
          rootScope.error = error;
          rootScope.showError = true;
          timeout(function() {
            rootScope.showError = false;
          }, 3000);

          // do something on error
          var stateService = injector.get('$state');
          if (response.status == 401) {
            timeout(function() {
              stateService.go('home');
            }, 3000)
          }
        }
        return q.reject(response);
      }
    }
  }
]);

angular.module("laravel_angular").config(['$httpProvider', function(httpProvider) {
  httpProvider.interceptors.push('errorInterceptor');
}]);

angular.module('laravel_angular').factory('Requests', ['$http', '$rootScope', function(
  http, rootScope) {
  var Requests = {};
  Requests.data = [];
  Requests.post_data = []
  var base_url = "http://api.epikenya.com/";
  //var img_url = "http://images.epikenya.org/";
  var url = null;

  /**
   * Post Data
   * @param  {[type]} resource [description]
   * @param  {[type]} object   [description]
   * @return {[type]}          [description]
   */
  Requests.post = function post(resource, object, callBack) {
    var request_url = '';
    if (object.top_level) {
      request_url = resource;
    } else {
      request_url = base_url + resource;
    }
    var req = {
      method: 'POST',
      url: request_url,
      data: object
    };

    /**
     * Check if Post Data exists
     * @param  {[type]} object [description]
     * @return {[type]}        [description]
     */

    if (object) {
      http(req)
        .success(function(data) {
          //this is the key
          callBack(data);
        })
        .error(function(data, response) {
          console.log(response + " " + data);
        });;
    }
  }

  /**
   * @description Put Data
   * @param resource
   * @param object
   * @param callBack
   */
  Requests.put = function put(resource, object, callBack) {

    var req = {
      method: 'PUT',
      url: base_url + resource,
      data: object
    };

    /**
     * Check if Post Data exists
     * @param  {[type]} object [description]
     * @return {[type]}        [description]
     */
    if (object) {
      http(req)
        .success(function(data) {
          //this is the key
          callBack(data);
        })
        .error(function(data, response) {
          console.log(response + " " + data);
        });;
    }
  }

  Requests.destroy = function destroy(resource, object, callBack) {

    var req = {
      method: 'DELETE',
      url: base_url + resource,
      data: object
    };

    /**
     * Check if Post Data exists
     * @param  {[type]} object [description]
     * @return {[type]}        [description]
     */
    if (object) {
      http(req)
        .success(function(data) {
          //this is the key
          callBack(data);
        })
        .error(function(data, response) {
          console.log(response + " " + data);
        });;
    }
  }


  /**
   * [get description]
   * @return {[type]} [description]
   */
  Requests.get = function get(resource, object, callBack) {
    var req;
    var request_url = '';
    if (object.top_level) {
      request_url = resource;
      delete(object.top_level);
    } else {
      request_url = base_url + resource;
    }
    req = {
      method: 'GET',
      url: request_url,
      headers: {
        'Content-Type': 'application/json'
      },
      params: object
    };

    http(req)
      .success(function(data) {
        //this is the key
        callBack(data);
      })
      .error(function(data, response) {
        console.log(response + " " + data);
      });;
  }
  return Requests;
}])

angular.module('module.home', []).controller('homeCtrl', [
    '$scope',
    'Requests',
    '$state',
    function(scope, Requests, state) {

        scope.responses = []
        scope.story = {};
        scope.stories = [];

        //getAll();

        function getAll() {
            var payload = {};
            Requests.get('articles/county/nairobi/top', payload, function(data) {
                scope.stories = data.articles;
                console.log(data);
            });
        }

        function getByid(id) {
            var payload = {};
            Requests.get('articles/' + id, payload, function(data) {
                scope.story = data;
                console.log(data);
            });
        }

        function getTopByLocation(location) {
            var payload = {};
            Requests.get('articles/' + location + '/top', payload, function(data) {
                scope.story = data;
                console.log(data);
            });
        }

        function getLatestByLocation(location, page) {
            var payload = {};
            Requests.get('articles/county' + location + '/page/' + page, payload, function(data) {
                scope.story = data;
                console.log(data);
            });
        }

        function getLatestBycategory(location, categoryname) {
            var payload = {};
            Requests.get('articles/county' + location + '/category/' + categoryname, payload, function(data) {
                scope.story = data;
                console.log(data);
            });
        }

    }
])

angular.module('module.home').config(function($stateProvider, $urlRouterProvider) {

    $stateProvider.state('home', {
        url: '/home',
        views: {
            '': {
                templateUrl: VIEW._modules('home/home.main')
            },
            '': {
                templateUrl: VIEW._modules('home/home.header')
            }
        }
    }).state('home.all', {
        url: '/all',
        controller: 'homeCtrl',
        templateUrl: VIEW._modules('home/home.glimpse')

    }).state('home.one', {
        url: '/one',
        templateUrl: VIEW._modules('home/article.view.one')

    }).state('home.politics', {
        url: '/politics',
        templateUrl: VIEW._modules('home/politics.glimpse')

    }).state('home.opinion', {
        url: '/opinion',
        templateUrl: VIEW._modules('home/opinion.glimpse')

    }).state('home.business', {
        url: '/business',
        templateUrl: VIEW._modules('home/business.glimpse')

    }).state('home.agriculture', {
        url: '/agriculture',
        templateUrl: VIEW._modules('home/agriculture.glimpse')

    }).state('home.crime', {
        url: '/crime',
        templateUrl: VIEW._modules('home/crime.glimpse')

    }).state('home.sports', {
        url: '/sports',
        templateUrl: VIEW._modules('home/sports.glimpse')

    })
});

angular.module('module.users',[]).controller('usersCtrl', ['$scope', 'Requests',
  '$state',
  function(scope, Requests, state) {
    scope.user = {};



  }
])

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
