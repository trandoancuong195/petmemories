petMemories.controller('HomeCtrl', ['$scope', '$rootScope', 'commonService', '$location', '$timeout',
    function ($scope, $rootScope, commonService, $location, $timeout) {
        $scope.products=[];

        $scope.getProduct = function(){
            commonService.requestFunction('getproduct', '', function (res) {
                $scope.products = res
            });
        }
        $scope.initApp = function(){
            $scope.getProduct();
        }
        $scope.$on('$viewContentLoaded', function () {
            $scope.initApp();
        });
    }
]);