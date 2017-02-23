@extends('app')
@section('content')
    <div class="container">
        <h3>Editando cupom {{ $cupom->code }}</h3>        
        @include('errors._check')
        {!! Form::model($cupom, ['route' => ['admin.cupoms.update', $cupom->id]]) !!}
            @include('admin.cupoms._form')
            <div class="form-group">
                {!! Form::submit('Salvar cupom', ['class' => 'btn btn-primary']) !!}
            </div>
            
        {!! Form::close() !!}
    </div>
@endsection 