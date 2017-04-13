angular.module('starter.controllers').
controller('DeliverymanViewOrderCtrl', ['$scope', '$stateParams', 'DeliverymanOrder', '$ionicLoading', '$cordovaGeolocation', '$ionicPopup',
    function($scope, $stateParams, DeliverymanOrder, $ionicLoading, $cordovaGeolocation, $ionicPopup) {
        var watch, lat = null,
            long;
        $scope.order = [];
        $ionicLoading.show({
            template: 'Carregando...'
        });

        DeliverymanOrder.get({ id: $stateParams.id, include: 'items,cupom' }, function(data) {
            $scope.order = data.data;
            $ionicLoading.hide();
        }, function(dataError) {
            $ionicLoading.hide();
        });

        $scope.confirmDelivery = function() {
            $ionicLoading.show({
                template: 'Enviando...'
            });

            DeliverymanOrder.updateStatus({ id: $stateParams.id }, { status: 4 }, function(data) {
                $ionicLoading.hide();
                $ionicPopup.alert({
                    title: 'Advertência',
                    template: 'Entrega confirmada!'
                });
            }, function(dataError) {
                $ionicLoading.hide();
            });

        }

        $scope.goToDelivery = function() {
            $ionicPopup.alert({
                title: 'Advertência',
                template: 'Para parar a localização dê ok.'
            }).then(function() {
                stopWatchPosition();
            });
            DeliverymanOrder.updateStatus({ id: $stateParams.id }, { status: 3 }, function() {
                //geo localização
                var watchOptions = {
                    timeout: 3000,
                    enableHighAccuracy: false
                };
                watch = $cordovaGeolocation.watchPosition(watchOptions);
                watch.then(null, function(responseError) {
                        //error
                        console.log('watchPosition: ' + responseError);
                    },
                    function(position) {
                        if (!lat) {
                            lat = position.coords.latitude;
                            long = position.coords.longitude;
                        } else {
                            long -= 0.004;
                        }
                        DeliverymanOrder.geo({ id: $stateParams.id }, {
                            lat: lat,
                            long: long,
                        });
                    }
                );
            });
        };

        function stopWatchPosition() {
            if (watch && typeof watch == 'object' && watch.hasOwnProperty('watchID')) {
                $cordovaGeolocation.clearWatch(watch.watchID);

            }
        };


    }
]);