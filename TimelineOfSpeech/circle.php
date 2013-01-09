<!DOCTYPE html>
<html>
  <head>
    <title>Time line of Speech: Circle 2</title>
	
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
  
 <script src="d3.v2.js"></script>
 <script src="getMaxValTime.js"></script>
 
<script type="text/javascript">
	
	var title = '<?php $file = $_GET["file"]; echo addslashes($file); ?>';
	var dataFile = "dataFiles/"+title+".csv";
	console.log(dataFile);
	var leftMargin = 30;
	
	var w =1000,
		h = 600,
		maxValTime = getMaxValTime();
		
	var xScale = d3.scale.linear()
                    .domain([0, maxValTime/60])
					.range([leftMargin,w+leftMargin]);
	
					
	var xAxis = d3.svg.axis()
				.scale(xScale)
				.ticks(maxValTime/60);
	
		
	var svg = d3.select("body").append("svg:svg")
		.attr("width", w+50)
		.attr("height", h);
		
		var yS0 = 60;
		var yS1 = 80;
		var yS2 = 100;
		var yS3 = 120;
		var yS4 = 140;
		var isFive = false;
			
	d3.csv(dataFile, function(file) {

		var data = [file[0]]; 
		var j=0;
		var first = true;
		file.forEach(function(dat){
		if(!first){
			if(dat.subject === data[j].subject){
				data[j].time = parseFloat(data[j].time)+parseFloat(dat.time);
			}else{
				data.push(dat);
				j++;
			}
		}else{
			first= false;
		}
		});
			console.log(data);

		svg.selectAll("ellipse")
		.data(data)
		.enter().append("ellipse")
		.attr("cx", function(d){return (leftMargin + (parseFloat(d.tStart)+ parseFloat(d.time/2))*w/maxValTime);})
		.attr("cy", function(d){switch(d.subject)
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
							case "s4":
							isFive = true;
							return yS4;
							break;
							default:
							return -300;
							
							break;
						}
						})
		.attr("rx", function(d){return (d.time/2)*w/maxValTime;})
		.attr("ry", function(d){return (d.time/3)*w/maxValTime;})
		.style("fill", function(d){switch(d.subject)
						{
							case "s0":
							return "rgba(0, 0, 255, 0.5)";
							break;
							case "s1":
							return "rgba(0, 255, 0, 0.5)";
							break;
							case "s2":
							return "rgba(255, 0, 0, 0.5)";
							break;
							case "s3":
							return "rgba(255,192,203, 0.5)";
							break;
							case "s4":
							return "rgba(150, 75, 0, 0.5)";
							break;
							default:
							return "white";
							break;
						}
						})
		.style("stroke", function(d){switch(d.subject)
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
							case "s4":
							return "rgb(61, 43, 31)";
							break;
							default:
							return "white";
							break;
						}
						});
	var hAxis;
	
	if(isFive){
		hAxis=160;
		
	}else{
		hAxis=140;
		
	}
	var ypos = 40+ (w+leftMargin)/2
	svg.append("g")
	.attr("class", "axis")  //Assign "axis" class
	.attr("transform", "translate(0, "+hAxis+")")
    .call(xAxis);
		
	svg.append("text")
    .attr("class", "x label")
    .attr("text-anchor", "end")
    .attr("x", ypos)
    .attr("y", hAxis+40)
    .text("Time (minutes)");
	
	color = ["blue","lightgreen", "red", "rgb(255,192,203)","rgb(150, 75, 0)"];
	var j;
	if(isFive){
		j = 5;
	}else{
		j = 4;
	}
	for(var i=0; i< j; i++){
		svg.append("text")
		.attr("class", "x label")
		.attr("text-anchor", "end")
		.attr("x", 20)
		.attr("y", 65+i*20)
		.style("fill", color[i])
		.text("s"+i);
	}
	
	svg.append("text")
    .attr("class", "x label")
    .attr("text-anchor", "end")
    .attr("x", 20+ypos)
    .attr("y", 30)
    .text(title);
	}); 
	
  </script>
	
</html>