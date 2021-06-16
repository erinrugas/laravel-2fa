@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12 mt-5">
        <div class="card">
            <div class="card-header">
                Home Page
            </div>
            <div class="card-body">
                <p>You are logged in as {{ auth()->user()->name }}</p>
            </div>
        </div>
    </div>
</div>

@endsection