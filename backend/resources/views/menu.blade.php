@extends('layouts.app')

@section('content')
    @foreach($sections as $section)
    <div class="menu-section">
        <h1>{{ $section->name }}</h1>
        <div class="menu-section__items">
            @foreach($section->menuItems as $item)
            <div class="menu-item">
                <div>{{ $item->name }}</div>
                <div>${{ $item->price }}</div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
@endsection
