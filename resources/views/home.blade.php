@php
    $page = 'home'
@endphp
@extends('layouts/app')
@section('content')
			<createCharacter
                v-bind:races="{{ json_encode( $races ) }}"
                v-bind:traits="{{ json_encode($traits) }}"
            >
            </createCharacter>
@endsection
