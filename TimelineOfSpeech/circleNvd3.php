<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8" />
	<title>Ellipse</title>
	<script type="text/javascript" src="d3.v2.js"></script>
    <script type="text/javascript" src="nv.d3.js"></script>
	<script src="getMaxValTime.js"></script>
	
	<link href="nv.d3.css" rel="stylesheet" type="text/css">
	
	<style>

#chart svg {
  height: 400px;
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
		
		var yS0 = 1;
		var yS1 = 2;
		var yS2 =3;
		var yS3 = 4;
		var yS4 = 5;
		var isFive = false;
			
	d3.csv(dataFile, function(file) {
		var data=[];
			data.push({key:"s0", values:[]});
			data.push({key:"s1", values:[]});
			data.push({key:"s2", values:[]});
			data.push({key:"s3", values:[]});
			
		file.forEach(function(dat){
		
			switch(dat.subject){
				case "s0":
				
					data[0].values.push({ x: parseFloat(dat.tStart)/60+parseFloat(dat.time)/60
										, y: yS0
										, size: parseFloat(dat.time)})	  
				break;
				case "s1":
					data[1].values.push({ x: parseFloat(dat.tStart)/60+parseFloat(dat.time)/60
										, y: yS1
										, size:  parseFloat(dat.time)})	 	
				break;
				case "s2":
					data[2].values.push({ x: parseFloat(dat.tStart)/60+parseFloat(dat.time)/60
										, y: yS2
										, size:  parseFloat(dat.time)})	 
				break;
				case "s3":
					data[3].values.push({ x:parseFloat(dat.tStart)/60+parseFloat(dat.time)/60
										, y: yS3
										, size:  parseFloat(dat.time)})	 
				break;
				default:
				break;
				
		}
		if((dat.tStart+dat.time)/60 > 200){
		console.log(dat.time);
		}
		});
	
	console.log(data);
	
		 nv.addGraph(function() {
        var chart = nv.models.scatterChart()
            .showDistX(true)
            .showDistY(true)
            //.height(500)
           .useVoronoi(true)
            .color(d3.scale.category10().range());

       // chart.xAxis.tickFormat(d3.format('.02f')).axisLabel('LDA1')
        //chart.yAxis.tickFormat(d3.format('.02f')).axisLabel('LDA2')

        d3.select('#chart svg')
            .datum(data)
            .transition().duration(500)
            .call(chart);

        nv.utils.windowResize(chart.update);
        return chart;
		});	
	}); 
	
  </script>
	
</html>