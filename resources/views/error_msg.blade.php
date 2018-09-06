@if($errors AND count($errors))
<div class="alert alert-danger" style="padding: .5rem .25rem;margin-top:5px;">
	<ul style="margin:0px;margin-top:5px;padding-left: 30px;">
		@foreach($errors->all() as $err)
		<li class="text-danger">{{ $err }}</li>
		@endforeach
	</ul>
</div>
@endif