<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {
    
    


    public function about(){
        $this->load->view('template/header',array('meta'=>array('title' =>  'Hakkımızda'),"active" =>"about"));
        $this->load->view('pages/about');
        $this->load->view('template/footer');
    }


    public function contact() {
        $this->load->view('template/header',array('meta'=>array('title' =>  'İletişim'),"active" =>"contact"));
        $this->load->view('pages/contact');
        $this->load->view('template/footer');
    }

    public function faq() {
        $data["faqs"] = $this->faqs = array(
            array(
                "q" =>  "Tüm Sorumluluk Bana mı Ait ?",
                "a" =>  "Sitemizde yayınlanan tüm imza kampanyaları, kampanyayı oluşturan kullanıcının kendi sorumluluğundadır."
            ),
            array(
                "q" =>  "Yorumların Sorumluluğu Banamı Ait ?",
                "a" =>  "Bir imza kampanyasına eklenen yorum, yorumu ekleyen kişinin kendi sorumluluğundadır."
            ),
            array(
                "q" =>  "Yorumların Sorumluluğu Banamı Ait ?",
                "a" =>  "Bir imza kampanyasına eklenen yorum, yorumu ekleyen kişinin kendi sorumluluğundadır."
            ),
            array(
                "q" =>  "Ne Tarz İmza Kampanyası Açabilirim ?",
                "a" =>  "Türkiye Cumhuriyeti kanunlarına aykırı olmayan her trlü imza kampanyası açabilir ve düzenleyebilirsiniz."
            ),
            array(
                "q" =>  "Hangi Kampanya ve Yorumlar Yayınlanmaz veya Yayından Kaldırılır ?",
                "a" =>  "Hakaret, küfür, saldırı, şiddet, müstehçen içerik, ırkçılık, bölücülük, irticai faaliyet unsurlarına sahip içerikler eklenemez."
            )
            ,
            array(
                "q" =>  "Hangi Kampanya ve Yorumlar Yayınlanmaz veya Yayından Kaldırılır ?",
                "a" =>  "Hakaret, küfür, saldırı, şiddet, müstehçen içerik, ırkçılık, bölücülük, irticai faaliyet unsurlarına sahip içerikler eklenemez."
            ),
            array(
                "q" =>  "Bilgilerim Gizli mi Tutuluyor ?",
                "a" =>  "Bundan kesinlikle emin olabilirsiniz ! "
            ),  
            array(
                'q' =>  'İmza Kampanyasını Oluşturduktan Sonra Düzenleyebilir miyim ?',
                "a" =>  "Evet düzenleyebilirsiniz"
            ),  
            array(
                'q' =>  'İmza Kampanyasını Oluşturduktan Sonra Silebilir miyim ?',
                "a" =>  "Evet silebilirsiniz"
            ),  
            array(
                'q' =>  'Kampanya Hedefine Ulaşabilir mi ?',
                "a" =>  "Bu kesinlikle size bağlı bir durum. Sosyal medyayı iyi kullanır ve insanların dikkatini çekebilirseniz kesinlikle ulaşabilirsiniz."
            )              
            
        );
        
        $this->load->view('template/header',array('meta'=>array('title' =>  'Sıkça Sorulan Sorular'),"active" =>"faq"));
        $this->load->view('pages/faq',$data);
        $this->load->view('template/footer');
    }

    




    

}
