@extends('layouts.app')

@section('content')

<style>

/* FULL PAGE WITH IMAGE BACKGROUND */
.event-page{
    min-height:100vh;
    width:100%;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:60px 20px;

    /* IMAGE BACKGROUND */
    background:
        linear-gradient(rgba(0,0,0,0.75), rgba(0,0,0,0.85)),
        url("https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=2000&q=80");

    background-size:cover;
    background-position:center;
    background-attachment:fixed;
}

/* LUXURY WRAPPER */
.event-wrap{
    width:100%;
    max-width:700px;
}

/* GLASS CARD */
.event-card{
    background:rgba(10,10,10,0.72);
    border:1px solid rgba(255,215,0,0.25);
    border-radius:25px;
    backdrop-filter:blur(18px);
    box-shadow:0 30px 80px rgba(0,0,0,0.85);
    overflow:hidden;
}

/* GOLD HEADER */
.event-header{
    padding:28px;
    text-align:center;
    font-size:18px;
    font-weight:700;
    letter-spacing:4px;
    text-transform:uppercase;
    background:linear-gradient(90deg,#FFD700,#B8860B);
    color:#111;
}

/* BODY */
.event-body{
    padding:45px;
}

/* LABELS */
.form-label{
    font-size:11px;
    letter-spacing:2px;
    text-transform:uppercase;
    color:#FFD700;
    margin-top:15px;
}

/* INPUTS */
.form-control{
    background:transparent;
    border:none;
    border-bottom:1px solid rgba(255,215,0,0.3);
    border-radius:0;
    color:#fff !important;
    padding:12px 5px;
}

.form-control:focus{
    outline:none;
    box-shadow:none;
    border-bottom:1px solid #FFD700;
    background:transparent;
    color:#fff !important;
}

/* PLACEHOLDER */
.form-control::placeholder{
    color:rgba(255,255,255,0.4);
}

/* AUTOFILL FIX */
input.form-control:-webkit-autofill{
    -webkit-text-fill-color:#fff !important;
    -webkit-box-shadow:0 0 0px 1000px #0a0a0a inset;
}

/* BUTTON */
.btn-event{
    margin-top:30px;
    width:100%;
    padding:15px;
    border:none;
    border-radius:60px;
    background:linear-gradient(135deg,#FFD700,#B8860B);
    color:#111;
    font-weight:800;
    letter-spacing:3px;
    text-transform:uppercase;
    transition:.3s;
}

.btn-event:hover{
    transform:translateY(-3px);
    box-shadow:0 20px 40px rgba(255,215,0,0.25);
}

/* MOBILE */
@media(max-width:768px){
    .event-body{
        padding:30px;
    }
}

</style>

<div class="event-page">

    <div class="event-wrap">

        <div class="event-card">

            <div class="event-header">
                ARAUM • Create Event / Suite
            </div>

            <div class="event-body">

                <form action="{{ route('events.store') }}" method="POST">
                    @csrf

                    <label class="form-label">Event / Room Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter name" required>

                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control" placeholder="Enter location">

                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Enter description"></textarea>

                    <label class="form-label">Capacity</label>
                    <input type="number" name="capacity" class="form-control" placeholder="Enter capacity" required>

                    <button type="submit" class="btn-event">
                        SAVE EXPERIENCE
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection