<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\ValidRequest;
use ZipArchive;

class InterFaceController extends Controller
{

    public function rabie(ValidRequest $request)
    {
       //echo "rabie";  
        $value = $request->file('filename');

        // if ($validator->fails()) 
        // {echo "error here";
        //     return back()->withErrors($validator->errors());
        // }
        
         if($request->file('filename')){
            $file = $request->file('filename');
            $username=Auth::user()->name;
       
        $current_time =time();
       // $currentTimeinSeconds= date("h:i:sa");
        $currentDate=date('Y-m-d-h-i-s');
      //  $currentDate2=date(' j-m-y');
      
      //  echo $currentDate2;

            $originalname = $file->getClientOriginalName();
            $name =  $username.'_'. $currentDate;
            $extention=$file->getClientOriginalExtension();
             
            
           // return "done";
          
        
        $filename=$file;
      
       
            $search2="</w:document>";
          
           
        $contents = file_get_contents($filename);
       
        $contents = preg_replace('/' . preg_quote('<w:document') . 
                          '.*?' .
                          preg_quote('>') . '/', '',  $contents);
      
        $contents = str_replace( $search2, "", $contents);
        $contents = str_replace("w:", "w", $contents);
        file_put_contents($filename,$contents);


        $data=$filename;
        //$secondfolder=mkdir($name);
        $dir1=mkdir($username.'/'.$name, 0777, true);
     
        
         $file->move($username.'/'.$name ,  $originalname );
         $files1 = scandir($username.'/'.$name);
//dd($files1);




 $zipname = '.zip';
        $zip = new ZipArchive;
      
        $zip->open($username.'/'.$name.'/'.$request->lesson.$zipname, ZipArchive::CREATE);
        foreach ($files1 as $file) {
            
       

            $file_parts = pathinfo($file);

        if($file_parts['extension']=="xml"){
            //print_r($file);
           // echo $file."<br>";
    
  
          $zip->addFile($username.'/'.$name.'/'.$file,$file);
       echo "ddddddddddd".$file;
         
        }
        
    }
    
    $zip->close();

    
    echo '<a href="'.$username.'/'.$name.'/'.$request->lesson.$zipname.'" > أضغط لتحميل الملف </a>';
    //return redirect()->route('test')->file('value');
     


        }
       return $data;
    }

}
