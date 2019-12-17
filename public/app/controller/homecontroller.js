petMemories.controller('HomeCtrl', ['$scope', '$rootScope', 'commonService', '$location', '$timeout',
    function ($scope, $rootScope, commonService, $location, $timeout) {
        $scope.products=[];

        $scope.getProduct = function(){
            commonService.requestFunction('getproduct', '', function (res) {
                $scope.products = res
            });
        }
        $scope.addLike = function(id){
            console.log(id);
            commonService.requestFunction('productlike', id , function (res) {
                $scope.getProduct();
            });
        }
        $scope.initApp = function(){
            $scope.getProduct();
            var modal = document.getElementById('login');
            window.onclick = function(event) {
            if (event.target == modal) {
            modal.style.display = "none";
            }
            }
        }
        $scope.$on('$viewContentLoaded', function () {
            $scope.initApp();
            
        });
    }
]);