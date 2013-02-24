<!DOCTYPE html>
<html>
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8" />
	<title>Time line of Speech: Circle 2</title>
	<script type="text/javascript" src="d3.v2.js"></script>
    <script type="text/javascript" src="nv.d3.js"></script>
	<script src="getMaxValTime.js"></script>
	
	<link href="nv.d3.css" rel="stylesheet" type="text/css">
	
 <style>
	body {
            overflow-y:scroll;
            margin: 0;
            padding: 0;
        }
	svg {
            overflow: hidden;
        }
		
	#chart svg {
		height: 600px;
	}

</style>
  </head>
 



 <body>
	<div id="chart">
		<svg></svg>
	</div>
  </body>

 
<script type="text/javascript">

var title = '<?php $file = $_GET["file"]; echo addslashes($file); ?>';
var dataFile = "dataFiles/"+title+".csv";
var maxValTime = getMaxValTime();

	d3.csv(dataFile, function(file) {
	
	var threshold = 0
	var allTab=[[[0,threshold]],[[0,threshold]],[[0,threshold]],[[0,threshold]]];
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
				addSilenceToAll(i);
				break;
		}
	}
	
	
	var data=[];
	data.push({key:"s0", values:[]});
	data.push({key:"s1", values:[]});
	data.push({key:"s2", values:[]});
	data.push({key:"s3", values:[]});
	
	for(var i = 1; i< allTab[0].length;i++){
		data[0].values.push([allTab[0][i][0]/60,allTab[0][i][1]]);
		data[1].values.push([allTab[1][i][0]/60,allTab[1][i][1]])
		data[2].values.push([allTab[2][i][0]/60,allTab[2][i][1]])
		data[3].values.push([allTab[3][i][0]/60,allTab[3][i][1]])
	}

	 console.log(data)

		nv.addGraph(function() {
			var chart = nv.models.stackedAreaChart()
                .x(function(d) { return d[0] })
                .y(function(d) { return d[1] })
                .clipEdge(true)
				.color(["blue", "green", "red", "pink"]);

			chart.xAxis
				.showMaxMin(false)
				.axisLabel("Time (min)");

			chart.yAxis
				.axisLabel('Voltage (v)')
				.tickFormat(d3.format('.02f'));

			d3.select('#chart svg')
				.datum(data)
				.transition().
				duration(500).
				call(chart);

			nv.utils.windowResize(chart.update);

			return chart;
		});
	});

						
</script>
	
</html>