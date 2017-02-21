@extends('app')
@section('content')
    <div class="container">
        <h3>Clientes</h3>
        <a href="{{ route('admin.clients.create') }}" class="btn btn-default">Novo Cliente</a><br><br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NOME</th>
                    <th>E-MAIL</th>
                    <th>FONE</th>
                    <th width="150">AÇÃO</th>
                </tr>
            </thead>
            <tbody>
            @foreach($clients as $client)
                <tr>
                    <td>{{ $client->id }}</td>
                    <td>{{ $client->user->name }}</td>
                    <td>{{ $client->user->email }}</td>
                    <td>{{ $client->phone }}</td>
                    <td>
                        <a href="{{ route('admin.clients.edit', ['id' => $client->id]) }}" class="btn btn-default btn-sm"> Editar</a>
                        <a href="#" class="btn btn-danger btn-sm" disabled> Remover</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $clients->render() !!}
    </div>
@endsection 