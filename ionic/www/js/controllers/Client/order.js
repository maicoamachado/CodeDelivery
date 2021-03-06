angular.module('starter.controllers').
controller('ClientOrderCtrl', ['$state', '$scope', 'ClientOrder', '$ionicLoading', '$ionicActionSheet', '$timeout',
    function($state, $scope, ClientOrder, $ionicLoading, $ionicActionSheet, $timeout) {
        var page = 1;
        $scope.orders = [];
        $scope.canMoreItems = true;
        /*$ionicLoading.show({
            template: 'Carregando...'
        });*/

        $scope.doRefresh = function() {
            page = 1;
            $scope.orders = [];
            $scope.canMoreItems = true;
            $scope.loadMore();
            $timeout(function() {
                $scope.$broadcast('scroll.refreshComplete');
            }, 200);
            /*
            getOrders().then(function(data) {
                    $scope.orders = data.data;
                    $scope.$broadcast('scroll.refreshComplete');
                },
                function(dataError) {
                    $scope.$broadcast('scroll.refreshComplete');
                });
            */
        };

        $scope.showActionSheet = function(order) {
            $ionicActionSheet.show({
                buttons: [
                    { text: 'Ver Detalhes' },
                    { text: 'Ver Entrega' }
                ],
                titleText: 'O que fazer?',
                cancelText: 'Cancelar',
                cancel: function() {
                    //fazer alguma coisa para o cancelamento
                },
                buttonClicked: function(index) {
                    switch (index) {
                        case 0:
                            $state.go('client.view_order', { id: order.id });
                            break;
                        case 1:
                            $state.go('client.view_delivery', { id: order.id });
                            break;
                    }
                }
            });
        };

        $scope.openOrderDatail = function(order) {
            $state.go('client.view_order', { id: order.id });
        };

        function getOrders() {
            return ClientOrder.query({
                id: null,
                page: page,
                orderBy: 'created_at',
                sortedBy: 'desc'
            }).$promise;
        };

        $scope.loadMore = function() {
            getOrders().then(function(data) {
                $scope.orders = $scope.orders.concat(data.data);
                if ($scope.orders.length == data.meta.pagination.total) {
                    $scope.canMoreItems = false;
                }
                page += 1;
                $scope.$broadcast('scroll.infiniteScrollComplete');
            });
        };

        /*
        getOrders().then(function(data) {
                $scope.orders = data.data;
                $ionicLoading.hide();
            },
            function(dataError) {
                $ionicLoading.hide();
            });
        */
    }
]);