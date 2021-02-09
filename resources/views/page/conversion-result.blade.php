@extends('base')

@section('content')
    Result: {{ $value }}
    <br />
    <a href="{{ route('homepage') }}"><button>Try one more time</button></a>
@endsection 