@extends('layouts.app')

@section('content')
<receptions-show :id="{{ $reception->id }}"></receptions-show>
@endsection
