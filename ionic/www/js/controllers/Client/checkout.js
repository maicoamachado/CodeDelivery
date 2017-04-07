angular.module('starter.controllers').
controller('ClientCheckoutCtrl', ['$state', '$scope', '$cart', 'ClientOrder', '$ionicLoading', '$ionicPopup', 'Cupom', '$cordovaBarcodeScanner', 'User',
    function($state, $scope, $cart, ClientOrder, $ionicLoading, $ionicPopup, Cupom, $cordovaBarcodeScanner, User) {

        var cart = $cart.get();
        $scope.items = cart.items;
        $scope.cupom = cart.cupom;
        $scope.total = $cart.getTotalFinal();

        $scope.removeItem = function(i) {
            $cart.removeItem(i);
            $scope.items.splice(i, 1);
            $scope.total = $cart.getTotalFinal();
        };

        $scope.openProductDetail = function(i) {
            $state.go('client.checkout_item_detail', { index: i });
        };

        $scope.openListProducts = function() {
            $state.go('client.view_products');
        };

        $scope.save = function() {
            if ($cart.get().cupom.value > $cart.getTotalFinal()) {
                this.removeCupom();
                $ionicPopup.alert({
                    title: 'Advertência',
                    template: 'Cupom removido. Por favor, adicione um ou mais itens no pedido para utilizar este cupom.'
                });
            } else {
                var obj = { items: angular.copy($scope.items) };
                angular.forEach(obj.items, function(item) {
                    item.product_id = item.id;
                });
                $ionicLoading.show({
                    template: 'Carregando...'
                });
                if ($scope.cupom.value) {
                    obj.cupom_code = $scope.cupom.code;
                }
                ClientOrder.save({ id: null }, obj, function(data) {
                    $state.go('client.checkout_successful');
                    $ionicLoading.hide();
                }, function(responseError) {
                    $ionicLoading.hide();
                    $ionicPopup.alert({
                        title: 'Advertência',
                        template: 'Pedido não realizado. Tente novamente.'
                    });
                });

            }
        };

        $scope.readBarCode = function() {
            $cordovaBarcodeScanner
                .scan()
                .then(function(barcodeData) {
                    // Success! Barcode data is here
                    getValueCupom(barcodeData.text);
                }, function(error) {
                    // An error occurred
                    $ionicPopup.alert({
                        title: 'Advertência',
                        template: 'Não foi possível ler o codigo de barras. Tente novamente.'
                    });
                });
        };

        $scope.removeCupom = function() {
            $cart.removeCupom();
            $scope.cupom = $cart.get().cupom;
            $scope.total = $cart.getTotalFinal();
        };

        function getValueCupom(code) {
            $ionicLoading.show({
                template: 'Carregando...'
            });
            Cupom.get({ code: code }, function(data) {
                if ($cart.getTotalFinal() > data.data.value) {
                    $cart.setCupom(data.data.code, data.data.value);
                    $scope.cupom = $cart.get().cupom;
                    $scope.total = $cart.getTotalFinal();
                } else {
                    $ionicPopup.alert({
                        title: 'Advertência',
                        template: 'Você precisa adicionar um ou mais itens no pedido para utilizar este cupom.'
                    });
                }
                $ionicLoading.hide();

            }, function(responseError) {
                $ionicLoading.hide();
                $ionicPopup.alert({
                    title: 'Advertência',
                    template: 'Cupom inválido.'
                });
            });
        };
    }
]);