@extends('layouts.app')

@section('titulo', 'Novo Cliente')

@section('conteudo')
    <h1>Novo Cliente</h1>

    <form method="POST" action="{{ route('clientes.store') }}">
        @csrf

        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" name="nome" id="nome" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control">
        </div>

        <div class="mb-3">
            <label for="telefone" class="form-label">Telefone</label>
            <input type="text" name="telefone" id="telefone" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
    </form>
@endsection
