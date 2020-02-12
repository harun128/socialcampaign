<script type="text/javascript">
$(function(){
    p = 1;
    $("#load-campaign").on("click",function(e){
        p++;
        var lc = $(this);
        var q = '<?=$this->input->get('query')?>';
        var formData = {page:p,query:q};
        $.ajax({
            type : 'POST',
            data : formData,
            url : '<?=base_url('ajax/index_campaigns')?>',
            dataType : 'json',
            success : function(data) {
                if(data.number == 0 ){
                    lc.html("Daha Fazla Kampanya Yok !");
                } else {
                    $("ul.job_listings").append(data.html);
                }
                
            }
        });
        e.preventDefault();
    });
});

</script>

<!-- Main -->
<div class="main" role="main">
<?php if($this->input->get("query") == null) { ?>
<!-- Slider -->
<section class="slider-holder">
    <div class="flexslider carousel">
        <ul class="slides">
            
            <!-- <li>
                <img src="images/samples/slide1.jpg" alt="" />
            </li>
            <li>
                <img src="images/samples/slide2.jpg" alt="" />
            </li>
            <li>
                <img src="images/samples/slide3.jpg" alt="" />
            </li> -->
        </ul>

        <div class="search-box">
            <div class="container">
                <div class="search-box-inner">
                    <h1>Bir şeyleri düzeltmek mi istiyorsun ?</h1>
                    <form action="start" method="GET" role="form">

                        <div class="row text-center">
                            
                            <button id="singlebutton" name="singlebutton" class="btn btn-primary display-1" style="padding:20px; ">HEMEN BİR KAMPANYA BAŞLAT !</button> 									
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</section>
<!-- Slider / End -->
<?php } ?>
<!-- Page Content -->
<section class="page-content">
    <div class="container">
    <?php if($this->input->get("query") == null) { ?>
    <div class="row">
                <div class="col-md-4">
                    <div class="icon-box">
                        <div class="icon">
                            <i class="fa fa-pencil"></i>
                        </div>
                        <div class="icon-box-body">
                            <h4>Kampanya Başlat</h4>
                            Rahatsız olduğun bir durum hakkında kampanya başlat !
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="icon-box circled icon-box-animated">
                        <div class="icon">
                            <i class="fa fa-edit"></i>
                        </div>
                        <div class="icon-box-body">
                            <h4>Düzenle</h4>
                            Kampanyayı ziyaretçilerin en iyi anlayabileceği şekilde düzenle(resim, içerik,video)
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="icon-box squared icon-box-animated">
                        <div class="icon">
                            <i class="fa fa-share-alt"></i>
                        </div>
                        <div class="icon-box-body">
                            <h4>Paylaş !</h4>
                            Sosyal medyanın gücünü kullanarak milyonlarca kişiye ulaş.
                        </div>
                    </div>
                </div>
            </div>

        <!-- Stats -->
        <div class="section-light section-nomargin">
            <div class="section-inner">
                <div class="row">
                    <div class="col-md-3 col-xs-6">
                        <div class="counter-holder counter-dark">
                            <i class="fa fa-3x fa-pencil"></i>
                            <span class="counter-wrap">
                                <span class="counter" data-to="<?=$statistics->sign_count?>" data-speed="1500" data-refresh-interval="50"><?=$statistics->sign_count?></span>
                            </span>
                            <span class="counter-info">
                                <span class="counter-info-inner">İMZA</span>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="counter-holder counter-dark">
                            <i class="fa fa-3x fa-envelope"></i>
                            <span class="counter-wrap">
                                <span class="counter" data-to="<?=$statistics->petition_count?>" data-speed="1500" data-refresh-interval="50"><?=$statistics->petition_count?></span>
                            </span>
                            <span class="counter-info">
                                <span class="counter-info-inner">DİLEKÇE</span>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="counter-holder counter-dark">
                            <i class="fa fa-3x fa-user"></i>
                            <span class="counter-wrap">
                                <span class="counter" data-to="<?=$statistics->user_count?>" data-speed="1500" data-refresh-interval="50"><?=$statistics->user_count?></span>
                            </span>
                            <span class="counter-info">
                                <span class="counter-info-inner">Üye</span>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="counter-holder counter-dark">
                            <i class="fa fa-3x fa-check-circle"></i>
                            <span class="counter-wrap">
                                <span class="counter" data-to="<?=$statistics->success_count?>" data-speed="1500" data-refresh-interval="50"><?=$statistics->success_count?></span>
                            </span>
                            <span class="counter-info">
                                <span class="counter-info-inner">BAŞARI</span>
                            </span>
                        </div>
                    </div>
                </div>
                
            </div>
           
        </div>
        <!-- Stats / End -->
        <?php }?>
        <?php if($this->input->get("query") == null) { ?>
            <div class="spacer-xl"></div>
        <?php }?>
        <!-- Listings -->
        <div class="title-bordered">
            <h2>KAMPANYALAR <small>Son eklenenler.</small></h2>
        </div>
        <div class="job_listings">
            <ul class="job_listings">
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
                
            </ul>
        </div>

        <div class="spacer"></div>

        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <a class="btn btn-default btn-block" id="load-campaign" href="#">Daha Fazla Kampanya Görüntüle</a>
            </div>
        </div>

        <!-- Listings / End -->

        

    

        <div class="spacer-lg"></div>




        <div class="spacer"></div>

        
    </div>
</section>
<!-- Page Content / End -->

<!-- Footer -->
<?php $this->load->view('template/copyright') ?>
<!-- Footer / End -->

</div>
<!-- Main / End -->
