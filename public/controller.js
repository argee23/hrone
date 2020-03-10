
var app = angular.module('myApp', ['ngRoute']);

// Routers
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
            return 'redirect_to/personal_info';
        }
    });
});

app.controller('appCtrl',  ['$scope', '$http', '$location', function($scope, $http, $location) {

    $scope.questionList = [];
    $scope.edits = 0;
    $scope.resume;

    $scope.activate = function()
    {
        if ($scope.edits == 0)
        {
            $scope.edits = 1;
        }
        else {
            $scope.edits = 0;
            this.getPersonalInfo();
        }
    }

    $scope.deactivate = function()
    {
        $scope.edits = 0;
    }
    $scope.disableSelection = function()
    {
        $scope.hideQuestions = 1;
    	$scope.disabled = 1;
    	this.loadSignUpData(); 
    }


    $scope.cleanURL = function()
    {
    	var path = '#';
  		window.location.href = path;
    }

    $scope.loadQuestions = function()
    {
    	$scope.result = {};
    	$scope.decide = 2;
    	$http.post('get_qualifying_questions/'+$scope.selected_job).success(function(data){
        $scope.questionList = data;
        });
        $scope.message = {};
        $scope.qLoader = true;
    }

    $scope.setDecide = function()
    {
    	$scope.decide = 2;
    }

    $scope.loadSignUpData = function()
    {
    	$http.post('loadSignUpData').success(function(data){
        $scope.dataList = data;
        });
    }

    $scope.getApplicationCount = function()
    {
        $http.post('getActiveJobApplications').success(function(data){
        $scope.appCount = data;
        });
    }

    $scope.printToCart = function(printSectionId, bootstrap, css) {
        console.log("Source: " + bootstrap);

        var printContents = document.getElementById(printSectionId).innerHTML;
            var popupWin = window.open('', '_blank', 'width=800,height=800,scrollbars=no,menubar=no,toolbar=no,location=no,status=no,titlebar=no,top=50');
            popupWin.window.focus();
            popupWin.document.open();
            popupWin.document.write('<!DOCTYPE html><html><head><title>MyHRIS Generated Resume</title>' 
                                    +'<link rel="stylesheet" media="print" type="text/css" href="'+ bootstrap +'" />' 
                                    +'<link rel="stylesheet" media="print" type"text/css" href="' + css +'" />'
                                    +'</head><body onload="window.print(); window.close();"><div>' 
                                    + printContents + '</div></body></html>');
            popupWin.document.close();
    }

    $scope.getData = function()
    {
        this.getPersonalInfo();
        this.getTrainings();
        this.getAddress();
        this.getMoreInfo();
        this.getReferences();   
        this.getContactInfo();
        this.getWorkExperience();
        this.getEducation();
        this.getSkills();
    }

    $scope.getPersonalInfo = function()
    {
        $http.post('getPersonalInfo').success(function(data){
        $scope.personal_info = data;
        });
    }

    $scope.getTrainings = function()
    {

        if (angular.isUndefined($scope.trainings))
        {
            $http.post('getTrainings').success(function(data){
            $scope.trainings = data;
            });
        }
        else {

        }


    }

    $scope.getRequirements = function()
    {
        if (angular.isUndefined($scope.requirements))
        {
            $http.post('get_requirements').success(function(data){
            $scope.requirements = data;
            });
        }
        else {
        }
    }

    $scope.getSubmittedRequirements = function()
    {
        console.log("started");
        if (angular.isUndefined($scope.sub_reqs))
        {
            $http.post('get_submitted_requirements').success(function(data){
            $scope.sub_reqs = data;
            });
        }
        else {
             console.log("1");
        }
    }

    $scope.getAddress = function()
    {
        $http.post('getAddressInfo').success(function(data){
        $scope.address_info = data;
        });
    }

    $scope.getMoreInfo = function()
    {

        $http.post('getMoreInfo').success(function(data){
        $scope.more_info = data;

        if ($scope.more_info.citizenship == null)
        {
            $scope.more_info.citizenship = '38';
        }
        });
    }

    $scope.getReferences = function()
    {
        if (angular.isUndefined($scope.references))
        {
            $http.post('getReferences').success(function(data){
            $scope.references = data;
            });
        }
        else {

        }
    }

    $scope.isCopied = false;
    $scope.copyPermanentAddress = function()
    {

        $scope.address_info.present_province = angular.copy($scope.address_info.permanent_province);
        $scope.address_info.present_city = angular.copy($scope.address_info.permanent_city);
        $scope.address_info.present_address = angular.copy($scope.address_info.permanent_address);
        $scope.address_info.present_address_years_of_stay = angular.copy($scope.address_info.permanent_address_years_of_stay);
    }

    $scope.getSkills = function()
    {
        if (angular.isUndefined($scope.skills))
        {
            $http.post('getSkills').success(function(data){
            $scope.skills = data;
            });
        }
        else {

        } 
    }

    $scope.getContactInfo = function()
    {
        if (angular.isUndefined($scope.contact_info))
        {
            $http.post('getContactInfo').success(function(data){
            $scope.contact_info = data;
            });
        }
        else {

        }
    }

    $scope.getResume = function()
    {
        if (angular.isUndefined($scope.resumee))
        {
            $http.post('getResume').success(function(data){
            $scope.resumee = data;
            });
        }
        else {

        }
    }

    $scope.getWorkExperience = function()
    {
        if (angular.isUndefined($scope.experiences))
        {
            $http.post('getWorkExperience').success(function(data){
            $scope.experiences = data;
            });
        }
        else {

        }
    }

    $scope.trackChanges = function()
    {
        console.log($scope.isPresentWork);
    }

    $scope.copyWork = function(work)
    {
        $scope.selected_work = angular.copy(work);  
    }

    $scope.copySkill = function(skill)
    {
        $scope.selected_skill = angular.copy(skill);
    }

    $scope.editTraining = function(training)
    {
        $scope.selected_training = angular.copy(training);
    }


    $scope.editEducation = function(education)
    {
        $scope.selected_education = angular.copy(education);    
    }

    $scope.editReference = function(reference)
    {
        $scope.selected_reference = angular.copy(reference);    
    }

    $scope.detectPresentWork = function()
    {
        if ($scope.isPWork)
        {
            $scope.selected_work.isPresentWork = 1;
        }
        else {
            $scope.selected_work.isPresentWork = 0;
        }
    }

    $scope.detectPresentEd = function()
    {
        if ($scope.isGrad)
        {
            $scope.selected_education.isGraduated = 0;

        }
        else {
             $scope.selected_education.isGraduated = 1;
        }
    }

    $scope.trackTraining = function()
    {
        console.log($scope.isOneDay);
        if ($scope.isOneDay)
        {
            $scope.selected_training.isOneDay = 1;
        }
        else {
             $scope.selected_training.isOneDay = 0;
        }
    }

    $scope.getEducation = function()
    {
        if (angular.isUndefined($scope.educations))
        {
            $http.post('getEducation').success(function(data){
            $scope.educations = data;
            });
        }
        else {

        }
    }

    $scope.isExisting = function(ed_id) //Detect if the education type is already added
    {
        var d = false;

        if (!angular.isUndefined($scope.educations))
        {
            for (var i = 0; i < $scope.educations.length; i++)
            {
                if ($scope.educations[i].education_id == ed_id)
                {
                    d = true;
                    break;
                }
            }

            return d;
        }
    }

    $scope.getMyMessages = function()
    {
        $http.post('getMyMessages').success(function(data){
            $scope.messages = data;
        });
    }

    $scope.getQuestions = function($jobid)
    {
        $http.post('getQuestions/'+$jobid).success(function(data){
            $scope.pqList = data;
        });
        console.log($scope.pqList);
    }

}]);

