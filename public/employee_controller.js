
var app = angular.module('myApp', ['ngRoute']);
app.config(function($routeProvider) {
    $routeProvider
    .when("/:name*", {
        templateUrl : function (urlattr)
        {
            return 'redirect_to/' + urlattr.name;
        }
    })
    .otherwise({
        templateUrl : function ()
        {
            return 'redirect_to/1';
        }
    });
});

app.controller('appCtrl', ['$scope', '$http', '$location', '$window', function($scope, $http, $location, $window) {
  $scope.general_url = "";
  $scope.present_citylist = {};
  $scope.permanent_citylist = {};
  $scope.education = {};
  $scope.education.education_type_id = 0;
  $scope.present_address = {};
  $scope.permanent_address = {};

 $scope.$on('$viewContentLoaded', function () {
            $window.scrollTo(0, 0);
  });

  $scope.getCityList = function(province_id, type)
  {    
      $http.post('getCityByProvince/' + province_id).success(function(data){
      if (type=='present')
      {
          $scope.present_citylist = data;
      }
      else
      {
          $scope.permanent_citylist = data;
      }

      });
  }

  $scope.copyPermanentAddress = function()
  {
      $scope.present_address = angular.copy($scope.permanent_address);
      $scope.present_citylist = angular.copy($scope.permanent_citylist);
  }


  $scope.getFamily = function(family_id)
  {
     $http.post('getFamily/' + family_id).success(function(data)
     {
      $scope.family = data[0];
      $scope.update_family = data[1];
     });
  }

  $scope.getDependent = function(dep_id)
  {
     $http.post('getDependent/' + dep_id).success(function(data)
     {
      $scope.family = data[0];
      $scope.ufamily = data[1];
     });
  }

  $scope.getReference = function(ref_id)
  {
     $http.post('getReference/' + ref_id).success(function(data)
     {
        $scope.reference = data[0];
        $scope.ref_update = data[1];
      });
  }

  $scope.getSkill = function(skill_id)
  {
     $http.post('getSkill/' + skill_id).success(function(data)
     {
        $scope.selected_skill = data[0];
        $scope.uskill = data[1];
      });
  }

  $scope.getInventory = function(inventory_id)
  {
    $http.post('getInventory/' + inventory_id).success(function(data)
     {
      $scope.inventory = data[0];
       $scope.uinventory = data[1];
      });
  }

  $scope.getExperience = function(work_id)
  {
     $http.post('getExperience/' + work_id).success(function(data)
     {
      $scope.selected_work = data[0];
      $scope.update_work = data[1];
     });
  }

  $scope.getTraining = function(training_id)
  {
      $http.post('getTraining/' + training_id).success(function(data)
     {
      $scope.selected_training = data[0];
      $scope.utraining = data[1];
     });
  }

  $scope.getEducation = function(education_id)
  {
    $http.post('getEducation/' + education_id).success(function(data)
     {
      $scope.education = data[0];
      $scope.update_educ = data[1];
     });
  }

  $scope.setIsGrad = function()
  {
     $scope.isGrad = !$scope.isGrad;
  }

  $scope.setIsPWork = function()
  {
    $scope.isPresentWork = !$scope.isPresentWork;
  }

  $scope.setIs1D = function()
  {
    $scope.isOneDay = !$scope.isOneDay;
  }
}]);