@extends('errors::layout')

@section('title', 'Service Unavailable')

@section('message')
    @if(!empty($exception->getMessage()))
        {{ $exception->getMessage() }}
    @else
        Down for maintenance.
    @endif

    <br><br>

    @if(!empty($exception->retryAfter) && $exception->willBeAvailableAt->isFuture())
        Please try again {{ $exception->wentDownAt->addSeconds($exception->retryAfter)->diffForHumans() }}.
    @elseif(!empty($exception->retryAfter))
        Please try again later.
    @endif
@endsection
