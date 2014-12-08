<div class="user_list">
	<ul>
	<li>
		<?php if($this->uri->segment(1)!='search'):?>
		<a href="/search/info/<?php echo $info->id;?>">Location<span><?php echo $info->name; ?></span></a>
		<?php endif;?>
		</li>
		<li>
                    <a href="#" id="menuButton">menu<span><?php echo count($menu);?></span></a>
		</li>
		<li>
		<?php if($info->id):?>
		<a id="dealsBtn" rel="/deals/<?php echo $info->id;?>" href="/deals/<?php echo $info->id;?>">deals<span><?php echo count($deals);?></span></a>
		<?php else:?>
		<a  id="dealsBtn2" rel="/deals" href="/deals">deals<span><?php echo count($deals);?></span></a>
		<?php endif;?>
		</li>
		<li>
                    <a id="reviewsBtn" rel="/reviews/info/<?php echo $info->id;?>" href="/reviews/info/<?php echo $info->id;?>">reviews<span><?php echo count($reviews);?></span></a>
		</li>
		<li>
                    <a id="uploadsTabButton" rel="" href="#">uploads<span><?php echo count($uploads); ?></span></a>
		</li>
		<li>
                    <a id="revBtn" rel="/dojos/info/<?php echo $info->id;?>" href="/dojos/info/<?php echo $info->id;?>">Write a Review<span></span></a>
		</li>
		<!-- 
		<li><a href="/user/following/<?php echo $info->id;?>">following<span><?php echo count($followingCnt);?>
			</span>
		</a>
		</li>
		<li><a href="/user/followers/<?php echo $info->id;?>">followers<span><?php echo count($followersCnt);?>
			</span>
		</a>
		</li>
		
		 -->
	</ul>
</div>
