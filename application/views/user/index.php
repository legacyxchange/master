<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
    
    <div class="container">         
        <div class="content-container">
            <h2><?php echo $user->firstName.' '.$user->lastName; ?>(<?php echo $user->username;?>)</h2> 
            <p>
            <img src="/user/profileimg/300/<?php echo $user->user_id;?>/<?php echo $user->profileimg; ?>" class="img-thumbnail avatar">
            <pre>
            <?php var_dump($user);?> 
            </pre>          
            </p>                               
        </div>             
     </div>