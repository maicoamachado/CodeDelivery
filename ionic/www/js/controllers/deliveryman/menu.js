angular.module('starter.controllers').
controller('DeliverymanMenuCtrl', ['$scope', '$state', 'UserData', '$ionicLoading',
    function($scope, $state, UserData, $ionicLoading) {
        $scope.user = UserData.get();
        $scope.isSupportTouchID = false;
        $scope.logout = function() {
            $state.go('logout');
        }

        if (ionic.Platform.isWebView() && ionic.Platform.isIOS() && ionic.Platform.isIPad()) {
            $cordovaTouchID.checkSupport().then(function() {
                // success, TouchID supported
                $scope.isSupportTouchID = true;
            });
        }
    }
]);