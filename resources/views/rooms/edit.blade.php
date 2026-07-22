@extends('layouts.app')

@section('content')

@include('rooms.form', [
    'title' => 'Edit Room',
    'action' => route('rooms.update', $room),
    'method' => 'PUT',
    'room' => $room,
])

@endsection
