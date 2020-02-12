<script type="text/javascript">
$(function(){
    
    $.ajax({
        dataType: "json",
        url: '<?=base_url('static/json/ulkeler.json')?>',
        success: function(data) {   
            $.each(data.countries,function(i,item){
                var option = document.createElement('option');
                option.text = item.name;
      	        option.value = item.id;
                if(item.name == "Turkey")
                    option.selected = true;
                $('select#country').append(new Option(item.name,item.id));
                //alert(option.text);
            });        
        }
    }).then(function() {
        $('#country option')
        .filter('[value=223]')
        .attr('selected', true)
        $('#country').trigger('change');
    });

    $('select#country').on('change',function() {
        var val = this.value;
        $.ajax({
            type: 'POST',
            dataType: "json",
            url: '<?=base_url('json/cities')?>',
            data : {id:val},
            success: function(data) {                  
                $.each(data,function(i,item){                    
                    var option = document.createElement('option');
                    option.text = item.name;
                    option.value = item.id;
                    $('select#city').append(new Option(item.name,item.id));
                });
            }
    })
    });
    // $('form#sign').submit(function(e){
        
        
        
        
    // });
    $('form#sign').on('submit',function(e) {
        
        $.ajax({
            type: 'POST',
            dataType : 'json',
            data : $('form#sign').serialize(),
            url : '<?=base_url('sign/process')?>',
            success : function(data) {
                //alert(data);
                if(data.success == 1) {
                    location.href = '<?=base_url($detail["id"].'/'.$detail["sef_link"].'?signed=true')?>'
                } else {
                    $('#errors .modal-body').html(data.error);
                    $('#error').trigger('click');
                }
               
            }
        });
        e.preventDefault();
    });
})
</script>

<!-- Main -->
<div class="main" role="main">



<!-- Page Content -->
<section class="page-content">
    <div class="container">
        
        <div class="row ">
            <div class="col-md-6" style="">
            <?php 
            if(isset($hata)) {
                echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times"></i></button>
                <strong>Hata !</strong> '.$hata.'
            </div>';
            }
            ?>
            <a data-toggle="modal" id="error" data-target="#errors"></a>

            <div class="modal fade" id="errors" role="dialog">
            <div class="modal-dialog">
            
            <!-- Modal content-->
            <div class="modal-content">
                    <form action="<?=(base_url("change-target-count/".$detail["id"]))?>" method="POST">
                        <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Hata !</h4>
                        </div>
                        <div class="modal-body">
                        
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
                        </div>
                    </form>
                </div>
                
                </div>
            </div>
                <div class="box">
                    <h3 style="text-align:center"><?=$detail["title"]?> İmza Kampanyası</h3>
                    <form id="sign"  action="" method="POST"  role="form">
                    <input type="hidden" name="id" required  value="<?=$detail["id"] ?>" class="form-control"  >
                    <?php if($this->session->userdata('oauth_provider') != "facebook") { ?>
                        <div class="form-group col-md-12">
                        <a href="<?=$facebookLoginLink?>" title="Facebook" class="btn btn-facebook btn-lg"><i class="fa fa-facebook fa-fw"></i> Facebook ile Kolay İmzala  <i class=""></i></a>
                        </div>
                    <?php } ?>
                        <?php if(!$this->session->userdata('id')) { ?>
                        <div class="form-group col-md-6">
                            <label>Ad <span class="required">*</span></label>
                            <input name="first_name" required  value="<?php echo set_value('first_name'); ?>" class="form-control" >
                            <?php echo form_error('first_name'); ?>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Soyad <span class="required">*</span></label>
                            <input  name="last_name" required  value="<?php echo set_value('last_name'); ?>" class="form-control" >
                            <?php echo form_error('last_name'); ?>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Email <span class="required">*</span></label>
                            <input type="email" name="email" required  value="<?php echo set_value('email'); ?>" class="form-control" >
                            <?php echo form_error('email'); ?>
                        </div>
                        <?php }?>
                        <div class="form-group col-md-12">
                            <label>Ülke  <span class="required">*</span></label>
                            <div class="form-group">
								<div class="select-style">
									<select name="country" id="country" class="form-control">
										
									</select>
								</div>
							</div>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Şehir  <span class="required">*</span></label>
                            <div class="form-group">
								<div class="select-style">
									<select name="city" id="city" class="form-control">
										
									</select>
								</div>
							</div>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Yorumunuz <span class="required">*</span></label>
                            <textarea name="comment" cols="30" rows="5" class="form-control" placeholder="Yorumunuz..."></textarea>
                        </div>
                        <div class="form-group col-md-12 ">
                           
                            <button style="width:100%;" id="save" type="submit" class="btn btn-lg btn-success">IMZAYI KAYDET</button>
                        </div>
                        
                        
                        
                    </form>
                </div>
                
            </div>
            
            
            <div class="col-md-6" style="">
            <?php 
            if(isset($hata)) {
                echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times"></i></button>
                <strong>Hata !</strong> '.$hata.'
            </div>';
            }
            ?>
                <div class="box">
                <h3>Kampanya Dilekçesi</h3>
                <form target="_self" action="" method="POST"  role="form">
                    <div class="form-group">
                        <p><?=htmlspecialchars_decode($detail["content"])?></p>
                    </div>
                    
                </form>
            </div>
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