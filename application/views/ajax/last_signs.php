<?php foreach($last_signs as $ls) { ?>
    <li class="comment">
        <div class="comment-wrapper">
            <div class="comment-author vcard">
                <img src="<?=profile_link($ls->picture,"small")?>" alt="" class="gravatar">
<h5><a style="cursor:pointer" <?php if($ls->user != null) {?> href="profile/<?=$ls->user?>"  <?php } ?>><?=$ls->name."  ".mb_substr($ls->surname,0,1,'UTF-8')?>.</a></h5>                                                
                <div class="comment-meta">
                    <a ><?=timeConvert($ls->sign_date)?></a>
                </div>                                                
            </div>
            <div class="comment-body">
                <?=$ls->comment?>        
            </div>
        </div>
    </li>
<?php }?>   