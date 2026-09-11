@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


Welcome , {{ Auth::user()->name }}

<br><br>

<form action="{{ route('users.logout') }}" method="POST">
    @csrf

    <button type="submit">
        Logout
    </button>
</form>