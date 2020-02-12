<?php foreach($campaigns as $campaign) { ?>
    <li class="job_listing">
        <a href="<?=site_url($campaign->id."/".$campaign->sef_link)?>">
            <div class="job_img">
                <img src="<?=campaign_image_link($campaign->image,"small")?>" alt="" class="company_logo">
            </div>
            <div class="position">
                <h3><?=$campaign->title?></h3>
                <div class="company">
                    <strong><?=$campaign->first_name." ".substr($campaign->last_name,0,2)?>.</strong>
                </div>
            </div>
            
        
            <ul class="meta">
                <li class="job-type">İmza Sayısı </li>
                <li class="date">
                        <i class="fa fa-pencil"></i> <?=number_format($campaign->count)?>
                </li>
            </ul>
        </a>
    </li>
<?php }?>