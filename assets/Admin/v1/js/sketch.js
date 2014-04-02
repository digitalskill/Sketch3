var sketch = angular.module('sketch', ['ngRoute']);

sketch.config(function($routeProvider) {
  $routeProvider.when('/login', {
    templateUrl: 'admin/login',
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
      $location.url("/login");
    }
    event.preventDefault();
  });
});

sketch.controller('LoginCtrl', function($scope, $http, $location, authentication) {
  $scope.login = function() {
      
      
    if ($scope.username === 'admin' && $scope.password === 'pass') {
      authentication.isAuthenticated = true;
      authentication.user = { name: $scope.username };
      $location.url("/");
    } else {
      $scope.loginError = "Invalid username/password combination";
    };
  };
});

sketch.controller('HomeCtrl', function($scope, authentication) {
  $scope.user = authentication.user.name;
});

sketch.factory('authentication', function() {
  return {
    isAuthenticated: false,
    user: null
  }
});