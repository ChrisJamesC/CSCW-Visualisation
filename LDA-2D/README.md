This scatterplot is constructed from a TSV file storing the dimensions of sepals and petals of various iris flowers. The chart employs [conventional margins](http://bl.ocks.org/3019563) and a number of D3 features:

* [d3.tsv](https://github.com/mbostock/d3/wiki/CSV) - load and parse data
* [d3.scale.linear](https://github.com/mbostock/d3/wiki/Quantitative-Scales) - *x*- and *y*-position encoding
* [d3.scale.ordinal](https://github.com/mbostock/d3/wiki/Ordinal-Scales) - color encoding
* [d3.extent](https://github.com/mbostock/d3/wiki/Arrays#wiki-d3_extent) - compute domains
* [d3.svg.axis](https://github.com/mbostock/d3/wiki/SVG-Axes) - display axes