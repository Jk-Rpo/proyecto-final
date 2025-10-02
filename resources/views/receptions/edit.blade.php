@extends('layouts.app')

@section('content')
@if($reception->is_special)
<receptions-edit-special :id="{{ $reception->id }}"></receptions-edit-special>
@else
<receptions-edit-patient :id="{{ $reception->id }}"></receptions-edit-patient>
@endif
@endsection
