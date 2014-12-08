<!--container start-->
<div class="container">
    <div class="war_bottom">
        <h2>REVIEWS</h2>
        <div class="border-top">
            <?php if ($reviews): ?>
                <?php foreach ($reviews as $r): ?>       
                    <div class="review_title"><?php echo $r->name; ?></div>
                    <div class="inbox_date"><?php echo $r->created; ?> hours</div>
                    <div class="clear"></div>
                    <div class="star">
                        <?php
                        $bodyRating['avg'] = $r->rating;
                        $bodyRating['largeStar'] = true;
                        $ratingHtml = $this->load->view('dojos/listavgrating', $bodyRating, true);
                        ?>
                        <?php echo $ratingHtml; ?>
                    </div>
                    <div class="clear"></div>
                    <p class="review_text_p"><?php echo $r->comment; ?></p>        
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-warning text-center">There are no Reviews Currently.</div>
            <?php endif; ?>
        </div>
    </div>
</div>
<!--container end-->
<div class="container">
    <div class="war_bottom">
        <h2>Post a Review</h2>
        <div class="border-top">
            <?php
            $attr = array
                (
                'id' => 'reviewForm'
            );

            echo form_open('#', $attr);

            $disabled = ($this->session->userdata('logged_in') == true) ? "disabled='disabled'" : null;
            ?>

            <input type='hidden' name='rating' id='rating' value='0'>

            <input type='hidden' name='location' id='location' value='<?= $id ?>'>

            <div class='row name-email-review'>
                <div class='col-md-6'>
                    <div class="form-group">
                        <label for='reviewName'>NAME*:</label>
                        <input type='text' class='form-control' id='reviewName' name='reviewName' <?= $disabled ?> value="<?= ($this->session->userdata('logged_in') == true) ? "{$this->session->userdata('firstName')} {$this->session->userdata('lastName')}" : null ?>">
                    </div> <!-- .form-group -->
                </div>

                <div class='col-md-6'>

                    <div class="form-group">
                        <label for='reviewEmail'>E-MAIL*:</label>
                        <input type='text' class='form-control' id='reviewEmail' name='reviewEmail' <?= $disabled ?> value="<?= ($this->session->userdata('logged_in') == true) ? $this->session->userdata('email') : null ?>">
                    </div> <!-- .form-group -->

                </div>
            </div> <!-- row -->

            <div class="form-group">
                <label for='ratings'>RATING:</label>

                <div id='reviewStars' class='reviewStars'>
                    <i class='fa fa-star' id='rating_star_1' value='1'></i>
                    <i class='fa fa-star' id='rating_star_2' value='2'></i>
                    <i class='fa fa-star' id='rating_star_3' value='3'></i>
                    <i class='fa fa-star' id='rating_star_4' value='4'></i>
                    <i class='fa fa-star' id='rating_star_5' value='5'></i>
                </div>
            </div> <!-- .form-group -->

            <div class="form-group">
                <label  for='reviewDesc'>DESCRIPTION:</label>
                <textarea class='form-control' name='reviewDesc' id='reviewDesc' rows='5'></textarea>
            </div> <!-- .form-group -->
            
            <button type="button" class="btn btn-primary col-md-2 col-md-offset-10">Submit</button>
            
            </form>
        </div> <!-- reviews-results -->
    </div>
</div>