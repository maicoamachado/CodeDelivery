angular.module('starter.controllers').
controller('ClientCheckoutSuccessfulCtrl', ['$state', '$scope', '$cart',
    function($state, $scope, $cart) {
        var cart = $cart.get();
        $scope.items = cart.items;
        $scope.total = $cart.getTotalFinal();
        $scope.cupom = cart.cupom;
        $cart.clear();

        $scope.openListOrder = function() {
            $state.go('client.order');
        }
    }
]);