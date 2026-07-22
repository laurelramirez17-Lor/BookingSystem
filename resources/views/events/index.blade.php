@extends('layouts.app')

@section('content')

<style>

/* FULL PAGE */
.events-page{
    min-height:100vh;
    width:100%;
    background:
        radial-gradient(circle at top, #111 0%, #000 70%);
    padding:60px 40px;
    color:#fff;
}

/* HEADER */
.events-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:40px;
}

.events-title{
    font-size:28px;
    font-weight:800;
    letter-spacing:3px;
    color:#FFD700;
    text-transform:uppercase;
}

/* ADD BUTTON (GOLD ONLY) */
.btn-add{
    background:linear-gradient(135deg,#FFD700,#B8860B);
    color:#111;
    padding:12px 20px;
    border:none;
    border-radius:50px;
    font-weight:700;
    letter-spacing:2px;
    text-transform:uppercase;
    transition:.3s;
}

.btn-add:hover{
    transform:translateY(-3px);
    box-shadow:0 15px 30px rgba(255,215,0,0.25);
}

/* ALERT (GOLD ONLY) */
.alert{
    border:1px solid rgba(255,215,0,0.3);
    background:rgba(255,215,0,0.08);
    color:#FFD700;
    border-radius:12px;
}

/* GRID */
.events-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:25px;
}

/* LUXURY CARD */
.event-card{
    background:rgba(10,10,10,0.85);
    border:1px solid rgba(255,215,0,0.25);
    border-radius:20px;
    padding:25px;
    backdrop-filter:blur(14px);
    transition:.3s;
}

.event-card:hover{
    transform:translateY(-6px);
    box-shadow:0 25px 60px rgba(0,0,0,0.7);
    border:1px solid rgba(255,215,0,0.6);
}

/* TITLE */
.event-title{
    font-size:18px;
    font-weight:700;
    color:#FFD700;
    letter-spacing:1px;
}

/* META */
.event-meta{
    margin-top:8px;
    font-size:13px;
    color:#ddd;
}

/* BADGE */
.badge-capacity{
    display:inline-block;
    margin-top:12px;
    padding:6px 12px;
    border-radius:30px;
    font-size:11px;
    letter-spacing:1px;
    background:rgba(255,215,0,0.08);
    border:1px solid rgba(255,215,0,0.3);
    color:#FFD700;
}

/* BUTTONS (ALL GOLD STYLE) */
.btn-group-actions{
    margin-top:18px;
    display:flex;
    gap:8px;
    flex-wrap:wrap;
}

/* ALL ACTION BUTTONS UNIFIED GOLD STYLE */
.btn-sm-custom{
    padding:7px 12px;
    border-radius:8px;
    font-size:11px;
    font-weight:700;
    letter-spacing:1px;
    border:1px solid rgba(255,215,0,0.3);
    transition:.3s;
    text-transform:uppercase;
    background:transparent;
    color:#FFD700;
}

.btn-sm-custom:hover{
    transform:translateY(-2px);
    background:rgba(255,215,0,0.1);
    box-shadow:0 10px 20px rgba(255,215,0,0.15);
}

</style>

<div class="events-page">

    <!-- HEADER -->
    <div class="events-header">

        <div class="events-title">
            ARAUM • Events & Suites
        </div>

        <a href="{{ route('events.create') }}" class="btn-add">
            + Add Event
        </a>

    </div>

    <!-- SUCCESS -->
    @if(session('success'))
        <div class="alert">
            {{ session('success') }}
        </div>
    @endif

    <!-- GRID -->
    <div class="events-grid">

        @foreach($events as $event)

            <div class="event-card">

                <div class="event-title">
                    {{ $event->name }}
                </div>

                <div class="event-meta">
                    📍 {{ $event->location ?? 'No location provided' }}
                </div>

                <div class="badge-capacity">
                    Capacity: {{ $event->capacity }}
                </div>

                <div class="btn-group-actions">

                    <a href="{{ route('events.show', $event) }}" class="btn-sm-custom">
                        View
                    </a>

                    <a href="{{ route('events.edit', $event) }}" class="btn-sm-custom">
                        Edit
                    </a>

                    <form action="{{ route('events.destroy', $event) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn-sm-custom">
                            Delete
                        </button>
                    </form>

                </div>

            </div>

        @endforeach

    </div>

</div>

@endsection