{{ Auth::user()->name }}

<form action="/logout" method="POST">
    @csrf
    <button type="submit">Sair</button>
</form>