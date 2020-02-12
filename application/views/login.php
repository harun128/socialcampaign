<!-- Main -->
<div class="main" role="main">

<!-- Page Heading -->
<section class="page-heading">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>GİRİŞ</h1>
            </div>
        </div>
    </div>
</section>
<!-- Page Heading / End -->

<!-- Page Content -->
<section class="page-content">
    <div class="container">
        
        <div class="row ">
            <div class="col-md-6" style="float:none; margin:0 auto;">
            <?php 
            if(isset($hata)) {
                echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times"></i></button>
                <strong>Hata !</strong> '.$hata.'
            </div>';
            }
            ?>
                <div class="box">
                    <h3>GİRİŞ</h3>
                    <form target="_self" action="" method="POST"  role="form">
                    <div class="form-group">
                    <a href="<?=$facebookLoginLink?>" title="Facebook" class="btn btn-facebook btn-lg"><i class="fa fa-facebook fa-fw"></i> Facebook ile giriş yap</a>
                    </div>
                    
                    <div class="form-group col">
                        <label>Email Addresiniz <span class="required">*</span></label>
                        <input type="email" name="email" required  value="<?php echo set_value('email'); ?>" class="form-control" >
                        <?php echo form_error('email'); ?>
                    </div>
                    <div class="form-group">
                        <div class="clearfix">
                            <label class="pull-left">
                                Şifre <span class="required">*</span>
                            </label>
                            <span class="pull-right"><a href="#">Şifrenizi mi unuttunuz ??</a></span>
                        </div>
                        <input type="password" name="password" required class="form-control">
                        <?php echo form_error('password'); ?>
                    </div>
                    <button type="submit" class="btn btn-primary btn-inline">GİRİŞ</button>&nbsp; &nbsp; &nbsp; 
                    <label for="remember" class="checkbox-inline">
                        <input type="checkbox" name="remember" id="remember"> Beni Hatırla
                    </label>
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