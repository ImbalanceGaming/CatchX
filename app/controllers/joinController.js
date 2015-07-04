function joinController($scope, $http, $routeParams) {
    $scope.password = "";
    $scope.errors = [];
    $scope.gameId = $routeParams.gameId;
    $scope.Join = function (side) {
        $http({
            method: 'POST',
            url: backendUrl + 'games/checkLogin',
            data: $.param({"gameId": $scope.gameId, "password": $scope.password}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (data) {
            if (data.errors.length > 0) {
                $scope.errors = data.errors;
                console.log('no');
            }
            else {
                $.cookie('name', $scope.gameName);
                $.cookie('password', $scope.password);
                $.cookie('id', $scope.gameId);
                $.cookie('side', side);
                window.location.href = baseUrl + "play";
            }
        })
    };
}

catchXApp.controller("joinController", joinController);




