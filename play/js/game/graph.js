Graph = function (graph) {
    this.nodes = [];
    this.edges = [];

    this.Initialize = function (graph) {
        for (var i = 0; i < graph.nodes.length; i++) {
            this.nodes[graph.nodes[i].dbId] = (
                new Node(
                    i,
                    graph.nodes[i].x,
                    graph.nodes[i].y,
                    graph.nodes[i].adjacent,
                    graph.nodes[i].colors,
                    graph.nodes[i].dbId
                )
            );
        }

        for (var j = 0; j < graph.edges.length; j++) {
            this.edges.push(new Edge(
                graph.edges[j].node1,
                graph.edges[j].node2,
                graph.edges[j].type,
                graph.edges[j].color,
                j,
                this.nodes));
        }
    };
    this.Initialize(graph);
};

Node = function (entry, x, y, adjacentNodes, colors, id) {
    this.x = x;
    this.y = y;
    this.adjacentNodes = adjacentNodes;
    this.colors = colors;
    this.htmlElement = {};
    this.id = id;

    this.Highlight = function () {
        this.htmlElement.addClass("moveNode");
    };

    this.RemoveHighlight = function () {
        this.htmlElement.removeClass("moveNode");
    };

    this.Click = function () {
        game.selection.SelectNode(this);
    };

    this.Initialize = function () {
        $("#map").append("<div id='node_" + this.id + "' class='node' style='left:" + (this.x - 25) + "px;top:" + (this.y - 25) + "px;' >" + entry + "</div>");
        this.htmlElement = $("#node_" + this.id);
        if (this.colors.indexOf("#325E32") !== -1)
            this.htmlElement.addClass("nodeWithGreenConnection");
        if (this.colors.indexOf("#C2B615") !== -1)
            this.htmlElement.addClass("nodeWithYellowConnection");
        if (this.colors.indexOf("#009C99") !== -1)
            this.htmlElement.addClass("nodeWithBlueConnection");

        this.htmlElement.click({node: this.id}, function (event) {
            game.graph.nodes[event.data.node].Click();
        });
        this.htmlElement.on("click touchstart", {node: this.id}, function (event) {
            game.graph.nodes[event.data.node].Click();
        });
    };
    this.Initialize();
};

Edge = function (node1, node2, type, color, id, nodes) {
    this.node1 = node1;
    this.node2 = node2;
    this.type = type;
    this.color = color;
    this.id = id;
    this.htmlElement = {};

    this.Initialize = function (nodes) {
        switch (this.type) {
            case "straight":
                this.htmlElement = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                this.htmlElement.setAttribute('x1', nodes[node1].x);
                this.htmlElement.setAttribute('y1', nodes[node1].y);
                this.htmlElement.setAttribute('x2', nodes[node2].x);
                this.htmlElement.setAttribute('y2', nodes[node2].y);
                this.htmlElement.setAttribute('stroke', this.color);
                this.lineSize = 1;

                switch (this.color) {
                    case "#000099":
                        this.lineSize = 4;
                        break;
                    case "#325E32":
                        this.lineSize = 16;
                        break;
                    case "#009C99":
                        this.lineSize = 8;
                        break;
                    case "#C2B615":
                        this.lineSize = 10;
                        break;
                }

                this.htmlElement.setAttribute('stroke-width', this.lineSize);
                $("svg").append(this.htmlElement);
                break;
        }
    };
    this.Initialize(nodes);
};
