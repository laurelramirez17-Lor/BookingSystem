@extends('layouts.app')

@section('content')

@include('rooms.form', [
    'title' => 'Add Room',
    'action' => route('rooms.store'),
    'method' => 'POST',
    'room' => new \App\Models\Room(),
])

@endsection
