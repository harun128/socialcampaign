<?php 
$dataSM = json_decode($user->social_media);

if($my) { ?>
<script>
$(function(){
	var password = document.getElementById("password")
  	, confirm_password = document.getElementById("confirm_password");

	function validatePassword(){
		if(password.value != confirm_password.value) {
			confirm_password.setCustomValidity("Şifreler birbiriyle uyuşmuyor !");
		} else {
			confirm_password.setCustomValidity('');
		}
	}

	password.onchange = validatePassword;
	confirm_password.onkeyup = validatePassword;

	$("form#change-password").on("submit",function(e) {
		$.ajax({
			type :'POST',
			dataType : 'json',
			data : $(this).serialize(),
			url : '<?=site_url("profile/change-password")?>',
			success: function(data) {
				alert(data.msg);				
			}
		});
		e.preventDefault();		
	});
	$("#edit-profil-image").on("click",function(e){
		var file = $("#upload-profile-image");
		file.trigger('click');
		var that = $(this);
		file.on("change",function(e){
			that.html("Fotoğraf yükleniyor ..!")
			$("#image-upload-form").trigger("submit");
		});
	});

	$("#image-upload-form").on('submit',function(e) {
		var fd = new FormData();
        var files = $('#upload-profile-image')[0].files[0];
		fd.append('image',files);
		$.ajax({
			type :'POST',
			contentType: false,
            processData: false,
			url : '<?=site_url("profile/edit-profile-image")?>',
			data: fd,
			success: function(data) {
				setTimeout(function() { window.location=window.location;},1750);
			}
		});
		e.preventDefault();
	});

	$("#edit-profile-form").on("submit",function(e){
		$.ajax({
			type :'POST',
			dataType : 'json',
			data :  $("#edit-profile-form").serialize(),
			url : '<?=site_url("profile/edit-profile")?>',
			success: function(data) {
				$(".profile-modal-body").html(data.msg);
				setTimeout(function() { window.location=window.location;},2200);				
			}
		});
		e.preventDefault();	
	});

	$("#update-social-media-profile").on("submit",function(e){
		$.ajax({
			type :'POST',
			dataType : 'json',
			data :  $("#update-social-media-profile").serialize(),
			url : '<?=site_url("profile/update-social-media-accounts")?>',
			success: function(data) {
				
				setTimeout(function() { window.location=window.location;},2200);				
			}
		});
		e.preventDefault();	
	});

})
</script>
<?php } ?>

		<!-- Main -->
		<div class="main" role="main">
		<?php if($my) { ?>
		<div class="modal fade" id="successfullModal" role="dialog">
            <div class="modal-dialog">
            
            <!-- Modal content-->
            <div class="modal-content">
                <form action="" id="edit-profile-form" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Profili Düzenle</h4>
                    </div>
                    <div class="modal-body profile-modal-body">
                    <p><input minlength="2" name="first_name" type="text" class="form-control" placeholder="Ad" required value="<?=$user->first_name?>"></p>
                    <p><input minlength="2" name="last_name" type="text" class="form-control" placeholder="Soyad"  required value="<?=$user->last_name?>"></p>
                    <button id="save" type="submit" class="btn btn-primary btn-inline">Kaydet</button>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
                    </div>
                </form>
            </div>
            
            </div>
        </div>
		<div class="modal fade" id="socialEdit" role="dialog">
            <div class="modal-dialog">
            
            <!-- Modal content-->
            <div class="modal-content">
               
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Profili Düzenle</h4>
                    </div>
                    <div class="modal-body">
					<form  method="POST" id="update-social-media-profile" role="form">
						<div class="form-group form-grop__icon">
							<i class="entypo facebook"></i>
							<input value="<?=@$dataSM->facebook?>" id="facebook" name="facebook"  type="url" pattern="http://www\.facebook\.com\/(.+)|http://facebook\.com\/(.+)"   type="text" class="form-control" placeholder="http://facebook.com/your-profile " >
						</div>
						<div class="form-group form-grop__icon">
							<i class="entypo twitter"></i>
							<input value="<?=@$dataSM->twitter?>"  id="twitter" name="twitter" class="form-control" placeholder="http://twitter.com/your-profile " type="url" pattern="http://www\.twitter\.com\/(.+)|http://twitter\.com\/(.+)">
						</div>
						<div class="form-group form-grop__icon">
							<i class="entypo gplus"></i>
							<input value="<?=@(((array)$dataSM)["google-plus"])?>" id="gplus" name="google-plus" type="url" pattern="http://www\.plus.google\.com\/(.+)|http://plus.google\.com\/(.+)" class="form-control" placeholder="http://plus.google.com/your-profile " minlength="8">
						</div>
						<div class="form-group form-grop__icon">
							<i class="entypo instagram"></i>
							<input value="<?=@$dataSM->instagram?>" id="instagram" name="instagram" type="url" pattern="http://www\.instagram.com\.com\/(.+)|http://instagram\.com\/(.+)" class="form-control" placeholder="http://instagram.com/your-profile " minlength="8">
						</div>
						
						<p>
					<button id="save" type="submit" class="btn btn-primary btn-inline">Kaydet</button>
					</p>
					</form>
					
					
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
                    </div>
                
            </div>
            
            </div>
        </div>
		<?php } ?>

			<!-- Page Content -->
			<section class="page-content">
				<div class="container">

					<div class="row">
						<div class="content col-md-8">

							<div class="box mb-30">
								<div class="job-profile-info">
									<div class="row">
										<div class="col-md-5">
											<figure class="alignnone">
											<form action="/" id="image-upload-form" ></form>
												
												<img src="<?=profile_link(($user->picture ?: 'profile.jpg'),"large")?>" alt="">
												<?php if($my) { ?>
												<input name="image" id="upload-profile-image" type="file" accept="image/x-png,image/gif,image/jpeg" style="display:none"/>
												<br/><?=anchor('/','(Profil Resmi Ekle)',array("id"=>"edit-profil-image",'data-toggle'=>"modal","data-target" => "#editProfileImage"));?>
												<?php }?>
											</figure>
										</div>
										<div class="col-md-7">
												<h2 class="name"><?=$user->first_name." ".$user->last_name?> <?php if($my) {  ?> <a href="" class="hup-button border-radius" data-toggle="modal" data-target="#successfullModal"> (Düzenle)</a>&nbsp;&nbsp;  <?php }?></h2>
											<br/>
											
											<ul class="info">
												<li><i class="fa fa-envelope"></i> Açtığı Kampanya Sayısı <?=count($opens)?> </li>
												<li><i class="fa fa-pencil"></i> İmzaladığı Kampanya Sayısı <?=count($signs)?></li>
											</ul>
										</div>
									</div>

									<div class="spacer-lg"></div>
									
									
									
								</div>
							</div>

							<!-- Additional Info Tabs -->
							<div class="tabs">
								<!-- Nav tabs -->
								<ul class="nav nav-tabs">
									<li class="active"><a href="#tab1-1" data-toggle="tab">Kampanyalar</a></li>
									<li><a href="#tab1-2" data-toggle="tab">İmzalananlar</a></li>
								</ul>
								<!-- Tab panes -->
								<div class="tab-content">
									<div class="tab-pane fade in active" id="tab1-1">
										<!-- Comments -->
										<div class="comments-wrapper">
											<h3>Son Açılan Kampanyalar (<?=count($opens)?>)</h3>
											<ol class="commentlist">
                                            <?php foreach($opens as $open) { ?>
												<li class="comment">
													<div class="comment-wrapper">
														<div class="comment-author vcard">
															<img src="<?=campaign_image_link($open->image,"small")?>" alt="" class="gravatar">
															<h5><a href="<?=campaign_link($open->id,$open->sef_link)?>"><?=$open->title?></a></h5>
															
															<div class="comment-meta">
																<a ><?=date("M, Y H:m A",strtotime($open->start_date))?></a>
															</div>
															
														</div>
														<div class="comment-body">
															<?=substr($open->content,0,125)?>
														</div>
													</div>
												</li>
                                            <?php }?>
												
											</ol>
										</div>
										<!-- Comments / End -->

									</div>
									<div class="tab-pane fade" id="tab1-2">
										<div class="row">
											<div class="col-sm-12 col-md-12">
												<h4>Son İmzalananlar</h4>
												<div class="list list__arrow2">
													<ul>
													<?php foreach($signs as $s) { ?>
														<li><a href="<?=site_url($s->id."/".$s->sef_link)?>"><?=$s->title?></a></li> 
													<?php }?>
														
													</ul>
												</div>
											</div>
											
										</div>
									</div>
								</div>
							</div>
							<!-- Additional Info Tabs / End -->

						</div>
						
						<!-- Sidebar -->
						<aside class="sidebar col-md-4">
							<hr class="visible-sm visible-xs lg">
							<?php if($my) { ?>
							<div class="box box__color-darken mb-30">
								<h4>Şifre Değiştir</h4>
								<form  method="POST" id="change-password" role="form">
									<div class="form-group form-grop__icon">
										<i class="entypo key"></i>
										<input required id="oldpassword" name="oldpassword" type="password" class="form-control" placeholder="Eski Şifreniz" minlength="8">
									</div>
									<div class="form-group form-grop__icon">
										<i class="entypo key"></i>
										<input required id="password" name="password" type="password" class="form-control" placeholder="Yeni Şifreniz" minlength="8">
									</div>
									<div class="form-group form-grop__icon">
										<i class="entypo key"></i>
										<input required id="confirm_password" name="confirm_password" type="password" class="form-control" placeholder="Yeni Şifreniz Tekrar" minlength="8">
									</div>
									<button type="submit" class="btn btn-primary">Şifremi Değiştir</button>
								</form>
							</div>
							<?php }?>
							<div class="box box__color-darken mb-30">
								<h4>Sosyal Medya Hesapları <?php if($my) {  ?> <a href="" class="hup-button border-radius" data-toggle="modal" data-target="#socialEdit"> (Düzenle)</a>&nbsp;&nbsp;  <?php }?></h4>
								<ul class="social-links social-links__dark">
								<?php 
									
									if(isset($dataSM)) {
									foreach($dataSM as $key => $value) {
										if($value != "") {
									?>
									<li><a href="<?=$value?>"><i class="fa fa-<?=$key?>"></i></a></li>
									<?php } } } ?>
							
								</ul>
							</div>

							
								<!-- Table (Bordered) / End -->
							</div>

							
						</aside>
						<!-- Sidebar / End -->
						

					</div>
				</div>
			</section>
			<!-- Page Content / End -->

            <?php $this->load->view('template/copyright') ?>
			<!-- Footer / End -->