@extends('app')
@section('content')
    <div class="container">
        <h3>Meus pedidos</h3>
        
        <a href="{{ route('customer.order.create') }}" class="btn btn-default">Novo pedido</a><br><br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>TOTAL</th>
                    <th>STATUS</th>
                    <th width="150">AÇÃO</th>
                </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->total }}</td>
                    <td>{{ $order->status->name }}</td>
                    <td>
                        
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $orders->render() !!}
    </div>
@endsection 