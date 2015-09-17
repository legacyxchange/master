<style>.btn-silver{ background-color: #ccc; width: 358px;
    height: 160px;
    margin-bottom: 10px;</style>
<!-- begin: .tray-right -->
        <aside class="tray tray-right tray290 pull-left" data-tray-height="match">

          <!-- menu quick links -->
          <div class="admin-form">

            <h4> Filter Products</h4>

            <hr class="short">

            <div class="section mb15">
              <label for="order-id" class="field prepend-icon">
                <input type="text" name="order-id" id="order-id" class="gui-input" placeholder="Product SKU #">
                <label for="order-id" class="field-icon">
                  <i class="fa fa-tag"></i>
                </label>
              </label>
            </div>

            <h5><small>Price Range($)</small></h5>
            <div class="section row mb15">
              <div class="col-md-6">
                <label for="price1" class="field prepend-icon">
                  <input type="text" name="price1" id="price1" class="gui-input" placeholder="0">
                  <label for="price1" class="field-icon">
                    <i class="fa fa-usd"></i>
                  </label>
                </label>
              </div>
              <div class="col-md-6">
                <label for="price2" class="field prepend-icon">
                  <input type="text" name="price2" id="price2" class="gui-input" placeholder="1000">
                  <label for="price2" class="field-icon">
                    <i class="fa fa-usd"></i>
                  </label>
                </label>
              </div>
            </div>

            <h5><small>Sales Date</small></h5>
            <div class="section row">
              <div class="col-md-6">
                <label for="date1" class="field prepend-icon">
                  <input type="text" name="date1" id="date1" class="gui-input" placeholder="01/01/15">
                  <label for="date1" class="field-icon">
                    <i class="fa fa-calendar"></i>
                  </label>
                </label>
              </div>
              <div class="col-md-6">
                <label for="date2" class="field prepend-icon">
                  <input type="text" name="date2" id="date2" class="gui-input" placeholder="01/31/15">
                  <label for="date2" class="field-icon">
                    <i class="fa fa-calendar"></i>
                  </label>
                </label>
              </div>
            </div>

            <h5><small>Search Categories</small></h5>
            <div class="section mb15">
              <label class="field select">
                <select id="filter-categories" name="filter-categories">
                  <option value="0" selected="selected">Filter by Categories</option>
                  <option value="1">Electronics</option>
                  <option value="2">Software</option>
                </select>
                <i class="arrow double"></i>
              </label>
            </div>

            <h5><small>Search Customers</small></h5>
            <div class="section">
              <label class="field select">
                <select id="filter-customers" name="filter-customers">
                  <option value="0" selected="selected">Filter by Vendor</option>
                  <option value="1">Michael</option>
                  <option value="2">David</option>
                  <option value="3">Sara</option>
                  <option value="4">Tasha</option>
                </select>
                <i class="arrow double"></i>
              </label>
            </div>

            <hr class="short">

            <div class="section">
                <button class="btn btn-default btn-sm ph25" type="button">Search</button>
                <label class="field option ml15">
                  <input type="checkbox" name="info">
                  <span class="checkbox"></span>
                  <span class="text-muted">Save Search</span>
                </label>
            </div>

          </div>

        </aside>
        <!-- end: .tray-right -->


        <!-- begin: .tray-center -->
        <div class="tray col-lg-9 col-md-9">

          <!-- create new order panel -->
          <div class="panel mb25 mt5">
            <div class="panel-heading">
              <span> Add New Product</span>
              <ul class="nav panel-tabs-border panel-tabs">
                <li class="active">
                  <a href="#tab1_1" data-toggle="tab">Product</a>
                </li>
                <li>
                  <a href="#tab1_2" data-toggle="tab">Description</a>
                </li>
                <li>
                  <a href="#tab1_3" data-toggle="tab">List Product</a>
                </li>
                <li>
                  <a href="#tab1_4" data-toggle="tab">Advertise Product</a>
                </li>
                <li>
                  <a href="#tab1_5" data-toggle="tab">Add Funds</a>
                </li>
                <li>
                  <a href="#tab1_6" data-toggle="tab">Shipping</a>
                </li>
              </ul>
            </div>
            <?php //if(!is_null($product->image)){ var_dump($product->image); exit;}?>
            <div class="panel-body p20 pb10">
            <?php echo form_open_multipart("/ecommerce/products/save", array('method' => 'post'));?>            
              <input type="hidden" name="product_id" value="<?php echo ($product->product_id != '') ? $product->product_id : null; ?>" />
              <div class="tab-content pn br-n admin-form">
                  
                <div id="tab1_1" class="tab-pane active">

                  <div class="section row mbn">
                    <div class="col-md-4">
                      <div class="fileupload fileupload-new admin-form" data-provides="fileupload">
                        <div class="">
                        <?php if(!is_null($product->image)):?>
                            <img src="/products/productimg/140/<?=$product->product_id?>/<?php echo isset($product->image) ? $product->image : 0; ?>">
                        <?php else: ?>   
                            <label class="btn btn-silver">
  							Choose File
  							<input type="file" name="avatar" id="avatar" style="display: none" onchange="$(this.form).submit();">
							</label>
					    <?php endif;?>
                        <!-- 
                          <img data-src="holder.js/100%x140" alt="100%x140" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMjk2IiBoZWlnaHQ9IjE0MCIgdmlld0JveD0iMCAwIDI5NiAxNDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjxkZWZzLz48cmVjdCB3aWR0aD0iMjk2IiBoZWlnaHQ9IjE0MCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjExMS42Nzk2ODc1IiB5PSI3MCIgc3R5bGU9ImZpbGw6I0FBQUFBQTtmb250LXdlaWdodDpib2xkO2ZvbnQtZmFtaWx5OkFyaWFsLCBIZWx2ZXRpY2EsIE9wZW4gU2Fucywgc2Fucy1zZXJpZiwgbW9ub3NwYWNlO2ZvbnQtc2l6ZToxNHB0O2RvbWluYW50LWJhc2VsaW5lOmNlbnRyYWwiPjI5NngxNDA8L3RleHQ+PC9nPjwvc3ZnPg==" data-holder-rendered="true" style="height: 140px; width: 100%; display: block;">
                        -->
                        </div>
                        <div class="row">
                          <div class="col-xs-7 pr5">
                            <input type="text" name="name2" id="name2" class="text-center event-name gui-input br-light bg-light" placeholder="Img Keywords">
                            <label for="name2" class="field-icon"></label>
                          </div>
                          <div class="col-xs-5">
                            <label class="btn btn-silver">
  							Change
  							<input type="file" name="avatar" id="avatar" style="display: none" onchange="$(this.form).submit();">
							</label>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-8 pl15">
                      <div class="section mb10">
                        <label for="name2" class="field prepend-icon">
                          <input type="text" name="name2" id="name2" class="event-name gui-input br-light light" placeholder="Product Title">
                          <label for="name2" class="field-icon">
                            <i class="fa fa-tag"></i>
                          </label>
                        </label>
                      </div>
                      <div class="section mb10">
                        <label class="field prepend-icon">
                          <textarea style="height: 160px;" class="gui-textarea br-light bg-light" id="comment" name="comment" placeholder="Product Description"></textarea>
                          <label for="comment" class="field-icon">
                            <i class="fa fa-comments"></i>
                          </label>
                          <span class="input-footer hidden">
                            <strong>Hint:</strong>Don't be negative or off topic! just be awesome...</span>
                        </label>
                      </div>
                    </div>
                  </div>


                </div>
                <div id="tab1_2" class="tab-pane">

                  <div class="section row">
                    <div class="col-md-6">
                      <label for="product-category" class="field select">
                        <select id="product-category" name="product-category">
                          <option value="0" selected="selected">Product Category...</option>
                          <option value="1">Software</option>
                          <option value="2">Computers</option>
                          <option value="3">Gadgets</option>
                          <option value="4">Clothing</option>
                        </select>
                        <i class="arrow double"></i>
                      </label>
                    </div>
                    <!-- end section -->

                    <div class="col-md-6">
                      <label class="field select">
                        <select id="product-status" name="product-status">
                          <option value="0" selected="selected">Product Availability</option>
                          <option value="1">Available</option>
                          <option value="2">Unavailable</option>
                          <option value="3">Discontinued</option>
                          <option value="4">Out of Stock</option>
                        </select>
                        <i class="arrow double"></i>
                      </label>
                    </div>
                    <!-- end section -->

                  </div>
                  <!-- end section row section -->

                  <div class="section row">
                    <div class="col-md-4">
                      <label for="product-price" class="field prepend-icon">
                        <input type="text" name="product-price" id="product-price" class="gui-input" placeholder="Product Price...">
                        <label for="product-price" class="field-icon">
                          <i class="fa fa-usd"></i>
                        </label>
                      </label>
                    </div>
                    <!-- end section -->

                    <div class="col-md-4">
                      <label for="product-vendor" class="field prepend-icon">
                        <input type="text" name="product-vendor" id="product-vendor" class="gui-input" placeholder="Vendor Source...">
                        <label for="product-vendor" class="field-icon">
                          <i class="fa fa-shopping-cart"></i>
                        </label>
                      </label>
                    </div>
                    <!-- end section -->

                    <div class="col-md-4">
                      <label for="product-sku" class="field prepend-icon">
                        <input type="text" name="product-sku" id="product-sku" class="gui-input" placeholder="Product SKU...">
                        <label for="product-sku" class="field-icon">
                          <i class="fa fa-barcode"></i>
                        </label>
                      </label>
                    </div>
                    <!-- end section -->

                  </div>
                  <!-- end section row section -->

                  <div class="section">
                    <input id="tagsinput" type="text" value="Software, Adobe, Photoshop, Editor, Commercial">
                  </div>
                  <!-- end section row section -->
                 
                  <hr class="short alt">
                  
                  <div class="section row mbn">
                    <div class="col-sm-8">
                      <label class="field option mt10">
                        <input type="checkbox" name="info" checked>
                        <span class="checkbox"></span>Save Customer
                        <em class="small-text text-muted">- A Random Unique ID will be generated</em>
                      </label>
                    </div>
                    <div class="col-sm-4">
                      <p class="text-right">
                        <input type="submit" class="btn btn-primary" type="button" value="Save Product" />
                      </p>
                    </div>
                  </div>
                  <!-- end section -->

                </div>
                
                <div id="tab1_3" class="tab-pane">
                    
                    <div class="form-group col-lg-6 col-md-6">
                    <label for="start_date" class="field prepend-icon"><i class="fa fa-calendar"> Start Date</i>
                      <input type="date" name="start_date" id="start_date" class="gui-input" placeholder="Start Date">                     
                    </label>                   
                    </div>
                    <div class="form-group col-lg-6 col-md-6">
                    <label for="end_date" class="field prepend-icon"><i class="fa fa-calendar"> End Date</i>
                      <input type="date" name="end_date" id="end_date" class="gui-input" placeholder="End Date">                     
                    </label>
                    </div>
                    <div class="form-group col-lg-4 col-md-4">
                      <label class="field select">
                        <select id="product-status" name="product-status">
                          <option value="0" selected="selected">List As</option>
                          <?php foreach($listing_types as $val): ?>
					    	  <option value="<?php echo $val->listing_type_id; ?>"><?php echo $val->listing_type; ?></option>
					      <?php endforeach;?>		
                        </select>
                        <i class="arrow double"></i>
                      </label>
                    </div>
                    <div class="form-group col-lg-4 col-md-4">
                      <label for="product-price" class="field prepend-icon">
                        <input type="text" name="product-price" id="product-price" class="gui-input" placeholder="Starting / Asking Price">
                        <label for="product-price" class="field-icon">
                          <i class="fa fa-usd"></i>
                        </label>
                      </label>
                    </div>
                    <div class="form-group col-lg-4 col-md-4">
                      <label for="product-price" class="field prepend-icon">
                        <input type="text" name="product-price" id="product-price" class="gui-input" placeholder="Min. Bid Increment">
                        <label for="product-price" class="field-icon">
                          <i class="fa fa-usd"></i>
                        </label>
                      </label>
                    </div>
                    <div class="form-group col-lg-4 col-md-4">
                      <label for="product-price" class="field prepend-icon">
                        <input type="text" name="reserve-price" id="reserve-price" class="gui-input" placeholder="Reserve Price">
                        <label for="reserve-price" class="field-icon">
                          <i class="fa fa-usd"></i>
                        </label>
                      </label>
                    </div>
                    <div class="form-group col-lg-4 col-md-4">
                      <label class="field select">
                        <select id="accepted-payments" name="accepted-payments">
                          <option value="0" selected="selected">Payment Types</option>
                          <?php foreach($payment_types as $val): ?>
					    	  <option value="<?php echo $val->payment_type_id; ?>"><?php echo $val->payment_type; ?></option>
					      <?php endforeach;?>		
                        </select>
                        <i class="arrow double"></i>
                      </label>
                    </div>
                    <div class="form-group col-lg-4 col-md-4">
                      <label class="field select">
                        <select id="shipping-types" name="shipping-types">
                          <option value="0" selected="selected">Shipping Types</option>
                          <?php foreach($shipping_types as $val): ?>
					    	  <option value="<?php echo $val-shipping_type_id; ?>"><?php echo $val->shipping_type; ?></option>
					      <?php endforeach;?>		
                        </select>
                        <i class="arrow double"></i>
                      </label>
                    </div>
                    <div class="form-group col-lg-4 col-md-4">
                      <label for="weight-ounces" class="field prepend-icon">
                        <input type="text" name="weight-ounces" id="weight-ounces" class="gui-input" placeholder="Weight Ounces">
                        <label for="weight-ounces" class="field-icon">
                          <i class="fa fa-oz"></i>
                        </label>
                      </label>
                    </div>
                    <div class="form-group col-lg-4 col-md-4">
                      <label for="weight-pounds" class="field prepend-icon">
                        <input type="text" name="weight-pounds" id="weight-pounds" class="gui-input" placeholder="Weight Pounds">
                        <label for="weight-pounds" class="field-icon">
                          <i class="fa fa-oz"></i>
                        </label>
                      </label>
                    </div>
                    <div class="form-group col-lg-4 col-md-4">
                    	<label for="retail_price">Dimensions (Inches)</label> <br />
					<input type="text" size="1" name="length" placeholder="  L" value="" /> <input placeholder="  W" type="text" size="1" name="width" value="" /> <input placeholder="  H" size="1" type="text" name="height" value="" />
                    </div>
                </div>
                
                <div id="tab1_5" class="tab-pane">
                  <div class="section">
                    <label class="field option">
                      <input type="radio" name="payment" checked>
                      <span class="radio"></span>Credit Card</label>
                    <label class="field option">
                      <input type="radio" name="payment">
                      <span class="radio"></span>Paypal</label>
                    <label class="field option">
                      <input type="radio" name="payment">
                      <span class="radio"></span>Check</label>
                  </div>
                  <!-- end section -->

                  <div class="section">
                    <label for="cardname" class="field prepend-icon">
                      <input type="text" name="cardname" id="cardname" class="gui-input" placeholder="Name on card...">
                      <label for="cardname" class="field-icon">
                        <i class="fa fa-user"></i>
                      </label>
                    </label>
                  </div>
                  <!-- end section -->

                  <div class="section">
                    <label for="cardno" class="field prepend-icon">
                      <input type="text" name="cardno" id="lastname" class="gui-input" placeholder="Card number...">
                      <label for="cardno" class="field-icon">
                        <i class="fa fa-credit-card"></i>
                      </label>
                    </label>
                  </div>
                  <!-- end section -->

                  <div class="section row">
                    <div class="col-md-6">
                      <label for="cardmonth" class="field select">
                        <select id="cardmonth" name="cardmonth">
                          <option value="">Expiry month...</option>
                          <option value="01">01 - Jan</option>
                          <option value="02">02 - Feb</option>
                          <option value="03">03 - Mar</option>
                          <option value="04">04 - Apr</option>
                          <option value="05">05 - May</option>
                          <option value="06">06 - Jun</option>
                          <option value="07">07 - Jul</option>
                          <option value="08">08 - Aug</option>
                          <option value="09">09 - Sep</option>
                          <option value="10">10 - Oct</option>
                          <option value="11">11 - Nov</option>
                          <option value="12">12 - Dec</option>
                        </select>
                        <i class="arrow double"></i>
                      </label>
                    </div>
                    <!-- end section -->

                    <div class="col-md-6">
                      <label class="field select">
                        <select id="cardyear" name="cardyear">
                          <option value="">Expiry year...</option>
                          <option value="2014">2014</option>
                          <option value="2015">2015</option>
                          <option value="2016">2016</option>
                          <option value="2017">2017</option>
                          <option value="2018">2018</option>
                          <option value="2019">2019</option>
                          <option value="2020">2020</option>
                          <option value="2021">2021</option>
                          <option value="2022">2022</option>
                          <option value="2023">2023</option>
                          <option value="2024">2024</option>
                          <option value="2025">2025</option>
                          <option value="2026">2026</option>
                        </select>
                        <i class="arrow double"></i>
                      </label>
                    </div>
                    <!-- end section -->

                  </div>
                  <!-- end section row section -->

                  <div class="section row">
                    <div class="col-md-6">
                      <label for="secno" class="field prepend-icon">
                        <input type="text" name="secno" id="secno" class="gui-input" placeholder="Security number...">
                        <b class="tooltip tip-left-top"><em> This is a four diigit number at the back of your card </em></b>
                        <label for="secno" class="field-icon">
                          <i class="fa fa-barcode"></i>
                        </label>
                      </label>
                    </div>
                    <!-- end section -->

                    <div class="col-md-6">
                      <p class="field-align">
                        <a href="#" class="theme-link"> What is this? </a>
                      </p>
                    </div>
                    <!-- end section -->

                  </div>
                  <!-- end section row section -->

                </div>
                
                <div id="tab1_6" class="tab-pane">

                  <div class="section">
                    <label for="lastaddr" class="field prepend-icon">
                      <input type="text" name="lastaddr" id="lastaddr" class="gui-input" placeholder="Street address">
                      <label for="lastaddr" class="field-icon">
                        <i class="fa fa-map-marker"></i>
                      </label>
                    </label>
                  </div>
                  <!-- end section -->

                  <div class="section">
                    <label class="field select">
                      <select id="location" name="location">
                        <option value="">Select country...</option>
                        <option value="AL">Albania</option>
                        <option value="DZ">Algeria</option>
                        <option value="AD">Andorra</option>
                        <option value="AO">Angola</option>
                        <option value="AI">Anguilla</option>
                        <option value="AG">Antigua and Barbuda</option>
                        <option value="AR">Argentina</option>
                        <option value="AM">Armenia</option>
                        <option value="AW">Aruba</option>
                        <option value="AU">Australia</option>
                        <option value="AT">Austria</option>
                        <option value="AZ">Azerbaijan Republic</option>
                        <option value="BS">Bahamas</option>
                        <option value="BH">Bahrain</option>
                        <option value="BB">Barbados</option>
                        <option value="BE">Belgium</option>
                        <option value="BZ">Belize</option>
                        <option value="BJ">Benin</option>
                        <option value="BM">Bermuda</option>
                        <option value="BT">Bhutan</option>
                        <option value="BO">Bolivia</option>
                        <option value="BA">Bosnia and Herzegovina</option>
                        <option value="BW">Botswana</option>
                        <option value="BR">Brazil</option>
                        <option value="BN">Brunei</option>
                        <option value="BG">Bulgaria</option>
                        <option value="BF">Burkina Faso</option>
                        <option value="BI">Burundi</option>
                        <option value="KH">Cambodia</option>
                        <option value="CA">Canada</option>
                        <option value="CV">Cape Verde</option>
                        <option value="KY">Cayman Islands</option>
                        <option value="TD">Chad</option>
                        <option value="CL">Chile</option>
                        <option value="C2">China Worldwide</option>
                        <option value="CO">Colombia</option>
                        <option value="KM">Comoros</option>
                        <option value="CK">Cook Islands</option>
                        <option value="CR">Costa Rica</option>
                        <option value="HR">Croatia</option>
                        <option value="CY">Cyprus</option>
                        <option value="CZ">Czech Republic</option>
                        <option value="CD">Democratic Republic of the Congo</option>
                        <option value="DK">Denmark</option>
                        <option value="DJ">Djibouti</option>
                        <option value="DM">Dominica</option>
                        <option value="DO">Dominican Republic</option>
                        <option value="EC">Ecuador</option>
                        <option value="EG">Egypt</option>
                        <option value="SV">El Salvador</option>
                        <option value="ER">Eritrea</option>
                        <option value="EE">Estonia</option>
                        <option value="ET">Ethiopia</option>
                        <option value="FK">Falkland Islands</option>
                        <option value="FO">Faroe Islands</option>
                        <option value="FJ">Fiji</option>
                        <option value="FI">Finland</option>
                        <option value="FR">France</option>
                        <option value="GF">French Guiana</option>
                        <option value="PF">French Polynesia</option>
                        <option value="GA">Gabon Republic</option>
                        <option value="GM">Gambia</option>
                        <option value="GE">Georgia</option>
                        <option value="DE">Germany</option>
                        <option value="GI">Gibraltar</option>
                        <option value="GR">Greece</option>
                        <option value="GL">Greenland</option>
                        <option value="GD">Grenada</option>
                        <option value="GP">Guadeloupe</option>
                        <option value="GT">Guatemala</option>
                        <option value="GN">Guinea</option>
                        <option value="GW">Guinea Bissau</option>
                        <option value="GY">Guyana</option>
                        <option value="HN">Honduras</option>
                        <option value="HK">Hong Kong</option>
                        <option value="HU">Hungary</option>
                        <option value="IS">Iceland</option>
                        <option value="IN">India</option>
                        <option value="ID">Indonesia</option>
                        <option value="IE">Ireland</option>
                        <option value="IL">Israel</option>
                        <option value="IT">Italy</option>
                        <option value="JM">Jamaica</option>
                        <option value="JP">Japan</option>
                        <option value="JO">Jordan</option>
                        <option value="KZ">Kazakhstan</option>
                        <option value="KE">Kenya</option>
                        <option value="KI">Kiribati</option>
                        <option value="KW">Kuwait</option>
                        <option value="KG">Kyrgyzstan</option>
                        <option value="LA">Laos</option>
                        <option value="LV">Latvia</option>
                        <option value="LS">Lesotho</option>
                        <option value="LI">Liechtenstein</option>
                        <option value="LT">Lithuania</option>
                        <option value="LU">Luxembourg</option>
                        <option value="MG">Madagascar</option>
                        <option value="MW">Malawi</option>
                        <option value="MY">Malaysia</option>
                        <option value="MV">Maldives</option>
                        <option value="ML">Mali</option>
                        <option value="MT">Malta</option>
                        <option value="MH">Marshall Islands</option>
                        <option value="MQ">Martinique</option>
                        <option value="MR">Mauritania</option>
                        <option value="MU">Mauritius</option>
                        <option value="YT">Mayotte</option>
                        <option value="MX">Mexico</option>
                        <option value="FM">Micronesia</option>
                        <option value="MN">Mongolia</option>
                        <option value="MS">Montserrat</option>
                        <option value="MA">Morocco</option>
                        <option value="MZ">Mozambique</option>
                        <option value="NA">Namibia</option>
                        <option value="NR">Nauru</option>
                        <option value="NP">Nepal</option>
                        <option value="NL">Netherlands</option>
                        <option value="AN">Netherlands Antilles</option>
                        <option value="NC">New Caledonia</option>
                        <option value="NZ">New Zealand</option>
                        <option value="NI">Nicaragua</option>
                        <option value="NE">Niger</option>
                        <option value="NU">Niue</option>
                        <option value="NF">Norfolk Island</option>
                        <option value="NO">Norway</option>
                        <option value="OM">Oman</option>
                        <option value="PW">Palau</option>
                        <option value="PA">Panama</option>
                        <option value="PG">Papua New Guinea</option>
                        <option value="PE">Peru</option>
                        <option value="PH">Philippines</option>
                        <option value="PN">Pitcairn Islands</option>
                        <option value="PL">Poland</option>
                        <option value="PT">Portugal</option>
                        <option value="QA">Qatar</option>
                        <option value="CG">Republic of the Congo</option>
                        <option value="RE">Reunion</option>
                        <option value="RO">Romania</option>
                        <option value="RU">Russia</option>
                        <option value="RW">Rwanda</option>
                        <option value="KN">Saint Kitts and Nevis Anguilla</option>
                        <option value="PM">Saint Pierre and Miquelon</option>
                        <option value="VC">Saint Vincent and Grenadines</option>
                        <option value="WS">Samoa</option>
                        <option value="SM">San Marino</option>
                        <option value="ST">São Tomé and Príncipe</option>
                        <option value="SA">Saudi Arabia</option>
                        <option value="SN">Senegal</option>
                        <option value="RS">Serbia</option>
                        <option value="SC">Seychelles</option>
                        <option value="SL">Sierra Leone</option>
                        <option value="SG">Singapore</option>
                        <option value="SK">Slovakia</option>
                        <option value="SI">Slovenia</option>
                        <option value="SB">Solomon Islands</option>
                        <option value="SO">Somalia</option>
                        <option value="ZA">South Africa</option>
                        <option value="KR">South Korea</option>
                        <option value="ES">Spain</option>
                        <option value="LK">Sri Lanka</option>
                        <option value="SH">St. Helena</option>
                        <option value="LC">St. Lucia</option>
                        <option value="SR">Suriname</option>
                        <option value="SJ">Svalbard and Jan Mayen Islands</option>
                        <option value="SZ">Swaziland</option>
                        <option value="SE">Sweden</option>
                        <option value="CH">Switzerland</option>
                        <option value="TW">Taiwan</option>
                        <option value="TJ">Tajikistan</option>
                        <option value="TZ">Tanzania</option>
                        <option value="TH">Thailand</option>
                        <option value="TG">Togo</option>
                        <option value="TO">Tonga</option>
                        <option value="TT">Trinidad and Tobago</option>
                        <option value="TN">Tunisia</option>
                        <option value="TR">Turkey</option>
                        <option value="TM">Turkmenistan</option>
                        <option value="TC">Turks and Caicos Islands</option>
                        <option value="TV">Tuvalu</option>
                        <option value="UG">Uganda</option>
                        <option value="UA">Ukraine</option>
                        <option value="AE">United Arab Emirates</option>
                        <option value="GB">United Kingdom</option>
                        <option value="US">United States</option>
                        <option value="UY">Uruguay</option>
                        <option value="VU">Vanuatu</option>
                        <option value="VA">Vatican City State</option>
                        <option value="VE">Venezuela</option>
                        <option value="VN">Vietnam</option>
                        <option value="VG">Virgin Islands (British)</option>
                        <option value="WF">Wallis and Futuna Islands</option>
                        <option value="YE">Yemen</option>
                        <option value="ZM">Zambia</option>
                      </select>
                      <i class="arrow double"></i>
                    </label>
                  </div>
                  <!-- end section -->

                  <div class="section row">
                    <div class="col-md-3">
                      <label for="zip" class="field prepend-icon">
                        <input type="text" name="zip" id="zip" class="gui-input" placeholder="Zip">
                        <label for="zip" class="field-icon">
                          <i class="fa fa-certificate"></i>
                        </label>
                      </label>
                    </div>
                    <!-- end section -->

                    <div class="col-md-4">
                      <label for="city" class="field prepend-icon">
                        <input type="text" name="city" id="city" class="gui-input" placeholder="City">
                        <label for="city" class="field-icon">
                          <i class="fa fa-building-o"></i>
                        </label>
                      </label>
                    </div>
                    <!-- end section -->

                    <div class="col-md-5">
                      <label for="states" class="field select">
                        <select id="states" name="states">
                          <option value="">Choose state</option>
                          <option value="AL">Alabama</option>
                          <option value="AK">Alaska</option>
                          <option value="AZ">Arizona</option>
                          <option value="AR">Arkansas</option>
                          <option value="CA">California</option>
                          <option value="CO">Colorado</option>
                          <option value="CT">Connecticut</option>
                          <option value="DE">Delaware</option>
                          <option value="DC">District Of Columbia</option>
                          <option value="FL">Florida</option>
                          <option value="GA">Georgia</option>
                          <option value="HI">Hawaii</option>
                          <option value="ID">Idaho</option>
                          <option value="IL">Illinois</option>
                          <option value="IN">Indiana</option>
                          <option value="IA">Iowa</option>
                          <option value="KS">Kansas</option>
                          <option value="KY">Kentucky</option>
                          <option value="LA">Louisiana</option>
                          <option value="ME">Maine</option>
                          <option value="MD">Maryland</option>
                          <option value="MA">Massachusetts</option>
                          <option value="MI">Michigan</option>
                          <option value="MN">Minnesota</option>
                          <option value="MS">Mississippi</option>
                          <option value="MO">Missouri</option>
                          <option value="MT">Montana</option>
                          <option value="NE">Nebraska</option>
                          <option value="NV">Nevada</option>
                          <option value="NH">New Hampshire</option>
                          <option value="NJ">New Jersey</option>
                          <option value="NM">New Mexico</option>
                          <option value="NY">New York</option>
                          <option value="NC">North Carolina</option>
                          <option value="ND">North Dakota</option>
                          <option value="OH">Ohio</option>
                          <option value="OK">Oklahoma</option>
                          <option value="OR">Oregon</option>
                          <option value="PA">Pennsylvania</option>
                          <option value="RI">Rhode Island</option>
                          <option value="SC">South Carolina</option>
                          <option value="SD">South Dakota</option>
                          <option value="TN">Tennessee</option>
                          <option value="TX">Texas</option>
                          <option value="UT">Utah</option>
                          <option value="VT">Vermont</option>
                          <option value="VA">Virginia</option>
                          <option value="WA">Washington</option>
                          <option value="WV">West Virginia</option>
                          <option value="WI">Wisconsin</option>
                          <option value="WY">Wyoming</option>
                        </select>
                        <i class="arrow double"></i>
                      </label>
                    </div>
                    <!-- end .col8 section -->

                  </div>
                  <!-- end section row section -->

                  <div class="section row mbn">
                    <div class="col-sm-8">
                      <label class="field option mt10">
                        <input type="checkbox" name="info" checked>
                        <span class="checkbox"></span>Save Customer
                        <em class="small-text text-muted">- A Random Unique ID will be generated</em>
                      </label>
                    </div>
                    <div class="col-sm-4">
                      <p class="text-right">
                        <button class="btn btn-primary" type="button">Save Order</button>
                      </p>
                    </div>
                  </div>
                  <!-- end section -->

                </div>              
             
                
                <div id="tab1_4" class="tab-pane">

                  <div class="section">
                    <label for="lastaddr" class="field prepend-icon">
                      <input type="text" name="lastaddr" id="lastaddr" class="gui-input" placeholder="Street address 2">
                      <label for="lastaddr" class="field-icon">
                        <i class="fa fa-map-marker"></i>
                      </label>
                    </label>
                  </div>
                  <!-- end section -->

                  <div class="section">
                    <label class="field select">
                      <select id="location" name="location">
                        <option value="">Select country...</option>
                        <option value="AL">Albania</option>
                        <option value="DZ">Algeria</option>
                        <option value="AD">Andorra</option>
                        <option value="AO">Angola</option>
                        <option value="AI">Anguilla</option>
                        <option value="AG">Antigua and Barbuda</option>
                        <option value="AR">Argentina</option>
                        <option value="AM">Armenia</option>
                        <option value="AW">Aruba</option>
                        <option value="AU">Australia</option>
                        <option value="AT">Austria</option>
                        <option value="AZ">Azerbaijan Republic</option>
                        <option value="BS">Bahamas</option>
                        <option value="BH">Bahrain</option>
                        <option value="BB">Barbados</option>
                        <option value="BE">Belgium</option>
                        <option value="BZ">Belize</option>
                        <option value="BJ">Benin</option>
                        <option value="BM">Bermuda</option>
                        <option value="BT">Bhutan</option>
                        <option value="BO">Bolivia</option>
                        <option value="BA">Bosnia and Herzegovina</option>
                        <option value="BW">Botswana</option>
                        <option value="BR">Brazil</option>
                        <option value="BN">Brunei</option>
                        <option value="BG">Bulgaria</option>
                        <option value="BF">Burkina Faso</option>
                        <option value="BI">Burundi</option>
                        <option value="KH">Cambodia</option>
                        <option value="CA">Canada</option>
                        <option value="CV">Cape Verde</option>
                        <option value="KY">Cayman Islands</option>
                        <option value="TD">Chad</option>
                        <option value="CL">Chile</option>
                        <option value="C2">China Worldwide</option>
                        <option value="CO">Colombia</option>
                        <option value="KM">Comoros</option>
                        <option value="CK">Cook Islands</option>
                        <option value="CR">Costa Rica</option>
                        <option value="HR">Croatia</option>
                        <option value="CY">Cyprus</option>
                        <option value="CZ">Czech Republic</option>
                        <option value="CD">Democratic Republic of the Congo</option>
                        <option value="DK">Denmark</option>
                        <option value="DJ">Djibouti</option>
                        <option value="DM">Dominica</option>
                        <option value="DO">Dominican Republic</option>
                        <option value="EC">Ecuador</option>
                        <option value="EG">Egypt</option>
                        <option value="SV">El Salvador</option>
                        <option value="ER">Eritrea</option>
                        <option value="EE">Estonia</option>
                        <option value="ET">Ethiopia</option>
                        <option value="FK">Falkland Islands</option>
                        <option value="FO">Faroe Islands</option>
                        <option value="FJ">Fiji</option>
                        <option value="FI">Finland</option>
                        <option value="FR">France</option>
                        <option value="GF">French Guiana</option>
                        <option value="PF">French Polynesia</option>
                        <option value="GA">Gabon Republic</option>
                        <option value="GM">Gambia</option>
                        <option value="GE">Georgia</option>
                        <option value="DE">Germany</option>
                        <option value="GI">Gibraltar</option>
                        <option value="GR">Greece</option>
                        <option value="GL">Greenland</option>
                        <option value="GD">Grenada</option>
                        <option value="GP">Guadeloupe</option>
                        <option value="GT">Guatemala</option>
                        <option value="GN">Guinea</option>
                        <option value="GW">Guinea Bissau</option>
                        <option value="GY">Guyana</option>
                        <option value="HN">Honduras</option>
                        <option value="HK">Hong Kong</option>
                        <option value="HU">Hungary</option>
                        <option value="IS">Iceland</option>
                        <option value="IN">India</option>
                        <option value="ID">Indonesia</option>
                        <option value="IE">Ireland</option>
                        <option value="IL">Israel</option>
                        <option value="IT">Italy</option>
                        <option value="JM">Jamaica</option>
                        <option value="JP">Japan</option>
                        <option value="JO">Jordan</option>
                        <option value="KZ">Kazakhstan</option>
                        <option value="KE">Kenya</option>
                        <option value="KI">Kiribati</option>
                        <option value="KW">Kuwait</option>
                        <option value="KG">Kyrgyzstan</option>
                        <option value="LA">Laos</option>
                        <option value="LV">Latvia</option>
                        <option value="LS">Lesotho</option>
                        <option value="LI">Liechtenstein</option>
                        <option value="LT">Lithuania</option>
                        <option value="LU">Luxembourg</option>
                        <option value="MG">Madagascar</option>
                        <option value="MW">Malawi</option>
                        <option value="MY">Malaysia</option>
                        <option value="MV">Maldives</option>
                        <option value="ML">Mali</option>
                        <option value="MT">Malta</option>
                        <option value="MH">Marshall Islands</option>
                        <option value="MQ">Martinique</option>
                        <option value="MR">Mauritania</option>
                        <option value="MU">Mauritius</option>
                        <option value="YT">Mayotte</option>
                        <option value="MX">Mexico</option>
                        <option value="FM">Micronesia</option>
                        <option value="MN">Mongolia</option>
                        <option value="MS">Montserrat</option>
                        <option value="MA">Morocco</option>
                        <option value="MZ">Mozambique</option>
                        <option value="NA">Namibia</option>
                        <option value="NR">Nauru</option>
                        <option value="NP">Nepal</option>
                        <option value="NL">Netherlands</option>
                        <option value="AN">Netherlands Antilles</option>
                        <option value="NC">New Caledonia</option>
                        <option value="NZ">New Zealand</option>
                        <option value="NI">Nicaragua</option>
                        <option value="NE">Niger</option>
                        <option value="NU">Niue</option>
                        <option value="NF">Norfolk Island</option>
                        <option value="NO">Norway</option>
                        <option value="OM">Oman</option>
                        <option value="PW">Palau</option>
                        <option value="PA">Panama</option>
                        <option value="PG">Papua New Guinea</option>
                        <option value="PE">Peru</option>
                        <option value="PH">Philippines</option>
                        <option value="PN">Pitcairn Islands</option>
                        <option value="PL">Poland</option>
                        <option value="PT">Portugal</option>
                        <option value="QA">Qatar</option>
                        <option value="CG">Republic of the Congo</option>
                        <option value="RE">Reunion</option>
                        <option value="RO">Romania</option>
                        <option value="RU">Russia</option>
                        <option value="RW">Rwanda</option>
                        <option value="KN">Saint Kitts and Nevis Anguilla</option>
                        <option value="PM">Saint Pierre and Miquelon</option>
                        <option value="VC">Saint Vincent and Grenadines</option>
                        <option value="WS">Samoa</option>
                        <option value="SM">San Marino</option>
                        <option value="ST">São Tomé and Príncipe</option>
                        <option value="SA">Saudi Arabia</option>
                        <option value="SN">Senegal</option>
                        <option value="RS">Serbia</option>
                        <option value="SC">Seychelles</option>
                        <option value="SL">Sierra Leone</option>
                        <option value="SG">Singapore</option>
                        <option value="SK">Slovakia</option>
                        <option value="SI">Slovenia</option>
                        <option value="SB">Solomon Islands</option>
                        <option value="SO">Somalia</option>
                        <option value="ZA">South Africa</option>
                        <option value="KR">South Korea</option>
                        <option value="ES">Spain</option>
                        <option value="LK">Sri Lanka</option>
                        <option value="SH">St. Helena</option>
                        <option value="LC">St. Lucia</option>
                        <option value="SR">Suriname</option>
                        <option value="SJ">Svalbard and Jan Mayen Islands</option>
                        <option value="SZ">Swaziland</option>
                        <option value="SE">Sweden</option>
                        <option value="CH">Switzerland</option>
                        <option value="TW">Taiwan</option>
                        <option value="TJ">Tajikistan</option>
                        <option value="TZ">Tanzania</option>
                        <option value="TH">Thailand</option>
                        <option value="TG">Togo</option>
                        <option value="TO">Tonga</option>
                        <option value="TT">Trinidad and Tobago</option>
                        <option value="TN">Tunisia</option>
                        <option value="TR">Turkey</option>
                        <option value="TM">Turkmenistan</option>
                        <option value="TC">Turks and Caicos Islands</option>
                        <option value="TV">Tuvalu</option>
                        <option value="UG">Uganda</option>
                        <option value="UA">Ukraine</option>
                        <option value="AE">United Arab Emirates</option>
                        <option value="GB">United Kingdom</option>
                        <option value="US">United States</option>
                        <option value="UY">Uruguay</option>
                        <option value="VU">Vanuatu</option>
                        <option value="VA">Vatican City State</option>
                        <option value="VE">Venezuela</option>
                        <option value="VN">Vietnam</option>
                        <option value="VG">Virgin Islands (British)</option>
                        <option value="WF">Wallis and Futuna Islands</option>
                        <option value="YE">Yemen</option>
                        <option value="ZM">Zambia</option>
                      </select>
                      <i class="arrow double"></i>
                    </label>
                  </div>
                  <!-- end section -->

                  <div class="section row">
                    <div class="col-md-3">
                      <label for="zip" class="field prepend-icon">
                        <input type="text" name="zip" id="zip" class="gui-input" placeholder="Zip">
                        <label for="zip" class="field-icon">
                          <i class="fa fa-certificate"></i>
                        </label>
                      </label>
                    </div>
                    <!-- end section -->

                    <div class="col-md-4">
                      <label for="city" class="field prepend-icon">
                        <input type="text" name="city" id="city" class="gui-input" placeholder="City">
                        <label for="city" class="field-icon">
                          <i class="fa fa-building-o"></i>
                        </label>
                      </label>
                    </div>
                    <!-- end section -->

                    <div class="col-md-5">
                      <label for="states" class="field select">
                        <select id="states" name="states">
                          <option value="">Choose state</option>
                          <option value="AL">Alabama</option>
                          <option value="AK">Alaska</option>
                          <option value="AZ">Arizona</option>
                          <option value="AR">Arkansas</option>
                          <option value="CA">California</option>
                          <option value="CO">Colorado</option>
                          <option value="CT">Connecticut</option>
                          <option value="DE">Delaware</option>
                          <option value="DC">District Of Columbia</option>
                          <option value="FL">Florida</option>
                          <option value="GA">Georgia</option>
                          <option value="HI">Hawaii</option>
                          <option value="ID">Idaho</option>
                          <option value="IL">Illinois</option>
                          <option value="IN">Indiana</option>
                          <option value="IA">Iowa</option>
                          <option value="KS">Kansas</option>
                          <option value="KY">Kentucky</option>
                          <option value="LA">Louisiana</option>
                          <option value="ME">Maine</option>
                          <option value="MD">Maryland</option>
                          <option value="MA">Massachusetts</option>
                          <option value="MI">Michigan</option>
                          <option value="MN">Minnesota</option>
                          <option value="MS">Mississippi</option>
                          <option value="MO">Missouri</option>
                          <option value="MT">Montana</option>
                          <option value="NE">Nebraska</option>
                          <option value="NV">Nevada</option>
                          <option value="NH">New Hampshire</option>
                          <option value="NJ">New Jersey</option>
                          <option value="NM">New Mexico</option>
                          <option value="NY">New York</option>
                          <option value="NC">North Carolina</option>
                          <option value="ND">North Dakota</option>
                          <option value="OH">Ohio</option>
                          <option value="OK">Oklahoma</option>
                          <option value="OR">Oregon</option>
                          <option value="PA">Pennsylvania</option>
                          <option value="RI">Rhode Island</option>
                          <option value="SC">South Carolina</option>
                          <option value="SD">South Dakota</option>
                          <option value="TN">Tennessee</option>
                          <option value="TX">Texas</option>
                          <option value="UT">Utah</option>
                          <option value="VT">Vermont</option>
                          <option value="VA">Virginia</option>
                          <option value="WA">Washington</option>
                          <option value="WV">West Virginia</option>
                          <option value="WI">Wisconsin</option>
                          <option value="WY">Wyoming</option>
                        </select>
                        <i class="arrow double"></i>
                      </label>
                    </div>
                    <!-- end .col8 section -->

                  </div>
                  <!-- end section row section -->

                  <div class="section row mbn">
                    <div class="col-sm-8">
                      <label class="field option mt10">
                        <input type="checkbox" name="info" checked>
                        <span class="checkbox"></span>Save Customer
                        <em class="small-text text-muted">- A Random Unique ID will be generated</em>
                      </label>
                    </div>
                    <div class="col-sm-4">
                      <p class="text-right">
                        <button class="btn btn-primary" type="button">Save Order</button>
                      </p>
                    </div>
                  </div>
                  <!-- end section -->

</form>
                </div>
              </div>
            </div>
          </div>

          <!-- recent orders table -->
          <div class="panel">
            <div class="panel-menu p12 admin-form theme-primary">
              <div class="row">
                <div class="col-md-5">
                  <label class="field select">
                    <select id="filter-category" name="filter-category">
                      <option value="0">Filter by Category</option>
                      <option value="1">Baseball</option>
                      <option value="2">Football</option>
                      <option value="3">Hockey</option>
                      <option value="4">Soccer</option>
                      <option value="5">Golf</option>
                    </select>
                    <i class="arrow"></i>
                  </label>
                </div>
                <div class="col-md-5">
                  <label class="field select">
                    <select id="filter-status" name="filter-status">
                      <option value="0">Filter by Status</option>
                      <option value="1">Active</option>
                      <option value="2">Inactive</option>
                      <option value="3">Low Stock</option>
                      <option value="4">Out of Stock</option>
                    </select>
                    <i class="arrow"></i>
                  </label>
                </div>
                <div class="col-md-2">
                  <label class="field select">
                    <select id="bulk-action" name="bulk-action">
                      <option value="0">Actions</option>
                      <option value="1">Edit</option>
                      <option value="2">Delete</option>
                      <option value="3">Active</option>
                      <option value="4">Inactive</option>
                    </select>
                    <i class="arrow double"></i>
                  </label>
                </div>
              </div>
            </div>
            <div class="panel-body pn">
              <div class="table-responsive">
                <table class="table admin-form theme-warning tc-checkbox-1 fs13">
                  <thead>
                    <tr class="bg-light">
                      <th class="text-center">Select</th>
                      <th class="">Image</th>
                      <th class="">Product Title</th>
                      <th class="">SKU</th>
                      <th class="">Price</th>
                      <th class="">Stock</th>
                      <th class="text-right">Status</th>

                    </tr>
                  </thead>
                  <tbody>
                  <?php foreach($products as $p):?>
                    <tr>
                      <td class="text-center">
                        <label class="option block mn">
                          <input type="checkbox" name="mobileos" value="FR">
                          <span class="checkbox mn"></span>
                        </label>
                      </td>
                      <td class="w100">
                        <img src="/products/productimg/40/<?php echo $p->product_id;?>/<?php echo $p->image;?>" />
                      </td>
                      <td class=""><?php echo $p->name;?></td>
                      <td class=""><?php echo $p->product_id;?></td>
                      <td class="">$<?php echo $p->retail_price;?></td>
                      <td class=""><?php echo $p->quantity;?></td>
                      <td class="text-right">
                        <div class="btn-group text-right">
                          <button type="button" class="btn btn-success br2 btn-xs fs12 dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <?php echo ($p->active == 1) ? 'Active' : 'DeActivated';?>
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

        </div>
        <!-- end: .tray-center -->

        
        