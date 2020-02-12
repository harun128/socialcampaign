<!-- Main -->
<div class="main" role="main">

<!-- Page Heading -->
<section class="page-heading">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>KAYIT OL</h1>
            </div>
        </div>
    </div>
</section>
<!-- Page Heading / End -->

<!-- Page Content -->
<section class="page-content">
    <div class="container">
        
        
        <div class="row ">
            <div class="col-md-8" style="float:none; margin:0 auto;">
            <?php if(get_cookie("campaign_title") != null) { ?>
                <div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times"></i></button>
                    <strong>Merhaba !</strong>Kampanya başlatmaya çalıştığını farkettik ! Kampanya başlatabilmen için bir üyeliğin olmalı. Alttaki formu doldurarak veya facebook ile giriş yaparak hızlıca kampanyanı başlatabilirsin.<br/>
                    <strong>Dikkat !</strong> Eğer bir üyeliğiniz varsa üye giriş sayfasına gitmek için <a href="login">tıklayınız.</a>
                </div
            <?php }?>
        
            <?php 
            if(isset($hata)) {
                echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times"></i></button>
                <strong>Hata !</strong> '.$hata.'
            </div>';
            }
            ?>
                <div class="box">
                    <h3>KAYIT OL</h3>
                    <form target="_self" action="" method="POST"  role="form">
                    <div class="form-group">
                    <a href="<?=$facebookLoginLink?>" title="Facebook" class="btn btn-facebook btn-lg"><i class="fa fa-facebook fa-fw"></i> Facebook ile kayıt ol</a>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Ad <span class="required">*</span></label>
                        <input type="text" name="first_name" required  value="<?php echo set_value('first_name'); ?>" class="form-control" >
                        <?php echo form_error('first_name'); ?>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Soyad <span class="required">*</span></label>
                        <input type="text" name="last_name" required  value="<?php echo set_value('last_name'); ?>" class="form-control" >
                        <?php echo form_error('last_name'); ?>
                    </div>
                    
                    <div class="form-group col-md-12">
                        <label>Email Addresiniz <span class="required">*</span></label>
                        <input type="email" name="email" required  value="<?php echo set_value('email'); ?>" class="form-control" >
                        <?php echo form_error('email'); ?>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Şifre <span class="required">*</span></label>
                        <input type="password" name="password" required  value="<?php echo set_value('password'); ?>" class="form-control" >
                        <?php echo form_error('password'); ?>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Tekrar şifre <span class="required">*</span></label>
                        <input type="password" name="confirm_password" required  value="<?php echo set_value('confirm_password'); ?>" class="form-control" >
                        <?php echo form_error('confirm_password'); ?>
                    </div>
                    
                    <div class="form-group col-md-12">
                        <button type="submit" class="btn btn-primary btn-inline">KAYIT OL</button>&nbsp; &nbsp; &nbsp; 
                        <label for="remember" class="checkbox-inline">
                            <input type="checkbox" name="remember" id="remember"> Beni Hatırla
                        </label>
                    </div>
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