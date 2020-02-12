<script type="text/javascript">
$(function(){
    // When the user scrolls the page, execute myFunction 
    window.onscroll = function() {myFunction()};

    // Get the header
    var header = document.getElementById("myHeader");

    // Get the offset position of the navbar
    var sticky = header.offsetTop;

    var showing =document.getElementById("showing")
    var hidding = document.getElementById("hidding")

    // Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
    function myFunction() {
    if (window.pageYOffset > sticky) {
        
        header.classList.add("sticky");

        var s = document.getElementsByClassName("sticky");
        showing.style.display ="none";
        hidding.style.display ="block";
        
    } else {
        header.classList.remove("sticky");
        hidding.style.display ="none";
        showing.style.display ="block";
        
    }
    }
    
})
</script>

<?php if($myCampaign) { ?>

<script src="editor/summernote.min.js"></script>
<link href="editor/summernote.css" rel="stylesheet">
<script type="text/javascript">
$(document).ready(function() {
	$('#petitionContent').summernote({
    
    });
    $('#successStory').summernote({
        
    });
    $('#edit-petition').summernote({
        
    });
    var addBtn = $("#add-picture");
    var file = $("#picture-input");
    var imageForm = $("#edit-campaign-image");
    addBtn.on("click",function(e) {
        file.trigger("click");
        e.preventDefault();
    });
    file.on("change",function(e){
        addBtn.html("Fotoğraf yükleniyor ..!")
        imageForm.trigger("submit");
    });
    imageForm.on("submit",function(e) {
        var fd = new FormData();
        var files = file[0].files[0];
        fd.append('image',files);
        fd.append('id',$("#hiddenId").val());
		$.ajax({
			type :'POST',
			contentType: false,
            processData: false,
			url : '<?=site_url("load-campaign-image")?>',
			data: fd,
            dataType :'json',
			success: function(data) {
                console.log(data);
				if(data.success) {
                    
                    $("#campaignImage").attr("src",data.img+"?timestamp=" +new Date().getTime());
                }
                addBtn.html("Fotoğraf Yükle");
			}
		});
        e.preventDefault();
    });



});
</script>

<?php  } ?>
<script type="text/javascript">
$(function(){
    p = 0;
    $("#load-signs").on("click",function(e){
        
        p++;
        var lc = $(this);
        var q = '<?=$this->input->get('query')?>';
        var formData = {page:p,id:<?=$detail["id"]?>};
        $.ajax({
            type : 'POST',
            data : formData,
            url : '<?=base_url('ajax/last_signs')?>',
            dataType : 'json',
            success : function(data) {
                if(data.number == 0 ){
                    lc.html("Daha Fazla İmza Yok !");
                } else {
                    $("ol.commentlist").append(data.html);
                }
                
            }
        });
        e.preventDefault();
    });

    var ccount = <?=$detail["count"]?>;
    if(ccount > 0) {
        setTimeout(function(){  $("#load-signs").trigger('click'); }, 3500);
    }
   
});
</script>


<div class="main" role="main">
<?php if($this->input->get('signed')) { ?>
<section style="margin:25px 0 50px 0;">
    <div class="container">
    <div class="title-bordered">
						<h2>Kampanyayı İmzaladın !<small>The most popular services</small></h2>
					</div>

					<div class="row">
						<div class="col-sm-4 col-md-5">
							<div class="service-box">
								<figure class="service-img">
									<img src="<?=campaign_image_link($detail["image"],"large")?>" alt="">
								</figure>
								<div class="service-body">
									<div class="service-icon">
										<i class="fa fa-pencil fa-3x"></i>
									</div>
									<h4 class="service-title">İmzaladın</h4>
									<p></p>
								</div>
							</div>
						</div>
						<div class="col-sm-4 col-md-7 text-center">
                            <h1>Sosyal Medyanın Gücünü Kullan !</h1>
                            <p style="font-size:18px">Bu kampanyayı sosyal ağlarda paylaşarak kampanyanın başarılı olmasına katkı sağlayabilirsin !</p>
                            
                            <div class="info-box" >
                                <center style="padding-top:7px;"><!-- Go to www.addthis.com/dashboard to customize your tools --> <div class="addthis_inline_share_toolbox"></div></center>
                            </div>
                            <br/>
                            <h3>Sende bir İmza Kampanyası Başaltabilirsin !</h3>
                            <p>Bir çok kampanya üyelerimiz tarafından başlatılmıştır. Bir kampanya başlatmak çok kolaydır ! Sende bir İmza Kampanyası Başlat</p>
                            <a style="display:block; width:100%; colo:red;" href="<?=base_url('start')?>" class="btn btn-lg btn-info "> <i class="fa fa-pencil"></i> İMZA AKMPANYASI BAŞLAT !</a>
						</div>
						
					</div>
    </div>
</section>

<?php } ?>



