
var app = angular.module('myApp', []);

app.controller('appCtrl', ['$scope', '$http', '$location', '$window', function($scope, $http, $location, $window) {
$scope.initialise = "MISS E";
$scope.receiver = '';

$scope.getConvo = function(message_id)
{
   $http.post('getMessage/' + message_id).success(function(data)
   {
    $scope.message = data;
   });
}

$scope.getBDMessages = function(employee_id)
{
   $http.get('get_birthday_messages/' + employee_id).then(function(data)
   {
      $scope.messages = data.data;

   })
   .finally(function() {

  });
}

$scope.loadMessage = function(message)
{
  $scope.selected_message = angular.copy(message);
}

$scope.getAllEvents = function() {
  $http.post('getEvents/').success(function(data)
  {
    $scope.eventList = data;
  });
}
}]);