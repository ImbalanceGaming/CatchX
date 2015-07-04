function hostController($scope, $http) {
    $scope.gameName = "";
    $scope.password = "";
    $scope.errors = [];
    $scope.side = "evil";
    $scope.Host = function () {
        $http({
            method: 'POST',
            url: backendUrl + 'games/host',
            data: $.param({"gameName": $scope.gameName, "password": $scope.password}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (data) {
            if (data.errors.length > 0) {
                $scope.errors = data.errors;
            }
            else {
                $.cookie('name', $scope.gameName);
                $.cookie('password', $scope.password);
                $.cookie('id', data.id);
                $.cookie('side', $scope.side);
                window.location.href = baseUrl + "play";
            }
        })
    };
}

catchXApp.controller("hostController", hostController);





