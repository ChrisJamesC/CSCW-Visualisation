<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <title>The Gaze table</title>
    <script type="text/javascript" src="http://mbostock.github.com/d3/d3.v2.js"></script>
    <script type="text/javascript" src="http://underscorejs.org/underscore.js"></script>
</head>
<body>
<script>
//var source = "data/Week 2/Parrot/Parrot_EnergyTask_Part2.csv"
//var source = "data/Week 3/Parrot/Parrot_NeurologyTask_Part1.csv"
var title = '<?php $file = $_GET["file"]; echo addslashes($file); ?>';
var source = "data/"+title+".csv"
d3.csv(source, function(rows) {
    var count = {
        s0:{tool:0, wb:0, s0:0, s1:0, s2:0, s3:0},
        s1:{tool:0, wb:0, s0:0, s1:0, s2:0, s3:0},
        s2:{tool:0, wb:0, s0:0, s1:0, s2:0, s3:0},
        s3:{tool:0, wb:0, s0:0, s1:0, s2:0, s3:0}
    }
    rows.forEach(function(row){
        count[row.subject][row.target] = count[row.subject][row.target] + parseFloat(row.time)
    })

    var max=0;
    var stroke_width_coeff = 15;

    //Compute max
    _.each(count, function(subject){_.each(subject, function(target){if(target>max)max =target;})})

    var img_width = 800;
    var img_height = 600;

    var tool_w = 32;
    var tool_h = 50;
    var positions = {
        s0:{id:"s0", head:{x:0.78*img_width, y:0.455*img_height}, tool:{x:0.617*img_width, y:0.485*img_height}, color:"blue"},
        s1:{id:"s1", head:{x:0.74*img_width, y:0.155*img_height}, tool:{x:0.580*img_width, y:0.250*img_height}, color:"green"},
        s2:{id:"s2",head:{x:0.27*img_width, y:0.150*img_height}, tool:{x:0.368*img_width, y:0.248*img_height}, color:"red"},
        s3:{id:"s3", head:{x:0.20*img_width, y:0.450*img_height}, tool:{x:0.335*img_width, y:0.500*img_height}, color:"HotPink"}
    };

    var screen = {x: 0.12*img_width, y:0.88* img_height, width:img_width*3/4, height:30}

    var margin = {top: 20, right: 20, bottom: 30, left: 40},
        width = 960 - margin.left - margin.right,
        height = 700 - margin.top - margin.bottom;

    var x = d3.scale.linear()
        .range([0, width]);

    var y = d3.scale.linear()
        .range([height, 0]);

    var svg = d3.select("body").append("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom);

    /* Add image */
    var image = svg.append("image")
        .attr("xlink:href", "display-experimentCSCW-tableOnly.jpg")
        .attr("width", img_width)
        .attr("height", img_height);


    /* Define relations between users */
    var relations = [["s0","s1"], ["s0","s2"],["s0","s3"],["s1","s2"],["s1","s3"],["s2","s3"]];

    relations.forEach(function(rel){
        var from = rel[0];
        var to = rel[1];
        var coeff = count[from][to]/(count[from][to]+ count[to][from]);
        var fromPos = positions[from];
        var toPos = positions[to];
        var middlePosX = fromPos.head.x + (toPos.head.x - fromPos.head.x) * coeff;
        var middlePosY = fromPos.head.y + (toPos.head.y - fromPos.head.y) * coeff;
        var strokeW = (count[from][to] + count[to][from])/(2*max) *stroke_width_coeff

        svg.append("path")
                .attr("d", "M"+positions[from].head.x+","+ positions[from].head.y +" L" + middlePosX +","+ middlePosY)
                .attr("stroke-width", strokeW )
                .attr("stroke-opacity", "50%")
                .style("stroke", positions[from].color);
        svg.append("path")
                .attr("d", "M"+ middlePosX +","+ middlePosY+" L " + positions[to].head.x+","+ positions[to].head.y)
                .attr("stroke-width", strokeW )
                .attr("stroke-opacity", "50%")
                .style("stroke", positions[to].color);
    })

    /* Draw relations to iPads */
    _.each(positions,function(pos){
        svg.append("path")
                .attr("d", "M"+pos.head.x+","+ pos.head.y +" L" + (screen.x+screen.width/2) + "," + (screen.y+screen.height/2))
                .attr("stroke", pos.color)
                .attr("stroke-width", function(){return count[pos.id].tool /max * stroke_width_coeff})
                .attr("stroke-opacity", "50%")
    })

    /* Draw relations to Screen */
    _.each(positions,function(pos){
        svg.append("path")
            .attr("d", "M"+pos.head.x+","+ pos.head.y +" L" + (pos.tool.x+tool_w/2) + "," + (pos.tool.y+tool_h/2))
            .attr("stroke", pos.color)
            .attr("stroke-width", function(){return count[pos.id].wb /max * stroke_width_coeff})
            .attr("stroke-opacity", "50%")
    })

    /* Draw heads */
    _.each(positions, function(pos){
        svg.append("circle")
            .attr("class", "head")
            .attr("stroke",pos.color)
            .attr("stroke-width", "6px")
            .attr("fill", "#DADADA")
            .attr("r", "30px")
            .attr("cx", pos.head.x)
            .attr("cy", pos.head.y)
    });

    /* Draw tools */
    _.each(positions, function(pos){
        svg.append("rect")
            //.attr("class", "tool")
            .attr("stroke-width", "4px")
            .attr("stroke", pos.color)
            .attr("fill", "#DADADA")
            .attr("width", tool_w)
            .attr("height", tool_h)
            .attr("x", pos.tool.x)
            .attr("y", pos.tool.y)
    });

    /* Draw screen */
    svg.append("rect")
        .attr("stroke", "black")
        .attr("stroke-width", "4px")
        .attr("fill", "Silver")
        .attr("width",  screen.width)
        .attr("height", screen.height)
        .attr("borderStyle", "plain")
        .attr("x", screen.x)
        .attr("y", screen.y);
})

</script>
</body>
</html>
