@extends('app')
@section('content')
    <div class="container">
        <div class="well">
            <h3>Pedido #{{$order->id}} - R${{$order->total}}</h3>
            <h4>Cliente: {{$order->client->user->name}}</h4>
            <h4>Data: {{$order->created_at}}</h4>
            <p><b>Entregar em:</b><br> {{$order->client->address}} - {{$order->client->state}}</p>
        </div>
        @include('errors._check')
        {!! Form::open(['route' => ['admin.orders.update', $order->id]]) !!}
            <div class="form-group">
                {!! Form::label('user_deliveryman_id', 'Entregador:') !!}
                {!! Form::select('user_deliveryman_id', $deliveryman, null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('status_id', 'Status:') !!}
                {!! Form::select('status_id', $status, null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::submit('Salvar pedido', ['class' => 'btn btn-primary']) !!}
            </div>
            
        {!! Form::close() !!}
    </div>
@endsection 