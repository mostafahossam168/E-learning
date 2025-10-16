@extends('dashboard.layouts.backend', ['title' => 'المحادثات'])

@section('contant')
    <div class="main-side">
        <div class="main-title">
            <div class="small">الرئيسية</div>/
            <div class="large">المحادثات</div>
        </div>
        <div class="chats">
            @livewire('chat')
        </div>
    </div>
@endsection
