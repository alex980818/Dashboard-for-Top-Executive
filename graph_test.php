<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
</head>
<script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
    
function drawChart () {
    var data = google.visualization.arrayToDataTable([
        ['Category', 'Name', 'Value'],
        ['Foo', 'Fiz', 5],
        ['Foo', 'Buz', 2],
        ['Bar', 'Qud', 7],
        ['Bar', 'Piz', 4],
        ['Cad', 'Baz', 6],
        ['Cad', 'Baz', 6],
        ['Cad', 'Nar', 8]
    ]);
    
    var aggregateData = google.visualization.data.group(data, [0], [{
        type: 'number',
        label: 'Value',
        column: 2,
        aggregation: google.visualization.data.sum
    }]);
    
    var topLevel = true;
    
    var chart = new google.visualization.ColumnChart(document.querySelector('#chart'));
    var options = {
        // height: 400,
        // width: 600
        'chartArea': {
            'backgroundColor': {
                'fill': '#F4F4F4',
                'opacity': 100
             },
         }
    };
    
    function draw (category) {
        if (topLevel) {
            // rename the title
            options.title = 'Top Level data';
            // draw the chart using the aggregate data
            chart.draw(aggregateData, options);
        }
        else {
            var view = new google.visualization.DataView(data);
            // use columns "Name" and "Value"
            view.setColumns([1, 2]);
            // filter the data based on the category
            view.setRows(data.getFilteredRows([{column: 0, value: category}]));
            // rename the title
            options.title = 'Category: ' + category;
            // draw the chart using the view
            chart.draw(view, options);
        }
    }
    
    google.visualization.events.addListener(chart, 'select', function () {
        if (topLevel) {
            var selection = chart.getSelection();
            // drill down if the selection isn't empty
            if (selection.length) {
                var category = aggregateData.getValue(selection[0].row, 0);
                topLevel = false;
                draw(category);
            }
        }
        else {
            // go back to the top
            topLevel = true;
            draw();
        }
    });
    
    draw();
}
google.load('visualization', '1', {packages: ['corechart'], callback: drawChart});
</script>
<body>
<div id="chart" style="width: 100%; height: 100%"></div>

</body>
</html>
