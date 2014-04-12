var sketch = angular.module('sketch', ['ngRoute'],function($httpProvider){
    $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8'; 
    
});

sketch.config(function($routeProvider) {
    $routeProvider.when('/auth', {
        templateUrl: 'admin/auth',
        controller: 'LoginCtrl'
    })
    .when('/', {
        templateUrl: 'admin/dashboard',
        controller: 'HomeCtrl'
    })
    .otherwise({ redirectTo: '/' });
});

// Default to Login view
sketch.run(function(authentication, $rootScope, $location) {
  $rootScope.$on('$routeChangeStart', function(evt) {
    if(!authentication.isAuthenticated){ 
      $location.url("/auth");
    }
    event.preventDefault();
  });
});

sketch.controller('LoginCtrl', function($scope, $http, $location, authentication) {
    $scope.formData = {};
    $scope.processForm = function(){
        $http.post('/api/v1/auth',$.param($scope.formData))
          .success(function(data){
              authentication.isAuthenticated = true;
              authentication.token = data.token;
              $location.url("/");
        })
          .error(function(){
              $scope.loginError = "Invalid login";
        });
    };
});

sketch.controller('HomeCtrl', function($scope, authentication) {
    $scope.user = authentication.user.name;
});

sketch.factory('authentication', function() {
    return {
        isAuthenticated: false,
        token: null
    }
});