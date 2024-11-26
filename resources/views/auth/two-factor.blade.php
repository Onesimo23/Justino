@extends('layouts.guest2')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-100 via-blue-200 to-blue-300 flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-md mx-auto">
        <div class="bg-white shadow-2xl rounded-2xl overflow-hidden transform transition-all duration-300 hover:scale-[1.02]">
            <div class="p-8">
                <div class="text-center mb-8">
                    <div class="mb-4 flex justify-center">
                        <svg class="w-16 h-16 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>

                    <h1 class="text-3xl font-extrabold text-gray-900 mb-3 tracking-tight">
                        Verificação 2FA
                    </h1>
                    <p class="text-sm text-gray-600 max-w-xs mx-auto">
                        Insira o código de 6 dígitos enviado para seu e-mail para confirmar sua identidade.
                    </p>
                </div>

                <form action="{{ route('auth.two-factor') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="two_factor_code" class="sr-only">Código de Verificação</label>
                        <div class="relative">
                            <input
                                type="text"
                                name="two_factor_code"
                                id="two_factor_code"
                                pattern="\d{6}"
                                maxlength="6"
                                class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-300 transition duration-300 text-center text-2xl font-bold tracking-widest @error('two_factor_code') border-red-500 @enderror"
                                placeholder="_ _ _ _ _ _"
                                required
                                autofocus
                                autocomplete="off"
                            >
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>

                        @error('two_factor_code')
                            <p class="mt-2 text-sm text-red-600 text-center">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-blue-600 text-white py-3 rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition duration-300 ease-in-out transform hover:scale-[1.02] shadow-lg hover:shadow-xl"
                    >
                        Verificar Código
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Não recebeu o código? 
                        <form action="{{ route('auth.two-factor.resend') }}" method="POST" class="inline">
                            @csrf
                            <button 
                                type="submit" 
                                class="font-semibold text-blue-600 hover:text-blue-800 transition duration-300 ml-1"
                            >
                                Reenviar código
                            </button>
                        </form>
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-6 text-center text-gray-600 text-sm">
            <p>Proteja sua conta com verificação em dois fatores</p>
        </div>
    </div>
</div>
@endsection