angular.module('starter.controllers').
controller('DeliverymanMenuCtrl', ['$scope', '$state', 'UserData', '$ionicLoading',
    function($scope, $state, UserData, $ionicLoading) {
        $scope.user = UserData.get();

        $scope.logout = function() {
            $state.go('logout');
        }
    }
]);