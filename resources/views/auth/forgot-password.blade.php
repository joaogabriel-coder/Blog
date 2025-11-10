<x-layout>
    <divc class="">
        @if(@session()->has('status'))
            <span class="text text-success">{{session()->get('status')}}</span>
        @endif

        <h2 >Resetar Senha</h2>
        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <input type="text" name="email" placeholder="Email">

            <button type="submit" class="">Enviar link de recuperação de senha</button>
        </form>
    </div>
</x-layout>
