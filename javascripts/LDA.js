
function drawLDA(){
  d3.csv("LDA_data.csv", function(rows) {
    //Format A
    var data = [];
    var roles = ['Organize', 'Time', 'Leader', 'Search', 'None']

    for (i = 0; i < roles.length; i++) {
        data.push({
            key: roles[i],
            values: []
        });
    }

    rows.forEach(function(row){
        data.forEach(function(d){
            if(d.key == row.role){
                d.values.push({
                    x: parseFloat(row.x),
                    y: parseFloat(row.y),
                    size: parseFloat(row.size),
                    shape: 'circle',
                    team: row.team,
                    position: row.position
                })
            }
        })
    })

    nv.addGraph(function() {
        var chart = nv.models.scatterChart()
            .showDistX(false)
            .showDistY(false)
            .useVoronoi(true)
            .tooltips(true)
            .tooltipContent(function(role, x, y, data){return data.point.team + " - Subject " + data.point.position})
            .color(d3.scale.category10().range());



        chart.xAxis.tickFormat(d3.format('.02f')).axisLabel('(+)Age, (+)Being Male, (+)Write w/ Ipad, (-)Page switches')
        chart.yAxis.tickFormat(d3.format('.02f')).axisLabel('(+)Write w/Keyboard, (+)Explicit search actions, (-)Total Actions')
       	
       	d3.select('#graph')
               .html("<svg></svg>")
               .style("height", 600)
       	
        d3.select('#graph svg')
        	//.attr("width", 640)
        	//.attr("height", 500)
            .datum(data)
            .transition().duration(500)
                .call(chart);

        nv.utils.windowResize(chart.update);
        return chart;
    });
  })
}