<?php

namespace App\Http\Controllers\Admin;
use App\Models\Page;
use App\Http\Traits\Media;
use Validator ;
use Input ;
use Session ;
use Redirect ;

class PagesController extends AdminController
{
  use Media ; 
  
  /**
   * List all pages
   *
   * @return Response
   */
  public function index()
  {
    $pages = Page::where('shop_id', '=', Session::get('shop'))->get() ;
    return view('admin/pages/index', ['pages' => $pages]);
  }
  
  /**
   * Create a page
   *
   * @return Response
   */
  public function create()
  {
    return view('admin/pages/create');
  }
  
  /**
   * Save a page
   * 
   * @return Redirect
   */
  public function store(  )
  {
    // validate
    $rules = [
      'name'       => 'required'
    ];
    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      return Redirect::to('admin/pages/create')
        ->withErrors($validator)
        ->withInput();
    } else {
      // store
      $lang = Session::get('language');
      $page = new Page;
      $page->shop_id = Input::get('shop_id');
      $page->slug = Input::get('slug');
      $data = Input::except(['shop_id', 'slug', '_token', '_method']) ;
      $page->$lang = $data ;
      if($lang==config('app.locale')){
        $page->default = $data ;
      }
      $page->save();

      // redirect
      Session::flash('success',  trans('pages.page').' '.trans('crud.created'));
      return Redirect::to('admin/pages/' . $page->id . '/edit');
    }
  }
  
  /**
   * Edit a page
   *
   * @param string $id
   * 
   * @return Response
   */
  public function edit( $id )
  {
    $page = Page::find($id) ;
    $files = $this->getFiles('images/pages/'.$page->id.'/'.key(config('filesystems.image_sizes')));
    return view('admin/pages/edit', ['page' => $page, 'files' => $files]);
  }
  
  /**
   * Update a page
   *
   * @param string $id
   * 
   * @return Redirect
   */
  public function update( $id )
  {
    // validate
    $rules = [
      'name'       => 'required'
    ];
    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      return Redirect::to('admin/pages/' . $id . '/edit')
        ->withErrors($validator)
        ->withInput();
    } else {
      // store
      $lang = Session::get('language');
      $page = Page::find($id);
      $page->shop_id = Input::get('shop_id');
      $page->slug = Input::get('slug');
      $data = Input::except(['shop_id', 'slug', '_token', '_method']) ;
      $page->$lang = $data ;
      if($lang==config('app.locale')){
        $page->default = $data ;
      }
      $page->save();

      // redirect
      Session::flash('success', trans('pages.page').' '.trans('crud.updated'));
      return Redirect::to('admin/pages/' . $id . '/edit');
    }
  }
  
  /**
   * Delete a page
   *
   * @param string $id
   * 
   * @return Redirect
   */
  public function destroy( $id )
  {
    // delete
    $page = Page::find($id);      
    $page->delete();

    // redirect
    Session::flash('success',  trans('pages.page').' '.trans('crud.deleted'));
    return Redirect::to('admin/pages');
  }
}