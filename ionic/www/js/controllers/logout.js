angular.module('starter.controllers').
controller('LogoutCtrl', ['$scope', '$state', 'OAuthToken', 'UserData', '$ionicHistory',
    function($scope, $state, OAuthToken, UserData, $ionicHistory) {
        OAuthToken.removeToken();
        UserData.set(null);
        $ionicHistory.clearCache();
        $ionicHistory.clearHistory();
        $ionicHistory.nextViewOptions({
            disableBack: true,
            historyRoot: true
        });

        $state.go('login');
    }
]);