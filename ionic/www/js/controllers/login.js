angular.module('starter.controllers').
controller('LoginCtrl', ['$scope', '$auth', '$cordovaTouchID', '$cordovaKeychain',
    function($scope, $auth, $cordovaTouchID, $cordovaKeychain) {
        $scope.user = {
            username: '',
            password: ''
        };

        $scope.isSupportTouchID = false;

        $scope.login = function() {
            $auth.login($scope.user.username, $scope.user.password);
        }

        $scope.loginWithTouchID = function() {
            if ($scope.isSupportTouchID) {
                $cordovaTouchID.authenticate("Passe o dedo para autenticar").then(function() {
                    // success
                    var promise = $cordovaKeychain.getForKey('username', 'codedelivery'),
                        username = null,
                        password = null;
                    promise
                        .then(function(value) {
                            username = value;
                            return $cordovaKeychain.getForKey('password', 'codedelivery');
                        }).then(function(value) {
                            password = value;
                        });

                    if (username != null && password != null) {
                        $auth.login(username, password);
                    }

                }, function() {
                    // error
                });

            }
        };

        if (ionic.Platform.isWebView() && ionic.Platform.isIOS() && ionic.Platform.isIPad()) {
            $cordovaTouchID.checkSupport().then(function() {
                // success, TouchID supported
                $scope.isSupportTouchID = true;
            });
        }
    }
]);