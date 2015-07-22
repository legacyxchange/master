
    <?php if($this->session->flashdata('SUCCESS')): ?>
    <div class='ro'>
    	<h3 class="alert alert-success" style="text-align:center;"><?php echo $this->session->flashdata('SUCCESS'); ?></h3>
    </div>
    <?php elseif($this->session->flashdata('FAILURE')): ?>
    <div class='ro'>
        <h3 class="alert alert-danger" style="text-align:center;"><?php echo $this->session->flashdata('FAILURE'); ?></h3>
    </div>
    <?php elseif($this->session->flashdata('NOTICE')): ?>
    <div class='ro'>
        <h3 class="alert alert-warning" style="text-align:center;"><?php echo $this->session->flashdata('NOTICE'); ?></h3>
    </div>
    <?php endif; ?> 
