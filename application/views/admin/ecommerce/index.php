      
      

      <!-- Start: Topbar -->
      <header id="topbar" class="hidden">
        <div class="topbar-left">
          <ol class="breadcrumb">
            <li class="crumb-active">
              <a href="dashboard.html">Dashboard</a>
            </li>
            <li class="crumb-icon">
              <a href="dashboard.html">
                <span class="glyphicon glyphicon-home"></span>
              </a>
            </li>
            <li class="crumb-link">
              <a href="dashboard.html">Home</a>
            </li>
            <li class="crumb-trail">Dashboard</li>
          </ol>
        </div>
        <div class="topbar-right">
          <div class="ib topbar-dropdown">
            <label for="topbar-multiple" class="control-label pr10 fs11 text-muted">Reporting Period</label>
            <select id="topbar-multiple" class="hidden">
              <optgroup label="Filter By:">
                <option value="1-1">Last 30 Days</option>
                <option value="1-2" selected="selected">Last 60 Days</option>
                <option value="1-3">Last Year</option>
              </optgroup>
            </select>
          </div>
          <div class="ml15 ib va-m" id="toggle_sidemenu_r">
            <a href="#">
              <i class="ad ad-sort"></i>
              <span class="badge badge-hero badge-warning">3</span>
            </a>
          </div>
        </div>
      </header>
      <!-- End: Topbar -->

      
      
      <!-- Begin: Content -->
      <section id="content" style="background:#ccc;" class="table-layout animated fadeIn col-lg-12 col-md-12">

        <!-- begin: .tray-center -->
        <div class="tray tray-center col-lg-12 col-md-12">

          <!-- dashboard tiles -->
          <div class="row">
            <div class="col-sm-4 col-xl-3">
              <div class="panel panel-tile text-center br-a br-grey">
                <div class="panel-body">
                  <h1 class="fs30 mt5 mbn"><?php echo count($orders);?></h1>
                  <h6 class="text-system">NEW ORDERS</h6>
                </div>
                <div class="panel-footer br-t p12">
                  <span class="fs11">
                    <i class="fa fa-arrow-up pr5"></i> 3% INCREASE
                    <b>1W AGO</b>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-sm-4 col-xl-3">
              <div class="panel panel-tile text-center br-a br-grey">
                <div class="panel-body">
                <?php 
                foreach($orders as $o){
                	$total_sales += $o->amount;
                }
                ?>
                  <h1 class="fs30 mt5 mbn">$<?php echo number_format($total_sales, 2);?></h1>
                  <h6 class="text-success">TOTAL SALES GROSS</h6>
                </div>
                <div class="panel-footer br-t p12">
                  <span class="fs11">
                    <i class="fa fa-arrow-up pr5"></i> 2.7% INCREASE
                    <b>1W AGO</b>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-sm-4 col-xl-3">
              <div class="panel panel-tile text-center br-a br-grey">
                <div class="panel-body">
                  <h1 class="fs30 mt5 mbn"><?php echo count($pending_shipments);?></h1>
                  <h6 class="text-warning">PENDING SHIPMENTS</h6>
                </div>
                <div class="panel-footer br-t p12">
                  <span class="fs11">
                    <i class="fa fa-arrow-up pr5 text-success"></i> 1% INCREASE
                    <b>1W AGO</b>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-sm-3 col-xl-3 visible-xl">
              <div class="panel panel-tile text-center br-a br-grey">
                <div class="panel-body">
                  <h1 class="fs30 mt5 mbn"><?php echo $num_visitors;?></h1>
                  <h6 class="text-danger">UNIQUE VISITS</h6>
                </div>
                <div class="panel-footer br-t p12">
                  <span class="fs11">
                    <i class="fa fa-arrow-down pr5 text-danger"></i> 6% DECREASE
                    <b>1W AGO</b>
                  </span>
                </div>
              </div>
            </div>
          </div>

          <script src="http://admindesigns.com/demos/absolute/1.1/vendor/plugins/highcharts/highcharts.js"></script> 
          
          <script>
          var s = function(){
        	  load_ajax_revenue_panel('monthly', '<?php echo date('m');?>');
          }();
          
              function load_ajax_revenue_panel(interval, month){ console.log(interval, month)
            	  if(!interval) {
                	  interval = 'monthly';                	  
            	  }
            	  
            	  if($('.interval-form').val() == 'daily'){
            		  $('#month-form').show();
            	  }else{
            		  $('#month-form').hide();
            	  }
                  
            	  $.ajax({
            		  method: "GET",
            		  url: "/ecommerce/account/getrevenuepanel/"+interval+"/"+month,
            		  //data: { name: "John", location: "Boston" }
            		})
            		  .done(function( msg ) { 
            		    $('#ajax-revenue-panel').html(msg ); 
            		    initCharts();
            		  });
              }
          
          </script>

          <!-- dashboard metric chart -->
          <div class="panel">
            <div class="panel-heading">
              <span class="panel-title" style="float:left"> Revenue &nbsp;&nbsp;&nbsp;&nbsp;</span>
              
              <?php echo form_open($_SERVER['PHP_SELF'], array('name' => 'interval-form', 'method' => 'post', 'class' => 'interval-form', 'style' => 'float:left')); ?>
              <select name="interval" onchange="load_ajax_revenue_panel($(this).val(), '<?php echo (date('m'));?>');if($(this).val()=='daily'){$('#month-form').show();}else{$('#month-form').hide();}">
                  <option value="">Choose Interval</option>
                  <option value="monthly">Monthly</option>
                  <option value="daily">Daily</option>
              </select>
              <?php echo form_close();?>
              
              
              <?php $months = array(1 => 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');?>
              <?php echo form_open($_SERVER['PHP_SELF'], array('name' => 'month-form', 'id' => 'month-form', 'method' => 'post', 'class' => 'month-form', 'style' => 'display:none;float:left')); ?>
              <select name="month" id="month" onchange="load_ajax_revenue_panel('daily', $(this).val());if($(this).val()!=''){$('#month-form').show();}else{$('#month-form').hide();}"> 
                  <option value="">Choose Month</option>
                  <?php for($i = 1; $i <= count($months); $i++):?>
                  <option <?php echo $selected[$i]; ?> value="<?php echo $i;?>"><?php echo $months[$i]; ?></option>
                  <?php endfor;?>
              </select>
              <?php echo form_close();?>
              
          </div>
          
          <div id="ajax-revenue-panel"></div>
          
          </div>
          <!-- recent activity table -->
          <div class="panel">
            <div class="panel-heading">
              <span class="panel-title hidden-xs"> Recent Activity</span>
              <ul class="nav panel-tabs panel-tabs-merge">
                <li class="active">
                  <a href="#tab1_1" data-toggle="tab"> Top Sellers</a>
                </li>
                <li>
                  <a href="#tab1_2" data-toggle="tab"> Most Viewed</a>
                </li>
                <li>
                  <a href="#tab1_3" class="hidden-xs" data-toggle="tab"> New Customers</a>
                </li>
              </ul>
            </div>
            <div class="panel-body pn">
              <div class="table-responsive">
                <table class="table admin-form theme-warning tc-checkbox-1 fs13">
                  <thead>
                    <tr class="bg-light">
                      <th class="">Image</th>
                      <th class="">Order Id</th>
                      <th class="">Product Title</th>
                      <th class="">SKU</th>
                      <th class="">Price</th>
                      <th class="">Quantity</th>
                      <th class="text-right">Status</th>

                    </tr>
                  </thead>
                  <tbody>
                  <?php foreach($topsellers as $ts): ?>
                    <tr>
                      <td class="w100">
                        <img class="img-responsive mw20 ib mr10" title="user" src="/products/productimg/40/<?php echo $ts->order_products[0]->product_id;?>/<?php echo $ts->products[0]->image;?>">
                      </td>
                      <td class=""><?php echo $ts->order_products[0]->order_id;?></td>
                      <td class=""><?php echo $ts->products[0]->name;?></td>
                      <td class="">#<?php echo $ts->products[0]->product_id;?></td>
                      <td class="">$<?php echo number_format($ts->products[0]->retail_price, 2);?></td>
                      <td class=""><?php echo $ts->products[0]->quantity;?></td>
                      <td class="text-right">
                        <div class="btn-group text-right">
                          <button type="button" class="btn btn-success br2 btn-xs fs12 dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Active
                            <span class="caret ml5"></span>
                          </button>
                          <ul class="dropdown-menu" role="menu">
                            <li>
                              <a href="#">Edit</a>
                            </li>
                            <li>
                              <a href="#">Delete</a>
                            </li>
                            <li>
                              <a href="#">Archive</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                              <a href="#">Complete</a>
                            </li>
                            <li class="active">
                              <a href="#">Pending</a>
                            </li>
                            <li>
                              <a href="#">Canceled</a>
                            </li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach;?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          
        
        <!-- end: .tray-center -->

        