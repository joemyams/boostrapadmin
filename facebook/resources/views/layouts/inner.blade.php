@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
      <?/*<div class="col-sm-3">
        @include('layouts.menu')
      </div>*/?>
      <div class="col-sm-12">


            @yield('inner')

    </div>
</div>

@endsection
