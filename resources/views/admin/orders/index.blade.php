@extends('app')
@section('content')
    <div class="container">
        <h3>Pedidos</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>CLIENTE</th>
                    <th>DATA</th>
				    <th>ITENS</th>
                    <th>ENTREGADOR</th>
                    <th>TOTAL</th>
                    <th>STATUS</th>
                    <th width="80">AÇÃO</th>
                </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->client->user->name }}</td>
                    <td>{{$order->created_at}}</td>
                    <td>
                        <ul>
                        @foreach($order->items as $item)
                            <li>{{$item->product->name}}</li>
                        @endforeach
                        </ul>
                    </td>
                    @if(isset($order->deliveryman->name))
                        <td>{{$order->deliveryman->name}}</td>
                    @else
                        <td>-</td>
                    @endif
                    <td>{{ $order->total }}</td>
                    <td>{{ $order->status->name }}</td>
                    <td>
                        <a href="{{ route('admin.orders.edit', ['id' => $order->id]) }}" class="btn btn-default btn-sm"> Editar</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $orders->render() !!}
    </div>
@endsection 