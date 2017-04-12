angular.module('starter.controllers').
controller('ClientViewDeliveryCtrl', ['$scope', '$stateParams', 'ClientOrder', '$ionicLoading', 'UserData', '$ionicPopup', '$pusher', '$window', '$map', 'uiGmapGoogleMapApi',
        function($scope, $stateParams, ClientOrder, $ionicLoading, UserData, $ionicPopup, $pusher, $window, $map, uiGmapGoogleMapApi) {
            var iconUrl = 'http://maps.google.com/mapfiles/kml/pal2';
            $scope.order = [];
            $scope.map = $map;
            $scope.markers = [];

            $ionicLoading.show({
                template: 'Carregando...'
            });

            uiGmapGoogleMapApi.then(function(maps) {
                $ionicLoading.hide();
            }, function(responseError) {
                $ionicLoading.hide();
            });

            ClientOrder.get({ id: $stateParams.id, include: 'items,cupom' }, function(data) {
                $scope.order = data.data;
                if ($scope.order.status_id == 3) {
                    initMarkers($scope.order);
                } else {
                    $ionicPopup.alert({
                        title: 'Advertência',
                        template: 'O pedido não está em status de entrega.'
                    });
                }
            });

            $scope.$watch('markers.length', function(value) {
                if (value == 2) {
                    createBounds();
                }
            });

            function initMarkers(order) {
                var client = UserData.get().client,
                    address = client.data.zipcode + ',' + client.data.address + ',' + client.data.city + '-' + client.data.state;
                createMarkerClient(address);
                watchPositionDeliveryman(order.hash);
            };

            function createMarkerClient(address) {
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({
                    address: address
                }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        var lat = results[0].geometry.location.lat(),
                            long = results[0].geometry.location.lng();
                        $scope.markers.push({
                            id: 'client',
                            coords: {
                                latitude: lat,
                                longitude: long
                            },
                            options: {
                                title: 'Local de entrega',
                                icon: iconUrl + '/icon2.png'
                            }
                        });
                    } else {
                        $ionicPopup.alert({
                            title: 'Advertência',
                            template: 'Não foi possível encontrar seu endereço.'
                        });
                    }
                });
            }

            function watchPositionDeliveryman(channel) {

                var pusher = $pusher($window.client),
                    my_channel = pusher.subscribe(channel);

                my_channel.bind('CodeDelivery\\Events\\GetLocationDeliveryman', function(data) {

                    var lat = data.geo.lat,
                        long = data.geo.long;
                    if ($scope.markers.length == 1 || $scope.markers.length == 0) {
                        $scope.markers.push({
                            id: 'entregador',
                            coords: {
                                latitude: lat,
                                longitude: long
                            },
                            options: {
                                title: 'Entregador',
                                icon: iconUrl + '/icon47.png'
                            }
                        });
                        return;
                    }
                    for (var key in $scope.markers) {
                        if ($scope.markers[key].id == 'entregador') {
                            $scope.markers[key].coords = {
                                latitude: lat,
                                longitude: long
                            }
                        }
                    }
                });
            };

            function createBounds() {
                var bounds = new google.maps.LatLngBounds(),
                    latlng;
                angular.forEach($scope.markers, function(value) {
                    latlng = new google.maps.LatLng(Number(value.coords.latitude), Number(value.coords.longitude));
                    bounds.extend(latlng);
                });

                $scope.map.bounds = {
                    northeast: {
                        latitude: bounds.getNorthEast().lat(),
                        longitude: bounds.getNorthEast().lng()
                    },
                    southwest: {
                        latitude: bounds.getSouthWest().lat(),
                        longitude: bounds.getSouthWest().lng()
                    }
                }
            }
        }
    ])
    .controller('CvdControlDescentralize', ['$scope', '$map', function($scope, $map) {
        $scope.map = $map;
        $scope.fit = function() {
            $scope.map.fit = !$scope.map.fit;
        }
    }])
    .controller('CvdControlReload', ['$scope', '$window', '$timeout', function($scope, $window, $timeout) {
        $scope.reload = function() {
            $timeout(function() {
                $window.location.reload(true);
            }, 100);
        }
    }]);