@extends('layouts.master')

@section('content')
	<p id="status"></p>
@endsection

@section('script')
	<script>
	if("{{$status}}" === 'ok')
		window.location.replace("{{$data}}");
	else
		document.getElementById('status').innerText = "{{$status}}";
	</script>
@endsection