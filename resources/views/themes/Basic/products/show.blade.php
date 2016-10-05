@extends('themes.Basic.layouts.app')

@section('content')
  <div class="row">
    <div class="col-md-6">
      <img src="/storage/{{ str_replace('/thumb/', '/large/', $product->defaultImage) }}" class="img-responsive">
      <ul class="row">
      @foreach($product->files as $thumb)
        <li class="col-md-4">
          <img src="/storage/{{ $thumb }}" class="img-responsive">
        </li>
      @endforeach
      </ul>
    </div>
    <div class="col-md-6">
      <h1>{{ isset($product->$language['name']) ? $product->$language['name'] : $product->default['name'] }}</h1>
      <p id="excerpt">{{ isset($product->$language['excerpt']) ? $product->$language['excerpt'] : $product->default['excerpt'] }}</p>
      <div id="price">
        @if(!empty($product->rrp))
        <p>rrp: <strong>&pound;{{ $product->rrp }}</strong></p>
        @endif
        @if(!empty($product->salePrice))
        <p>was: <strong>&pound;{{ $product->price}}</strong></p>
        <p>now: <strong>&pound;{{ $product->salePrice}}</strong></p>
        @else
        <p>price: <strong>&pound;{{ $product->price}}</strong></p>
        @endif
      </div>
      {{ Form::open(['url' => 'basket']) }}
        {{ Form::hidden('id',  $product['id']) }}
        {{ Form::hidden('price',  isset($product->salePrice) ? $product->salePrice : $product->price) }}
        {{ Form::submit('Add to Basket', ['class' => 'btn btn-primary']) }}
      {{ Form::close() }}
    </div>
  </div>
  <hr>
  <h3>Product Details</h3>
  <div class="content">
    {!! isset($product->$language['content']) ? $product->$language['content'] : $product->default['content'] !!}
  </div>
@endsection
