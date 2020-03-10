var app = angular.module('myApp', []);

app.controller('appCtrl',  ['$scope', '$http', '$location', function($scope, $http, $location) {

	$scope.selected_job = 0;
    $scope.choose = 0;
	$scope.loaded = false;
	$scope.accepted = false;
	$scope.message = {};
	$scope.result = {};
	$scope.complete = true;
	$scope.show_apply = false;
	$scope.company_name = '';

	$scope.getJobDetails = function()
    {
    	$scope.accepted = false;
        $scope.loaded = false;
        $http.post('get_job_details/'+$scope.selected_job).success(function(data){
        $scope.jobDetails = data;
        });
    }

    $scope.getQualifyingQuestions = function()
    {
    	$scope.result = {};
    	$http.post('get_qualifying_questions/'+$scope.jobDetails.job_id).success(function(data){
        $scope.questionList = data;
        });

        $scope.loaded = true;
    }

    $scope.loadInitialData = function()
    {
    	$http.post('loadInitialData').success(function(data){
        $scope.dataList = data;
        });
    }

    $scope.evaluate = function()
    {
    	$scope.complete = true;
    	$scope.show_apply = false
    	var array = [];

		angular.forEach($scope.result, function(element) {
  			array.push(element);
		});

    	if (array.length != $scope.questionList.length)
    	{
            $scope.complete = false;
    	}

    	else
    	{

            for (var i = 0; i < $scope.questionList.length; i++)
            {
                if (array[i] != $scope.questionList[i].correct_ans)
                {
                	$scope.accepted = false;
                    break;
                }
                else 
                {
                    $scope.accepted = true;
                }
            }
    	}
    }

    $scope.validate = function()
    {
    	if ($scope.complete && $scope.accepted) //If the form is complete and the applicant is qualified
    	{
			$scope.show_apply = true;
    	}

        if ($scope.complete && !$scope.accepted) //If the form is complete and the applicant is not qualified, redirect to LOGIN. Hahaa
        {
            var path = "../../login/";
            window.location.href = path;
        }
    }

}]);