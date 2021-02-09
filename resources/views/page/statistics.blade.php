@extends('base')

@section('content')
    <div>
        <span>Most Popular: </span> {{ $most_popular }}
    </div>
    <div>
        <span>Total Converted: </span> {{ $total_converted }}
    </div>
    <div>
        <span>Total Requests: </span> {{ $total_requests }}
    </div>

    <a href="{{ route('homepage') }}"><button>Want to convert more</button></a>
@endsection 