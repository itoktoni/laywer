@extends('backend.'.config('website.backend').'.layouts.app')

@section('content')
<div class="row">
    <div class="panel panel-default">
        <header class="panel-heading">
            <h2 class="panel-title">No {{ ucFirst($template) }} : {{ $data->$key }}</h2>
        </header>

        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-table table-bordered table-striped table-hover mb-none">
                    <tbody>
                        @foreach($fields as $item => $value)
                        @isset($data->$item)
                        <tr>
                            <th class="col-lg-2">{{ $value }}</th>
                            <td colspan="3">{{ $data->$item }}</td>
                        </tr>
                        @endisset
                        @endforeach

                        <tr>
                            <th class="col-lg-2">Customer</th>
                            <td>{{ $data->customer->name }}</td>

                        </tr>

                        <tr>
                            <th class="col-lg-2">Jenis Perkara</th>
                            <td>{{ $data->perkara->name }}</td>
                        </tr>
                    </tbody>
                </table>
                <hr>
                 <table class="table table-table table-bordered table-striped table-hover mb-none">
                    <tbody>
                        <tr>
                            <th class="col-lg-2">Gedung</th>
                            <td>{{ $data->gedung->name }}</td>
                        </tr>
                        <tr>
                            <th class="col-lg-2">Ruangan</th>
                            <td>{{ $data->ruangan->name }}</td>
                        </tr>
                        <tr>
                            <th class="col-lg-2">Rack</th>
                            <td>{{ $data->rack->name }}</td>
                        </tr>
                        <tr>
                            <th class="col-lg-2">Archived By</th>
                            <td>{{ $data->team->name }}</td>
                        </tr>
                        <tr>
                            <th class="col-lg-2">No Pengaduan</th>
                            <td>{{ $data->no_pengaduan }}</td>
                        </tr>
                        <tr>
                            <th class="col-lg-2">Pengajuan Kejaksaan</th>
                            <td>{{ $data->no_pengajuan_kejaksaan }}</td>
                        </tr>
                        <tr>
                            <th class="col-lg-2">Status</th>
                            <td>{{ $data->status }}</td>
                        </tr>
                        <hr>

                         <tr>
                            <th class="col-lg-2">Berkas Pemohon</th>
                            <td><a class="btn btn-xs btn-danger" target="__blank" href="{{ Helper::files('perkara').'/'.$data->berkas_pemohon }}">{{ $data->berkas_pemohon }}</a> </td>
                        </tr>
                        <tr>
                            <th class="col-lg-2">Berkas Pengadilan</th>
                            <td><a class="btn btn-xs btn-danger" target="__blank" href="{{ Helper::files('perkara').'/'.$data->berkas_pengadilan }}">{{ $data->berkas_pengadilan }}</a> </td>
                        </tr>
                        <tr>
                            <th class="col-lg-2">Laporan Polisi</th>
                            <td><a class="btn btn-xs btn-danger" target="__blank" href="{{ Helper::files('perkara').'/'.$data->berkas_laporan_polisi }}">{{ $data->berkas_laporan_polisi }}</a> </td>
                        </tr>
                        <tr>
                            <th class="col-lg-2">Putusan Pengadilan</th>
                            <td><a class="btn btn-xs btn-danger" target="__blank" href="{{ Helper::files('perkara').'/'.$data->berkas_putus_pengadilan }}">{{ $data->berkas_putus_pengadilan }}</a> </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>

        <div class="navbar-fixed-bottom" id="menu_action">
            <div class="text-right" style="padding:5px">
                <a href="{!! route("{$form}_list") !!}" class="btn btn-warning">Back</a>
                @isset($update)
                <a href="{!! route("{$template}_update", ["code" => $data->$key]) !!}" class="btn btn-primary">Edit</a>
                @endisset
            </div>
        </div>

    </div>
</div>

@endsection