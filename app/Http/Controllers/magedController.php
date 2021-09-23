<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\ValidRequest;
use ZipArchive;

class magedController extends Controller
{
    //
    public function coursefour($filename,$username,$result,$lesson)
    {

        $pageTop = ' <!DOCTYPE html>
        <html class="no-js">
        <head>
        <meta charset="utf-8">
        <title></title>
        <meta name="description" content="">
        <meta name="HandheldFriendly" content="True">
        <meta name="MobileOptimized" content="320">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimal-ui,maximum-scale=2">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimal-ui,maximum-scale=1">
        <meta http-equiv="cleartype" content="on">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=cairo">
        <link type="text/css" rel="stylesheet" href="assets/css/fonts.css" charset="utf-8">
        <link type="text/css" rel="stylesheet" href="assets/css/style.css" charset="utf-8">
        <link type="text/css" rel="stylesheet" href="assets/css/jquery.fancybox.css?v=2.0.6" charset="utf-8">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/img/touch/apple-touch-icon-144x144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/img/touch/apple-touch-icon-114x114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/img/touch/apple-touch-icon-72x72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/img/touch/apple-touch-icon-57x57-precomposed.png">
        <link rel="shortcut icon" sizes="196x196" href="assets/img/touch/touch-icon-196x196.png">
        <link rel="shortcut icon" href="assets/img/touch/apple-touch-icon.png">

        <!-- Tile icon for Win8 (144x144 + tile color) -->
        <meta name="msapplication-TileImage" content="assets/img/touch/apple-touch-icon-144x144-precomposed.png">
        <meta name="msapplication-TileColor" content="#222222">

        <!-- SEO: If mobile URL is different from desktop URL, add a canonical link to the desktop page -->
        <!--
         <link rel="canonical" href="http://www.example.com/" >
         -->

        <!-- Add to homescreen for Chrome on Android -->
        <!--
         <meta name="mobile-web-app-capable" content="yes">
         -->

        <!-- For iOS web apps. Delete if not needed. https://github.com/h5bp/mobile-boilerplate/issues/94 -->
        <!--
         <meta name="apple-mobile-web-app-capable" content="yes">
         <meta name="apple-mobile-web-app-status-bar-style" content="black">
         <meta name="apple-mobile-web-app-title" content="">
         -->

        <!-- This script prevents links from opening in Mobile Safari. https://gist.github.com/1042026 -->
        <!--
         <script>(function(a,b,c){if(c in b&&b[c]){var d,e=a.location,f=/^(a|html)$/i;a.addEventListener("click",function(a){d=a.target;while(!f.test(d.nodeName))d=d.parentNode;"href"in d&&(d.href.indexOf("http")||~d.href.indexOf(e.host))&&(a.preventDefault(),e.href=d.href)},!1)}})(document,window.navigator,"standalone")</script>
         -->

        <link rel="stylesheet" href="assets/css/normalize.css">
        <link rel="stylesheet" href="assets/wow_book/wow_book.css" type="text/css">
        <link rel="stylesheet" href="assets/css/main.css">
        <script src="assets/js/vendor/modernizr-2.7.1.min.js"></script>
        
        <link href="https://fonts.googleapis.com/css?family=Cairo|Tajawal&amp;display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://www.fontstatic.com/f=bahij">

       
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@400;700;800&display=swap" rel="stylesheet">

        </head>
        <body>

        <!-- Add your site or application content here -->
        <!--
        <div class="header_wrape">
          <div class="header_logo">
            <div class="اسم-الدرس"> دورة مراقي الفلاح </div>
          </div>
        </div>

         Add your site or application content here -->

        <div class="footer_wrape">
          <div class="footer_logo"></div>
        </div>

        <!-- Add your site or application content here -->

        <div class="book_container">
          <div id="book">
            <div id="cover"><img height="100%" src="assets/covers/front/h-05.jpg" width="100%" align="center"></div>
            <div id="page"><div class="top"></div><div dir="rtl" class="text-contaner">
          ';
        $footer = '<div id="cover"><img height="100%" src="assets/covers/back/h-05.jpg" width="100%" align="center"></div>

        </div>
        </div>

        <!-- if you dont need support for IE8 use jquery 2.1 -->
        <!-- <script src="js/vendor/jquery-2.1.0.min.js"></script> -->
        <script src="assets/js/vendor/jquery-1.11.2.min.js"></script>
        <script src="assets/js/helper.js"></script>
        <script src="assets/wow_book/wow_book.min.js"></script>
        <script type="text/javascript" src="assets/js/jquery.fancybox.js?v=2.0.6"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $(".fancybox").fancybox();
             });
        </script>
        <!-- <script src="js/main.js"></script> -->
        <script>
          $(function(){

           var bookOptions = {
             height   : 670
            ,width    : 1000
            ,maxWidth : 1000
            ,maxHeight : 700

            ,centeredWhenClosed : true
            ,hardcovers : true
            ,toolbar : "lastLeft, left, right, lastRight, zoomin, zoomout, slideshow, flipsound, fullscreen, thumbnails,share"
            ,thumbnailsPosition : "left"
            ,responsiveHandleWidth : 50
            ,rtl: true
            ,container: window
            ,containerPadding: "20px"
        ,toolbarPosition: "bottom" // default "bottom"
        , strings: {
                 "lastLeftTooltip"  : "أذهب الي اخر صفحة" // go to last left page button tooltip
                ,"leftTooltip"      : "الصفحة التالية" // go to left page button tooltip
                ,"rightTooltip"     : "الصفحة السابقة" // go to right page button tooltip
                ,"lastRightTooltip" : "أذهب الي اول صفحة" // go to last right page button tooltip
                ,"firstTooltip"     : "الصفحة الاولي" // go to first page button tooltip
                ,"backTooltip"      : "السابق" // back to previous page button tooltip
                ,"nextTooltip"      : "التالي" // go to next page button tooltip
                ,"lastTooltip"      : "الاخيرة" // go to last page button tooltip
                ,"zoominTooltip"    : "تكبير الصفحة" // zoom in button tooltip
                ,"zoomoutTooltip"   : "تصغير الصفحة" // zoom out button tooltip
                ,"slideshowTooltip" : "تقليب ألي" // zoom out button tooltip
                ,"flipsoundTooltip" : "الصوت" // page flip sound button tooltip
                ,"fullscreenTooltip": "تكبير حجم الصفحة" // fullscreen button tooltip
                ,"thumbnailsTooltip": "المصغرات" // thumbnails button tooltip
                ,"tocTooltip"       : "فهرس الموضوعات" // show/hide table of contents button tooltip
                ,"downloadTooltip"  : "تحميل ملف PDF" // download button tooltip
                ,"homeTooltip"      : "الصفحة الرئيسية" // home button tooltip
                ,"shareTooltip"     : "المشاركة" // share button tooltip

                // pdf find control
                ,"findTooltip"         : "" // pdf find button tooltip
                ,"findInputPlaceHolder": "" // placeholder inside the input text
                ,"findPreviousTooltip" : "" // find previous match button tooltip
                ,"findNextTooltip"     : "" // find next match button tooltip
                ,"findMatchCase"       : "" // the label "Match case" beside the checkbox
              }


            // Uncomment the option toc to create a Table of Contents
            // ,toc: [                    // table of contents in the format
            //  [ "Introduction", 2 ],  // [ "title", page number ]
            //  [ "First chapter", 5 ],
            //  [ "Go to codecanyon.net", "http://codecanyon.net" ] // or [ "title", "url" ]
            // ]
           };

           $("#book").wowBook( bookOptions ); // create the book



           // How to use wowbook API
           // var book=$.wowBook("#book"); // get book object instance
           // book.gotoPage( 4 ); // call some method

          })
         </script>
        </body>
        </html>';

        $remove = array('ِ', 'ُ', 'ٓ', 'ٰ', 'ْ', 'ٌ', 'ٍ', 'ً', 'ّ', 'َ');

        $poetry = 0;
        $count = 1; //يستخدم كبداية لائنشاء اول ملف
        $page = 1;
        $lesson = 0;
        $line = 0;
        $text = '';
        $check_photo = 0; //يستخدم كمتغير عند قراءة اكثر من صورة
        $video_id = 0;
        $videos = array();

