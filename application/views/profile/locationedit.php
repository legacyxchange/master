<?php if(!defined('BASEPATH')) die('Direct access not allowed'); ?>

<?php
$attr = array
    (
        'name' => 'locationForm',
        'id' => 'locationForm'
    );

?>

<div class='container page-content'>
<div class="war_bottom">
                     		<h2>SETTINGS</h2>                           
                            <div class="left_list">
                            	<ul class="list list-inline">
                                	<li><a class="menu_link" href="/admin/deals/<?php echo $info->id;?>"><span>Deals</span></a></li>
                                    <li><a class="menu_link" href="#"><span>Menu</span></a></li>
                                    <li><a class="menu_link" href="/profile/locationedit/<?php echo $info->id;?>"><span>Profile</span></a></li>
                                    <li><a class="menu_link" href="/dojos/info/<?=$info->id;?>"><span>Images</span></a></li>
                                    <li><a class="menu_link" href="#"><span>Videos</span></a></li>
                                </ul>
                            </div>
                         </div>
<?php echo form_open_multipart('profile/savelisting', $attr);?>
    <div class='row'>
        <div class='col-md-9 col-bg' id="profile-main-div">
            <h1><?php echo (empty($id)) ? 'Create' : 'Edit'; ?> Listing</h1>

        <div class='form-horizontal'>
<input type='hidden' name='karateToken' value='<?=$this->security->get_csrf_hash()?>'>
    <input type='hidden' name='id' id='id' value='<?=$id?>'>
        <div class="form-group">
            <label class='col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label' for='name'>Business Name</label>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 controls">
                <input type='text' class='form-control' id='name' name='name' value="<?=$info->name?>">
            </div> <!-- .controls -->
        </div> <!-- .form-group -->

        <?php
        /*

        <div class="form-group">
            <label class='col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label' for='position'>Position in Company</label>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 controls">
            <input type='text' class='form-control' id='position' name='position' value="<?=$meta->position?>">
            </div> <!-- .controls -->
        </div> <!-- .form-group -->
        */
        ?>

        <div class="form-group">
            <label class='col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label' for='address'>Address</label>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 controls">
                <input type='text' class='form-control' id='address' name='address' value="<?=$info->address?>">
            </div> <!-- .controls -->
        </div> <!-- .form-group -->
        
        <div class="form-group">
            <label class='col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label' for='address2'>Address Line 2</label>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 controls">
                <input type='text' class='form-control' id='address2' name='address2' value="<?=$info->address2?>">
            </div> <!-- .controls -->
        </div> <!-- .form-group -->


        <div class="form-group">
            <label class='col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label' for='city'>City</label>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 controls">
                <input type='text' class='form-control' id='city' name='city' value="<?=$info->city?>">
            </div> <!-- .controls -->
        </div> <!-- .form-group -->


        <div class="form-group">
            <label class='col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label' for='state'>State</label>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 controls">
            	<select name='state' id='state' class='form-control'>
            	<option value=''></option>
            	<?php
            	if (!empty($states))
            	{
	            	foreach ($states as $k => $v)
	            	{
	            		$sel = ($k == $info->state) ? 'selected' : null;
	            	
		            	echo "<option {$sel} value='{$k}'>{$v}</option>" . PHP_EOL;
	            	}
            	}
            	?>
            	</select>
            </div> <!-- .controls -->
        </div> <!-- .form-group -->


        <div class="form-group">
            <label class='col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label' for='postalCode'>Postal Code</label>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 controls">
                <input type='text' class='form-control' id='postalCode' name='postalCode' value="<?=$info->postalCode?>">
            </div> <!-- .controls -->
        </div> <!-- .form-group -->



        <div class="form-group">
            <label class='col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label' for='phone'>Phone</label>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 controls">
                <input type='text' class='form-control' id='phone' name='phone' value="<?=$info->phone?>">
            </div> <!-- .controls -->
        </div> <!-- .form-group -->

        <div class="form-group">
            <label class='col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label' for='website'>Website</label>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 controls">
                <input type='text' class='form-control' id='website' name='website' value="<?=$info->websiteUrl?>">
            </div> <!-- .controls -->
        </div> <!-- .form-group -->

        <div class="form-group">
            <label class='col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label' for='email'>E-mail</label>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 controls">
                <input type='text' class='form-control' id='email' name='email' value="<?=$info->email?>">
            </div> <!-- .controls -->
        </div> <!-- .form-group -->

        <div class="form-group">
            <label class='col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label' for='styles'>Styles</label>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 controls">
