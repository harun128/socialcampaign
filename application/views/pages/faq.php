
		<!-- Main -->
		<div class="main" role="main">

			<!-- Page Heading -->
			<section class="page-heading">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<h1>Sıkça Sorulan Sorular</h1>
						</div>
					</div>
				</div>
			</section>
			<!-- Page Heading / End -->

			<!-- Page Content -->
			<section class="page-content">
				<div class="container">
					
					<div class="row">
						<div class="col-md-12">
                        <?php foreach($faqs as $faq) {?>
							<div class="faq-item">
								<div class="faq-question">
									<span class="dropcap">S</span>
									<h4 class="dropcap-txt"><?=$faq["q"]?></h4>
								</div>
								<div class="faq-answer">
									<span class="dropcap">C</span>
									<div class="dropcap-txt">
										<p><?=$faq["a"]?></p>
									</div>
								</div>
							</div>
                        <?php }?>
							
	
						</div>
					</div>

				</div>
			</section>
			<!-- Page Content / End -->