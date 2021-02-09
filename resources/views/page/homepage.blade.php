@extends('base')

@section('content')
    @if (empty($error))
        <form action="{{ route('convert') }}" method="post">
            <div>
                <span>Source currency</span>
                <select name="source">
                    @foreach ($currencies as $code => $title)
                        <option value="{{ $code }}">{{ $title }}</option>
                    @endforeach 
                </select>
            </div>

            <div>
                <span>Destination currency</span>
                <select name="destination">
                    @foreach ($currencies as $code => $title)
                        <option value="{{ $code }}">{{ $title }}</option>
                    @endforeach 
                </select>
            </div>

            <div>
                <span>amount</span>
                <input type="number" name="amount" />
            </div>

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button>Calculate</button>
        </form>
    @else
        {{ $error }}
    @endif

    <a href="{{ route('statistics') }}"><button>Show me the statistic</button></a>
@endsection