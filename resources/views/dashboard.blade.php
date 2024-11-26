@extends('layouts.app')

@section('content')
<div>
    <h1>Configurações</h1>
    
    @if(session('status'))
        <p>{{ session('status') }}</p>
    @endif

    <form method="POST" action="{{ route('settings.toggleTwoFactor') }}">
        @csrf
        <p>Autenticação em dois fatores: 
            @if(auth()->user()->two_factor_enabled)
                <strong>Ativada</strong>
            @else
                <strong>Desativada</strong>
            @endif
        </p>
        <button type="submit">
            @if(auth()->user()->two_factor_enabled)
                Desativar
            @else
                Ativar
            @endif
        </button>
    </form>
</div>
@endsection
