function drawTimeline(source){
    /* Empty svg from all previous content */
    d3.select('#graph')
        .style("height", "400px")
        .html("<svg></svg>")


    /* Draw stacked area */
    aoeNvd3(source);

    /* Draw ellipses */
    circle(source)
}

function drawTimelineB(source){
    /* Empty svg from all previous content */
    d3.select('#graph')
        .html("<svg></svg>")
        .style("height","400px")
    /* Draw stacked area */
    aoeNvd3Beaver(source);

    /* Draw ellipses */
    circle(source)
}



function aoeNvd3(source){
    //var title = '<?php $file = $_GET["file"]; echo addslashes($file); ?>';
    var dataFile = source;
    //var maxValTime = getMaxValTime();

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

        //console.log(data)

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

            d3.select('#graph svg')
                .style("height", "400px")
                .datum(data)
                .transition().
                duration(500).
                call(chart);

            nv.utils.windowResize(chart.update);

            return chart;
        });
    });
}

function aoeNvd3Beaver(source){
    //var title = '<?php $file = $_GET["file"]; echo addslashes($file); ?>';
    var dataFile = source;
    //var maxValTime = getMaxValTime();

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
        data.push({key:"s0", values:[]});
        data.push({key:"s1", values:[]});
        data.push({key:"s2", values:[]});
        data.push({key:"s3", values:[]});
        data.push({key:"s4", values:[]});

        for(var i = 1; i< allTab[0].length;i++){
            data[0].values.push([allTab[0][i][0]/60,allTab[0][i][1]]);
            data[1].values.push([allTab[1][i][0]/60,allTab[1][i][1]])
            data[2].values.push([allTab[2][i][0]/60,allTab[2][i][1]])
            data[3].values.push([allTab[3][i][0]/60,allTab[3][i][1]])
            data[4].values.push([allTab[4][i][0]/60,allTab[4][i][1]])
        }

        //console.log(data)

        nv.addGraph(function() {
            var chart = nv.models.stackedAreaChart()
                .x(function(d) { return d[0] })
                .y(function(d) { return d[1] })
                .clipEdge(true)
                .color(["blue", "green", "red", "pink", "brown"]);

            chart.xAxis
                .showMaxMin(false)
                .axisLabel("Time (min)");

            chart.yAxis
                .axisLabel('Voltage (v)')
                .tickFormat(d3.format('.02f'));

            d3.select('#graph svg')
                .style("height", "400px")
                .datum(data)
                .transition().
                duration(500).
                call(chart);

            nv.utils.windowResize(chart.update);

            return chart;
        });
    });
}

function circle(source){
    //var title = '<?php $file = $_GET["file"]; echo addslashes($file); ?>';
    var dataFile = source;
    //console.log(dataFile);
    var leftMargin = 30;

    var w =800,
        h = 200,
        maxValTime = getMaxValTime(source);

    var xScale = d3.scale.linear()
        .domain([0, maxValTime/60])
        .range([leftMargin,w+leftMargin]);


    var xAxis = d3.svg.axis()
        .scale(xScale)
        .ticks(maxValTime/60);


    var svg = d3.select("#graph").append("svg:svg")
        .attr("width", w)
        .style("height", h+"px");

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
        //console.log(data);

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
        /*
        svg.append("text")
            .attr("class", "x label")
            .attr("text-anchor", "end")
            .attr("x", 20+ypos)
            .attr("y", 30)
            .text(title);

        */
    });
}

function getMaxValTime(dataFile){
    var txtFile = new XMLHttpRequest();

    txtFile.open("GET", dataFile, false);
    txtFile.send('');

    if (txtFile.readyState === 4) {
        if (txtFile.status === 200) {
            lines = txtFile.responseText.split("\n");
            var lineSplit =[] ;

            lineSplit.push(lines[lines.length - 1].split(","));

            return parseFloat(lineSplit[lineSplit.length-1][0]) +parseFloat(lineSplit[lineSplit.length-1][1])

        }
    }
}