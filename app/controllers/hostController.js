function hostController ($scope, $http)
{
	$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
	$scope.gameName = "";
	$scope.password = "";
	$scope.errors = [];
	$scope.Host = function() 
	{ 
		$http({
		method: 'POST',
		url: backendUrl + 'games/Host',
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
				window.location.href = baseUrl + "#/join/" + $scope.gameName;
			}
		})
	};
}

catchXApp.controller("hostController",hostController);