<?php
    if (!empty($styles))
    {
        foreach ($styles as $r)
        {
            $checked = null;

            if (!empty($id))
            {
                if (!empty($assignedStyles))
                {
                    foreach ($assignedStyles as $ar)
                    {
                        if ($ar->code == $r->code)
                        {
                            $checked = "checked='checked'";
                            break;
                        }
                    }
                }
            }

            echo "<div class='checkbox'>
                    <label>
                        <input type='checkbox' name='styles[]' {$checked} value='{$r->code}'> {$r->display}
                    </label>
                </div>";
        }
    }
?>
            </div> <!-- .controls -->
        </div> <!-- .form-group -->


        <div class="form-group">
            <label class='col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label' for='description'>Description</label>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 controls">
                <textarea class='form-control' rows='5' name='description' id='description'><?=$info->description?></textarea>
            </div> <!-- .controls -->
        </div> <!-- .form-group -->

        </div> <!-- form-horizontal -->

        <h3>Images</h3>
<?php
	//echo "<div class='dojologo'><img src='/public/uploads/locationImages/{$id}/{$defaultImg}'></div>";

	if (empty($images))
	{
		$this->alerts->info("No images have been uploaded.");
	}
	else
	{
		echo "<div class='imgContainer'>
		<ul id='imgSortable'>" . PHP_EOL;
	
			foreach ($images as $imgID)
			{
				echo "<li class='ui-state-default' id='img_{$imgID}'>
				
				<img src='/dojos/img/{$id}/100/{$imgID}' style=\"width:100px;height:100px;\">
				<button type='button' class='btn btn-danger btn-xs pic-del-btn' onclick=\"profile.deleteImage(this, {$id}, {$imgID});\"><i class='fa fa-trash-o'></i></button>
				</li>" . PHP_EOL;
			}

		echo "</ul></div>";
		
		//echo "<button type='button' id='deleteImgsBtn' class='btn btn-danger'><i class='fa fa-trash-o'></i></button>";
		
		//echo "<hr>" . PHP_EOL;
	}
