@component('component.select2')
@endcomponent

<div class="form-group">
    <label class="col-md-2 control-label">Name</label>
    <div class="col-md-4 {{ $errors->has('name') ? 'has-error' : ''}}">
        {!! Form::text('name', null, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
    </div>

    <label class="col-md-2 control-label">Tanggal</label>
    <div class="col-md-4">
        <div class="input-group">
            <input type="text" name="birth" data-plugin-datepicker value="{{ date('Y-m-d') }}" class="form-control">
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
        </div>
    </div>
</div>

<div class="form-group">
<label class="col-md-2 control-label">Customer</label>
<div class="col-md-4 {{ $errors->has('id_customer') ? 'has-error' : ''}}">
    {{ Form::select('id_customer', $customer, null, ['class'=> 'form-control', 'data-plugin-selectTwo']) }}
</div>

  <label class="col-md-2 control-label">Jenis Perkara</label>
    <div class="col-md-4 {{ $errors->has('id_jenis_perkara') ? 'has-error' : ''}}">
        {{ Form::select('id_jenis_perkara', $cat, null, ['class'=> 'form-control', 'data-plugin-selectTwo']) }}
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label"> Tagging</label>
    <div class="col-md-10">
        <select class="form-control input-sm mb-md" data-plugin-selectTwo multiple id="filter" name="tags[]">
            @foreach($tag as $key => $value)
            <option selected="" value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group">
	<label class="col-md-2 control-label">Notes</label>
    <div class="col-md-7 {{ $errors->has('description') ? 'has-error' : ''}}">
        {!! Form::textArea('description', null, ['class' => 'form-control', 'rows' => '3']) !!}
    </div>

    <div class="col-md-2 {{ $errors->has('status') ? 'has-error' : ''}}">
    	Status :
    	<br>
	    {{ Form::select('status', $status, null, ['class'=> 'form-control']) }}
	</div>

</div>
<hr>


<div class="form-group">
<label class="col-md-2 control-label">Gedung</label>
<div class="col-md-4 {{ $errors->has('id_gedung') ? 'has-error' : ''}}">
    {{ Form::select('id_gedung', $gedung, null, ['class'=> 'form-control', 'data-plugin-selectTwo']) }}
</div>

  <label class="col-md-2 control-label">Ruangan</label>
    <div class="col-md-4 {{ $errors->has('id_ruangan') ? 'has-error' : ''}}">
        {{ Form::select('id_ruangan', $ruangan, null, ['class'=> 'form-control', 'data-plugin-selectTwo']) }}
    </div>
</div>


<div class="form-group">
<label class="col-md-2 control-label">Rack</label>
<div class="col-md-4 {{ $errors->has('id_rack') ? 'has-error' : ''}}">
    {{ Form::select('id_rack', $rack, null, ['class'=> 'form-control', 'data-plugin-selectTwo']) }}
</div>

  <label class="col-md-2 control-label">User Archive</label>
    <div class="col-md-4 {{ $errors->has('id_user') ? 'has-error' : ''}}">
        {{ Form::select('id_user', $team, null, ['class'=> 'form-control', 'data-plugin-selectTwo']) }}
    </div>
</div>


<div class="form-group">
    <label class="col-md-2 control-label">No Pendaduan</label>
    <div class="col-md-4 {{ $errors->has('no_pengaduan') ? 'has-error' : ''}}">
        {!! Form::text('no_pengaduan', null, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
    </div>
    <label class="col-md-2 control-label">Pengajuan Kejaksaan</label>
    <div class="col-md-4 {{ $errors->has('no_pengajuan_kejaksaan') ? 'has-error' : ''}}">
        {!! Form::text('no_pengajuan_kejaksaan', null, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
    </div>
</div>


<hr>

<div class="form-group">
    <label class="col-md-2 control-label">Berkas Pemohon</label>
     <div class="col-md-4">
        <input type="file" name="pemohon" class="btn btn-default btn-sm btn-block">
    </div>

     <label class="col-md-2 control-label">Berkas Pengadilan</label>
     <div class="col-md-4">
        <input type="file" name="pengadilan" class="btn btn-default btn-sm btn-block">
    </div>

</div>

<div class="form-group">
    <label class="col-md-2 control-label">Berkas Kepolisian</label>
     <div class="col-md-4">
        <input type="file" name="polisi" class="btn btn-default btn-sm btn-block">
    </div>

    <label class="col-md-2 control-label">Putusan Pengadilan</label>
     <div class="col-md-4">
        <input type="file" name="putusan" class="btn btn-default btn-sm btn-block">
    </div>

</div>

<hr>