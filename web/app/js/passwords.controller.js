/**
 * Created by PhpStorm.
 * User: Kahfi
 * Date: 7/19/15
 */

(function (window, angular) {
    'use strict';

    angular.module('App').controller('PasswordController', [
        '$scope', '$passwords',
        function ($scope, $passwords)
        {
            $scope.passwordsLoaded = false;
            $scope.passwords = null;
            $scope.passwordsError = null;

            /**
             * Find all existing passwords
             */
            $scope.loadAll = function()
            {
                $scope.passwordsLoaded = false;
                $scope.passwords = [];

                $passwords.findAll().then(findAllPasswordsSuccess, findAllPasswordsFailure);

                function findAllPasswordsSuccess(passwords)
                {
                    $scope.passwords = passwords;
                    $scope.passwordsLoaded = true;
                }

                function findAllPasswordsFailure(reason)
                {
                    $scope.passwordsError = reason;
                    $scope.passwordsLoaded = true;
                }
            };

            $scope.create = function () {
                alert($scope.password);
                $passwords.create($scope.password, function () {
                        $scope.loadAll();
                        $('#savePasswordModal').modal('hide');
                        $scope.clear();
                    });
            };

            $scope.update = function(password){
                $scope.password = angular.copy(password);
                $('#savePasswordModal').modal('show');
            };

            $scope.deletePassword = function (password) {
                    $scope.password = angular.copy(password);
                    $('#deletePasswordConfirmation').modal('show');
            };

            $scope.confirmDelete = function(key){
                $passwords.removePassword(key).then(deleteSuccess(), deleteError);

                function deleteSuccess(passwords)
                {
                    $scope.password = passwords;
                    $('#deletePasswordConfirmation').modal('hide');
                }

                function deleteError(reason){
                    $scope.passwordsError = reason;
                }
            };

            $scope.clear = function(){
                $scope.password = {key: null, username:null, password:null};
            };

            $scope.loadAll();
        }
    ]);

})(window, angular);