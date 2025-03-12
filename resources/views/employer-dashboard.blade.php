
<h1>Welcome, {{ auth()->guard('employer')->user()->name }}</h1>
<form method="POST" action="{{ route('employer.logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>
