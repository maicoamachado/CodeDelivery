angular.module('starter.controllers').
controller('ClientOrderCtrl', ['$state', '$scope', 'Order', '$ionicLoading',
    function($state, $scope, Order, $ionicLoading) {
        $scope.orders = [];
        $ionicLoading.show({
            template: 'Carregando...'
        });

        Order.query({}, function(data) {
            $scope.orders = data.data;
            $ionicLoading.hide();
        }, function(dataError) {
            $ionicLoading.hide();
        });

        $scope.openListProducts = function() {
            $state.go('client.view_products');
        }
    }
]);