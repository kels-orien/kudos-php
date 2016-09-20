@extends('themes.Basic.layouts.account')

@section('content')
<h1>{{ trans('orders.orders') }}</h1>
<table class="table table-striped">
  <thead>
    <tr>
      <th>{{ trans('orders.ref') }}</th>
      <th>{{ trans('orders.total') }}</th>
      <th>{{ trans('orders.date') }}</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($orders as $order)
    <tr>
      <td><a href="/account/orders/{{ $order->id }}">{{ $order->id }}</a></td>
      <td><a href="/account/orders/{{ $order->id }}">&pound;{{ $order->total }}</a></td>
      <td><a href="/account/orders/{{ $order->id }}">{{ $order->created_at }}</a></td>
    </tr>    
    @endforeach
  </tbody>
</table>
{{ $orders->links() }}
@endsection