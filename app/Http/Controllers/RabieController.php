<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;
use App\Http\Requests\ValidRequest;
use ZipArchive;
  use File;
class RabieController extends Controller
{
  public $filename;
    public function tester($filename,$username,$result,$lesson)
  {
    $page =  0;
    $text = '';
    $count = 1;
    $head = 0;
    $txt = '';
    $flag=0;

    
    
    
  
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
        if ($children->getName() == "wrStyle") {
          $info["Link"] = $children->attributes();
        }
        if ($children->getName() == "wb") {
          $info["Bold"] = "Bold";
        }
      }
      return  $info;
    }


    $Rinfo = array();
    $color = "";
    $size = "";
    $Bold = "";
    $Font = "";
    //echo "ssss";
    $line = 0;
    $myfile = fopen($username."/".$result."/"."01-01-01-0" . $count . ".html", "w") or die("Unable to open file!");

    foreach ($rabie->children() as $child) {
      //echo "sii,s";
      //echo $child->getName()."<br>";


      foreach ($child->children() as $kid) //Extra tages here 
      {
        //echo $kid ->getName()."<br>";
        if ($kid->getName() == "whyperlink") {
          foreach ($kid->children() as $kid1) {

            foreach ($kid1->children() as $kid2) {
              if ($kid2->getName() == "wrPr") { // many styles here color & size
                $Rinfo = recurse($kid2);
                //echo "styles"."<br>";
              }



              if ($kid2->getName() == "wt") {

                $text.="<span style='";
                if ((isset($Rinfo["color"]))) {
                  $color = $Rinfo["color"];
                  $text.="color:#".$color.";";
                }

                if ((isset($Rinfo["size"]))) {
                  $size = $Rinfo["size"];
                  $text.="font-size:".$size.";";
                }
                if ((isset($Rinfo["Font"]))) {
                  $Font=$Rinfo["Font"];
                  $text.="font-family:".$Font.";";
                }
                if ((isset($Rinfo["Bold"]))) {
                  $Bold = "Bold";
                  $text.="font-family:".$Bold.";";
                }
                if ((isset($Rinfo["Link"]))) {
                  $Link = "Link";
                  $text.="'><a href='#'>".$kid2."</a></span>&nbsp";
                }
                
                else{
  
                  $text.="'>".$kid2."</span>&nbsp";
                  $text.=" ";
                }
                $color = "";
                $size = "";
                $Bold = "";
                $Font = "";
                $Link = "";
              }
            }
          }
        }

        ////////////////////////////////////////


        foreach ($kid->children() as $kid1) // wrpr contain styles and test here you can find all text and its styles inside this foreach .
        {

          //echo "**".$kid1->getName()."<br>";
          if ($kid1->getName() == "wrPr") { // many styles here color & size
            $Rinfo = recurse($kid1);
            //echo "styles"."<br>";
          }

          if ($kid1->getName() == "wt") {

            if ((isset($Rinfo["color"]))) {
              $color = $Rinfo["color"];
            }
            if ((isset($Rinfo["size"]))) {
              $size = $Rinfo["size"];
            }
            if ((isset($Rinfo["Font"]))) {
              $Font = $Rinfo["Font"];
            }
            if ((isset($Rinfo["Bold"]))) {
                $Bold = "Bold";
            }
            if ((isset($Rinfo["Link"]))) {
              $Link = "Link";
            }

            
           
            if (str_starts_with(trim($kid1), 'P')) {
                  $picture="";
                  
                  if($kid1!=='.')
                  {
                       $picture.=$kid1;

                  }
                  //echo $picture."<br>";
                $text .= '<p class="images" align="center"; ><img src="./Image_Gallary/' . $kid1 . '.png" ></p>';

            }
            
            if (str_starts_with(trim($kid1), 'G')) {
            
                switch ($kid1) {

                    case "G-M":
                        $text .= '<p  align="center"; ><img style="width:120px;height:40px;" src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/icone/' . $kid1 . '.png"></p>&nbsp';
                         
                        break;
                    case "G-F":
                        $text .= '<p  align="center"; ><img style="width:120px;height:40px;"src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/icone/' . $kid1 . '.png" ></p>&nbsp';
                        break;
                    case "G-K":
                        $text .= '<img style="width:120px;height:40px;" src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/icone/' . $kid1 . '.png" >&nbsp';
                        break;
                    case "G-V":
                        $text .= '<img style="width:120px;height:40px;"src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/icone/' . $kid1 . '.png" >';
                        break;
                    case "G-E":
                        $text .= '<img style="width:120px;height:40px;" src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/icone/' . $kid1 . '.png" >';
                        break;
                    case "G-L":
                        $text .= '<img style="width:120px;height:40px;"src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/icone/' . $kid1 . '.png" >';
                        break;
                    case "G-I":
                        $text .= '<img style="width:120px;height:40px;" src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/icone/' . $kid1 . '.png" >&nbsp';
                        break;
                    case "G-Z":
                        $text .= '<img style="width:120px;height:40px;"src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/icone/' . $kid1 . '.png" >';
                        break;
                    case "G-B":
                        $text .= '<img style="width:120px;height:40px;" src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/icone/' . $kid1 . '.png" >';
                        break;
                    case "G-O":
                        $text .= '<img style="width:120px;height:40px;"src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/icone/' . $kid1 . '.png" >';
                        break;
                    case "G-N":
                        $text .= '<img style="width:120px;height:40px;" src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/icone/' . $kid1 . '.png" >';
                        break;
                    case "G-A":
                        $flag=1;
                        $text .= '<img  style="width:120px;height:40px;"src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/icone/' . $kid1 . '.png" >';
                        
                        break;
                    case "G-D":
                        $text .= '<img style="width:120px;height:40px;" src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/icone/' . $kid1 . '.png" >';
                        break;
                    case "G-G":
                      $flag=2;
                        $text .= '<img style="width:120px;height:40px;" src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/icone/' . $kid1 . '.png" >';
                        break;
                    case "G-S":
                        $text .= '<img style="width:120px;height:40px;" src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/icone/' . $kid1 . '.png" >';
                        break;
                    case "G-KL":
                        $text .= '<p  align="right"; ><img style="width:150px;height:60px;"src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/icone/' . $kid1 . '.png" ></p>';
                        break;
                    case "G-T":
                        $text .= '<img style="width:120px;height:40px;" src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/icone/' . $kid1 . '.png" >';
                        break;
                    case "G-KM":
                        $text .= '<p  align="right"; ><img style="width:150px;height:60px;"src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/icone/' . $kid1 . '.png" ></p>';
                        break;
                    case "G-R":
                        $text .= '<img style="width:120px;height:40px;" src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/icone/' . $kid1 . '.png" >';
                        break;
                    case "G-TM":
                        $text .= '<img style="width:120px;height:40px;"src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/icone/' . $kid1 . '.png" >';
                        break;
                    case "G-C":
                        $text .= '<img style="width:120px;height:40px;" src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/icone/' . $kid1 . '.png" >';
                        break;
                    case "G-TR":
                        $text .= '<img style="width:120px;height:40px;"src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/icone/' . $kid1 . '.png" >';
                        break;
                }
            }
            if (!empty($kid1)&&!str_starts_with(trim($kid1), 'P') && !str_starts_with(trim($kid1), 'G')&&!str_starts_with(trim($kid1), 'N')) 
            {
          
              $vowels = array('HB','MB','TB','RB','ER','EM','ET','EH','ED','DB','SB','ES','MB','EM','FB','EF','LB','EL','ZB','EZ');
              $data=trim(str_replace($vowels, '', $kid1));
              if(!empty($data)){
              $text .= "<span style='";
              if ($color) {
               $text .= "color:#" .$color. ";";
              }
              if ($Font) {
               $text.="font-family:" .$Font. ";";
              }
              if($Bold) {
                $text.="font-weight:" .$Bold. ";";
              }
              if($size) {
                            switch ($size) {
                              case '44':
                                $size=30;
                                $text.="font-size:" .$size. ";";
                                break;
                              case '28':
                                $size=20;
                                $text.="font-size:" .$size. ";";
                                break;
                              case '32':
                                $size=20;
                                $text.="font-size:" .$size. ";";
                                break;
                              
                            }
             
              }
              $text .="'>".$data."&nbsp</span> ";
            }
              $color = "";
              $size = "";
              $Bold = "";
              $Font = "";
              $Link = "";
               
            
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
              if (str_starts_with(trim($kid1), 'LB')) {
                $text .= "<div class='Header_Box'> ";
              }
                if (str_starts_with(trim($kid1), 'EL')) {
               
                $text .= "</div>";
              
              }
             //////////////////////////////////////////////////////////////////////////////////
              if (str_starts_with(trim($kid1), 'HB')) {
                $text .= "<div class='main'>";
                $text .= "<div class=' main-imageright'></div> ";
                $text .= "<div class='Header2_Box'";
                $text.=trim($kid1);
              }
                if (str_starts_with(trim($kid1), 'EH')) {
                $text.="</span>"; 
                $text .= "</div><div class='main-imageleft'></div></div>";
              }
              //////////////////////////////////////////////////
              if (str_starts_with(trim($kid1), 'RB')) {

                $text .= "<div class='Reference_Box' '>";
              
                $kid1 = str_replace('RB', '', $kid1);
                 
              }
              if (str_starts_with(trim($kid1), 'ER')) {

                $text .= "</div>";
                
              }

               //////////////////////////////////////////////////
               if (str_starts_with(trim($kid1), 'MB')) {

                $text .= "<div class='start_Box'> ";
              }
              if (str_starts_with(trim($kid1), 'EM')) {

                $text .= "</div>";
                
              }
              //////////////////////////////////////////////////
              if (str_starts_with(trim($kid1), 'CB')) {

                $text .= "<div class='Poem_Box'> ";
              }
              if (str_starts_with(trim($kid1), 'EC')) {

                $text .= "</div>";
                
              }
              ///////////////////////////////////////////////////
              if (str_starts_with(trim($kid1), 'ZB')) {

                $text .= "<div class='Moral_Box'> ";
              }
              if (str_starts_with(trim($kid1), 'EZ')) {

                $text .= "</div>";
                
              }
              //////////////////////////////////////////////////
               if (str_starts_with(trim($kid1), 'FB')) {

                $text .= "<div class='goals_Box'>";
              }
              if (str_starts_with(trim($kid1), 'EF')) {
                $text .= "</div>";
                
              }
              ///////////////////////////////////////////////////
              if (str_starts_with(trim($kid1), 'SB')) {
                $text .= "<div class='saying-imagetop'></div>";
                $text .= "<div class='Saying_Box' ";
                $text .= " style='";
             /*   if ($color) {
                  $text .= "color:#" . $color . "; ";
                }*/
                //s$Font="bahij";
                 
                $text .= "font-size:".$size."px;font-family:" . $Font . ";' >" . "\n";

                $kid1 = str_replace($kid1, '', 'SB');
                if ($color) {
                  $text .= "<span  style='" . "color:#" . $color . ";' >" . $kid1 . "</span>";
                } else {
                  $kid1 = str_replace('SB', '', $kid1);
                  $text .= $kid1;
                  // echo $kid1."<br>";
                  // echo $value."--";
                }
              }
              if (str_starts_with(trim($kid1), 'ES')) {

                $text .= "</div> <div class='saying-imagebottom'></div>";
                
              }
              //////////////////////////////////////////////////////
              if (str_starts_with(trim($kid1), 'DB')) {
               // echo "DB";
               $text .= "<div class='Definition_Box' ";
                $text .= " style='";
                if ($color) {
                  $text .= "color:#" . $color . "; ";
                }
                //s$Font="bahij";
                 
                $text .= "font-size:".$size."px;font-family:" . $Font . ";' >" . "\n";

                $kid1 = str_replace($kid1, '', 'DB');
                if ($color) {
                  $text .= "<span  style='" . "color:#" . $color . ";' >" . $kid1 . "</span>";
                } else {
                  $kid1 = str_replace('ED', '', $kid1);
                  $text .= $kid1;
                  // echo $kid1."<br>";
                  // echo $value."--";
                }
              }
              if (str_starts_with(trim($kid1), 'ED')) {

                $text .= "</div>";
                
              }
              //////////////////////////////////////////////////////
              if (str_starts_with(trim($kid1),'TB')) {
                if ($Bold){ $text .= "<div  style='font-weight:".$Bold.";'>";
                }else{
                $text .= "<div  style='font-size:".$size."px;'>";
                }
                $kid1 = str_replace('TB', '', $kid1);
                $text .= "<span  style='";
                if ($color) {
                  $text .= "color:#" . $color . ";";
                }
                elseif($Bold)
                {
                  $text .= "font-weight:".$Bold.";";
                }
                //s$Font="bahij";
                $text .= "font-family:" . $Font . ";'>" . $kid1 . "</span>" . "\n";
              }
             /*  if ( $kid1=='E') {
                $text .= "</div>";
                
              }*/

              if (str_starts_with(trim($kid1), 'ET')) {

                $text .= "</div>";
                
              }
              //////////////////////////////////////////////////
  
              /*$text.="<div  style='" ;
                                  if($color){ $text.= "color:#$color;"; }
                                  //s$Font="bahij";
                                  $text.="font-size:".$size."px;font-family:$Font;'>$kid1</div>"."\n";
          
*/
                                



              $Bold="";
              $color = "";
              $kid1=trim($kid1);
              if ($kid1 == '.' ||$kid1 == '؟'||$kid1 == ':.') {
                $text .= "<br>";
              }

              if ($kid1 == 'N') {

                $page++;
                break;
              }
             
              ///////////////////////////////start of header ///////////////////////////

              $pageTop = ' 
      <!doctype html>
      <html dir="rtl">

      <head>
        <!-- Basic -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>تعريف الطهارة لغة وشرعًا</title>
        <meta property="og:title" content="دار الإفتاء المصرية">
        <meta property="og:description" content="دار الإفتاء المصرية">
        <meta name="keywords" content="دار الإفتاء المصرية">
        <meta name="description" content="دار الإفتاء المصرية">
        <meta name="author" content="http://dar-alifta.org/">
        <!-- Favicon -->
        <link rel="apple-touch-icon" sizes="57x57"
          href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/images/viewer/fav/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60"
          href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/images/viewer/fav/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72"
          href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/images/viewer/fav/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76"
          href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/images/viewer/fav/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114"
          href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/images/viewer/fav/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120"
          href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/images/viewer/fav/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144"
          href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/images/viewer/fav/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152"
          href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/images/viewer/fav/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180"
          href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/images/viewer/fav/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"
          href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/images/viewer/fav/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32"
          href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/images/viewer/fav/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96"
          href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/images/viewer/fav/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16"
          href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/images/viewer/fav/favicon-16x16.png">
        <link rel="manifest"
          href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/images/viewer/fav/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage"
          content="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/images/viewer/fav/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        <!-- Mobile Metas -->
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <!-- Vendor CSS -->
        <link rel="stylesheet"
          href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet"
          href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/vendor/bootstrap/css/bootstrap-theme.min.css">
        <link rel="stylesheet"
          href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/vendor/bootstrap-rtl/bootstrap-rtl.css">
        <link rel="stylesheet"
          href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/vendor/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet"
          href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/vendor/simple-line-icons/css/simple-line-icons.min.css">
        <link rel="stylesheet"
          href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/css/theme-animate.css">
        <!-- custom Font Icon -->
        <link rel="stylesheet"
          href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/Fonts/ICONS/styles.css">
        <!-- Theme CSS -->
        <!--<link rel="stylesheet" href="../css/theme.css">
                  <link rel="stylesheet" href="../css/theme-elements.css">
                  <link rel="stylesheet" href="../css/theme-blog.css">
                  <link rel="stylesheet" href="../css/theme-shop.css">-->
        <link rel="stylesheet"
          href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/css/rtl-theme.css">
        <link rel="stylesheet"
          href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/css/rtl-theme-elements.css">
        <!-- Skin CSS -->
        <link rel="stylesheet"
          href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/css/skins/default.css">
        <!--<script src="../master/style-switcher/style.switcher.localstorage.js"></script>-->
        <!-- mCustomScrollbar -->
        <link rel="stylesheet" type="text/css"
          href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/script/mCustomScrollbar/jquery.mCustomScrollbar.css">
        <!-- Head Libs -->
        <script
          src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/vendor/modernizr/modernizr.min.js"></script>
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script
          src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/js/ie10-viewport-bug-workaround.js"></script>
        <script
          src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/script/prefixfree/prefixfree.min.js"></script>
        <!-- hover.css -->
        <link rel="stylesheet" type="text/css"
          href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/css/hover.css">
        <!-- Main CSS -->

        <link href="https://fonts.googleapis.com/css?family=Cairo|Tajawal&amp;display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://www.fontstatic.com/f=bahij">


        <link rel="stylesheet" type="text/css"
          href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/css/Viewer-rtl.css">

          <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">


        <!-- slick 1.6 CSS -->
        <link rel="stylesheet" type="text/css"
          href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/script/slick_1.6/slick.css">
        <link rel="stylesheet" type="text/css"
          href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/script/slick_1.6/slick-theme.css">
        <!-- Templat CSS -->
        <link rel="stylesheet" type="text/css"
          href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/css/Templates-rtl.css">
        <link type="text/css" rel="stylesheet"
          href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/css/shapes.css"
          charset="utf-8">
        <style>
        #MainArea .MainScr .MainScr_med_med,
        .SupportTempsInPopup .MainScr .MainScr_med_med {
          background: #ffffff;
        }
    html{    
      overflow: hidden;
    }
        #Temp009 .TextArea {
          max-height: 86vh;
          min-height: 85vh;
        }
    
        #mybody, #R02,.MainScr,.TextArea,#Temp009 .MainScr_med_med,.Title2  {
          margin-bottom: 0px !important;
          margin-top: 0px !important;
          padding-bottom: 0px !important;
          padding-top: 0px !important;
        }
    
        .body {
          height: 100% !important;
        }
          
          
          
        </style>
      </head>
      
      <body id="mybody">
        <div class="site-overlay"></div>
        <div class="body">
      
          <div class="cleaner"></div>
          <div id="R02">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-12">
                  <div class="table MainAreTable">
                    <div class="table-row">
                      <div class="table-cell SideMenuWrapper">
                        <div class="features_btns">
                          <div class="features_main">
                            <a id="t0_btn" href="#" rel="toggle[HelpingTools]"
                              data-openimage="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/images/viewer/icons/HelpingTools_Down.png"
                              data-closedimage="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/images/viewer/icons/HelpingTools_Top.png"
                              class="hvr-bounce-to-bottom HomeToolTip01" title="الأدوات المساعدة"> <img
                                src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/images/viewer/icons/HelpingTools_Down.png"
                                border="0"> </a>
                          </div>
                          <div id="HelpingTools" class="features_2">
                            <a href="#" data-toggle="modal" data-target="#Notes_Scr"
                              class="hvr-bounce-to-bottom HomeToolTip01" title="الملاحظات"> <img
                                src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/images/viewer/icons/Note.png"
                                alt=""> </a>
                            <a href="https://storage.googleapis.com/ifta-learning-dp/uploads/courses_reference/012/unit1/index.html"
                              data-toggle="modal" data-target="#References_Scr"
                              class="hvr-bounce-to-bottom HomeToolTip01 fancybox fancybox.iframe" title="المراجع"> <img
                                src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/images/viewer/icons/Glossary.png"
                                alt=""> </a>
                            <a onclick="window.location.reload(true)" href="javascript:void()"
                              class="hvr-bounce-to-bottom HomeToolTip01" title="إعادة تحميل الصفحة"> <img
                                src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/images/viewer/icons/Reload.png"
                                alt=""> </a>
                            <a class="fancybox fancybox.iframe hvr-bounce-to-bottom HomeToolTip01"
                              href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/templates/01-12/course_help.html"
                              title="ارشادات الاستخدام"> <img
                                src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/images/viewer/icons/Help.png"
                                alt=""> </a>
                            <a class="hvr-bounce-to-bottom HomeToolTip01 fullScreen" href="javascript:void()"
                              title="ملئ الشاشة"> <img
                                src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/images/viewer/icons/fullscreen.png"
                                alt=""> </a>
                          </div>
                        </div>
                      </div>
                      <div class="table-cell MainAreWrapper">
                        <div class="unit_btns">
                          <a class="hvr-bounce-to-bottom" href="#"> <img class="icon"
                              src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/images/viewer/icons/unit_menu_icon_01.png"
                              alt=""> <span class="text">المقدمة</span> </a>
                          <a class="fancybox fancybox.iframe hvr-bounce-to-bottom"
                            href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/templates/01-12/map/map.html"
                            title="الخريطة"> <img class="icon"
                              src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/images/viewer/icons/unit_menu_icon_02.png"
                              alt=""> <span class="text">الخريطة</span> </a>
                          <a class="fancybox fancybox.iframe hvr-bounce-to-bottom"
                            href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/templates/01-12/glossaries.html"
                            title="المعاجم"> <img class="icon"
                              src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/assets/images/viewer/icons/unit_menu_icon_03.png"
                              alt=""> <span class="text">المعجم</span> </a>
                          <a class="fancybox fancybox.iframe hvr-bounce-to-bottom"
                            href="https://storage.googleapis.com/ifta-learning-dp/uploads/courses_libs/index.html"
                            title="المكتبة"> <img class="icon"
                              src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/images/viewer/icons/References.png"
                              alt=""> <span class="text">المكتبة</span> </a>
                          <a href="rm011.htm" class="hvr-bounce-to-bottom" title="الخلاصة"> <img class="icon"
                              src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/images/viewer/icons/unit_menu_icon_05.png"
                              alt=""> <span class="text">الملخص</span> </a>
                        </div>
                        <!-- Temp comes her -->
                        <div id="MainArea">
                          <div id="Temp009" class="MainBg" data-appear-animation="fadeIn" data-appear-animation-delay="100">
                            <div class="wrapper">
                              <div class="Title2" data-appear-animation="fadeInDown" data-appear-animation-delay="200">
                                <div class="table TitleBox2">
                                  <div class="table-row">
                                    <div class="table-cell td01"></div>
                                    <div class="table-cell td06">
                                      <div class="table TitleBox2-main">
                                        <div class="table-row">
                                          <div class="table-cell right-s">
                                          </div>
                                          <div class="table-cell">
                                          </div>
                                          <div class="table-cell left-s">
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="table-cell td07"></div>
                                  </div>
                                </div>
                              </div>
                              <div class="cleaner"></div>
                              <div id="MainScr" class="table MainScr" data-appear-animation="bounceIn"
                                data-appear-animation-delay="800">
                                <div class="table-row">
                                  <div class="table-cell MainScr_top_right"></div>
                                  <div class="table-cell MainScr_top_med"></div>
                                  <div class="table-cell MainScr_top_left"></div>
                                </div>
                                <div class="table-row">
                                  <div class="table-cell MainScr_med_right"></div>
                                  <div class="table-cell MainScr_med_med">
                                    <div class="TextArea content-rd">
             
        ';
              /////////////////////////////// end of header   //////////////////////////


              ///////////////////////////////begin of footer ////////////////////////////////

              $next = $count + 1;

              $bef = "LeftArrow";
              $nxt = "RightArrow";
              if ($count == 1) {
                $num = $count;
                $bef = "LeftArrow off ";
              } else {
                $num = $count - 1;
              }
/*



              <a href="01-01-01-0' . $num . '.html" class="' . $bef . '" title="السابق"></a>

         <a href="01-01-01-01.html" class="HomeArrow" title="المقدمة"></a> 

         <a href="01-01-01-0' . $next . '.html" class="' . $nxt . '" title="التالي"></a> 

*/


              $tools = '

              
        </div> 
        </div> 
        <div class="table-cell MainScr_med_left"></div> 
       </div> 
       <div class="table-row"> 
        <div class="table-cell MainScr_bot_right"></div> 
        <div class="table-cell MainScr_bot_med"> 

        <a href="01-01-01-0' . $num . '.html" class="' . $bef . '" title="السابق"></a>

        <a href="01-01-01-01.html" class="HomeArrow" title="المقدمة"></a> 

        <a href="01-01-01-0' . $next . '.html" class="' . $nxt . '" title="التالي"></a>

         <a href="javascript:void()" class="centerArrow " title="جميع الحقوق محفوظة دار الإفتاء المصرية"></a> 
         <img id="increaseFont" src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/images/templates/Temp-General/FontPlus.png" class="FontPlus" title="تكبير حجم الخط"> 
         <img src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/images/templates/Temp-General/fontDefualt.png" id="fontDefualt" class="fontDefualt" title="إستعاد حجم الخط"> 
         <img src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/images/templates/Temp-General/fontMins.png" id="decreaseFont" class="fontMins " title="تصغير حجم الخط"> 
        </div>'
        
        ;
              $footer = '
        <div class="table-cell MainScr_bot_left"></div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="cleaner"></div>
<div id="R03">
<div class="container">
<div class="row">
<div class="col-md-12">
<div class="table NavigationTable">
<div class="table-row">
<!-- <div id="blank_div" class="table-cell blank_div"> </div> -->
<!--  <div id="NavigationArea" class="table-cell">
<div class="NavBox"> <a href="0361-01.html" class="RightArrow off" title="السابق"></a>
<div class="pagerBox">
<div class="inner"> <span class="PageNum"> <span id="Page_N">99</span> <span>من</span> <span id="Page_T">99</span> </span>
<input id="p_txt" class="go_to HomeToolTip02" type="text" placeholder="ادخل" title="قم بادخال رقم الصفحة المراد الانتقال اليها">
<button id="go_btn" type="button"><i class="fa fa-hand-o-up"></i></button>
</div>
</div> 
<a href="#" class="LeftArrow" title="التالي"></a> </div>
</div>-->
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- <div class="footer"> جميع الحقوق محفوظة © | دار الإفتاء المصرية  </div> -->
<div class="modal fade modal_style1" id="Notes_Scr" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<div class="table modal_header_table">
<div class="table-row">
<div class="table-cell icon_area">
<img
  src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/images/viewer/icons/Note.png"
  width="23" height="23" alt="">
</div>
<div class="table-cell title_area">
ملاحظات الوحدة
</div>
<div class="table-cell close_area" data-dismiss="modal" aria-hidden="true">
<img
  src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/images/viewer/icons/close_big.png"
  width="20" height="20" data-dismiss="modal" aria-hidden="true" alt="">
</div>
</div>
</div>
</div>
<div class="modal-body">
<ul class="nav nav-tabs nav-left tabs-primary">
<li class="active"> <a href="#Add_Notes" data-toggle="tab"><i class="fa fa-plus"></i> إضافة ملاحظة</a>
</li>
</ul>
<div class="tab-content">
<div id="Add_Notes" class="tab-pane active">
<form>
<div class="form-group has-error has-feedback">
  <span class="new_title_icon"><i class="fa fa-quote-right" aria-hidden="true"></i></span>
  <label for="NoteTitle" class="new_title_txt">عنوان الملاحظة:</label>
  <input type="text" class="form-control " id="NoteTitle" placeholder="فضلا قم بادخال عنوان الملحوظة">
</div>
<div class="alert alert-danger" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <span class="sr-only">Error:</span> برجاء ادخال عنوان للملاحظة
</div>
<div class="form-group">
  <span class="new_title_icon"><i class="fa fa-align-right" aria-hidden="true"></i></span>
  <label class="new_title_txt" for="exampleInputPassword1">محتوي الملاحظة :</label>
  <textarea class="form-control" id="textarea" name="textarea"
    placeholder="فضلا قم بادخال عنوان الملحوظة"></textarea>
</div>
<div class="alert alert-danger hidden" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <span class="sr-only">خطأ:</span> برجاء ادخال محتوي للملاحظة
</div>
<div class="modal-footer">
  <div class="alert alert-success">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
    <span class="glyphicon icon-check icons" aria-hidden="true"></span> تم حفظ الملحوظة بنجاح
  </div>
  <a data-bb-handler="cancel" class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i
      class="fa fa-times"></i> إلغاء</a>
  <a data-bb-handler="confirm" class="btn btn-primary"><i class="fa fa-check"></i> حفظ</a>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- Vendor -->
<script
src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/vendor/jquery/jquery.min.js"></script>
<script
src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/vendor/jquery.appear/jquery.appear.min.js"></script>
<script
src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/vendor/jquery.easing/jquery.easing.min.js"></script>
<script
src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/vendor/jquery-cookie/jquery-cookie.min.js"></script>
<script
src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script
src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/vendor/common/common.min.js"></script>
<script
src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/vendor/jquery.validation/jquery.validation.min.js"></script>
<script
src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/vendor/jquery.stellar/jquery.stellar.min.js"></script>
<script
src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/vendor/jquery.lazyload/jquery.lazyload.min.js"></script>
<!-- Theme Base, Components and Settings 
<script src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/js/theme.js"></script> -->
<!-- Current Page Vendor and Views -->
<script
src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/js/views/view.home.js"></script>
<!-- Theme Custom -->
<script src=".https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/js/custom.js"></script>
<!-- Theme Initialization Files -->
<script
src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/js/theme.init.js"></script>
<!-- Tooltip  -->
<link rel="stylesheet" type="text/css"
href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/script/tooltipster/css/tooltipster.bundle.css">
<link rel="stylesheet" type="text/css"
href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/script/tooltipster/css/plugins/tooltipster/sideTip/themes/tooltipster-sideTip-borderless.min.css">
<link rel="stylesheet" type="text/css"
href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/script/tooltipster/css/plugins/tooltipster/sideTip/themes/tooltipster-sideTip-light.min.css">
<link rel="stylesheet" type="text/css"
href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/script/tooltipster/css/plugins/tooltipster/sideTip/themes/tooltipster-sideTip-punk.min.css">
<script type="text/javascript"
src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/script/tooltipster/js/tooltipster.bundle.min.js"></script>
<script>
$(document).ready(function () {



$(".fontMins, .FontPlus, .fontDefualt, .HomeArrow, .centerArrow ,.LeftArrow,.RightArrow,.HomeToolTip04,.HomeToolTip03,.HomeToolTip02,.HomeToolTip01,.tooltip_temp009").tooltipster(

{
animation: "grow",
delay: 10,
theme: "tooltipster-light",
touchDevices: true,
trigger: "hover",
maxWidth: 400,
distance: 5,
side: ["right", "top", "bottom", "left"]


}
);





});
</script>
<!-- Add fancyBox -->
<link rel="stylesheet"
href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/script/fancybox/source/jquery.fancybox8cbb.css?v=2.1.5"
type="text/css" media="screen">
<script type="text/javascript"
src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/script/fancybox/source/jquery.fancybox.pack8cbb.js?v=2.1.5"></script>
<!-- Optionally add helpers - button, thumbnail and/or media -->
<!--<link rel="stylesheet" href="script/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
<script type="text/javascript" src="script/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
<script type="text/javascript" src="script/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>

<link rel="stylesheet" href="script/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
<script type="text/javascript" src="script/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>-->
<!-- Text ReSizer -->
<script src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/script/textsizer.js"></script>
<script src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/js/custom.js"></script>
<script type="text/javascript">

$(document).ready(function () {
$(".fancybox").fancybox();
});

jQuery(document).ready(function () {
jQuery(".various").fancybox({
maxWidth: 1200,
maxHeight: 700,

fitToView: false,
width: "95%",
height: "98%",
autoSize: false,
closeClick: false,
openEffect: "fade",
openSpeed: 500,
closeEffect: "fade",
padding: 0,
closeBtn: false
});

jQuery(".PhotoPop").fancybox({
maxWidth: 1000,
maxHeight: 700,
minWidth: 200,
minHeight: 200,
fitToView: false,
//width		: "50%",
//height		: "50%",
fitToView: true,
autoSize: true,
autoScale: true,
closeClick: false,
openEffect: "fade",
openSpeed: 500,
closeEffect: "fade",
padding: 20,
closeBtn: true
});

jQuery(".PhotoPop").on("click", function () {
setTimeout(function () { $(".fancybox-skin").addClass("new-pop-01"); }, 50);
});


jQuery(".PhotoG").fancybox({
openEffect: "elastic",
closeEffect: "elastic",
});

jQuery(".PhotoG").on("click", function () {
setTimeout(function () { $(".fancybox-skin").addClass("new-pop-01"); }, 50);
});

$(".single_photo").fancybox({
maxWidth: 1600,
helpers: {
title: {
type: "float"
}
}
});

jQuery(".InteractivePhotoPop").fancybox({
maxWidth: 1200,
//maxHeight	: 700,
minWidth: 200,
minHeight: 200,
//fitToView	: false,
width: "90vw",
height: "90vh",
fitToView: true,
autoSize: true,
autoScale: true,
closeClick: false,
openEffect: "fade",
openSpeed: 500,
closeEffect: "fade",
padding: 20,
closeBtn: true
});

jQuery(".InteractivePhotoPop").on("click", function () {
setTimeout(function () { $(".fancybox-skin").addClass("new-pop-01"); }, 50);
setTimeout(function () { $(".fancybox-skin").addClass("Interactive-pop-01"); }, 50);
});

});
</script>
<!-- mCustomScrollbar -->
<link rel="stylesheet" type="text/css"
href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/script/mCustomScrollbar/jquery.mCustomScrollbar.css">
<script
src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/script/mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<script>
(function ($) {
$(window).on("load", function () {
$.mCustomScrollbar.defaults.scrollButtons.enable = true; //enable scrolling buttons by default
$(".p_menu_container").mCustomScrollbar({
axis: "y",
theme: "light-3",

});
$(".inner_txt").mCustomScrollbar({
axis: "y",
theme: "dark-3",

});
$(".Notes_result_wrapper").mCustomScrollbar({
axis: "y",
theme: "rounded-dark",

});
$(".TermsArea").mCustomScrollbar({
axis: "y",
theme: "rounded-dark",

});

$(".ReferencesArea").mCustomScrollbar({
axis: "y",
theme: "rounded-dark",

});

$(".content-rd").mCustomScrollbar({
axis: "y",
theme: "rounded-dark",

});

$(".dark-3").mCustomScrollbar({
axis: "y",
theme: "dark-3",

});
});
})(jQuery);
</script>
<script>
(function ($) {
$(window).on("load", function () {
$.mCustomScrollbar.defaults.scrollButtons.enable = true; //enable scrolling buttons by default
$(".modal-mCustomScrollbar").mCustomScrollbar({
axis: "yx",
theme: "dark-3",
setHeight: 400,

});


});
})(jQuery);
</script>
<!-- Pushy CSS -->
<link rel="stylesheet"
href="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/script/pushy/css/pushy.css">
<script
src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/script/pushy/js/pushy.js"></script>
<!--<script>

$("#SearchBtn").on("click", function ()
{ pushy = $("#Search"); push = $("#Search"); init(); DPush(); });

$("#MenuBtn").on("click", function ()
{ pushy = $("#MainMenu"); push = $("#MainMenu"); init(); DPush(); });
</script>-->
<!-- Animated Collapsible DIV v2.4 -->
<script type="text/javascript">
var Closed = false;
jQuery(document).ready(function () {
$("#t0_btn").on("click", function () {


if (!Closed) {
$(".blank_div").animate({ opacity: 0 }, 400);
Closed = true;
}
else {

$(".blank_div").animate({ opacity: 1, }, 400);
Closed = false;
}


})


});
</script>
<script type="text/javascript"
src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/script/AnimatedCollapsibleDIVv2.4/animatedcollapse.js"></script>
<script type="text/javascript">
animatedcollapse.addDiv("HelpingTools", "fade=1,speed=400,group=HelpingTools")

//animatedcollapse.addDiv("home_u_btn", "fade=1,speed=400,group=u_btns")
//animatedcollapse.addDiv("introduction_u_btn", "fade=1,speed=400,group=u_btns,hide=1")
//animatedcollapse.addDiv("objectives_u_btn", "fade=1,speed=400,group=u_btns,hide=1")
//animatedcollapse.addDiv("activities_u_btn", "fade=1,speed=400,group=u_btns")
//animatedcollapse.addDiv("output_u_btn", "fade=1,speed=400,group=u_btns,hide=1")
//animatedcollapse.addDiv("summary_u_btn", "fade=1,speed=400,group=u_btns,hide=1")
//animatedcollapse.addDiv("LearningResources_u_btn", "fade=1,speed=400,group=u_btns,hide=1")

animatedcollapse.ontoggle = function ($, divobj, state) { //fires each time a DIV is expanded/contracted
//$: Access to jQuery
//divobj: DOM reference to DIV being expanded/ collapsed. Use "divobj.id" to get its ID
//state: "block" or "none", depending on state


}

animatedcollapse.init()

</script>
<!-- slick 1.6 JS -->
<script
src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/script/slick_1.6/slick.js"
type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
$(document).on("ready", function () {

$(".slider-for").slick({

arrows: false,
fade: true,
dots: false,
adaptiveHeight: true,
asNavFor: ".slider-nav",
rtl: true,
});
$(".slider-nav").slick({
centerMode: true,
centerPadding: "00px",
slidesToShow: 3,
slidesToScroll: 1,
autoplay: false,
autoplaySpeed: 2000,
adaptiveHeight: true,
asNavFor: ".slider-for",
rtl: true,
arrows: false,


focusOnSelect: true
});

$(".PhotosWrapper").slick({
infinite: true,
slidesToShow: 3,
slidesToScroll: 1,
rtl: true,
adaptiveHeight: true,
dots: true,
infinite: false,
responsive: [
{
breakpoint: 769,
settings: {
slidesToShow: 2,
slidesToScroll: 2,

}
},

{
breakpoint: 601,
settings: {
slidesToShow: 1,
slidesToScroll: 1,

}
},
]
});

$("#grid-containter").slick({
infinite: true,
slidesToShow: 3,
slidesToScroll: 1,
rtl: true,
adaptiveHeight: true,
dots: true,
infinite: false,
responsive: [
{
breakpoint: 992,
settings: {
slidesToShow: 2,
slidesToScroll: 2,

}
},

{
breakpoint: 550,
settings: {
slidesToShow: 1,
slidesToScroll: 1,

}
},
]
});

$(".DragSlider").slick({
infinite: true,
slidesToShow: 5,
slidesToScroll: 1,
rtl: true,
adaptiveHeight: true,
dots: true,
arrows: true,
infinite: false,
responsive: [
{
breakpoint: 991,
settings: {
slidesToShow: 3,
slidesToScroll: 1,

}
},

{
breakpoint: 601,
settings: {
dots: true,
arrows: true,
slidesToShow: 2,
slidesToScroll: 1,

}
},

{
breakpoint: 360,
settings: {
slidesToShow: 1,
slidesToScroll: 1,

}
},


]
});

//$(".tabs_links").slick({
//  
//  slidesToShow: 3,
//  slidesToScroll: 1,
//  rtl:true,
//  adaptiveHeight: true,
//  dots: false,
//  infinite: false,
//  responsive: [
//    {
//      breakpoint: 768,
//      settings: {
//        slidesToShow: 2,
//        slidesToScroll: 1,
//       
//      }
//    },
//	
//	{
//      breakpoint: 481,
//      settings: {
//        slidesToShow: 1,
//        slidesToScroll: 1,
//       
//      }
//    },
//]
//});

$(".tabs_links").slick({

slidesToShow: 3,
slidesToScroll: 1,
//rtl:true,
adaptiveHeight: true,
dots: false,
infinite: false,
vertical: true,
verticalSwiping: true,
responsive: [
{
breakpoint: 992,
settings: {
vertical: false,
slidesToShow: 3,
slidesToScroll: 1,
rtl: true,

}
},

{
breakpoint: 768,
settings: {
slidesToShow: 2,
slidesToScroll: 1,
vertical: false,
rtl: true,

}
},

{
breakpoint: 481,
settings: {
slidesToShow: 1,
slidesToScroll: 1,
vertical: false,
rtl: true,

}
},
]
});

});
</script>
<!-- tabs-module | http://jsfiddle.net/HTHnW/2/ -->
<script type="text/javascript">//<![CDATA[
$(window).load(function () {
$(".tabs_links a").on("click", function () {
$(this).addClass("current_tab");
$(this).parent().siblings().find("a").removeClass("current_tab");
});
});//]]> 

</script>
<!-- Flip JS -->
<script
src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/script/Flip_1.1.1/jquery.flip.js"
type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
$(function () {

$(".card-grid").flip({
trigger: "click",
autoSize: true,
});

});
</script>
<!-- IE 10 hack css | https://css-tricks.com/ie-10-specific-styles/ -->
<script>
var doc = document.documentElement;
doc.setAttribute("data-useragent", navigator.userAgent);
</script>
<script type="text/javascript">
jQuery(document).ready(function () {


var src = $("#goal_chr").attr("src");
$("#goal_chr").attr("src", src + "?" + Math.random());

});

</script>
<script
src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/script/nav.js"></script>
<!-- Full screen with animation problem solution  -->
<script>
$(document).on("webkitfullscreenchange", function () {
if (document.webkitFullscreenElement !== null) {
$("body").addClass("in-fullscreen");
} else {
$("body").removeClass("in-fullscreen");
}
});
</script>
</body>

</html>';






              /////////////////////////////end of footer ////////////////////////////////////////
           } }
            if ($kid1 == 'N') {
              $count++;
              $text = $pageTop . $text . $tools . $footer;
              fwrite($myfile, $text);
              $color = "";
              $size = "";
              $Bold = "";
              $Font = "";
              $text = "";
              $page++;
            }
            if ($kid1 == 'EB') {

              $page++;
              $text .= "<br>";
            }


            $myfile = fopen($username."/".$result."/01-01-01-0" . $count . ".html", "w") or die("Unable to open file!");
          }
        }
      }
    
    //  echo $count."<br>";
    if ($page < $count - 1) {
      $text = $pageTop . $text . $tools . $footer;
    } else {
     // echo $count;
      $next = $count;
      ////////////////////////

      $tools = '
      </div> 
      </div> 
      <div class="table-cell MainScr_med_left"></div> 
     </div> 
     <div class="table-row"> 
      <div class="table-cell MainScr_bot_right"></div> 
      <div class="table-cell MainScr_bot_med"> 

      <a href="01-01-01-0' .$num . '.html" class=' . $bef . ' title="السابق"></a>

       <a href="01-01-01-01.html" class="HomeArrow" title="المقدمة"></a> 

       <a href="01-01-01-0' . $next . '.html" class="RightArrow off" title="التالي"></a> 

       <a href="javascript:void()" class="centerArrow " title="جميع الحقوق محفوظة دار الإفتاء المصرية"></a> 
       <img id="increaseFont" src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/images/templates/Temp-General/FontPlus.png" class="FontPlus" title="تكبير حجم الخط"> 
       <img src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/images/templates/Temp-General/fontDefualt.png" id="bahij" class="fontDefualt" title="إستعاد حجم الخط"> 
       <img src="https://storage.googleapis.com/ifta-learning-dp/uploads/ifta_content/temps/nassets/images/templates/Temp-General/fontMins.png" id="decreaseFont" class="fontMins " title="تصغير حجم الخط"> 
      </div>';
      ////////////////////////
      $text = $pageTop . $text . $tools . $footer;
    }
    //$nxt="LeftArrow  off tooltipstered";


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






  ///////////////////////////
  
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
 $Lname= $this->tester($nam,$username,$name,$Name_Lesson);
  echo '<a href="'.$username.'/'.$name.'/'.$Lname.'" > أضغط لتحميل الملف </a>';
$data="$username.'/'.$name.'/'.$Lname.'"; 
  //echo '<a href="'.$username.'/'.$name.'/'.$request->lesson.$zipname.'" > أضغط لتحميل الملف </a>';
  return redirect()->back()->with(['data' => $data]);
  


      }
     //return $data;
  }
}
