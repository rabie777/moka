<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
  
  public function rabie(Request $request)
  {
      if ($file   =   $request->file('filename')) {
          $filename = 'uploaded-here.' . $file->getClientOriginalExtension();
      }
  }
}
