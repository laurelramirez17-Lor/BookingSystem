@extends('layouts.app')

@section('content')

<style>
    .event-container {
        max-width: 800px;
        margin-top: 50px;
    }

    .event-card {
        background: rgba(27, 58, 42, 0.75);
        border: 1px solid rgba(76,175,80,0.3);
        border-radius: 16px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.5);
        backdrop-filter: blur(12px);
        overflow: hidden;
        color: #e8f5e9;
    }

    .event-header {
        background: #1b5e20;
        padding: 18px;
        color: #c8e6c9;
        font-weight: 600;
        letter-spacing: 1px;
    }

    .event-body {
        padding: 30px;
    }

    .form-label {
        color: #a5d6a7;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* INPUT FIX */
    .form-control {
        background: rgba(255,255,255,0.08);
        border: 1px solid #4caf50;
        color: #e8f5e9 !important;
        border-radius: 10px;
    }

    .form-control:focus {
        background: rgba(255,255,255,0.12);
        border-color: #81c784;
        box-shadow: 0 0 10px rgba(76,175,80,0.4);
        color: #e8f5e9 !important;
    }

    .form-control::placeholder {
        color: rgba(232, 245, 233, 0.6);
    }

    select.form-control option {
        color: #000;
        background: #fff;
    }

    input.form-control:-webkit-autofill {
        -webkit-text-fill-color: #e8f5e9 !important;
        -webkit-box-shadow: 0 0 0px 1000px #1b3a2a inset;
    }

    .btn-event {
        background: linear-gradient(90deg, #1b5e20, #4caf50);
        border: 1px solid #66bb6a;
        color: #e8f5e9;
        font-weight: 600;
        padding: 12px;
        border-radius: 10px;
        text-transform: uppercase;
        transition: 0.3s ease;
    }

    .btn-event:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(76,175,80,0.3);
    }
</style>

<div class="container event-container">

    <div class="event-card">

        <div class="event-header">
            🏨 Edit Event / Room
        </div>

        <div class="event-body">

            <form method="POST" action="{{ route('events.update', $event) }}">
                @csrf
                @method('PUT')

                <!-- NAME -->
                <div class="mb-3">
                    <label class="form-label">Event / Room Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $event->name }}" required>
                </div>

                <!-- LOCATION -->
                <div class="mb-3">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control" value="{{ $event->location }}">
                </div>

                <!-- DESCRIPTION -->
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ $event->description }}</textarea>
                </div>

                <!-- CAPACITY -->
                <div class="mb-3">
                    <label class="form-label">Capacity</label>
                    <input type="number" name="capacity" class="form-control" value="{{ $event->capacity }}" required>
                </div>

                <button type="submit" class="btn-event w-100">
                    Update Event / Room
                </button>

            </form>

        </div>

    </div>

</div>

@endsection