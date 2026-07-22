@extends('layouts.app')

@section('content')

<style>

/* FULL PAGE BACKGROUND */
.show-page{
    min-height:100vh;
    width:100%;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:60px 20px;

    background:
        linear-gradient(rgba(0,0,0,0.78), rgba(0,0,0,0.88)),
        url("https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=2000&q=80");

    background-size:cover;
    background-position:center;
    background-attachment:fixed;
}

/* WRAPPER */
.show-wrap{
    width:100%;
    max-width:750px;
}

/* GLASS CARD */
.show-card{
    background:rgba(10,10,10,0.75);
    border:1px solid rgba(255,215,0,0.25);
    border-radius:25px;
    box-shadow:0 30px 80px rgba(0,0,0,0.85);
    backdrop-filter:blur(18px);
    overflow:hidden;
}

/* GOLD HEADER */
.show-header{
    padding:25px;
    text-align:center;
    font-weight:800;
    letter-spacing:4px;
    text-transform:uppercase;
    background:linear-gradient(90deg,#FFD700,#B8860B);
    color:#111;
}

/* BODY */
.show-body{
    padding:40px;
}

/* INFO BOX */
.info-box{
    margin-bottom:14px;
    padding:14px;
    border-left:3px solid #FFD700;
    background:rgba(255,255,255,0.04);
    border-radius:10px;
}

/* LABEL */
.label{
    font-size:11px;
    letter-spacing:2px;
    text-transform:uppercase;
    color:#FFD700;
    font-weight:600;
}

/* VALUE */
.value{
    display:block;
    margin-top:4px;
    font-size:15px;
    color:#f5f5f5;
}

/* BUTTON */
.btn-back{
    margin-top:25px;
    display:block;
    text-align:center;
    padding:14px;
    border-radius:60px;
    background:linear-gradient(135deg,#FFD700,#B8860B);
    color:#111;
    font-weight:800;
    letter-spacing:3px;
    text-transform:uppercase;
    text-decoration:none;
    transition:.3s;
}

.btn-back:hover{
    transform:translateY(-3px);
    box-shadow:0 20px 40px rgba(255,215,0,0.25);
    color:#111;
}

@media(max-width:768px){
    .show-body{
        padding:25px;
    }
}

</style>

<div class="show-page">

    <div class="show-wrap">

        <div class="show-card">

            <div class="show-header">
                ARAUM • Suite Details
            </div>

            <div class="show-body">

                <div class="info-box">
                    <span class="label">Name</span>
                    <span class="value">{{ $event->name }}</span>
                </div>

                <div class="info-box">
                    <span class="label">Location</span>
                    <span class="value">{{ $event->location }}</span>
                </div>

                <div class="info-box">
                    <span class="label">Description</span>
                    <span class="value">{{ $event->description ?? 'No description available' }}</span>
                </div>

                <div class="info-box">
                    <span class="label">Capacity</span>
                    <span class="value">{{ $event->capacity }}</span>
                </div>

                <a href="{{ route('events.index') }}" class="btn-back">
                    Back to ARAUM Suites
                </a>

            </div>

        </div>

    </div>

</div>

@endsection