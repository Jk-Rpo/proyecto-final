@extends('layouts.app')

@section('content')
<div id="app">
    <patients-edit :id="{{ $patient->id }}"></patients-edit>
</div>
@endsection
