<!DOCTYPE html>
<meta charset="utf-8">
<h1>Number of Answers answered by each user</h1>
<style>

.arc text {
  font: 10px sans-serif;
  text-anchor: middle;
}

.arc path {
  stroke: #fff;
}
body > svg{
	float: left;
}


</style>
<body>
<script src="//d3js.org/d3.v3.min.js"></script>
<script>


var width = 560,
    height = 500,
    radius = Math.min(width, height) / 2;

var color = d3.scale.ordinal()
    .range(["#98abc5", "#8a89a6", "#7b6888", "#6b486b", "#a05d56", "#d0743c", "#ff8c00"]);

var arc = d3.svg.arc()
    .outerRadius(radius - 10)
    .innerRadius(0);

var labelArc = d3.svg.arc()
    .outerRadius(radius - 40)
    .innerRadius(radius - 40);

var pie = d3.layout.pie()
    .sort(null)
    .value(function(d) { return d.answer; });

var svg = d3.select("body").append("svg")
	// .viewBox("-100 -1000 200 2000")
    .attr("width", width)
    .attr("height", height)
  .append("g")
    .attr("transform", "translate(" + width/2 + "," + height / 2 + ")");

d3.csv("anschart", type, function(error, data) {
  if (error) throw error;

  var g = svg.selectAll(".arc")
  	.attr("float", "right")
      .data(pie(data))
    .enter().append("g")
      .attr("class", "arc");

  g.append("path")
      .attr("d", arc)
      .style("fill", function(d) { return color(d.data.user); });

  g.append("text")
      .attr("transform", function(d) { return "translate(" + labelArc.centroid(d) + ")"; })
      .attr("dy", ".35em")
      .text(function(d) { return d.data.user+" "+d.data.answer; });
});

function type(d) {
  d.answer = +d.answer;
  return d;
}
</script>