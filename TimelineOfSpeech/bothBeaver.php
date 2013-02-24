<!DOCTYPE html>
<html>
  <head>
    <title>Time line of Speech: Circle 2</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8" />
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
var maxValTime = getMaxValTime();

	d3.csv(dataFile, function(file) {
	
	var threshold = 0
	var allTab=[[[0,threshold]],[[0,threshold]],[[0,threshold]],[[0,threshold]],[[0,threshold]]];
	var data = [];
	var addVal = 2;
	var subVal = 4;
	
	file.forEach(function(dat){
		data.push([dat.tStart, dat.time, dat.subject.replace(/\r/g, '')]);
	});
	
	function add(tab, i){
		allTab[tab].push([parseFloat(data[i][0]),parseFloat(allTab[tab][i][1])+parseFloat(data[i][1])/addVal]);
	}
	
	function substract(tab,  i){
		var valTemp = parseFloat(allTab[tab][i][1])-parseFloat(data[i][1])/subVal;
		if(valTemp < threshold){
				allTab[tab].push([parseFloat(data[i][0]),threshold]);
		}else{
				allTab[tab].push([parseFloat(data[i][0]),valTemp]);
		}
	}
	
	function subToAll(tab1, tab2, tab3, tab4, i){
		substract(tab1, i);
		substract(tab2, i);
		substract(tab3, i);
		substract(tab4, i);
	}
	
	function addSilence(tab, i){
			allTab[tab].push([parseFloat(data[i][0]),parseFloat(allTab[tab][i][1])]);
	}
	
	function addSilenceToAll(i){
		addSilence(0,i);
		addSilence(1,i);
		addSilence(2,i);
		addSilence(3,i);
		addSilence(4,i);
	}
	
	
	for(var i = 0; i< data.length; i++){
	switch(data[i][2])
		{
			case "s0":
				add(0,i);
				subToAll(1,2,3,4,i);
				break;
			case "s1":
				add(1,i);
				subToAll(0,2,3,4,i);
				break;
			case "s2":
				add(2,i);
				subToAll(1,0,3,4,i);
				break;
			case "s3":
				add(3,i);
				subToAll(1,2,0,4,i);
				break;
			case "s4":
				add(4,i);
				subToAll(1,2,0,3,i);
				break;
			default:
				addSilenceToAll(i);
				break;
		}
	}

	var data=[];
	for(var i = 1; i< allTab[0].length;i++){
		data.push({key:"s4", tStart:allTab[4][i][0], time:allTab[4][i][1]});
		data.push({key:"s3", tStart:allTab[3][i][0], time:allTab[3][i][1]});
		data.push({key:"s2", tStart:allTab[2][i][0], time:allTab[2][i][1]});
		data.push({key:"s1", tStart:allTab[1][i][0], time:allTab[1][i][1]});
		data.push({key:"s0", tStart : allTab[0][i][0], time:allTab[0][i][1]});
	}


	var h = 240;
	var hSvg = 600;
	var leftMargin = 30;
	var w =1000+leftMargin;
	
	var z = d3.scale.category20c();
	var x = d3.time.scale()
    .range([0, w]);

	var y = d3.scale.linear()
    .range([h, 0]);
	
	var nest = d3.nest()
    .key(function(d) { return d.key; });
	
	var stack = d3.layout.stack()
    .offset("expand")
    .values(function(d) { return d.values; })
    .x(function(d) { return d.tStart; })
    .y(function(d) { return d.time; });
	
	var layers = stack(nest.entries(data))
	var area = d3.svg.area()
    .x(function(d) { return x(d.tStart)+leftMargin; })
    .y0(function(d) { return y(d.y0); })
    .y1(function(d) { return y(d.y0 + d.y); });
	
	x.domain(d3.extent(data, function(d) { return d.tStart; }));
	y.domain([0, d3.max(data, function(d) { return d.y0 + d.y; })]);
  
	var svg = d3.select("body").append("svg:svg")
    .attr("width", w+leftMargin)
    .attr("height", hSvg);
	
	svg.selectAll("aera")
		.data(layers)
		.enter().append("path")
		.attr("d", function(d) { return area(d.values); })
		.style("fill", function(d, i) { switch(i%5)
						{
							case 4: 
							return "rgba(0, 0, 255, 0.5)";
							break;
							case 3:
							return "rgba(0, 255, 0, 0.5)";
							break;
							case 2:
							return "rgba(255, 0, 0, 0.5)";
							break;
							case 1:
							return "rgba(255,192,203, 0.5)";
							break;
							case 0:
							return "rgba(150, 75, 0, 0.5)";
							break;
							default:
							return "white";
							break;
						} });
						
	var maxValTime = getMaxValTime();
	
	var xScale = d3.scale.linear()
                    .domain([0, maxValTime/60])
					.range([leftMargin,w+leftMargin]);
	
					
	var xAxis = d3.svg.axis()
				.scale(xScale)
				.ticks(maxValTime/60);
			
	
	
/////////////////  ELLIPSE ///////////////////
var tem = 220;
var yS0 = tem+60;
		var yS1 = tem+80;
		var yS2 = tem+100;
		var yS3 =tem+ 120;
		var yS4 = tem+ 140;
		
		
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
							return yS4;
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
		var hAxis=380;
		
	
	svg.append("g")
	.attr("class", "axis")  //Assign "axis" class
	.attr("transform", "translate(0, "+hAxis+")")
    .call(xAxis);
		
	svg.append("text")
    .attr("class", "x label")
    .attr("text-anchor", "end")
    .attr("x", w/2)
    .attr("y", hAxis+40)
    .text("Time (minutes)");
	
	color = ["blue","lightgreen", "red", "rgb(255,192,203)","rgb(150, 75, 0)"];
	
	for(var i=0; i< 5; i++){
		svg.append("text")
		.attr("class", "x label")
		.attr("text-anchor", "end")
		.attr("x", 20)
		.attr("y", 50+i*40)
		.style("fill", color[i])
		.text("s"+i);
	}
	
	for(var i=0; i< 5; i++){
		svg.append("text")
		.attr("class", "x label")
		.attr("text-anchor", "end")
		.attr("x", 20)
		.attr("y", tem+65+i*20)
		.style("fill", color[i])
		.text("s"+i);
	}
	
	svg.append("text")
    .attr("class", "x label")
    .attr("text-anchor", "end")
    .attr("x", w/2)
    .attr("y", 30)
    .text(title);
}); 
</script>
	
</html>