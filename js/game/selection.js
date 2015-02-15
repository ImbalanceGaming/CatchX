Selection = function ()
{
    this.selectedPlayer = null;
    this.nodesAdjacentToSelectedPlayer = [];
    
    this.SelectPlayer = function(player)
    {
        if (this.selectedPlayer != null)
            this.selectedPlayer.RemoveHighlight();
        
        this.selectedPlayer = player;
        player.Highlight();
        
        this.nodesAdjacentToSelectedPlayer.forEach(function(nodeId){
            game.graph.nodes[nodeId].RemoveHighlight();
	});
        
        this.nodesAdjacentToSelectedPlayer = game.graph.nodes[player.position].adjacentNodes;
        
        this.nodesAdjacentToSelectedPlayer.forEach(function(nodeId){
            game.graph.nodes[nodeId].Highlight();
	});
    }
    
    this.SelectNode = function(node)
    {
        if(this.selectedPlayer == null || !this.selectedPlayer.turn)
            return;
        
        if ((this.nodesAdjacentToSelectedPlayer.indexOf(node.id)) != -1)
        {
            this.nodesAdjacentToSelectedPlayer.forEach(function(nodeId){
                game.graph.nodes[nodeId].RemoveHighlight();
            });
            
            this.nodesAdjacentToSelectedPlayer = [];
            wait = true;
            
            
            DoMove(this.selectedPlayer.id, this.selectedPlayer.position, node.id, false, false);
            this.selectedPlayer.PlayMoveSound();
        }
    }
    
    this.DeselectAll = function()
    {
        if (this.selectedPlayer != null)
            this.selectedPlayer.RemoveHighlight();
        this.selectPlayer = null;
        
        this.nodesAdjacentToSelectedPlayer.forEach(function(node){
            node.ClearHighlight();
	});
        
        this.nodesAdjacentToSelectedPlayer = [];
    }
}




