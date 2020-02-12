<!-- Main -->


<div class="main" role="main">

<!-- Page Heading -->
<section class="page-heading">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>BİR KAMPANYA BAŞLATIYORSUNUZ</h1>
            </div>
        </div>
    </div>
</section>
<!-- Page Heading / End -->

<!-- Page Content -->
<section class="page-content">
    <div class="container">
        
        <div class="row ">
            <div class="col-md-10" style="float:none; margin:0 auto;">
           
                <div class="box">
                    <h3>Kampanya Bilgileri</h3>
                    <form target="_self" action="" method="POST"  role="form">           
                    
                    <div class="form-group col">
                        <label>Kampanya Başlığı <span class="required">*</span></label>
                        <input type="text" minlength="20" maxlength="100" name="title" required  value="<?=($this->input->cookie("campaign_title",TRUE) != null) ? get_cookie("campaign_title")  : set_value('title'); ?>" class="form-control" >
                        <?php echo form_error('title'); ?>
                        <blockquote style="">
                            <p>Örnek.</p>
                            <p style="color:#ff3200">Öğretmenlere Atama İsityoruz @MEB <code>#30BinEkAtama</code></p>
                        </blockquote>
                    </div>
                    <div class="form-group col">
                        <label>Kampanya Dilekçesi <span class="required">*</span></label>
                        <textarea  name="petition"  maxlength="1000" minlength="40" id="petition" cols="30" rows="10" class="form-control"><?=($this->input->cookie("campaign_title",TRUE) != null) ? get_cookie("campaign_title")  : set_value('title'); ?></textarea>
                        <?php echo form_error('petition'); ?>
                        <blockquote style="">
                            <p>Örnek.</p>
                            <p style="color:#ff3200">Örnek : Sayın Belediye Başkanı, Sokağımızda çocuk parkı için gerekli alan bulunmaktadır ve çocuklarımızın daha güvenle oyun oynayacağı çocuk parkına ihtiyaç vardır. Gereğinin yapılmasını arz ederim. Saygılarımla</p>
                        </blockquote>
                    </div>
                    <button type="submit" class="btn btn-primary btn-inline">KAMPANYAYI BAŞLAT</button>&nbsp; &nbsp; &nbsp; 
                   
                </form>
                </div>
            </div>

          
           
        </div>

    </div>
</section>
<!-- Page Content / End -->

<!-- Footer -->
<?php $this->load->view('template/copyright') ?>
<!-- Footer / End -->

</div>
<!-- Main / End -->