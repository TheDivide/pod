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
