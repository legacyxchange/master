<!--container start-->
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
        <h3 class="alert alert-notice"><?php echo $this->session->flashdata('NOTICE'); ?></h3>
        </div>
        <?php endif; ?> 
        <?php echo $administrator_menu; ?> 
        	<div class="war">
            	<h2>Administrator Dashboard</h2>
                                
                <!--border_box start-->
                    <div class="border_box">
                        <a class="btn btn-default" href="/administrator/users">USERS</a>
                        <a class="btn btn-default" href="/administrator/products">PRODUCTS</a>
                    </div>
                <!--border_box end-->                            
            </div>
        </div>
     <!--container end-->