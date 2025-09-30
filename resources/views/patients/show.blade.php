@extends('layouts.app')

@section('content')
<div id="app">
    <patients-show :id="{{ $patient->id }}"></patients-show>
</div>
@endsection
