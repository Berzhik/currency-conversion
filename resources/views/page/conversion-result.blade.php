@extends('base')

@section('content')
    {{ $value }}

    <a href="{{ route('homepage') }}">Try one more time</a>
@endsection 