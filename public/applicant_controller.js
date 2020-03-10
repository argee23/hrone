
var app = angular.module('myApp', []);

app.controller('appCtrl', ['$scope', '$http', '$location', '$window', function($scope, $http, $location, $window) {
$scope.initialise = "MISS E";
$scope.receiver = '';

  $scope.search = function()
  {
     $http.post('search_job/' + $scope.title).success(function(data)
     {
      $scope.jobList = data;
      console.log(data);
     });
  }
}]);