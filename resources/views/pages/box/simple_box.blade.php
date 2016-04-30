@extends('layouts.app')

@section('htmlheader_title')
	@yield('simple_box_title', 'Box Header Here')
@endsection

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-10">
				<div class="box box-solid box-@yield('simple_box_style', 'danger')">
					<div class="box-header">
						  <h3 class="box-title">@yield('simple_box_title')</h3>
					</div>
					<div class="box-body">
						@yield('simple_box_body')
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

