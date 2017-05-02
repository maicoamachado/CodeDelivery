angular.module('starter.controllers').
controller('LogoutCtrl', ['$scope', '$state', '$auth',
    function($scope, $state, $auth) {
        $auth.logout();
        $state.go('login');
    }
]);