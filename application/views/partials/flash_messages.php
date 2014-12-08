<div class="container">
    <?php if($this->session->flashdata('SUCCESS')): ?>
    <div class='row'>
    	<h3 class="alert alert-success"><?php echo $this->session->flashdata('SUCCESS'); ?></h3>
    </div>
    <?php elseif($this->session->flashdata('FAILURE')): ?>
    <div class='row'>
        <h3 class="alert alert-danger"><?php echo $this->session->flashdata('FAILURE'); ?></h3>
    </div>
    <?php elseif($this->session->flashdata('NOTICE')): ?>
    <div class='row'>
        <h3 class="alert alert-warning"><?php echo $this->session->flashdata('NOTICE'); ?></h3>
    </div>
    <?php endif; ?> 
</div>