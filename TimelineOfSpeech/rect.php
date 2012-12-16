<!DOCTYPE html>
<html>
  <head>
    <title>Time line of speech : Rectangle</title>
	<style type="text/css">
	
	.axis path,
	.axis line {
    fill: none;
    stroke: black;
    shape-rendering: crispEdges;
	}

	.axis text {
    font-family: sans-serif;
    font-size: 11px;
	}
	</style>
  </head>
 <body>
  </body>
 <script src="http://d3js.org/d3.v2.js"></script>
 <script src="getMaxValTime.js"></script>
<script type="text/javascript">

var title = '<?php $file = $_GET["file"]; echo addslashes($file); ?>';
var dataFile = "dataFiles/"+title+".csv";
console.log(dataFile);
var leftMargin = 10
var graphScale = 2;
var w =8000,
    h = 600;
	maxValTime = getMaxValTime();
	
	var xScale = d3.scale.linear()
                    .domain([0, maxValTime/60])
					.range([leftMargin,graphScale*maxValTime]);
					
	var xAxis = d3.svg.axis()
				.scale(xScale)
				.ticks(maxValTime/60);
	
var svg = d3.select("body").append("svg:svg")
    .attr("width", w)
    .attr("height", h);
	
	function time(d){ return graphScale*d.time;}
	function tStart(d){ return leftMargin + graphScale*d.tStart;}
	
	function subject(d){ return d.subject;}
	function red(){svg.style("fill", "red");}
	function blue(){svg.style("fill", "blue");}
	function pink(){svg.style("fill", "pink");}
	function yellow(){svg.style("fill", "yellow");}
	var yS0 = 60;
	var yS1 = 90;
	var yS2 = 120;
	var yS3 = 150;
	
	
	d3.csv(dataFile, function(data) { 

	svg.selectAll("rect")
    .data(data)
	.enter().append("rect")
    .attr("x", tStart)
    .attr("y", function(d){switch(subject(d))
					{
						case "s0":
						return yS0;
						break;
						case "s1":
						return yS1;
						break;
						case "s2":
						return yS2;
						break;
						case "s3":
						return yS3;
						break;
						default:
						return -300;
						
						break;
					}
					})
    .attr("width", time)
	 .attr("height", time)
	.style("fill", function(d){switch(subject(d))
					{
						case "s0":
						return "rgba(0, 0, 255, 0.3)";
						break;
						case "s1":
						return "rgba(0, 255, 0, 0.3)";
						break;
						case "s2":
						return "rgba(255, 0, 0, 0.3)";
						break;
						case "s3":
						return "rgba(255,192,203, 0.3)";
						break;
						default:
						return "white";
						break;
					}
					})
	.style("stroke", function(d){switch(subject(d))
					{
						case "s0":
						return "darkblue";
						break;
						case "s1":
						return "darkgreen";
						break;
						case "s2":
						return "darkred";
						break;
						case "s3":
						return "rgb(255,20,147)";
						break;
						default:
						return "white";
						break;
					}
					});
}); 

svg.append("g")
	.attr("class", "axis")  //Assign "axis" class
	.attr("transform", "translate(0, 200)")
    .call(xAxis);
	
svg.append("text")
    .attr("class", "x label")
    .attr("text-anchor", "end")
    .attr("x", maxValTime/2)
    .attr("y", 240)
    .text("Time (minutes)");
	
svg.append("text")
    .attr("class", "x label")
    .attr("text-anchor", "end")
    .attr("x", maxValTime/2)
    .attr("y", 30)
    .text(title);
	
	
  </script>
	
</html>