angular.module('starter.services')
    .service('$auth', ['OAuth', 'OAuthToken', 'User', 'UserData', '$ionicHistory', '$ionicPopup', '$localStorage', '$redirect',
        function(OAuth, OAuthToken, User, UserData, $ionicHistory, $ionicPopup, $localStorage, $redirect) {
            this.login = function(username, password) {
                var promise = OAuth.getAccessToken({ username: username, password: password });
                promise
                    .then(function(data) {
                        var token = $localStorage.get('device_token');
                        return User.updateDeviceToken({}, { device_token: token }).$promise;
                    })
                    .then(function(data) {
                        return User.authenticated({ include: 'client' }).$promise;
                    })
                    .then(function(data) {
                        UserData.set(data.data);
                        $redirect.redirectAfterLogin();
                    }, function(responseError) {
                        UserData.set(null);
                        OAuthToken.removeToken();
                        $ionicPopup.alert({
                            title: 'Advertência',
                            template: 'Login e/ou senha inválidos.'
                        });
                        console.log(responseError);
                    });
            };
            this.logout = function() {
                OAuthToken.removeToken();
                UserData.set(null);
                $ionicHistory.clearCache();
                $ionicHistory.clearHistory();
                $ionicHistory.nextViewOptions({
                    disableBack: true,
                    historyRoot: true
                });

            }
        }
    ]);