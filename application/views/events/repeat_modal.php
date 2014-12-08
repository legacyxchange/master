<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="modal fade" id='repeatEventModal'>
  <div class="modal-dialog">
    <div class="modal-content">

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title">Repeat Event</h3>
      </div> <!-- modal-header -->
      

      <div class="modal-body form-horizontal">
		  <div id='repeatModalAlert'></div>

		  <div class="form-group">
		      <label for="" class="col-md-3 control-label">Repeats</label>
			  <div class="col-md-9">
		  		<select class='form-control' name='repeatType' id='repeatType'>
		  		<?php
		  		if (!empty($repeatTypes))
		  		{
			  		foreach ($repeatTypes as $r)
			  		{
			  			if (empty($id)) $sel = ($r->code == 2) ? "selected='selected'" : null;
			  			else $sel = ($info->repeatType == $r->code) ? "selected='selected'" : null;
			  			
				  		echo "<option {$sel} value='{$r->code}'>{$r->display}</option>" . PHP_EOL;
			  		}
		  		}
		  		?>
		  		</select>
		      </div> <!-- col-9 -->
		  </div> <!-- .form-group -->
		  
		  <div class="form-group">
		      <label for="" class="col-md-3 control-label">Repeats every</label>
			  <div class="col-md-9">
		  		<select class='form-control repeatWeekSelect' name='repeatEvery' id='repeatEvery'>
		  		<?php
		  		for ($i = 1; $i <= 30; $i++)
		  		{
		  			$sel = ($info->repeatEvery == $i) ? "selected='selected'" : null;
		  		
			  		echo "<option {$sel} value='{$i}'>{$i}</option>" . PHP_EOL;
		  		}
		  		?>
		  		</select> <span id='repeatTypeTxt'>Weeks</span>
		      </div> <!-- col-9 -->
		  </div> <!-- .form-group -->

		  <div class="form-group">
		      <label for="" class="col-md-3 control-label">Repeats on</label>
			  <div class="col-md-9">
		  		<?php
		  		for ($i = 0; $i <= 6; $i++)
		  		{
		  			$checked = null;
		  			
		  			if ($i == 0)
		  			{
		  				$label = 'S';
		  				$checked = (!empty($info->repeatSun)) ? "checked='checked'" : null;
		  			}
		  			else if ($i == 1)
		  			{
		  				$label = 'M';
		  				$checked = (!empty($info->repeatMon)) ? "checked='checked'" : null;
		  			}
		  			else if ($i == 2)
		  			{
		  				$label = 'T';
		  				$checked = (!empty($info->repeatTue)) ? "checked='checked'" : null;
		  			}
		  			else if ($i == 3)
		  			{
		  				$label = 'W';
		  				$checked = (!empty($info->repeatWed)) ? "checked='checked'" : null;
		  			}
		  			else if ($i == 4)
		  			{
		  				$label = 'T';
		  				$checked = (!empty($info->repeatThu)) ? "checked='checked'" : null;
		  			}
		  			else if ($i == 5)
		  			{
		  				$label = 'F';
		  				$checked = (!empty($info->repeatFri)) ? "checked='checked'" : null;
		  			}
		  			else if ($i == 6)
		  			{
		  				$label = 'S';
		  				$checked = (!empty($info->repeatSat)) ? "checked='checked'" : null;
		  			}
		  			
		  			
			  		echo <<< EOS
					<div class='checkbox weekdayRepeatCheckbox'>
						<label>
							<input type='checkbox' name='repeatOn[$i]' id='repeatOn_{$i}' value='1' {$checked}> {$label}
						</label>
					</div>		  		
EOS;
		  		}
		  		?>
		      </div> <!-- col-9 -->
		  </div> <!-- .form-group -->

		  <div class="form-group">
		      <label for="" class="col-md-3 control-label">Starts on</label>
			  <div class="col-md-9">
		  		<input type='text' class='form-control' name='startsOn' id='startsOn' value="<?=$info->startsOn?>" placeholder='<?=date("m/d/Y")?>'>
		      </div> <!-- col-9 -->
		  </div> <!-- .form-group -->
		  
		  
		  <?php
		  	$endsChecked[$info->ends] = "checked='checked'";
		  ?>
		  <div class="form-group">
		      <label for="" class="col-md-3 control-label">Ends</label>
			  <div class="col-md-9">
				  <div class='radio'>
				  	<label>
				  		<input type='radio' name='ends' id='ends_1' value='1' <?=$endsChecked[1]?>> Never
				  	</label>
				  </div>
				  
				  <div class='radio'>
				  	<label>
				  		<input type='radio' name='ends' id='ends_2' value='2' <?=$endsChecked[2]?>> After
				  	</label>
				  	
				  	<input type='text' class='form-control occurrencesTxt' name='occurrences' id='occurrences' value="<?=$info->occurrences?>"> Occurrences 
				  </div>
				 
				  <div class='radio'>
				  	<label>
				  		<input type='radio' name='ends' id='ends_3' value='3' <?=$endsChecked[3]?>> On
				  	</label>
				  	<input type='text' class='form-control occurrencesTxt' name='endsOnDate' id='endsOnDate' value="<?=$info->endsOnDate?>" placeholder='<?=date("m/d/Y")?>'>
				  </div>
		      </div> <!-- col-9 -->
		  </div> <!-- .form-group -->


      </div> <!-- /.model-body -->
      
      <div class="modal-footer">

		  <button type='button' class='btn btn-default' id='repeatCancelBtn'><i class='fa fa-times-circle'></i> Cancel</button>
		  <button type='button' class='btn btn-primary' id='repeatDoneBtn' onclick="">Done</button>


      </div> <!-- modal-footer -->

    
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->