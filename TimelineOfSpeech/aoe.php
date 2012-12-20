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

 
<script type="text/javascript">
var title = '<?php $file = $_GET["file"]; echo addslashes($file); ?>';
var dataFile = "dataFiles/"+title+".csv";

	d3.csv(dataFile, function(file) {
	
	var threshold = 0
	var allTab=[[[0,threshold]],[[0,threshold]],[[0,threshold]],[[0,threshold]]];
	var data = [];
	
	file.forEach(function(dat){
		data.push([dat.tStart, dat.time, dat.subject.replace(/\r/g, '')]);
	});
	
	function add(tab, i){
		//allTab[tab].push([parseFloat(data[i][0]),allTab[tab][allTab[tab].length-1][1]]);
		allTab[tab].push([parseFloat(data[i][0]),parseFloat(allTab[tab][i][1])+parseFloat(data[i][1])/2]);
	}
	
	function substract(tab,  i){
	//allTab[tab].push([parseFloat(data[i][0]),allTab[tab][allTab[tab].length-1][1]]);
		var valTemp = parseFloat(allTab[tab][i][1])-parseFloat(data[i][1])/3;
		if(valTemp < threshold){
				allTab[tab].push([parseFloat(data[i][0]),threshold]);
		}else{
				allTab[tab].push([parseFloat(data[i][0]),valTemp]);
		}
	}
	
	function subToAll(tab1, tab2, tab3, i){
		substract(tab1, i);
		substract(tab2, i);
		substract(tab3, i);
	}
	
	function addSilence(tab, i){
			allTab[tab].push([parseFloat(data[i][0]),parseFloat(allTab[tab][i][1])]);
	}
	
	function addSilenceToAll(i){
		addSilence(0,i);
		addSilence(1,i);
		addSilence(2,i);
		addSilence(3,i);
	}
	
	
	for(var i = 0; i< data.length; i++){
	switch(data[i][2])
		{
			case "s0":
				add(0,i);
				subToAll(1,2,3,i);
				break;
			case "s1":
				add(1,i);
				subToAll(0,2,3,i);
				break;
			case "s2":
				add(2,i);
				subToAll(1,0,3,i);
				break;
			case "s3":
				add(3,i);
				subToAll(1,2,0,i);
				break;
			default:
			console.log("default");
				addSilenceToAll(i);
				break;
		}
	}
	
	var w =8000,
	h = 600;
	
	var svg = d3.select("body").append("svg:svg")
    .attr("width", w)
    .attr("height", h);
	
	var area = d3.svg.area()
	.x(function(d) {return d[0]; })
	.y0(-h)
    .y1(function(d) { return d[1]; })
	.interpolate("basis");
      	
	var line = d3.svg.line()
    .x(function(d) {return d[0]; })
    .y(function(d) { return d[1]; });
  
	var x =[allTab[3]];
	
	svg.selectAll("aera")
    .data(x)
	.enter().append("path")
	.attr("d", area)
	.style("fill", "blue");
	
	
}); 
</script>
	
</html>