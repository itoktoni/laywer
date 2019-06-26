@extends('backend.'.config('website.backend').'.layouts.app')
@component('component.charts', ['array' => 'Frappe'])
    
@endcomponent
@section('content')
<div class="row">
    <section class="panel">
        <header class="panel-heading">
            <div class="panel-actions">
                <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
            </div>
            <h2 class="panel-title">Profile Management</h2>
        </header>
        <div class="panel-body">
           @component('component.chart')
               @slot('container')
                   {!! $chart->container() !!}
               @endslot
               @slot('script')
                   {!! $chart->script() !!}
               @endslot
           @endcomponent
        </div>
    </section>
</div>
@endsection

