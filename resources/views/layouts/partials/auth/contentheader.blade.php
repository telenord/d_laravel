{{--
This file is part of laravel-bootstrap-adminlte-starter-kit.

Copyright (c) 2016 Oleksii Prudkyi
--}}

{{-- if box then skip --}}
@hasSection('simple_box_title')
@else
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        @yield('contentheader_title', 'Page Header here')
        <small>@yield('contentheader_description')</small>
    </h1>
<!--
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol>
-->
</section>
@endif
