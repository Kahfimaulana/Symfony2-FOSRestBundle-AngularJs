/**
 * Created by PhpStorm.
 * User: Kahfi
 * Date: 7/19/15
 */

/* App Module */
(function (window, angular) {
    'use strict';

    angular.module('App', []);

    angular.module('App')
        .config(['$interpolateProvider', '$httpProvider',
        function ($interpolateProvider, $httpProvider) {

        $interpolateProvider.startSymbol('[[');
        $interpolateProvider.endSymbol(']]');
    }]);

})(window, angular);
