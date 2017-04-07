angular.module('starter.controllers').
controller('ClientMenuCtrl', ['$scope', '$state', 'UserData', '$ionicLoading',
    function($scope, $state, UserData, $ionicLoading) {
        $scope.user = UserData.get();
    }
]);