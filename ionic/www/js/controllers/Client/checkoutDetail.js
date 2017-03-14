angular.module('starter.controllers').
controller('ClientCheckoutDetailCtrl', ['$state', '$scope', '$cart', '$stateParams', function($state, $scope, $cart, $stateParams) {
    $scope.product = $cart.getItem($stateParams.index);

    $scope.updateQtd = function() {
        $cart.updateQtd($stateParams.index, $scope.product.qtd);
        $state.go('client.checkout');
    };
}]);