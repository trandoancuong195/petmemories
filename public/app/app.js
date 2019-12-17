var petMemories = angular.module('petMemories',["ngRoute"]);
petMemories.config(['$routeProvider', '$locationProvider',
    function ($routeProvider, $locationProvider) {
        var baseURL = $('base').attr('href');
        $routeProvider.when('/logout', {
            controller: 'LogoutCtrl',
            url: baseURL + 'logout'
        }).when('/', {
            templateUrl: 'layout/content.html',
            controller: 'HomeCtrl',
            title: 'コールシステム'
        })
        .otherwise({
            redirectTo: '/'
        });
        $locationProvider.html5Mode(true);
    }
]);