<!-- dashboard metric chart -->
          <div class="panel">
            <div class="panel-heading">
              <span class="panel-title" style="float:left"> Revenue &nbsp;&nbsp;&nbsp;&nbsp;</span>
              <?php echo form_open($_SERVER['PHP_SELF'], array('method' => 'post', 'class' => 'interval-form', 'style' => 'float:left')); ?>
              <select name="interval" onchange="this.form.submit();">
                  <option value="">Choose Interval</option>
                  <option value="monthly">Monthly</option>
                  <option value="daily">Daily</option>
              </select>
              <?php echo form_close();?>
            
            <div style="float:left;font-size:20px;font-weight:bold;"> &nbsp;&nbsp;<?php echo $revenue_heading;?></div>
            </div>
            <div class="panel-body pn">
              <div id="ecommerce_chart1" style="height: 300px;"></div>
            </div>
          </div>
          
          <script src="http://admindesigns.com/demos/absolute/1.1/vendor/plugins/highcharts/highcharts.js"></script>
        
        <script type="text/javascript">
  jQuery(document).ready(function() {

    "use strict";

    // Init Theme Core    
    Core.init();

    // Init Demo JS  
    Demo.init();

    var highColors = [bgSystem, bgSuccess, bgWarning, bgPrimary];

    // Chart data
    <?php if($interval == 'daily'): ?>
    	var seriesData = [{
      		name: 'Advertisement Costs',      		
      		data: <?php echo $data;?>
    	}, {
      	name: 'Advertisement Revenue',
      		data: [2.91, 3.22, 4.73, 5.54, 8.94, 12.24, 17.05, 16.66, 14.72, 10.73, 6.56, 4.58]
    	}];
    <?php endif; ?>
    <?php if($interval == 'monthly'): ?>
    	var seriesData = [{
      		name: 'Advertisement Costs',
      		//data: [5.00, 9.01, 17.43, 22.00, 19.10, 11.50, 5.20, 9.50, 11.38, 15.33, 19.92, 24.61]
      		data: <?php echo $data;?>
    	}, {
      	name: 'Advertisement Revenue',
      		data: [2.91, 3.22, 4.73, 5.54, 8.94, 12.24, 17.05, 16.66, 14.72, 10.73, 6.56, 4.58]
    	}];
    <?php endif; ?>
    var ecomChart = $('#ecommerce_chart1');

    if (ecomChart.length) {
      ecomChart.highcharts({
        credits: false,
        colors: highColors,
        chart: {
          backgroundColor: 'transparent',
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


  });
  </script>