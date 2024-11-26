@extends('layouts.guest2')

@section('content')
<div class="text-center mb-8">
    <h1 class="text-2xl font-bold text-gray-900 mb-2">
        Autenticação em Dois Fatores
    </h1>
    <p class="text-sm text-gray-600">
        Insira o código de verificação enviado para o seu e-mail.
    </p>
</div>

<form action="{{ route('auth.two-factor') }}" method="POST">
    @csrf

    <div class="mb-6">
        <label for="two_factor_code" class="block text-sm font-medium text-gray-700 mb-1">
            Código de Verificação
        </label>

        <div class="mt-1">
            <input
                type="text"
                name="two_factor_code"
                id="two_factor_code"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('two_factor_code') border-red-500 @enderror"
                placeholder="Digite o código"
                required
                autofocus
                autocomplete="off">
        </div>

        @error('two_factor_code')
        <p class="mt-2 text-sm text-red-600">
            {{ $message }}
        </p>
        @enderror
    </div>

    <div class="flex items-center justify-between">
        <button
            type="submit"
            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Verificar Código
        </button>
    </div>
</form>


    <div class="mt-6 text-center">
        <p class="text-sm text-gray-600">
            Não recebeu o código?
        <form action="{{ route('auth.two-factor.resend') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="font-medium text-indigo-600 hover:text-indigo-500">
                Reenviar código
            </button>
        </form>
        </p>
    </div>

@endsection