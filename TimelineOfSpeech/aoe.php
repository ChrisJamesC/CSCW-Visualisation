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
  
 <script src="http://d3js.org/d3.v2.js"></script>

 
<script type="text/javascript">
var title = '<?php $file = $_GET["file"]; echo addslashes($file); ?>';
var dataFile = "dataFiles/"+title+".csv";

var tab =[] ;
	//function getLineSplit(){
		var txtFile = new XMLHttpRequest();

		txtFile.open("GET", dataFile, false);
		txtFile.send('');

		//if (txtFile.readyState === 4) {
			//console.log("ready to parse");
			//if (txtFile.status === 200) {
				//console.log("file found");
				lines = txtFile.responseText.replace(/\r/g, '').split("\n");
				//lines = txtFile.responseText.split("\n");
				for(var i=1; i< lines.length; i++){
					tab.push(lines[i].split(","));
				}
			 
			//}	
	//	}
	//}

	
	var valS0 = [[0,25]];
	var valS1 = [[0,25]];
	var valS2 = [[0,25]];
	var valS3 = [[0,25]];
	
	
	
	for(var i = 0; i<tab.length-1;i++){
		//tabTemp = tab[i][2].split('');
		//temp = tabTemp[0]+tabTemp[1];
		
		switch(tab[i][2])
		{
			case "s0":
				valS0.push([parseFloat(tab[i][0]),valS0[i][1]]);
				valS0.push([parseFloat(tab[i][0])+parseFloat(tab[i][1]),parseFloat(valS0[i][1])+parseFloat(tab[i][1])]);
				
				valS1.push([parseFloat(tab[i][0]),valS1[i][1]]);
				valS1.push([parseFloat(tab[i][0])+parseFloat(tab[i][1]),parseFloat(valS1[i][1])-parseFloat(tab[i][1])/3]);
				
				valS2.push([parseFloat(tab[i][0]),valS2[i][1]]);
				valS2.push([parseFloat(tab[i][0])+parseFloat(tab[i][1]),parseFloat(valS2[i][1])-parseFloat(tab[i][1])/3]);
				
				valS3.push([parseFloat(tab[i][0]),valS3[i][1]]);
				valS3.push([parseFloat(tab[i][0])+parseFloat(tab[i][1]),parseFloat(valS3[i][1])-parseFloat(tab[i][1])/3]);
				break;
			case "s1":
				valS1.push([parseFloat(tab[i][0]),valS1[i][1]]);
				valS1.push([parseFloat(tab[i][0])+parseFloat(tab[i][1]),parseFloat(valS1[i][1])+parseFloat(tab[i][1])]);
				
				valS0.push([parseFloat(tab[i][0]),valS0[i][1]]);
				valS0.push([parseFloat(tab[i][0])+parseFloat(tab[i][1]),parseFloat(valS0[i][1])-parseFloat(tab[i][1])/3]);
				
				valS2.push([parseFloat(tab[i][0]),valS2[i][1]]);
				valS2.push([parseFloat(tab[i][0])+parseFloat(tab[i][1]),parseFloat(valS2[i][1])-parseFloat(tab[i][1])/3]);
				
				valS3.push([parseFloat(tab[i][0]),valS3[i][1]]);
				valS3.push([parseFloat(tab[i][0])+parseFloat(tab[i][1]),parseFloat(valS3[i][1])-parseFloat(tab[i][1])/3]);
				break;
			case "s2":
				valS2.push([parseFloat(tab[i][0]),valS2[i][1]]);
				valS2.push([parseFloat(tab[i][0])+parseFloat(tab[i][1]),parseFloat(valS2[i][1])+parseFloat(tab[i][1])]);
				
				valS1.push([parseFloat(tab[i][0]),valS1[i][1]]);
				valS1.push([parseFloat(tab[i][0])+parseFloat(tab[i][1]),parseFloat(valS1[i][1])-parseFloat(tab[i][1])/3]);
				
				valS0.push([parseFloat(tab[i][0]),valS0[i][1]]);
				valS0.push([parseFloat(tab[i][0])+parseFloat(tab[i][1]),parseFloat(valS0[i][1])-parseFloat(tab[i][1])/3]);
				
				valS3.push([parseFloat(tab[i][0]),valS3[i][1]]);
				valS3.push([parseFloat(tab[i][0])+parseFloat(tab[i][1]),parseFloat(valS3[i][1])-parseFloat(tab[i][1])/3]);
				break;
			case "s3":
				valS3.push([parseFloat(tab[i][0]),valS3[i][1]]);
				valS3.push([parseFloat(tab[i][0])+parseFloat(tab[i][1]),parseFloat(valS3[i][1])+parseFloat(tab[i][1])]);
				
				valS1.push([parseFloat(tab[i][0]),valS1[i][1]]);
				valS1.push([parseFloat(tab[i][0])+parseFloat(tab[i][1]),parseFloat(valS1[i][1])-parseFloat(tab[i][1])/3]);
				
				valS2.push([parseFloat(tab[i][0]),valS2[i][1]]);
				valS2.push([parseFloat(tab[i][0])+parseFloat(tab[i][1]),parseFloat(valS2[i][1])-parseFloat(tab[i][1])/3]);
				
				valS0.push([parseFloat(tab[i][0]),valS0[i][1]]);
				valS0.push([parseFloat(tab[i][0])+parseFloat(tab[i][1]),parseFloat(valS0[i][1])-parseFloat(tab[i][1])/3]);
				break;
			default:
				
				break;
		}
	}
	var m=200;
	var area1 = d3.svg.area()
	.x(function(d) {return d[0]; })
	.y0(h)
    .y1(function(d) {console.log(d[1]); return d[1]; })
	.interpolate("basis");
    
	
    
    	
	var line = d3.svg.line()
    .x(function(d) {return d[0]; })
    .y(function(d) {console.log(d[1]); return d[1]; });
  
	
	var w =8000,
    h = 600;
	
	var svg = d3.select("body").append("svg:svg")
    .attr("width", w)
    .attr("height", h);
	
	var data =[valS0];
	svg.selectAll("path")
    .data(data)
	.enter().append("path")
	.attr("d", area1)
	.style("fill", "blue");
	
</script>
	
</html>