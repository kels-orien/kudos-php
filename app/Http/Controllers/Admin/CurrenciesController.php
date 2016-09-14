<?php

namespace App\Http\Controllers\Admin;
use App\Models\Currency;
use Input ;
use Session ;
use Redirect ;

class CurrenciesController extends AdminController
{
  /**
   * Automatically get currency rates from fixer.io
   *
   * @return Redirect
   */
  public function auto()
  {
    $url = 'http://api.fixer.io/latest?base='.env('APP_CURRENCY');
    $rates = json_decode(file_get_contents($url), true);
    if($rates){
      $currency = Currency::firstOrNew([ 
        'currency'  => env('APP_CURRENCY'),
        'rate'      => 1
      ]);
      $currency->save() ;
      foreach($rates['rates'] as $code => $rate){
        $currency = Currency::firstOrNew([ 
          'currency'  => $code
        ]);
        $currency->rate = $rate ;
        $currency->save() ;
      }
      Session::flash('success',  trans('currencies.currency').' '.trans('crud.updated'));
      return Redirect::to('admin/currencies');
    }
    Session::flash('danger',  trans('currencies.currencies').' '.trans('crud.failed'));
    return Redirect::to('admin/currencies');
  }
  
  /**
   * List all currencies
   *
   * @return Response
   */
  public function index()
  {
    $currencies = Currency::all() ;
    return view('admin/currencies/index', ['currencies' => $currencies]);
  }
  
  /**
   * Create a currency
   *
   * @return Response
   */
  public function create()
  {
    return view('admin/currencies/create');
  }
  
  /**
   * Save a currency
   * 
   * @return Redirect
   */
  public function store()
  {
    // store
    $data = Input::except(['_token', '_method']) ;
    $currency = Currency::create($data);

    // redirect
    Session::flash('success',  trans('currencies.currency').' '.trans('crud.created'));
    return Redirect::to('admin/currencies/' . $currency->id . '/edit');
  }
  
  /**
   * Edit a currency
   *
   * @param string $id
   * 
   * @return Response
   */
  public function edit( $id )
  {
    $currency = Currency::find($id) ;
    return view('admin/currencies/edit', ['currency' => $currency]);
  }
  
  /**
   * Update a currency
   *
   * @param string $id
   * 
   * @return Redirect
   */
  public function update( $id )
  {
    // store
    $currency = Currency::find($id);
    $data = Input::except(['_token', '_method']) ;
    $currency->fill($data) ;
    $currency->save();

    // redirect
    Session::flash('success', trans('currencies.currency').' '.trans('crud.updated'));
    return Redirect::to('admin/currencies/' . $id . '/edit');
  }
  
  /**
   * Delete a currency
   *
   * @param string $id
   * 
   * @return Redirect
   */
  public function destroy( $id )
  {
    // delete
    $currency = Currency::find($id);      
    $currency->delete();

    // redirect
    Session::flash('success',  trans('currencies.currency').' '.trans('crud.deleted'));
    return Redirect::to('admin/currencies');
  }
}