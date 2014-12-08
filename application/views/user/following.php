<?php
if (!empty($followings))
{
    foreach ($followings as $following)
    {
        echo <<< EOS
            <div class="row">
                <img src="/user/profileimg/32/{$following->followingUser}" /> {$following->firstName} {$following->lastName} <button class="btn btn-primary btn-xs" type="button" onclick="user.unfollowByUserId({$following->followingUser}, this);"><i class="fa fa-eye-slash"></i> Unfollow</button>
            </div>
EOS;
    }
}
else
{
    echo "Sorry, no users are currently following this user.";
}

