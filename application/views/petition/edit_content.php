<script src="editor/summernote.min.js"></script>
<link href="editor/summernote.css" rel="stylesheet">
<script type="text/javascript">
$(document).ready(function() {
	$('#petitionContent').summernote({
        
    });

});
</script>
<div class="main" role="main">



    <!-- Page Content -->
    <section class="page-content">
        <div class="container">

            <div class="row">
                <div class="content col-md-8 col-md-push-4">

                    
                    
                    <div class="call-to-action" style="">
                        <div class="cta-txt">
                            <h2>Sevgili Kampanya Sahibi </h2>
                            <p>Burada kampanyanı güzel ve etkili bir şekilde anlatabilirsin. Bu başarıya ulaşmanın en önemli adımlarından biridir.</p>

                        </div>

                         <form action="<?=base_url('petition-edit-content/'.$detail["id"].'/')?>" method="POST" role="form">
                            <div class="form-group">

                                <textarea required name="detail" row="20" id="petitionContent"><?=$detail["petition"]?></textarea>
                            </div>

                            <button id="save" type="submit" class="btn btn-primary btn-inline">Kaydet</button>&nbsp; &nbsp; &nbsp;

                        </form>


                    </div>
                    

                                              
                </div>


                <aside class="sidebar col-md-4 col-md-pull-8">

                    <hr class="visible-sm visible-xs lg">

                    <!-- Widget :: Categories -->
                    <div class="widget_tag_cloud widget widget__sidebar">
                    <h4><a href="<?=base_url($detail["id"]."/".$detail["sef_link"])?>"> <i class="fa fa-arrow-left"></i> Kampanyaya Geri Dön</a></h4>
                            
                    </div>
                    <!-- /Widget :: Categories -->

                    
                    

                 

                    <!-- Widget :: Text Widget -->
                    <div class="widget_text widget widget__sidebar">
                        <h4 class="widget-title">Kurumlar için destek</h4>
                        <div class="widget-content">
                                Dernekler, organizasyonlar, kulüpler, şirketler, vakıflar ve tüm kurumlar! Kurumunuz için etkili imza kampanyaları başlatın ve başarıya ulaşın.
                        </div>
                    </div>
                    <div class="widget_text widget widget__sidebar">
                        <h4 class="widget-title">Bu Kampanya Hakkında</h4>
                        <div class="widget-content">
                                Bu bir ücretsiz online kampanya oluşturma aracı olup siyasi oluşum, örgüt, grup, organizasyon değildir. Bu sitedeki tüm imza kampanyaları kullanıcılar tarafından oluşturulmuştur ve kampanyalar birbirinden bağımsızdır. Kullanıcılar tarafından oluştururan hiç bir içerikten imzakampanyam.com sorumlu değildir. imzakampanyam.com toplumsal fayda için çalışır ve kişisel bilgilerinizi üçüncü şahıslara satmaz. Site içinde herhangi bir yerde kötü amaçlı içerik bulmanız halinde lütfen bize ulaşın.
                        </div>
                    </div>
                    <!-- /Widget :: Text Widget -->



                </aside>
            </div>

        </div>
    </section>
    <!-- Page Content / End -->

    <!-- Footer -->
    <footer class="footer" id="footer">

        <div class="footer-copyright">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        Copyright &copy; 2015  <a href="index.html">HandyMan</a> &nbsp;| &nbsp;All Rights Reserved
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer / End -->

</div>