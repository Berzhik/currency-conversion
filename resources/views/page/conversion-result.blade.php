@extends('base')

@section('content')
    Result: {{ $result }}
    <br />
    <a href="{{ route('homepage') }}"><button>Try one more time</button></a>
@endsection 