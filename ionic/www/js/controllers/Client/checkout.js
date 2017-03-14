angular.module('starter.controllers').
controller('ClientCheckoutCtrl', ['$state', '$scope', '$cart', 'Order', '$ionicLoading', '$ionicPopup',
    function($state, $scope, $cart, Order, $ionicLoading, $ionicPopup) {
        var cart = $cart.get();
        $scope.items = cart.items;
        $scope.total = cart.total;

        $scope.removeItem = function(i) {
            $cart.removeItem(i);
            $scope.items.splice(i, 1);
            $scope.total = $cart.get().total;
        };

        $scope.openProductDetail = function(i) {
            $state.go('client.checkout_item_detail', { index: i });
        };

        $scope.openListProducts = function() {
            $state.go('client.view_products');
        };

        $scope.save = function() {

            var items = angular.copy($scope.items);
            angular.forEach(items, function(item) {
                item.product_id = item.id;
            });
            $ionicLoading.show({
                template: 'Carregando...'
            });
            Order.save({ id: null }, { items: items }, function(data) {
                $state.go('client.checkout_successful');
                $ionicLoading.hide();
            }, function(responseError) {
                $ionicLoading.hide();
                $ionicPopup.alert({
                    title: 'Advertência',
                    template: 'Pedido não realizado. Tente novamente.'
                });
            });
        };
    }
]);