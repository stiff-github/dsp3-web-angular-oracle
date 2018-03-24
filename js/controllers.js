'use strict';

/* Controllers */
var appEAF3 = angular.module('appEAF3', ['ngRoute', 'ngResource', 'angular-loading-bar', 'ngAnimate', 'ngCookies']); //

/* Config */
appEAF3.config([
    '$routeProvider', '$locationProvider',
    function($routeProvide, $locationProvider){
        $locationProvider.hashPrefix('');
        $routeProvide
            .when('/',{
                templateUrl:'template/home.html',
                controller:'homeCtrl'
            })
            .when('/report',{
                templateUrl:'template/reportall.html',
                controller:'ReportAllCtrl'
            })
            .when('/reportburner',{
                templateUrl:'template/report.html',
                controller:'ReportCtrl'
            })
            .when('/reportheat',{
                templateUrl:'template/reportheat.html',
                controller:'ReportHeatCtrl'
            })
            .when('/heatprocess',{
                templateUrl:'template/heatprocess.html',
                controller:'HeatprocessCtrl'
            })
            .when('/contact',{
                templateUrl:'template/contact.html',
                controller:'ContactCtrl'
            })
            .when('/login',{
                templateUrl:'login/login.html',
                controller:'LoginCtrl'
            })
            .otherwise({
                redirectTo: '/'
            });
    }
]);

/* Factory */

/* Filter */
appEAF3.filter('checkmark', function() {
    return function(input) {
        return input ? '\u2713' : '\u2718';
    }
});

appEAF3.controller('homeCtrl',[
    '$scope','$http', '$location',
    function($scope, $http, $location) {
    }
]);

appEAF3.controller('ReportAllCtrl',[
    '$scope','$http', '$location',
    function($scope, $http, $location) {
    }
]);

appEAF3.controller('ReportHeatCtrl',[
    '$scope','$http', '$location', function($scope, $http) {
        var heatList = function () {
            $http.get('php/heats.php')
                .then(function onSuccess(response) {
                    $scope.lstHeats = response.data;
                });
        };
        heatList();
        $scope.openReportHeat = function (numHeat) {
            if (numHeat.length > 0) {
                var rptHeat = function () {
                    window.open('report/heat_report1.php?heat=' + numHeat,'_blank');
                };
                rptHeat();
            }
        };
    }
]);

/* HeatprocessCtrl Controller */
appEAF3.controller('HeatprocessCtrl',[
    '$scope','$http','$timeout', function($scope, $http, $timeout) {
        //$scope.vsblPanelIn = "";
        //$scope.vsblPanelUg = "";
        var HeatDataRefresh = function () {
            $http.get('php/heatdata.php',{ignoreLoadingBar: true})
                .then(function onSuccess(response) {
                    $scope.dataHeat = response.data;
                });
            $timeout(HeatDataRefresh, 3000);
        };
        HeatDataRefresh();
        var burnRefresh = function () {
            $http.get('php/burner.php',{ignoreLoadingBar: true})
                .then(function onSuccess(response) {
                    $scope.dataBurner = response.data;
                });
            $timeout(burnRefresh, 3000);
        };
        burnRefresh();
        var celoxRefresh = function () {
            $http.get('php/celox_current.php',{ignoreLoadingBar: true})
                .then(function onSuccess(response) {
                    $scope.dataCelox = response.data;
                });
            $timeout(celoxRefresh, 3000);
        };
        celoxRefresh();
        var sampleRefresh = function () {
            $http.get('php/sample_current.php',{ignoreLoadingBar: true})
                .then(function onSuccess(response) {
                    $scope.dataSample = response.data;
                });
            $timeout(sampleRefresh, 3000);
        };
        sampleRefresh();
    }
]);

appEAF3.controller('ReportCtrl',[
    '$scope','$http', '$window', function($scope, $http, $window) {
        $scope.vsblReport="none";
        $scope.vsblPrintReport = "none";
        var heatList = function () {
            $http.get('php/heats.php')
                .then(function onSuccess(response) {
                    $scope.lstHeats = response.data;
                });
        };
        heatList();
        $scope.addHeatF = function (numHeat) {
            if(numHeat != "")
            {
                $scope.fistHeat=numHeat;
            }
        };
        $scope.addHeatL = function (numHeat) {
            if(numHeat != "")
            {
                $scope.lastHeat=numHeat;
            }
        };
        $scope.openReport = function () {
            if (($scope.fistHeat)||($scope.lastHeat)) {
                if (($scope.fistHeat)&&(!$scope.lastHeat)) {
                    $scope.lastHeat=$scope.fistHeat;
                }
                if ((!$scope.fistHeat)&&($scope.lastHeat)) {
                    $scope.fistHeat=$scope.lastHeat;
                }
                $scope.vsblReport = "";
                $scope.rptDate = new Date();
                if ($scope.fistHeat > $scope.lastHeat) {
                    var varNumHeat = $scope.fistHeat;
                    $scope.fistHeat = $scope.lastHeat;
                    $scope.lastHeat = varNumHeat;
                }
                var rptBurner = function () {
                    $http.post('php/rptburner.php?heatstart=' + $scope.fistHeat + '&heatend=' + $scope.lastHeat)
                        .then(function onSuccess(response2) {
                            $scope.dataBurners = response2.data;
                        });
                };
                rptBurner();
                $scope.vsblPrintReport = "";
            }
        };
        $scope.printReport = function(){
            $window.print();
        };
    }
]);

/* Contact Controller */
appEAF3.controller('ContactCtrl',[
    '$scope',function($scope) {}
]);

/* Login Controller */
appEAF3.controller('LoginCtrl',[
    '$rootScope', '$location', '$cookies', '$http', '$window',function($rootScope, $location, $cookies, $http, $window) {
        $rootScope.globals = $cookies.getObject('globals') || {};
        if ($rootScope.globals.currentUser) {
            $http.defaults.headers.common['Authorization'] = 'Basic ' + $rootScope.globals.currentUser.authdata;
        }
        $rootScope.$on('$locationChangeStart', function (event, next, current) {
            // redirect to login page if not logged in and trying to access a restricted page
            var restrictedPage = $.inArray($location.path(), ['/login']) === -1;
            var loggedIn = $rootScope.globals.currentUser;
            if (restrictedPage && !loggedIn) {
                $location.path('/login');
            }
        });
    }
]);