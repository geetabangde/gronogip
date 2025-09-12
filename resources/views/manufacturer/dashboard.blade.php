@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <h1>Manufacturer Dashboard</h1>
    <p>Welcome, {{ Auth::guard('admin')->user()->name }}</p>
</div>
@endsection
