@extends('admin.layouts.app')

@section('content')
  <div class="title row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-12">
          <h1><a href="/admin/shops">{{ trans('shops.shops') }}</a> > {{ trans('crud.create') }}</h1>
        </div>
      </div>
    </div>
  </div>
  
  <section>
    <div class="container-fluid">
      {{ Html::ul($errors->all(), ['class' => 'alert alert-danger']) }}
      {{ Form::open(['url' => 'admin/shops']) }}
        {{ Form::label('name', trans('shops.shop_name')) }}
        {{ Form::text('name', '', ['class' => 'form-control', 'required' => 'required']) }}
        {{ Form::label('code', trans('shops.code')) }}
        {{ Form::text('code', '', ['class' => 'form-control', 'required' => 'required']) }}
        {{ Form::label('url', trans('fields.url')) }}
        {{ Form::url('url', '', ['class' => 'form-control', 'required' => 'required']) }}
        {{ Form::submit(trans('crud.create'), ['class' => 'btn btn-primary']) }}
      {{ Form::close() }}
    </div>
  </section>
    
@endsection
