@extends('layouts.public')

@section('content')
<h1>
    Choose your side!
</h1>

<h2>
    <a href="{{ route('board',['player'=> '1']) }}">Player 1</a>
</h2>

<h2>
    <a href="{{ route('board',['player'=> '2']) }}">Player 2</a>
</h2>
@endsection
