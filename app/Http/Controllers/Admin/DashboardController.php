<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use DB ;
use Redis ;

class DashboardController extends AdminController
{  
    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function show(Request $request)
    {
      return view('admin/dashboard');
    }
    
    public function remember(Request $request)
    {
      
      // toggle state 
      if( $request->has('toggled') )  $request->session()->put('toggled', $request->input('toggled') );
      
      // toggle shop 
      if( $request->has('shop') )  $request->session()->put('shop', $request->input('shop') );
      
      // toggle language 
      if( $request->has('language') )  $request->session()->put('language', $request->input('language') );
      
    }
}