// rabi3333
        $Rinfo = array();
        $color = "";
        $size = "";
        $Bold = "";
        $Font = "";
        $head = 0;
        $txt = '';

     
        //$xmlll = simplexml_load_file("document.xml");
        // $xmlll = simplexml_load_file("wtest.xml"); 
        $rabie= simplexml_load_file($filename);
        function recurse($child)
        {

            $info = array("foo" => "bar");

            foreach ($child->children() as $children) {

                if ($children->getName() == "wszCs") {
                    $info["size"] = $children->attributes();
                }
                if ($children->getName() == "wcolor") {
                    $info["color"] = $children->attributes();
                }
                if ($children->getName() == "wrFonts") {
                    $info["Font"] = $children->attributes();
                }

                if ($children->getName() == "wb") {
                    $info["Bold"] = "Bold";
                }
            }
            return $info;
        }

        $myfile = fopen($username."/".$result."/" . $count . ".html", "w") or die("Unable to open file!");
        // foreach($xmll as $para){
        foreach ( $rabie->children() as $child) {
            // dd($xmlll->children());

            foreach ($child->children() as $kid) {

                if ($kid->getName() == "whyperlink") {
                    foreach ($kid->children() as $kid1) {

                        foreach ($kid1->children() as $kid2) {
                            if ($kid2->getName() == "wrPr") { // many styles here color & size
                                $Rinfo = recurse($kid2);
                                //echo "styles"."<br>";
                            }

                            if ($kid2->getName() == "wt") {
                                if ((isset($Rinfo["color"]))) {
                                    $color = $Rinfo["color"];
                                }

                                if ((isset($Rinfo["size"]))) {
                                    //echo $kid1."<br>";
                                    $size = $Rinfo["size"];
                                }
                                if ((isset($Rinfo["Font"]))) {

                                }
                                if ((isset($Rinfo["Bold"]))) {
                                    $Bold = "Bold";

                                }
                                 else {

                                  // $text .= "<span style='color:#" . $color . ";font-weight:" . $Bold . ";font-family:" . $Font . "' >" . $kid2 . "</span>";
                            }
                                $color = "";
                                $size = "";
                                $Bold = "";
                                $Font = "";
                            }

                        }
                    }
                }

//   number two not colored

                foreach ($kid->children() as $kid1) {



                    if ($kid1->getName() == "wrPr") { // many styles here color & size
                        $Rinfo = recurse($kid1);
                        //echo "styles"."<br>";
                    }

                    if ($kid1->getName() == "wt") {


                        if ((isset($Rinfo["color"]))) {
                            $color = $Rinfo["color"];
                        }

                        if ((isset($Rinfo["size"]))) {
                            //echo $kid1."<br>";
                            $size = $Rinfo["size"];
                        }
                        if ((isset($Rinfo["Font"]))) {

                            $Font = $Rinfo["Font"];
                            //$Font="bahij";
                        }
                        if ((isset($Rinfo["Bold"]))) {
                            $Bold = "Bold";
                        }

                    }

                }

                if (str_starts_with(trim($kid1), 'P-')) {
                    $text .= '<p   align="center"; ><img width=100% height=auto src="assets/Image_Gallary/' . $kid1 . '.png" ></p>';
                    // if (strchr($kid1, 'C')) {
                    //     $text .= '<p   align="center"; ><img width="200px" height="120px" src="assets/icons/' . $kid1 . '.png" ></p>';
                    // }
                    // if (strchr($kid1, 'R')) {
                    //     $text .= '<p align="right" ><img width="146px" height="47px" src="assets/icons/' . $kid1 . '.png" ></p>';
                    // }



                }
                

                if (str_starts_with($kid1, 'G')) {
                    //style="width:120px;height:40px;"
                    switch ($kid1) {

                        case "G-M":
                            $text .= '<img style="width:120px;height:40px;" src="assets/icons/' . $kid1 . '.png">';

                            break;
                        case "G-F":
                            $text .= '<img style="width:120px;height:40px;"src="assets/icons/' . $kid1 . '.png" >';
                            break;
                        case "G-K":
                            $text .= '<img style="width:120px;height:40px;" src="assets/icons/' . $kid1 . '.png" >';
                            break;
                        case "G-V":
                            $text .= '<img style="width:120px;height:40px;"src="assets/icons/' . $kid1 . '.png" >';
                            break;
                        case "G-E":
                            $text .= '<img style="width:120px;height:40px;" src="assets/icons/' . $kid1 . '.png" >';
                            break;
                        case "G-L":
                            $text .= '<img style="width:120px;height:40px;"src="assets/icons/' . $kid1 . '.png" >';
                            break;
                        case "G-I":
                            $text .= '<img style="width:120px;height:40px;" src="assets/icons/' . $kid1 . '.png" >';
                            break;
                        case "G-Z":
                            $text .= '<img style="width:120px;height:40px;"src="assets/icons/' . $kid1 . '.png" >';
                            break;
                        case "G-B":
                            $text .= '<img style="width:120px;height:40px;" src="assets/icons/' . $kid1 . '.png" >';
                            break;
                        case "G-O":
                            $text .= '<img style="width:120px;height:40px;"src="assets/icons/' . $kid1 . '.png" >';
                            break;
                        case "G-N":
                            $text .= '<img style="width:120px;height:40px;" src="assets/icons/' . $kid1 . '.png" >';
                            break;
                        case "G-A":
                            $text .= '<img  style="width:120px;height:40px;"src="assets/icons/' . $kid1 . '.png" >';
                            break;
                        case "G-D":
                            $text .= '<img style="width:120px;height:40px;" src="assets/icons/' . $kid1 . '.png" >';
                            break;
                        case "G-G":
                            $text .= '<img style="width:120px;height:40px;" src="assets/icons/' . $kid1 . '.png" >';
                            break;
                        case "G-S":
                            $text .= '<img style="width:120px;height:40px;" src="assets/icons/' . $kid1 . '.png" >';
                            break;
                        case "G-KL":
                            $text .= '<img style="width:120px;height:40px;"src="assets/icons/' . $kid1 . '.png" >';
                            break;
                        case "G-T":
                            $text .= '<img style="width:120px;height:40px;" src="assets/icons/' . $kid1 . '.png" >';
                            break;
                        case "G-KM":
                            $text .= '<img style="width:120px;height:40px;"src="assets/icons/' . $kid1 . '.png" >';
                            break;
                        case "G-R":
                            $text .= '<img style="width:120px;height:40px;" src="assets/icons/' . $kid1 . '.png" >';
                            break;
                        case "G-TM":
                            $text .= '<img style="width:120px;height:40px;"src="assets/icons/' . $kid1 . '.png" >';
                            break;
                        case "G-C":
                            $text .= '<img style="width:120px;height:40px;" src="assets/icons/' . $kid1 . '.png" >';
                            break;
                        case "G-TR":
                            $text .= '<img style="width:120px;height:40px;"src="assets/icons/' . $kid1 . '.png" >';
                            break;
                    }
                }
                if (!str_starts_with(trim($kid1), 'P') && !str_starts_with(trim($kid1), 'G'))
                 {
                
                    $vowels = array('HB', 'SB', 'TB', 'RB', 'ER', 'ES', 'ET', 'MB','EM','FB','EF','CB','EC','EH','ZB','EZ','DB','ED','E','N');
                //     $vowels = array('HB', 'SB', 'TB', 'RB', 'ER', 'ES', 'ET', 'MB','EM','FB','EF','CB','EC','EH','ZB','EZ','DB','ED','E','N');
                    $data=trim(str_replace($vowels, '', $kid1));

                    if(str_ends_with( $data, '.')||str_ends_with( $data, '/'))
                    {
                    $text .= "<span style='";
                    if ($color) {
                        
                       
                     $text .= "color:#" .$color. ";";
                    }

                    if ($Font) {

                        if($Font=='Almarai Bold')
                      {
                        $font_weight= 700;
                        $text.="font-weight:".$font_weight.";";
                      }
                      
                      elseif($Font=='Almarai ExtraBold')
                      {
                        $font_weight= 800;
                        $text.="font-weight:".$font_weight.";";
                      }
                       $text.="font-family:Almarai;";
                      }

                    if($Bold) {
                      $text.="font-weight:" .$Bold. ";"; 
                    }


                    if($size) {
                        switch ($size) {
                          case '36':
                            $size=30;
                            $text.="font-size:" .$size. "px;";
                            break;
                          case '32':
                            $size=25;
                            $text.="font-size:" .$size. "px;";
                            break;
                          case '28':
                            $size=22;
                            $text.="font-size:" .$size. "px;";
                            break;
                          
                        }
         
          }


               if($data=='/'){
                $data=trim(str_replace('/','',$data));
               }
                    $text.="'>".$data." "."</span><br>";
                 }
                 
                    else{


                        $text .= "<span style='";
                        if ($color) {
                            
                           
                         $text .= "color:#" .$color. ";";
                        }
                        if ($Font) {

                            if($Font=='Almarai Bold')
                          {
                            $font_weight= 700;
                            $text.="font-weight:".$font_weight.";";
                          }
                          
                          elseif($Font=='Almarai ExtraBold')
                          {
                            $font_weight= 800;
                            $text.="font-weight:".$font_weight.";";
                          }
                           $text.="font-family:Almarai;";
                          }
                          if($size) {
                            switch ($size) {
                              case '36':
                                $size=30;
                                $text.="font-size:" .$size. "px;";
                                break;
                              case '32':
                                $size=25;
                                $text.="font-size:" .$size. "px;";
                                break;
                              case '28':
                                $size=22;
                                $text.="font-size:" .$size. "px;";
                                break;
                              
                            }
                        }
                        if($Bold) {
                          $text.="font-weight:" .$Bold. ";";
                          
                        }

                        if($data == "يرجى لك عزيزي الطالب بعد دراستك لهذا الدرس أن تتعرف على الأمور الآتية:"){
                            echo "here" ;
                        }
                        if($data=='/'){
                            $data=trim(str_replace('/','',$data));
                            }
                        $text .="'>".$data." "."</span>";
                       
                        
                    }



                   
                    $color = "";
                    $size = "";
                    $Bold = "";
                    $Font = "";
                    $Link = "";
                     



                    ////////////////////////////////////////////////////
                //   $vowels = array('HB', 'SB', 'TB', 'RB', 'ER', 'ES', 'ET', 'MB','EM','FB','EF','CB','EC','EH','ZB','EZ','DB','ED','E','N');
                //     $value = (str_replace($vowels,'', trim($kid1))) ;
                  
                //     if ($color) 
                //     {
                //         if(str_ends_with($value, '.'))
                //         {

                //         $text .= "<span  style='" ."color:#" . $color . " ;font-family:" . $Font.";' >" . $value."</span><br/>";
                        
                //         }
                //         else
                //         {
                //             $text .= "<span  style='" ."color:#" . $color . " ;font-family:" . $Font.";' >" . $value." "."</span>";
                //         }
                //     } 
                    
                //     else {

                //         if(str_ends_with($value, '.')){
                //             $text .= "<span  style='"."font-size: 22px;"."font-family:" . $Font . ";' >" .  $value."</span><br/>";
                //             }else{
                //                 $text .= "<span  style='"."font-size: 22px;"."font-family:" . $Font . ";' >" .  $value." "."</span>";
                //             }
                      

                //     }
     ////////////////////////////////////////////////////////////////////////////////////////////               
                    if (str_starts_with(trim($kid1), 'HB')) {
                        $lesson++;
                        if ($count != 0) {
                          if (!($page % 2 == 0)) {
                              $text .= ' </div></div><div id="page"><div class="top"></div><div dir="rtl" class="text-contaner">';
                          }else{
                          $text .= '</div></div>';
                          $text = $pageTop . $text . $footer;
                     fwrite($myfile, $text);
                       $text = "";
                       $page = 1;
                       $myfile = fopen($username."/".$result."/". $lesson . ".html", "w") or die("Unable to open file!");
                        }
                    }
                        $text = "";

                       

                        $text .= '
                      
                        <div align="center" class="Header_Box">';

                    //     $text .= "style='";
                    //     if ($color) {
                    //         $text .= "color:#" . $color . " ; ";
                    //     }
                    //     //$Font="bahij";
                    //     $value = str_replace('HB', '', $kid1);

                    //     //$value;

                    // //   $text .= "font-family:" . $Font . ";'>" . $value ." ". "\n";


                    }


                    //$text.= $data;
                    if (str_starts_with(trim($kid1), 'EH')) {
                        $kid1 = str_replace('EH', '', $kid1);
                        
                       
                        
                        $text .= '</div>';
                      

                        //////دورة منهجية التعلم
                        $videos = array("0_2os32hud", "0_hvsno517", "0_80zkgbnk", "0_f1nnw4yv", "0_ayx0h542", "0_ucptixid",
                            "0_rq2ucg04", "0_y4vdemye", "0_gp7qie3b", "0_ynb1fl4k", "0_13hq7qwy", "0_9qort5uc",
                            "0_j1j27u63", "0_dnzw49go", "0_ta41a2qf", "0_i5qi6794", "0_mny7ourj", "0_t2gdzn3h",

                            "0_3d5hiss4", "0_npsdyhxk", "0_gdcvne9t", "0_f7qtc5tp", "0_wrhjky5f", "0_r37qlsqp",
                            "0_8gfzodx1", "0_du91ukk2", "0_ekxfnpyz", "0_sn4h6wcu", "0_glxwherc", "0_li32v4ky",
                            "0_3rgrqvi5", "0_ohnymt23");

                        $text .= "<p align='center' class='مربع-بوربوينت'><a data-fancybox='' data-type='iframe' href='https://reach.esteam.rocks/p/102/sp/10200/embedIframeJs/uiconf_id/23448169/partner_id/102?iframeembed=true&playerId=kaltura_player_1591890467&entry_id=" . $videos[$video_id] . "' class='btn btn-primary'></a></p>";

                        //$count++;
                        // $line++;
                        // $video_id++;
                        // //continue;

                        // //  echo  $text."<br>";
                        // $data = " ";
                    }


                    ///////////////المقدمة
                    if (str_starts_with(trim($kid1), 'MB')) {

                        $text .= "<div class='introduction_Box'>";
                        // $text .= "style='";
                        
                        $kid1 = (str_replace('MB', '', trim($kid1)));
                        // if ($color) {
                        //     $text .= "<span  style='" . "color:#" . $color . ";' >" . $kid1 . "</span>";
                        // } else {
                        //     $value = (str_replace('MB', '', trim($kid1)));
                        //     $text .= $kid1;
                        //     $text .= "font-size:" . ($size) . "px;font-family:" . $Font . ";'>" . $value ;

                        // }

                     
                   }
                    if (str_starts_with(trim($kid1), 'EM')) {
                        $kid1 = str_replace('EM', '', $kid1);
                       
                        $text .= "</div>";
                        
                       // $text .= " ";
                    }

                    ///////الاهداف 

                    if (str_starts_with(trim($kid1), 'FB')) {

                        $text .= "<div class='Aims_Box'>";
                        // $text .= "style='";
                        
                      //  $kid1 = (str_replace('FB', '', trim($kid1)));
                        // if ($color) {
                        //     $text .= "<span  style='" . "color:#" . $color . ";' >" . $kid1 . "</span>";
                        // } else {
                        //     $value = (str_replace('FB', '', trim($kid1)));
                        //     $text .= $kid1;
                        //     $text .= "font-size:" . ($size) . "px;font-family:" . $Font . ";'>" . $value . "\n";

                        // }
                      
                        
                     
                       
                   }
                    if (str_starts_with(trim($kid1), 'EF')) {

                        $text .= "</div>";
                        // $kid1 = str_replace('EF', '', $kid1);
                        // $text .= $kid1;
                       // $text .= " ";
                    }
                    /////////////تعريف
                    if (str_starts_with(trim($kid1), 'DB')) {

                        $text .= "<div class='Defination_Box'>";

                        // $text .= "style='";
                        
                        $kid1 = (str_replace('DB', '', trim($kid1)));
                        // if ($color) {
                        //     $text .= "<span  style='" . "color:#" . $color . ";' >" . $kid1 . "</span>";
                        // } else {
                        //     $value = (str_replace('DB', '', trim($kid1)));
                        //     $text .= $kid1;
                        //     $text .= "font-size:" . ($size) . "px;font-family:" . $Font . ";'>" . $value . "\n";

                        // }
                   }
                    if (str_starts_with(trim($kid1), 'ED')) {

                        $text .= "</div>";
                      
                       // $text .= " ";
                    }
                    ///////////////الخلاصة
                    if (str_starts_with(trim($kid1), 'ZB')) {

                        $text .= "<div class='Conclusion_Box'>";
                        //  $text .= "style='";
                        
                        $kid1 = (str_replace('ZB', '', trim($kid1)));
                        // if ($color) {
                        //     $text .= "<span  style='" . "color:#" . $color . ";' >" . $kid1 . "</span>";
                        // } else {
                        //     $value = (str_replace('ZB', '', trim($kid1)));
                        //     $text .= $kid1;
                        //     $text .= "font-size:" . ($size) . "px;font-family:" . $Font . ";'>" . $value . "\n";

                        // }

                     
                   }
                    if (str_starts_with(trim($kid1), 'EZ')) {

                        $text .= "</div>";
                     
                    }                    
                     /////////////////ابيات الشعر 
                     if (str_starts_with(trim($kid1), 'CB')) {

                        $text .= "<div class='poem_Box'>";

                        // $text .= "style='";
                        
                        // $kid1 = str_replace('CB', '', $kid1);
                        // if ($color) {
                        //     $text .= "<span  style='" . "color:#" . $color . ";' >" . $kid1 . "</span>";
                        // } else {
                        //     $value = str_replace('CB', '', $kid1);
                        //     $text .= $kid1;
                        //     $text .= "font-size:" . ($size/1.5) . "px;font-family:" . $Font . ";'>" . $value . "\n";

                        // }
                   }
                    if (str_starts_with(trim($kid1), 'EC')) {

                        $text .= "</div>";
                        $kid1 = str_replace('EC', '', $kid1);
                        $text .= $kid1;

                       // $text .= " ";
                    }
                    //////////////////////////////////////////////////
                    if (str_starts_with(trim($kid1), 'RB')) {

                        $text .= "<div class='Reference_Box'>";

                        // $text .= "style='";
                        
                        $kid1 = str_replace('RB', '', $kid1);
                        // if ($color) {
                        //     $text .= "<span  style='" . "color:#" . $color . ";' >" . $kid1 . "</span>";
                        // } else {
                        //     $value = str_replace('RB', '', $kid1);
                        //     $text .= $kid1;
                        //     $text .= " position: absolute"."font-size:" . ($size) . "px;font-family:" . $Font . ";'>" . $value . "\n";

                        // }
                   }
                    if (str_starts_with(trim($kid1), 'ER')) {

                        $text .= "</div>";
                       // $text .= " ";
                    }
                    ///////////////////////////////////////////////////
                    if (str_starts_with(trim($kid1), 'SB')) {
                    
                        $text .= "<div class='saying-imagetop'></div>";
                         
                       
                        $text .= "<div class='Saying_Box'";
                     
                        // $text .= " style='";

                        //s$Font="bahij";

                       $text .= "font-size:" . ($size/1.5) . "px;font-family:" . $Font . ";' >" . "\n";

                        $kid1 = str_replace($kid1, '', 'SB');
                        // if ($color) {
                        //    $text .= "<span   style='" . "color:#" . $color . ";' >" . $kid1 . "</span>";
                        // }
                        //  else {
                        //     $kid1 = str_replace('SB', '', $kid1);
                        //     $text .= $kid1;


                        //     // echo $kid1."<br>";
                        //     // echo $value."--";
                        // }
                    }
                    if (str_starts_with(trim($kid1), 'ES')) {
                       
                        $text .= "</div><div class='saying-imagebottom'></div>";
                        $text .= " ";
                    }
                    //////////////////////////////////////////////////////
                    if (str_starts_with(trim($kid1), 'TB')) {
                      
                        $text .= "<div class='main'>";
                        $text .= "<div class='main-imageright'></div>";
                        $text .= "<div class='Title_Box' style='font-size:" . ($size) . " "."px;'>";

                        $kid1 = str_replace('TB', '', $kid1);
                    //     $text .= "<span  style='";
                    //     if ($color) {
                    //         $text .= "color:#" . $color . ";";
                    //     }
                    //     //s$Font="bahij";
                    //     $text .= "font-family:" . $Font . ";'>" . "\n";
                     }


                    if (str_starts_with(trim($kid1), 'ET')) {
                       
                        $text .= "</div><div class='main-imageleft'></div></div>";
                        //$text .= " ";
                    }
                    //////////////////////////////////////////////////

                    /*$text.="<div  style='" ;
                    if($color){ $text.= "color:#$color;"; }
                    //s$Font="bahij";
                    $text.="font-size:".$size."px;font-family:$Font;'>$kid1</div>"."\n";*/

                    $color = "";
                    if ( $kid1 == '؟') {
                        $text .= "<br>";
                    }
                    if ($kid1 == 'N') {
                         


                        $kid1= str_replace('N', '', $kid1) ;
                    //    $text .=$kid1 ;

                          $text .= '</div></div><div id="page"><div class="top"></div><div dir="rtl" class="text-contaner">';

                          //  fwrite($myfile, $text);


                           // $count++;
                            //$myfile = fopen("lessons5/lesson" . $lesson . ".html", "w") or die("Unable to open file!");


                        $page++;
                        break;
                    }

                } // for the big if

                // if ($kid1 == 'N') {
                //     //echo "aaa";




                //       $text .= ' </div></div><div id="page"><div class="top"></div><div dir="rtl" class="text-contaner">';
                //         //$text = $pageTop . $text . $footer;
                //         //fwrite($myfile, $text);
                //         // $text = "";
                //         // $page = 1;
                //         $line = 0;
                //         $check_photo = 0;
                //         $count++;
                //         //$myfile = fopen("lessons5/lesson" . $lesson . ".html", "w") or die("Unable to open file!");


                //     $page++;
                //     break;
                // }






                }
        }

        if (!($page % 2 == 0)) {
            $text .= ' </div></div><div id="page"><div class="top"></div><div dir="rtl" class="text-contaner">';
        }

        $text .= '</div></div>';
        $text = $pageTop.$text.$footer;

        fwrite($myfile, $text);

        fclose($myfile);

        


    $zipname = '.zip';
    $zip = new ZipArchive;
    $zip->open($username.'/'.$result.'/'.$lesson.$zipname, ZipArchive::CREATE);
    $files1 = scandir($username.'/'.$result);
    foreach ($files1 as $file) {
        
 
        $file_parts = pathinfo($file);

   if($file_parts['extension']=="html"){

   $zip->addFile($username.'/'.$result.'/'.$file,$file);

     }
}

