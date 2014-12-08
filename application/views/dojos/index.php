<?php if(!defined('BASEPATH')) die('Direct access not allowed'); ?>

<input type='hidden' name='tail' id='tail' value='0'>



<!-- <div class='content'> -->
<div class='container' id='content-container'>
    <!-- <h3>Featured Dojo</h3> -->



    <div class='row'>
    
    	<div class='col-xs-12 col-sm-12 col-md-5 pull-right' id='mapWell'>
            <div class='well affix'>
                <div id='previewMap'></div>


                <!-- saves all the markers to load onto the google map -->
                <div id='savedMarkers'>

                    
                </div>
<!--
                <form>
                    <div class='input-group'>
                    <input type='text' class='form-control' placeholder='Enter your location'>

                    <span class='input-group-btn'>
                    <button type='button' class='btn btn-default inverse'>GET DIRECTIONS</button>
                    </span>
                    </div> 
                </form>
-->
            </div> <!-- .well -->

        </div> <!-- col4 -->
    
        <div class='col-xs-12 col-sm-12 col-md-7 col-bg'>
        
        <?php if (empty($_GET['q'])) : ?>
        	<h3 class="resultstitle"><span class="resultstext">All dojos in </span><?=urldecode($_GET['location'])?></h3>
        <?php else: ?>
        	<h3 class="resultstitle"><?=urldecode($_GET['q'])?><span class="resultstext"> in </span><?=urldecode($_GET['location'])?></h3>
        <?php endif; ?>
        

        <div class='row <?php if (!empty($listings)) echo 'search-results'; ?>'>
            <div class='col-md-12' id='listContent'>

				<?=$initListings?>

                </div> <!-- col-12 -->

            </div> <!-- .row -->
            
            
            <div class='row' id='loadingPanel' style="display:none;">
            	<div class='col-md-12 well'>
            		<h3>Locating more listings...</h3>
            		<i class='fa fa-spin fa-refresh'></i>
            	</div> <!-- .col-12 -->
            </div> <!-- .row -->
            
        </div> <!-- col8 -->



    </div> <!-- .row -->

</div> <!-- .content -->
