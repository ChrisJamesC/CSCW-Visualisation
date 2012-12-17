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
  
 <script src="http://d3js.org/d3.v2.js"></script>

 
<script type="text/javascript">
var title = '<?php $file = $_GET["file"]; echo addslashes($file); ?>';
var dataFile = "dataFiles/"+title+".csv";

	function getLineSplit(){
		var txtFile = new XMLHttpRequest();

		txtFile.open("GET", dataFile, false);
		txtFile.send('');

		if (txtFile.readyState === 4) {
			console.log("ready to parse");
			if (txtFile.status === 200) {
				console.log("file found");
			  
				lines = txtFile.responseText.split("\n");
				var lineSplit =[] ;
				for(var i=1; i< lines.length;i++){
					lineSplit.push(lines[i].split(","));
				}
			return lineSplit;
			 
			}	
		}
	}
	
	var tab = getLineSplit();
	var a = [["0","6.7","s3"],["0","6.7","s0"]];
	console.log(a);
	console.log(tab);
	var valS0 = [[0,25]];
	var valS1 = [[0,25]];
	var valS2 = [[0,25]];
	var valS3 = [[0,25]];
	
	console.log(tab[0][2]);//output: s3
	console.log("s3");
	
	
	if(a[0][2]=="s3"){console.log("AAAA");} //Work
	if(tab[0][2]=="s3"){console.log("YIIII");} // doesn't work
	
	/*
	for(var i = 0; i<tab.length-1;i++){

		switch(tab[i][2])
		{
			case "s0":
				valS0.push([tab[i][0],valS0[i][1]]);
				valS0.push([parseFloat(tab[i][0])+parseFloat(tab[i][1]),parseFloat(valS0[i][1])+parseFloat(tab[i][1])/10]);
				
				valS1.push([tab[i][0],valS1[i][1]]);
				valS1.push([parseFloat(tab[i][0])+parseFloat(tab[i][1]),parseFloat(valS1[i][1])-parseFloat(tab[i][1])/10/3]);
				
				valS2.push([tab[i][0],valS2[i][1]]);
				valS2.push([parseFloat(tab[i][0])+parseFloat(tab[i][1]),parseFloat(valS2[i][1])-parseFloat(tab[i][1])/10/3]);
				
				valS3.push([tab[i][0],valS3[i][1]]);
				valS3.push([parseFloat(tab[i][0])+parseFloat(tab[i][1]),parseFloat(valS3[i][1])-parseFloat(tab[i][1])/10/3]);
				break;
			case "s1":
				valS1.push([tab[i][0],valS1[i][1]]);
				valS1.push([parseFloat(tab[i][0])+parseFloat(tab[i][1]),parseFloat(valS1[i][1])+parseFloat(tab[i][1])/10]);
				
				valS0.push([tab[i][0],valS0[i][1]]);
				valS0.push([parseFloat(tab[i][0])+parseFloat(tab[i][1]),parseFloat(valS0[i][1])-parseFloat(tab[i][1])/10/3]);
				
				valS2.push([tab[i][0],valS2[i][1]]);
				valS2.push([parseFloat(tab[i][0])+parseFloat(tab[i][1]),parseFloat(valS2[i][1])-parseFloat(tab[i][1])/10/3]);
				
				valS3.push([tab[i][0],valS3[i][1]]);
				valS3.push([parseFloat(tab[i][0])+parseFloat(tab[i][1]),parseFloat(valS3[i][1])-parseFloat(tab[i][1])/10/3]);
				break;
			case "s2":
				valS2.push([tab[i][0],valS2[i][1]]);
				valS2.push([parseFloat(tab[i][0])+parseFloat(tab[i][1]),parseFloat(valS2[i][1])+parseFloat(tab[i][1])/10]);
				
				valS1.push([tab[i][0],valS1[i][1]]);
				valS1.push([parseFloat(tab[i][0])+parseFloat(tab[i][1]),parseFloat(valS1[i][1])-parseFloat(tab[i][1])/10/3]);
				
				valS0.push([tab[i][0],valS0[i][1]]);
				valS0.push([parseFloat(tab[i][0])+parseFloat(tab[i][1]),parseFloat(valS0[i][1])-parseFloat(tab[i][1])/10/3]);
				
				valS3.push([tab[i][0],valS3[i][1]]);
				valS3.push([parseFloat(tab[i][0])+parseFloat(tab[i][1]),parseFloat(valS3[i][1])-parseFloat(tab[i][1])/10/3]);
				break;
			case "s3":
				valS3.push([tab[i][0],valS3[i][1]]);
				valS3.push([parseFloat(tab[i][0])+parseFloat(tab[i][1]),parseFloat(valS3[i][1])+parseFloat(tab[i][1])/10]);
				
				valS1.push([tab[i][0],valS1[i][1]]);
				valS1.push([parseFloat(tab[i][0])+parseFloat(tab[i][1]),parseFloat(valS1[i][1])-parseFloat(tab[i][1])/10/3]);
				
				valS2.push([tab[i][0],valS2[i][1]]);
				valS2.push([parseFloat(tab[i][0])+parseFloat(tab[i][1]),parseFloat(valS2[i][1])-parseFloat(tab[i][1])/10/3]);
				
				valS0.push([tab[i][0],valS0[i][1]]);
				valS0.push([parseFloat(tab[i][0])+parseFloat(tab[i][1]),parseFloat(valS0[i][1])-parseFloat(tab[i][1])/10/3]);
				break;
			default:
				
				break;
		}
	}
	*/
	//console.log(valS0.length);
	//console.log(valS1.length);
	//console.log(valS2.length);
	//console.log(valS3.length);
</script>
	
</html>