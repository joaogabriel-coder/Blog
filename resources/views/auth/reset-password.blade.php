<x-layout>
    <divc class="container">
        @if(@session()->has('status'))
            <span class="text text-success">{{session()->get('status')}}</span>
        @endif

        <h2>Resetar Senha</h2>
        <form action="{{ route('password.update') }}" method="POST">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
                <input type="text" name="email" placeholder="Email">
             @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <input type="text" name="password" placeholder="Digite sua nova senha">
            @error('password_confirmation')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <input type="text" name="password_confirmation" placeholder="Confirme sua nova senha">

            <button type="submit">Enviar</button>
        </form>
    </div>
</x-layout>
