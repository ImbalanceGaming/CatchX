

function gamesController($scope, $http) {
	
	$scope.currentPage = 0;
    $scope.pageSize = 10;
	$scope.games = [];
	
	$scope.UpdateGames = function() { $http.post(backendUrl + 'games/GameList',{}).success(function(data) 
	{
		$scope.games = data;
		
	})};
	
	$scope.UpdateGames();
	
	$scope.numberOfPages=function(){
        return Math.ceil($scope.games.length/$scope.pageSize);                
    }
}

catchXApp.controller("gamesController",gamesController);
