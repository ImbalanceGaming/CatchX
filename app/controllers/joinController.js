function joinController ($scope, $http, $routeParams)
{
	$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
	$scope.password = "";
	$scope.errors = [];
	$scope.gameName = $routeParams.gameName;
	$scope.Join = function(side) 
	{ 
		$http({
		method: 'POST',
		url: backendUrl + 'games/Join',
		data: $.param({"gameName":$scope.gameName,"password":$scope.password}),
		headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		}).success(function(data) 
		{
			if (data.errors.length > 0)
			{
				$scope.errors = data.errors;
			}
			else
			{
				$.cookie('name', $scope.gameName);
				$.cookie('password', $scope.password);
				$.cookie('id', data.id);
				$.cookie('side', side);
				window.location.href = baseUrl + "play";
			}
		})
	};	
}

catchXApp.controller("joinController",joinController);




