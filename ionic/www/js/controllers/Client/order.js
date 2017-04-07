angular.module('starter.controllers').
controller('ClientOrderCtrl', ['$state', '$scope', 'ClientOrder', '$ionicLoading',
    function($state, $scope, ClientOrder, $ionicLoading) {
        $scope.orders = [];
        $ionicLoading.show({
            template: 'Carregando...'
        });

        $scope.doRefresh = function() {
            getOrders().then(function(data) {
                    $scope.orders = data.data;
                    $scope.$broadcast('scroll.refreshComplete');
                },
                function(dataError) {
                    $scope.$broadcast('scroll.refreshComplete');
                });
        };

        $scope.openOrderDatail = function(order) {
            $state.go('client.view_order', { id: order.id });
        }

        function getOrders() {
            return ClientOrder.query({
                id: null,
                orderBy: 'created_at',
                sortedBy: 'desc'
            }).$promise;
        };

        getOrders().then(function(data) {
                $scope.orders = data.data;
                $ionicLoading.hide();
            },
            function(dataError) {
                $ionicLoading.hide();
            });

    }
]);