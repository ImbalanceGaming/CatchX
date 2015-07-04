var catchXApp = angular.module("catchXApp", ["ngRoute", "ngResource", "ngAnimate"]);

// Dit gedeelte verzorgt de routing. Omdat er op dit moment maar 1 view en controller is, is er dus ook maar 1 route.
catchXApp.config(['$routeProvider',
    function ($routeProvider) {
        $routeProvider.
            when('/games', {
                templateUrl: 'app/views/gamesList.html',
                controller: "gamesController"
            }).
            when('/join/:gameId', {
                templateUrl: 'app/views/join.html',
                controller: "joinController"
            }).
            when('/host', {
                templateUrl: 'app/views/host.html',
                controller: "hostController"
            }).
            when('/home', {
                templateUrl: 'app/views/home.html'
            }).
            when('/about', {
                templateUrl: 'app/views/about.html'
            }).
            otherwise({
                redirectTo: '/home'
            });
    }]
);