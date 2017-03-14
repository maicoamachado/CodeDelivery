angular.module('starter.services')
    .factory('Order', ['$resource', 'appConfig', function($resource, appConfig) {
        return $resource(appConfig.baseUrl + '/api/client/order/:id?include=items', { id: '@id' }, {
            query: {
                isArray: false,
            }
        });
    }]);