$zip->close();
$d=mkdir($username.'/'.$result.'/'.'Image_Gallary', 0777, true);



return($lesson.$zipname);
    }

    public function rabie(ValidRequest $request)
  {


   $file = $request->file('filename');
    $originalname = $file->getClientOriginalName();
    $temp_file='zip://'.$file.'#word/document.xml';

    //$result = file_get_contents($temp_file);   
      //Load the document XML into PHP's SimpleXML
      //echo $result;
      
      // $xml = simplexml_load_string($result);
      
      // $body= $xml->body;

      // foreach($body[0] as $key => $value){
      //     echo "<p>";
      //     if($key == "p"){
      //         foreach ($value->r as $kkey => $vvalue) {
      //             echo (string)$vvalue->t;
      //         }
      //     }
      //     echo "</p>";
      // }



    /*
    $zip = new ZipArchive; 
    $sUploadedFile = $originalname ;
    $zip->open("word_document/$sUploadedFile");
    $aFileName = explode('.',$sUploadedFile);
    $sDirectoryName =  current($aFileName);
    echo "r0";
    if (!is_dir("word_document/$sDirectoryName")){
        mkdir("word_document/$sDirectoryName", 0777, true);
        $zip->extractTo("word_document/$sDirectoryName"); 
        copy("word_document/$sDirectoryName/word/document.xml", "xml_document/$sDirectoryName.xml");
    
        $xml = simplexml_load_file("xml_document/$sDirectoryName.xml");
        $xml->registerXPathNamespace('w',"http://schemas.openxmlformats.org/wordprocessingml/2006/main");
        $text = $xml->xpath('//w:t');
    
        echo '<pre>'; print_r($text); echo '</pre>';
    
        rrmdir("word_document/$sDirectoryName");
    }
    echo "r1";
    function rrmdir($dir) {
      if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
          if ($object != "." && $object != "..") {
            if (filetype($dir."/".$object) == "dir") 
               rrmdir($dir."/".$object); 
            else unlink   ($dir."/".$object);
          }
        }
        reset($objects);
        rmdir($dir);
      }
     }
    
*/



    /////////////////////////////////////

      $value = $request->file('filename');
     if($request->file('filename')){
          $file = $request->file('filename');
          $username=Auth::user()->name;
     
      $current_time =time();
     
      $currentDate=date('Y-m-d-h-i-s');
      $originalname = $file->getClientOriginalName();

      //$file = $request->file('filename');
      //$originalname = $file->getClientOriginalName();
      $temp_file='zip://'.$file.'#word/document.xml';


          $name =  $username.'_'. $currentDate;
          $extention=$file->getClientOriginalExtension();
       
          $filename=$temp_file;
       
          $nam="file.xml";
          $myfile = fopen($nam, "w");
          $search2="</w:document>";
        
         
      $contents = file_get_contents($filename);
     
      $contents = preg_replace('/' . preg_quote('<w:document') . 
                        '.*?' .
                        preg_quote('>') . '/', '',  $contents);
    
      $contents = str_replace( $search2, "", $contents);
      $contents = str_replace("w:", "w", $contents);
      $contents = str_replace("w14:", "w", $contents);
      $contents = str_replace("r:", "r", $contents);


      fwrite($myfile,$contents);
      fclose($myfile);
    

      $data=$filename;
      
    
      $dir1=mkdir($username.'/'.$name, 0777, true);
      
      
       $file->move($username.'/'.$name ,  $originalname );
       
    
      

  $Name_Lesson=$request->lesson;
  
 // $file->move('public_uploads',  $originalname );
 $Lname= $this-> coursefour($nam,$username,$name,$Name_Lesson);
 
$data="$username/$name/$Lname"; 
  return view("home",compact('data'));
  


      }
     //return $data;
  }
}