<!-- Page Heading -->
    <section class="sign-header" id="myHeader">
    
        <div class="container ">
        
            <div class="row">
            <div id="showing">
                <div class="col-xs-4 col-md-4 col-lg-2 vcenter   text-center">
                    
                    <div class="info-box">
                        <h6>IMZALAYANLAR</h6>
                        <b class="k"><?=$detail["count"]?></b>
                    </div>
                </div>
                
                <div class="col-xs-4 col-md-4 col-lg-2 vcenter    text-center">
                    <div class="info-box">
                            <h6>GÖRÜNTÜLENME</h6>
                        <b class="k"><?=$detail["views"]?></b>
                    </div>
                </div>
                <div class="col-xs-4 col-md-4 col-lg-2 vcenter   text-center">                
                    <?php if($myCampaign) { ?>
                        <div class="info-box">
                                <h6>HEDEF</h6>
                            <b class="k"><?=($detail["target_count"] > 0 ? number_format($detail['target_count']) : 'Hedef belirleyin!')?></b>
                        </div>
                    <?php } else if($detail["target_count"] > 0 ){?>
                
                        <div class="info-box">
                                <h6>HEDEF</h6>
                            <b class="k"><?=number_format(($detail["target_count"]))?></b>
                        </div>
                    <?php }?>
                </div>
                <div class="col-xs-4 col-md-4 col-lg-2 vcenter    text-center">
                    
                </div>
                </div>
                
                
                
                <div id="hidding" style="display:none">


                <div class="col-xs-12 col-md-6 col-lg-8 vcenter   text-center" >  
                <div class="info-box" >
                   <center style="padding-top:7px;"><!-- Go to www.addthis.com/dashboard to customize your tools --> <div class="addthis_inline_share_toolbox"></div></center>
                </div>
                </div>
                </div>


                <div class="col-xs-12 col-md-6 col-lg-4 vcenter "  >
                        <div class="info-box">
                            <?php if($signed == true) {  ?>
                                <a  class="btn btn-lg btn-success "> <i class="fa fa-pencil"></i> IMZALADIN ! </a>

                            <?php } ?>
                            <?php if($detail["statement"] == 0 && $signed != true) {  ?>
                                <a  style="display:block; width:100%; colo:red;" href="<?=site_url('sign/'.$detail["id"])?>" class="btn btn-lg btn-success "> <i class="fa fa-pencil"></i> HEMEN IMZALA !</a>

                            <?php } ?>
                             <?php if($detail["statement"] == 1) {  ?>
                                <a  class="btn btn-lg btn-success "> <i class="fa fa-pencil"></i> IMZAYA KAPANDI !</a>										
                              <?php } ?>
                              <?php if($detail["successfull"] == 1) {  ?>
                                <a  class="btn btn-lg btn-success "> <i class="fa fa-pencil"></i> BAŞARIYA ULAŞTI !</a>										
                              <?php } ?>

                        </div>

                </div>
            </div>
            <div class="row">
            </div>
        </div>
    </section>
    
    <!-- Page Heading / End -->
    <?php if($myCampaign) { ?>
    <section>
    
        <div class="container">        
        <div class="campaign-process">
            <a href="<?=base_url('/change-target/'.$detail["id"])?>" class="hup-button border-radius" data-toggle="modal" data-target="#myModal">Hedef sayıyı değiştir</a>
            <a href="" class="hup-button border-radius" data-toggle="modal" data-target="#successfullModal">* Başarılı oldum</a>&nbsp;&nbsp;
           
            <a href="" class="hup-button border-radius" data-toggle="modal" data-target="#closeSign"><?=($detail["statement"] == 1) ? 'İmzaya aç': 'İmzaya kapat'?></a>&nbsp;&nbsp;
            <a href="" class="hup-button border-radius" data-toggle="modal" data-target="#publish"><?=($detail["publish"] == 0) ? 'Kampanyayı yeniden yayımla': 'Yayından kaldır'?></a>&nbsp;&nbsp;
            <a href="" class="hup-button border-radius" data-toggle="modal" data-target="#petition">Dilekçeyi Değiştir</a>&nbsp;&nbsp;
            <a href="" class="hup-button border-radius" data-toggle="modal" data-target="#delete">Sil</a>        
        </div>
        
        <!-- Modal -->
        <?php if($myCampaign && $this->session->userdata('id')) { ?>
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
            
            <!-- Modal content-->
            <div class="modal-content">
                <form action="<?=(base_url("change-target-count/".$detail["id"]))?>" method="POST">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Hedef İmza</h4>
                    </div>
                    <div class="modal-body">
                    <p><input name="count" type="number" class="form-control" placeholder="Hedef Imza"></p>
                    
                    <button id="save" type="submit" class="btn btn-primary btn-inline">Kaydet</button>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
                    </div>
                </form>
            </div>
            
            </div>
        </div>
        <div class="modal fade" id="successfullModal" role="dialog">
            <div class="modal-dialog">
            
            <!-- Modal content-->
            <div class="modal-content">
                <form action="<?=(base_url("success/".$detail["id"]))?>" method="POST">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Başarı Hikayeni Bizimle Paylaş</h4>
                    </div>
                    <div class="modal-body">
                    <p><textarea name="story" id="successStory" ><?=$detail["state_comment"]?></textarea></p>
                    
                    <button id="save" type="submit" class="btn btn-primary btn-inline">Kaydet</button>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
                    </div>
                </form>
            </div>
            
            </div>
        </div>
        <div class="modal fade" id="petition" role="dialog">
            <div class="modal-dialog">
            
            <!-- Modal content-->
            <div class="modal-content">
                <form action="<?=(base_url("edit-petition/".$detail["id"]))?>" method="POST">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Kampanya Dilekçesini Değiştir</h4>
                    <p>Bu kısım imzalama sayfasında imza formunun yanında gözükür.</p>
                    </div>
                    <div class="modal-body">
                    <p><textarea name="content" id="edit-petition" ><?=$detail["content"]?></textarea></p>
                    
                    <button id="save" type="submit" class="btn btn-primary btn-inline">Kaydet</button>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
                    </div>
                </form>
            </div>
            
            </div>
        </div>
        <?php }?>
        <?php if($myCampaign) { ?>
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
            
            <!-- Modal content-->
            <div class="modal-content">
                <form action="<?=(base_url("change-target-count/".$detail["id"]))?>" method="POST">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Hedef İmza</h4>
                    </div>
                    <div class="modal-body">
                    <p><input name="count" type="number" class="form-control" placeholder="Hedef Imza"></p>
                    
                    <button id="save" type="submit" class="btn btn-primary btn-inline">Kaydet</button>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
                    </div>
                </form>
            </div>
            
            </div>
        </div>
        <div class="modal fade" id="closeSign" role="dialog">
            <div class="modal-dialog">
            
            <!-- Modal content-->
            <div class="modal-content">
                <form action="<?=(base_url("close/".$detail["id"]))?>" method="POST">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?=($detail["statement"] == 1) ? 'Imzaya Açmak İstediğinizden Emin misiniz ?': 'Kampanyayı imzaya kapatmak istediğinizden emin misiniz ?'?></h4>
                    </div>
                    <div class="modal-body">
                    <div class="list">
                        <ul>
                        <?php if($detail["statement"] != 1)  { ?>
                            <li>İmzaya kapatırsanız hiçbir kullanıcı imzalayamacak.</li>
                            <li>Eğer kapatmak istiyorsanız aşağıdaki "Evet Eminim" butonuna basabilirsiniz</li>
                            <li>Not: Kampanyayı sonradan imzaya açabilirsiniz.</li>
                        <?php } else { ?>
                            <li>İmzaya açarsanız kullanıcılar imzalamaya başlayacak.</li>
                            <li>Kampanyanızın başarılı olma ihtimali artacaktır.</li>
                            <li>Not: Kampanyayı sonradan imzaya kapatabilirsiniz..</li>
                        <?php } ?>
                        </ul>
                    </div>
                    
                    <button id="save" type="submit" class="btn btn-primary btn-i<nline"><?=($detail["statement"] == 1) ? 'Evet Eminim Imzaya Aç.': 'Evet Eminim İmzaya Kapat'?></button>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Hayır Vazgeçtim</button>
                    </div>
                </form>
            </div>
            
            </div>
        </div>

        <div class="modal fade" id="publish" role="dialog">
            <div class="modal-dialog">
            
            <!-- Modal content-->
            <div class="modal-content">
                <form action="<?=(base_url("publish/".$detail["id"]))?>" method="POST">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?=($detail["publish"] == 1) ? 'Kampanyayı yayından kaldırmak istediğinizden emin misiniz  ?': 'Kampanyayı yeniden yayına almak istediğinizden emin misiniz ?'?></h4>
                    </div>
                    <div class="modal-body">
                    <div class="list">
                        <ul>
                        <?php if($detail["publish"] != 1)  { ?>
                            <li>Eğer yayından kaldırırsanız hiçbir kullanıcı imzalayamacak.</li>
                            <li>Kampanyanız sitemizde siz dışında kimseye gösterilmeyecektir.</li>
                            <li>Not: Kampanyayı sonradan yayına alabilirsiniz .</li>
                        <?php } else { ?>
                            <li>Eğer yayına alırsanız kullanıcılar imzalamaya başlayacak.</li>
                            <li>Kampanyanızın başarılı olma ihtimali artacaktır.</li>
                            <li>Kampanyanızı sitemizde gösterilmeye başlanacaktır.</li>
                            <li>Not: Kampanyayı sonradan yayından kaldırabilirsiniz.</li>
                        <?php } ?>
                        </ul>
                    </div>
                    
                    <button id="save" type="submit" class="btn btn-primary btn-i<nline"><?=($detail["publish"] == 1) ? 'Evet Eminim Yayından Kaldır.': 'Evet Eminim Yayına Al'?></button>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Hayır Vazgeçtim</button>
                    </div>
                </form>
            </div>
            
            </div>
        </div>
        <div class="modal fade" id="delete" role="dialog">
            <div class="modal-dialog">
            
            <!-- Modal content-->
            <div class="modal-content">
                <form action="<?=(base_url("delete/".$detail["id"]))?>" method="POST">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Kampanyayı silmek istediğinizden emin misiniz ?</h4>
                    </div>
                    <div class="modal-body">
                    <div class="list">
                        <ul>                        
                            <li>Bu işlemin hiçbir şekilde geri dönüşü yoktur.</li>
                            <li>Kampanya yayından kalkar .</li>   
                            <li>Bütüm imzalar silinir.</li>                         
                        </ul>
                    </div>
                    
                    <button id="save" type="submit" class="btn btn-primary btn-inline">Evet eminim bu kampanyayı sil.</button>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Hayır Vazgeçtim</button>
                    </div>
                </form>
            </div>
            
            </div>
        </div>
        <div class="modal fade" id="insertInstitution" role="dialog">
            <div class="modal-dialog">
            
            <!-- Modal content-->
            <div class="modal-content">
                <form action="<?=(base_url("insert-institutions/".$detail["id"]))?>" method="POST">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Alakalı Kurum Ekle</h4>
                        <div class="">
							<h4>Kurum İsmi / Email</h4>
							<div class="form-group form-grop__icon">
								<i class="entypo user"></i>
								<input type="text" name="name" required class="form-control" placeholder="Kurum veya Kişi ismi">
							</div>
							<div class="form-group form-grop__icon">
								<i class="entypo mail"></i>
								<input type="email" name="email" required class="form-control" placeholder="Kurumun email adresi">
							</div>						
							
						</div>
                    </div>
                    <div class="modal-body">
                    
                    
                    <button id="save" type="submit" class="btn btn-primary btn-i<nline">Kurumu Ekle.</button>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
                    </div>
                </form>
            </div>
            
            </div>
        </div>
        <?php }?>
        
        </div>
                      
    </section>

    <?php } ?>
    


    <!-- Page Content -->
    <section class="page-content">
        <div class="container">

            <div class="row">
                <div class="content col-md-8 col-md-push-4" style="background:#fff; padding:0px 8px">

                  
                    <?php if(empty($detail["petition"]) && $myCampaign)  {?>
                    <div class="call-to-action" style="">
                        <div class="cta-txt">
                            <h2>Sevgili Kampanya Sahibi </h2>
                            <p>Henüz bir içerik girmediğini farkettik ! Bu sayfada kullanıcılar kampanyanız hakkında bilgi alacaktır. Buraya gireceğiniz bilgiler kullanıcılara gösterilecektir.</p>

                        </div>

                         <form action="<?=base_url('petition-edit-content/'.$detail["id"].'/')?>" method="post" role="form">
                            <div class="form-group">

                                <textarea name="detail" row="20" id="petitionContent"></textarea>
                            </div>

                            <button id="save" type="submit" class="btn btn-primary btn-inline">Kaydet</button>&nbsp; &nbsp; &nbsp;

                        </form>


                    </div>
                    <?php } ?>
                    
                    <p style=""><h3 style="color:grey" class="widget-title"><?=$detail["title"]?> İmza Kampanyası</h1><?=htmlspecialchars_decode($detail["petition"])?> </p>
                   <?php if($detail["petition"] && $myCampaign) { ?>
                   <a href="<?=base_url('petition-edit-content/'.$detail["id"].'/')?>" class="btn btn-lg btn-primary">Yazıyı Düzenle</a>
                   <?php } ?>  
                   <br/><br/>
                   <h4>Sosyal Medyanın Gücünü Göster !</h4>
                   <center><h6>Kampanyayı Sosyal Medyada Paylaş !</h6></center>
                   <center style=""><!-- Go to www.addthis.com/dashboard to customize your tools --> <div class="addthis_inline_share_toolbox"></div></center>


                    <!-- Additional Info Tabs -->
                <div class="tabs" style="padding-top:40px;">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab1-1" data-toggle="tab">Son İmzalayanlar</a></li>
                        <li><a href="#tab1-2" data-toggle="tab">İmza Haritası</a></li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab1-1">
                            <!-- Comments -->
                            <div class="comments-wrapper">
                                <h3>Son İmzalayanlar (<?=$detail["count"]?>)</h3>
                                <ol class="commentlist">
                                      
                                    
                                </ol>
                            </div>
                            <!-- Comments / End -->
                            <?php if($detail["count"] > 0) {?>
                            <div class="row">
                                
                                    <a class="btn btn-default btn-block" id="load-signs" href="#">Daha Fazla İmza Görüntüle</a>
                                
                            </div>
                            <?php } ?>
                        </div>
                        <div class="tab-pane fade" id="tab1-2">
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <h4>Son İmzalananlar</h4>
                                    <div class="list list__arrow2">
                                        <ul>
                                        
                                            <li><a >Çok Yakında !</a></li> 
                                        
                                            
                                        </ul>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Additional Info Tabs / End -->                                            
                </div>


               
                

               
                
                
                <aside class="sidebar col-md-4 col-md-pull-8">
                
						
                <?php if($myCampaign) {?>
                     <!-- Widget :: Text Widget -->
                    <div class="widget_text widget widget__sidebar">
                        <h4 class="widget-title">Kampanya Fotoğrafı Ekle</h4>
                        <div class="widget-content">
                                Kampanyaya fotoğraf ekleyerek kampanyanın temasını yansıtabilirsin !
                                <br />
                                <br/>
                                <form action="" id="edit-campaign-image" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="id" id="hiddenId" value="<?=$detail["id"]?>">
                                    <a href="#" id="add-picture" class="btn btn-info" style="width:100%">Fotoğraf Yükle</a>
                                    <input name="image" id="picture-input" type="file" style="display:none">
                                </form>
                        </div>
                    </div>                
                    <!-- /Widget :: Text Widget -->
                <?php  } ?>

                <figure class="alignleft">
						<img id="campaignImage" src="<?=campaign_image_link($detail["image"],"large")?>" style="max-height:343px" alt="">
					</figure>
                    <hr class="visible-sm visible-xs lg">
                    <hr class="visible-sm visible-xs lg">
                    <!-- Widget :: Categories -->
                    <div class="widget_tag_cloud widget widget__sidebar">
                        
                        <h4 ><?=($detail["relevant"])? 'Alakalı Kurum veya Kişiler': 'Alakalı Kurum veya Kişi Eklenmemiş !'?></h4>
                        <?php if($myCampaign) {?> <a style=" color:red:padding:5px; font-size: 24px" href="" class="hup-button border-radius" data-toggle="modal" data-target="#insertInstitution">Alakalı Kurum Ekle</a>   <?php }?>
                        <div class="widget-content">
                            <div class="tagcloud">
                            <?php foreach($detail["relevant"] as $relevant) {?>
                                <?php if($myCampaign) { ?>
                                    <div class="row">
                                    <a style="display:inline-block" href="#">#<?=$relevant["name"]?></a>
                                    <a style="display:inline-block; float:right; background:#ff8200;color:white" href="<?=base_url('delete-institutions/'.$relevant["id"]."/".$detail["id"])?>">SİL</a>
                                    </div>
                                <?php } else { ?>
                                    <a style="display:block" href="#">#<?=$relevant["name"]?></a>
                                <?php } ?>
                                
                                <?php }?>
                            </div>
                        </div>
                        
                    </div>
                    <!-- Widget :: Latest Posts -->
							<div class="widget_latest-posts widget widget__sidebar">
								<h4 class="widget-title">Kampanya Sahibi</h4>
								<div class="widget-content">
									<ul class="latest-posts-list">
										<li>
											<figure class="thumbnail" height="auto"><a href="#"><img src="<?=profile_link($detail["picture"],"small")?>" alt=""></a></figure>
											<h5 class="title"><a href="<?=base_url('profile/'.$detail["user"])?>"><?=$detail["first_name"]." ".substr($detail["last_name"],0,2)?>.</a></h5>
											
										</li>
										
									</ul>
								</div>
							</div>
							<!-- /Widget :: Latest Posts -->
                    <!-- /Widget :: Categories -->

                    <div class="widget_tag_cloud widget widget__sidebar">							
                        <div class="box box__color-darken mb-30">
                                <h5>Sosyal Medya Hesaplarımız</h5>
                                <ul class="social-links social-links__dark">
                                    <li><a href="<?=get_social_link("facebook")?>"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="<?=get_social_link("twitter")?>"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="<?=get_social_link("linkedin")?>"><i class="fa fa-linkedin"></i></a></li>
                                    <li><a href="<?=get_social_link("google")?>"><i class="fa fa-google"></i></a></li>
                                    <li><a href="<?=get_social_link("pinterest")?>"><i class="fa fa-pinterest"></i></a></li>
                                    
                                </ul>
                            </div>									
                    </div>

                    <div class="widget_text widget widget__sidebar">
                        <h4 class="widget-title">Kampanya Ara</h4>
                        <div class="widget-content">
                        <div class="form-group form-grop__icon">
							<i class="entypo search" style="cursor:pointer" onclick="document.getElementById('search-form').submit();"></i>
                            <form id="search-form" action="<?=base_url()?>" method="GET">
							    <input value="" id="" name="query" class="form-control" placeholder="Kampanya Adı " type="text" >
						    </form>
                        </div>
                        </div>
                    </div>
                    <!-- Widget :: Text Widget -->
                    <div class="widget_text widget widget__sidebar">
                        <h4 class="widget-title">Kurumlar için destek</h4>
                        <div class="widget-content">
                        Dernekler, organizasyonlar, kulüpler, şirketler, vakıflar ve tüm kurumlar! Kurumunuz için etkili imza kampanyaları başlatabilir ve başarıya ulaşabilirsiniz.
                        </div>
                    </div>
                    <div class="widget_text widget widget__sidebar">
                        <h4 class="widget-title">Bu Kampanya Hakkında</h4>
                        <div class="widget-content">
                        İmzalayin.com bir ücretsiz online kampanya oluşturma aracı olup siyasi, örgüt, grup, organizasyon değildir. Bu sitedeki tüm imza kampanyaları kullanıcılar tarafından oluşturulmuştur ve kampanyalar birbirinden bağımsızdır. Kullanıcılar tarafından oluştururan hiç bir içerikten imzalayin.com sorumlu değildir. imzalayin.com toplumsal fayda için çalışır ve kişisel bilgilerinizi üçüncü şahıslara satmaz. Site içinde herhangi bir yerde kötü amaçlı içerik bulmanız halinde bizimle iletişime geçebilirsiniz !
                        </div>
                    </div>
                   

                </aside>
            </div>
            
            
        </div>
    </section>
    <!-- Page Content / End -->

    <!-- Footer -->
    <?php $this->load->view('template/copyright') ?>
    
    <!-- Footer / End -->
<!-- Go to www.addthis.com/dashboard to customize your tools --> <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5ca8c35c92506a8d"></script>
</div>

