
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
      $scope.family = data;
     });
  }

  $scope.getDependent = function(dep_id)
  {
     $http.post('getDependent/' + dep_id).success(function(data)
     {
      $scope.family = data;
     });
  }

  $scope.getReference = function(ref_id)
  {
     $http.post('getReference/' + ref_id).success(function(data)
     {
      $scope.reference = data;
      });
  }

  $scope.getSkill = function(skill_id)
  {
     $http.post('getSkill/' + skill_id).success(function(data)
     {
      $scope.selected_skill = data;
      });
  }

  $scope.getInventory = function(inventory_id)
  {
    $http.post('getInventory/' + inventory_id).success(function(data)
     {
      $scope.inventory = data;
      });
  }

  $scope.getExperience = function(work_id)
  {
     $http.get('getExperience/' + work_id).then(function(data)
     {
        $scope.selected_work = data.data;
     })
     .finally(function() {
      if ($scope.selected_work.isPresentWork == '0'){
        $scope.isPresentWork = false;
      }
      else
      {
        $scope.isPresentWork = true;
      }
    });
  }

  $scope.getTraining = function(training_id)
  {
     $http.get('getTraining/' + training_id).then(function(data)
     {
        $scope.selected_training = data.data;
     })
     .finally(function() {
      if ($scope.selected_training.isOneDay == '1'){
        $scope.isOneDay = true;
      }
      else
      {
        $scope.isOneDay = false;
      }
    });
  }

  $scope.getEducation = function(education_id)
  {
     $http.get('getEducation/' + education_id).then(function(data)
     {
        $scope.education = data.data;
     })
     .finally(function() {
      if ($scope.education.isGraduated == '0'){
        $scope.isGrad = true;
      }
      else
      {
        $scope.isGrad = false;
      }
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