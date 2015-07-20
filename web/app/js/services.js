/**
 * Created by PhpStorm.
 * User: Kahfi
 * Date: 7/19/15
 */

(function (window, angular) {
    'use strict';

    angular.module('App').service('$passwords', [
        '$http', '$q',
        function ($http, $q)
        {
            var passwordsDefer;

            /**
             * Fetch passwords on server or from promise
             * @returns {promise}
             */
            function fetch ()
            {
                if (!passwordsDefer) {
                    passwordsDefer = $q.defer();
                    $http.get('/api/v1/passwords') // hardcoded url
                        .success(passwordsLoadSuccess)
                        .error(passwordsLoadError);
                }

                /**
                 * Callback called when http request was successful
                 * @param response
                 */
                function passwordsLoadSuccess(response)
                {
                    var passwords = [];

                    angular.forEach(response, function (value, key) {
                        passwords.push(new Password(value));
                    });

                    passwordsDefer.resolve(passwords);
                }

                /**
                 * Callback to be called when the http request failed
                 */
                function passwordsLoadError()
                {
                    passwordsDefer.reject('Could not load the passwords from the server');
                }

                return passwordsDefer.promise;
            }

            /**
             * Find all passwords
             * @return {promise}
             */
            function findAll()
            {
                var findAllDefer = $q.defer();

                fetch().then(fetchSuccess, fetchFailure);

                /**
                 * Callback called when fetching passwords was successful
                 * @param passwords
                 */
                function fetchSuccess(passwords)
                {
                    findAllDefer.resolve(passwords);
                }

                /**
                 * Callback called when fetching the passwords failed
                 * @param reason
                 */
                function fetchFailure(reason)
                {
                    findAllDefer.reject('Could not find all passwords: ' + reason);
                }

                return findAllDefer.promise;
            }

            /**
             * Create new password
             * @return {promise}
             */
            function create(password)
            {
                var createDefer = $q.defer();

                if (!password instanceof Password) {
                    createDefer.reject('Not a valid password');
                } else {

                    $http({
                        method: 'POST',
                        url: '/api/v1/passwords',
                        data: password,
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    })
                        .success(passwordCreateSuccess)
                        .error(passwordCreateError);
                }


                function passwordCreateSuccess()
                {
                    passwordsDefer = null; // clear passwords
                    createDefer.resolve();
                }

                function passwordCreateError(errors)
                {
                    createDefer.reject(errors);
                }

                return createDefer.promise;
            }

            function getPassword(key){
                var getDefer = $q.defer();

                $http({
                    method: 'GET',
                    url: '/api/v1/passwords/' + key,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                })
                    .success(passwordGetSuccess)
                    .error(passwordGetError);

                function passwordGetSuccess()
                {
                    getDefer.resolve();
                }

                function passwordGetError(errors)
                {
                    getDefer.reject(errors);
                }

                return getDefer.promise;
            }

            function removePassword(key){
                var deleteDefer = $q.defer();

                $http({
                    method: 'DELETE',
                    url: '/api/v1/passwords/' + key,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                })
                    .success(passwordDeleteSuccess)
                    .error(passwordDeletetError);

                function passwordDeleteSuccess()
                {
                    deleteDefer.resolve();
                }

                function passwordDeletetError(errors)
                {
                    deleteDefer.reject(errors);
                }

                return deleteDefer.promise;
            }

            return {
                findAll: findAll,
                create: create,
                getPassword: getPassword,
                removePassword: removePassword
            }
        }
    ]);

})(window, angular);