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
