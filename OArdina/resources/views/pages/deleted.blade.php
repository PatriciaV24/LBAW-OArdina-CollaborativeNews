@extends('layouts.app')

@section('title', 'Xekkit | Deleted Account')

@section('content')

<div class="text-center text-white p-5">
    <h2 class="mb-3">Your account has been deleted</h2>
    <form method="POST" action="/recover_user" class="g-3 p-3 row justify-content-center">
        {{ csrf_field() }}
        <div class="col-7 mb-3">
            <label for="inputOldPassword">Password*</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary btn-lg col-6">Recover account</button>
    </form>
    <form method="GET" action="/logout" class="g-3 p-3 row justify-content-center">
        {{ csrf_field() }}
        <button type="submit" class="btn btn-outline-secondary btn-lg col-6">Logout</button>
    </form>
</div>

@endsection