?>

        <div id='imageUploadContainer'>

            <div class='imgContainer'>
                <div class='row'>
                    <div class='col-md-6'>
                        <input type='file' name='image[]'>
                    </div> <!-- col-6 -->

                    <div class='col-md-6'>
                        <button type='button' class='btn btn-info pull-right' onclick="profile.addImg(this);"><i class='fa fa-plus'></i></button>
                    </div> <!-- col-6 -->

                </div> <!-- .row -->
            </div> <!-- #imgContainer -->

        </div> <!-- #imageUploadContainer -->

        <h3>Menu/Products</h3>
        
        <div id="menuContainer">
            <div class="row">
                <div class="pull-left">
                    <div class="col-md-3">
                        <div class="input-group col-md-6">
                            <select class="form-control" name="menu[new0][item_type]">
                                <option value="">Choose Type</option>
                            <?php
                            foreach ($menu_options as $optionid => $option)
                            {
                                echo "<option value='$optionid'>$option</option>";
                            }
                            ?>
                            </select>
                        </div>
                        <div class="input-group col-md-6">
                            <input type="text" class="form-control" name="menu[new0][description]" />
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group col-md-2">
                            <input type="text" class="form-control" name="menu[new0][per_g]" /><span class="input-group-addon">/ g</span>
                        </div>
                        <div class="input-group col-md-2">
                            <input type="text" class="form-control" name="menu[new0][per_eighth]" /><span class="input-group-addon">/ 1/8</span>
                        </div>
                        <div class="input-group col-md-2">
                            <input type="text" class="form-control" name="menu[new0][per_quarter]" /><span class="input-group-addon">/ 1/4</span>
                        </div>
                        <div class="input-group col-md-2">
                            <input type="text" class="form-control" name="menu[new0][per_half]" /><span class="input-group-addon">/ 1/2</span>
                        </div>
                        <div class="input-group col-md-2">
                            <input type="text" class="form-control" name="menu[new0][per_oz]" /><span class="input-group-addon">/ oz</span>
                        </div>
                        <div class="input-group col-md-2">
                            <input type="text" class="form-control" name="menu[new0][per_each]" /><span class="input-group-addon">/ ea</span>
                        </div>
                    </div>
                    <input type="hidden" name="menu[new0][menuid]" />
                    <input type="hidden" name="menu[new0][locationid]" value="<?php echo $id; ?>" />
                    <input type="hidden" name="menu[new0][userid]" value="<?php echo $userid; ?>" />
                    <input type="hidden" name="menu[new0][strainid]" value="0" />
                    <input type="hidden" name="menu[new0][active]" value="1" />
                    <div class="col-md-1">
                        <button type='button' class='btn btn-info pull-right' onclick="profile.addItem(this);"><i class='fa fa-plus'></i></button>
                    </div>
                </div>
                <?php
                $x = 0;
                foreach ($menu_items as $menu_item) {
                ?>
                <div class="pull-left">
                    <div class="col-md-3">
                        <div class="input-group col-md-6">
                            <select class="form-control" name="menu[<?php echo $x; ?>][item_type]">
                                <option value="">Choose Type</option>
                            <?php
                            foreach ($menu_options as $optionid => $option)
                            {
                                echo "<option value='$optionid'" . (($optionid == $menu_item->item_type) ? ' SELECTED' : '') . ">$option</option>";
                            }
                            ?>
                            </select>
                        </div>
                        <div class="input-group col-md-6">
                            <input type="text" class="form-control" name="menu[<?php echo $x; ?>][description]" value="<?php echo $menu_item->description; ?>" />
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group col-md-2">
                            <input type="text" class="form-control" name="menu[<?php echo $x; ?>][per_g]" value="<?php echo $menu_item->per_g; ?>" /><span class="input-group-addon">/ g</span>
                        </div>
                        <div class="input-group col-md-2">
                            <input type="text" class="form-control" name="menu[<?php echo $x; ?>][per_eighth]" value="<?php echo $menu_item->per_eighth; ?>" /><span class="input-group-addon">/ 1/8</span>
                        </div>
                        <div class="input-group col-md-2">
                            <input type="text" class="form-control" name="menu[<?php echo $x; ?>][per_quarter]" value="<?php echo $menu_item->per_quarter; ?>" /><span class="input-group-addon">/ 1/4</span>
                        </div>
                        <div class="input-group col-md-2">
                            <input type="text" class="form-control" name="menu[<?php echo $x; ?>][per_half]" value="<?php echo $menu_item->per_half; ?>" /><span class="input-group-addon">/ 1/2</span>
                        </div>
                        <div class="input-group col-md-2">
                            <input type="text" class="form-control" name="menu[<?php echo $x; ?>][per_oz]" value="<?php echo $menu_item->per_oz; ?>" /><span class="input-group-addon">/ oz</span>
                        </div>
                        <div class="input-group col-md-2">
                            <input type="text" class="form-control" name="menu[<?php echo $x; ?>][per_each]" value="<?php echo $menu_item->per_each; ?>" /><span class="input-group-addon">/ ea</span>
                        </div>
                    </div>
                    <input type="hidden" name="menu[<?php echo $x; ?>][menuid]" value="<?php echo $menu_item->menuid; ?>" />
                    <input type="hidden" name="menu[<?php echo $x; ?>][userid]" value="<?php echo $id; ?>" />
                    <input type="hidden" name="menu[<?php echo $x; ?>][strainid]" value="<?php echo $menu_item->strainid; ?>" />
                    <input type="hidden" name="menu[<?php echo $x++; ?>][active]" value="<?php echo $menu_item->active; ?>" />
                    <div class="col-md-1">
                        <button type='button' class='btn btn-danger pull-right' onclick="profile.delItem(this);"><i class='fa fa-trash-o'></i></button>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        
        <hr>

        <h3>Videos</h3>

        <?php
        if (empty($videos))
        {
            echo $this->alerts->info("No videos have been uploaded.");
        }
        else
        {
            echo "<div class='videoThumbnailContainer'>" . PHP_EOL;
            
            foreach ($videos as $r)
            {
                //$videoMeta = $title = null;
                
                try
                {
                    // get meta data for each video
                    //$videoMeta = $this->dojos->getLocMetaData($r->ID);
                    //$title = $this->dojos->getPostTitle($r->ID);
                }
                catch (Exception $e)
                {
                    $this->functions->sendStackTrace($e);
                    continue;
                }
                
                echo "<div class='videoThumbnail' id='videoThumb_{$r->id}' onclick='profile.previewVideo($id, $r->id, \"{$r->title}\", \"{$r->videoID}\");'>" . PHP_EOL;
                
                echo "<img src='{$r->thumbnail}'>";
                
                echo "</div>" . PHP_EOL;
            }
            
            echo "</div> <!-- videoThumbnailContainer -->" . PHP_EOL;
        }
        ?>



        <div class='videoContainer'>

            <div class='vc'>
            <div class='input-group'>
                <input type='text' class='form-control' name='videoUrl[]' id='videoUrl' placeholder='http://youtu.be/CHZ_Jk5d3W4'>
                <span class='input-group-btn'>
                    <button type='button' class='btn btn-info' onclick="profile.addVideo(this);"><i class='fa fa-plus'></i></button>
                </span>
            </div> <!-- form-group -->
            </div>
        </div>
 
        <hr>

		<button type='button' class='btn btn-danger pull-left' id='deleteLocBtn'><i class='fa fa-trash-o'></i></button>
        
        <button type='button' class='btn btn-primary pull-right formbtn' id='saveBtn'><i class='fa fa-save'></i> Save</button>
        <button type='button' class='btn btn-default pull-right formbtn' id='cancelBtn'><i class='fa fa-times-circle'></i> Cancel</button>


        </div> <!-- col9 -->

        <div class='col-md-3'>
            <div class='well'>
                <div id='previewMap'></div>
                     <!-- saves all the markers to load onto the google map -->
                    <div id='savedMarkers'>
                    <?php if (!empty($id)) : ?>
                        <input type='hidden' id='marker' lat='<?=$info->lat?>' lng='<?=$info->lng?>'> 
                    <?php endif; ?>
                    </div>
                <hr>

            <div class="form-group">
            
                <input type='text' class='form-control' name='lat' id='lat' value="<?=$info->lat;?>" placeholder="LATITUDE">
            </div> <!-- .form-group -->
            
            <div class="form-group">
                <input type='text' class='form-control' name='lng' id='lng' value="<?=$info->lng;?>" placeholder="LONGITUDE">
            </div>
            </div>
        </div>
<style>
.time-label{float:left; display:inline; width:100px;}
.time-input{width:110px;}
.mybutton{float:right; margin-top:20px;}
</style>
<script>
$(document).ready(function(){
	$('.mybutton').on('click', function(e){
		e.preventDefault();
		$('#'+e.currentTarget.id+'_opening_time').val('closed');
		$('#'+e.currentTarget.id+'_closing_time').val('closed');		
	});
});
</script>
        <div class='col-md-3'> 
            <h3 style="text-align:center;">Hours of Operation:</h3>
            <div class="form-group"><button id="monday" class="btn btn-xs mybutton">Closed</button>
                <label for="monday_opening_time" class="time-label">MO Open: </label> <input type="time" value="<?php echo isset($location_hours->monday_opening_time) ? $location_hours->monday_opening_time : '06:00:00';?>" class='form-control input-sm time-input' name='monday_opening_time' id='monday_opening_time' placeholder="Monday Opening Time">
                <label for="monday_closing_time" class="time-label">MO Close: </label> <input type="time" value="<?php echo isset($location_hours->monday_closing_time) ? $location_hours->monday_closing_time : '15:00:00';?>" class='form-control input-sm time-input' name='monday_closing_time' id='monday_closing_time' placeholder="Monday Closing Time">
                
            </div>           
            <div class="form-group"><button id="tuesday" class="btn btn-xs mybutton">Closed</button>
                <label for="tuesday_opening_time" class="time-label">TU Open: </label> <input type="time" value="<?php echo isset($location_hours->tuesday_opening_time) ? $location_hours->tuesday_opening_time : '06:00:00';?>" class='form-control input-sm time-input' name='tuesday_opening_time' id='tuesday_opening_time' placeholder="Tuesday Opening Time">
                <label for="tuesday_opening_time" class="time-label">TU Close: </label> <input type="time" value="<?php echo isset($location_hours->tuesday_closing_time) ? $location_hours->tuesday_closing_time : '15:00:00';?>" class='form-control input-sm time-input' name='tuesday_closing_time' id='tuesday_closing_time' placeholder="Tuesday Closing Time">
            </div>
            <div class="form-group"><button id="wednesday" class="btn btn-xs mybutton">Closed</button>
                <label for="wednesday_opening_time" class="time-label">WE Open: </label> <input type="time" value="<?php echo isset($location_hours->wednesday_closing_time) ? $location_hours->wednesday_closing_time : '06:00:00';?>" class='form-control input-sm time-input' name='wednesday_opening_time' id='wednesday_opening_time' placeholder="Tuesday Opening Time">
                <label for="wednesday_opening_time" class="time-label">WE Close: </label> <input type="time" value="<?php echo isset($location_hours->wednesday_closing_time) ? $location_hours->wednesday_closing_time : '15:00:00';?>" class='form-control input-sm time-input' name='wednesday_closing_time' id='wednesday_closing_time' placeholder="Tuesday Closing Time">
            </div>
            <div class="form-group"><button id="thursday" class="btn btn-xs mybutton">Closed</button>
                <label for="thursday_opening_time" class="time-label">TH Open: </label> <input type="time" value="<?php echo isset($location_hours->thursday_closing_time) ? $location_hours->thursday_closing_time : '06:00:00';?>" class='form-control input-sm time-input' name='thursday_opening_time' id='thursday_opening_time' placeholder="Wednesday Opening Time">
                <label for="thursday_opening_time" class="time-label">TH Close: </label> <input type="time" value="<?php echo isset($location_hours->thursday_closing_time) ? $location_hours->thursday_closing_time : '15:00:00';?>" class='form-control input-sm time-input' name='thursday_closing_time' id='thursday_closing_time' placeholder="Wednesday Closing Time">
            </div>
            <div class="form-group"><button id="friday" class="btn btn-xs mybutton">Closed</button>
                <label for="friday_opening_time" class="time-label">FR Open: </label> <input type="time" value="<?php echo isset($location_hours->friday_closing_time) ? $location_hours->friday_closing_time : '06:00:00';?>" class='form-control input-sm time-input' name='friday_opening_time' id='friday_opening_time' placeholder="Thursday Opening Time">
                <label for="friday_opening_time" class="time-label">FR Close: </label> <input type="time" value="<?php echo isset($location_hours->friday_closing_time) ? $location_hours->friday_closing_time : '15:00:00';?>" class='form-control input-sm time-input' name='friday_closing_time' id='friday_closing_time' placeholder="Thursday Closing Time">
            </div>
            <div class="form-group"><button id="saturday" class="btn btn-xs mybutton">Closed</button>
                <label for="saturday_opening_time" class="time-label">SA Open: </label> <input type="time" value="<?php echo isset($location_hours->saturday_closing_time) ? $location_hours->saturday_closing_time : '06:00:00';?>" class='form-control input-sm time-input' name='saturday_opening_time' id='saturday_opening_time' placeholder="Friday Opening Time">
                <label for="saturday_opening_time" class="time-label">SA Close: </label> <input type="time" value="<?php echo isset($location_hours->saturday_closing_time) ? $location_hours->saturday_closing_time : '15:00:00';?>" class='form-control input-sm time-input' name='saturday_closing_time' id='saturday_closing_time' placeholder="Friday Closing Time">
            </div>
            <div class="form-group"><button id="sunday" class="btn btn-xs mybutton">Closed</button>
                <label for="sunday_opening_time" class="time-label">SU Open: </label> <input type="time" value="<?php echo isset($location_hours->sunday_closing_time) ? $location_hours->sunday_closing_time : '06:00:00';?>" class='form-control input-sm time-input' name='sunday_opening_time' id='sunday_opening_time' placeholder="Sunday Opening Time">
                <label for="sunday_opening_time" class="time-label">SU Close: </label> <input type="time" value="<?php echo isset($location_hours->sunday_closing_time) ? $location_hours->sunday_closing_time : '15:00:00';?>" class='form-control input-sm time-input' name='sunday_closing_time' id='sunday_closing_time' placeholder="Sunday Closing Time">
            </div>
        </div>
    </div> <!-- row -->




</div> <!-- .container -->

</form>

<?=$videoModal?>
