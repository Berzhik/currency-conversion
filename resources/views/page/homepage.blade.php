@extends('base')

@section('content')
    <form>
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
    </form>
@endsection