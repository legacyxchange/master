
            
            <div style="float:left;font-size:20px;font-weight:bold;"> &nbsp;&nbsp;<?php echo $revenue_heading;?></div>
            
            <div class="panel-body pn">
              <div id="ecommerce_chart1" style="height: 300px;"></div>
            </div>
          </div>
          

        
        <script type="text/javascript">
  initCharts = function() {
    
    "use strict";
    console.log($('#ecommerce_chart1'));
    Core.init();

    // Init Demo JS  
    Demo.init();

    var highColors = [bgSystem, bgSuccess, bgWarning, bgPrimary];

    // Chart data
    
    	var seriesData = [{
      		name: 'Advertisement Costs',      		
      		data: <?php echo $datacosts;?>
    	}, {
      	name: 'Gross Revenue',
      	data: <?php echo $datarevenue;?>
    	}, {
          	name: 'Listings Added',
          	data: <?php echo $listings_count;?>
        }];
    
    var ecomChart = $('#ecommerce_chart1');

    if (ecomChart.length) {
      ecomChart.highcharts({
        credits: false,
        colors: highColors,
        chart: {
          backgroundColor: '#fff',
          className: 'br-r',
          type: 'line',
          zoomType: 'x',
          panning: true,
          panKey: 'shift',
          marginTop: 45,
          marginRight: 1,
        },
        title: {
          text: null
        },
        xAxis: {
          gridLineColor: '#EEE',
          lineColor: '#EEE',
          tickColor: '#EEE',
          categories:
          <?php echo $categories; ?>           
        },
        yAxis: {
          min: 0,
          tickInterval: 5,
          gridLineColor: '#EEE',
          title: {
            text: null,
          }
        },
        plotOptions: {
          spline: {
            lineWidth: 3,
          },
          area: {
            fillOpacity: 0.2
          }
        },
        tooltip: {
            pointFormat: "${point.y:.2f}"
        },
        legend: {
          enabled: true,
          floating: false,
          align: 'right',
          verticalAlign: 'top',
        },
        series: seriesData
      });
    }


  }
  </script>