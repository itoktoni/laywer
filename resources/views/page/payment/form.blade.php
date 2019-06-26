
@section('javascript')

<script>
	$(function() {

		$('#model').change(function() {
			var id = $("#model option:selected").val();
			var url = '';
			if(id == 'PO'){
				url = '{{ route("po") }}';
			}
			else if(id == 'SO'){
				url = '{{ route("so") }}';
			}
			else if(id == 'SPK'){
				url = '{{ route("spk") }}';
			}
			else if(id == 'FEE'){
				url = '{{ route("fee") }}';
			}
			else if(id == 'DO'){
				url = '{{ route("do") }}';
			}
			else if(id == 'ETC'){
				url = '';
			}
			else{
				url = '';
				$('#reference').empty();
			}

			if(url != ''){

				if(url ! = ''){	
					$('#reference').select2({
						placeholder: 'Select an Reference',
						ajax: {
							url: url,
							dataType: 'json',
							data: function (params) {
								return {
	                        q: params.term, // search term
	                    };
	                },
	                processResults: function (data) {
		                	return {
		                			results: data
		                		};
			                },
			                cache: true
			            }   
			        });
				}
			}
			else{
				$('#reference').select2({
					placeholder: 'Select an Reference',
				});
			}
		});
	});
</script>
@endsection

<div class="form-group">
	<label class="col-md-2 control-label">Bank Pengirim</label>
	<div class="col-md-4 {{ $errors->has('account_from') ? 'has-error' : ''}}">
		<select class="form-control col-md-4" id="option" name="account_from">
			@isset($data)
			@if($account->where('account_id',$data->account_from)->count() > 0)
			@foreach($account as $value)
			<option @isset($data) {{ $value->account_id == $data->account_id ? 'selected="selected"' : '' }} @endisset value="{{ $value->account_id }}">
				{{ $value->account_name }} - {{ $value->account_location }}
			</option>
			@endforeach
			@else
			<option value="{{ $data->account_from }}">{{ $data->account_from }}</option>
			@endif
			@else
			<option value="">Select Account</option>
			<option value="Other">Other Payment Reference Note</option>
			@foreach($account as $value)
			<option @isset($data) {{ $value->account_id == $data->account_id ? 'selected="selected"' : '' }} @endisset value="{{ $value->account_id }}">
				{{ $value->account_name }} - {{ $value->account_location }}
			</option>
			@endforeach
			@endisset
		</select>
	</div>
	<label class="col-md-2 control-label">Bank Penerima</label>
	<div class="col-md-4 {{ $errors->has('account_to') ? 'has-error' : ''}}">
		{!! Form::text('account_to', null, ['class' => 'form-control col-md-4']) !!}
	</div>
</div>
<div class="form-group">
	<label class="col-md-2 control-label">Model Reference</label>
	<div class="col-md-4 {{ $errors->has('payment_model') ? 'has-error' : ''}}">
		<select class="form-control col-md-4" id="model" name="payment_model">
			@isset($data)
			<option value="{{ $data->payment_model }}">{{ $model }}</option>
				@if(isset($data) && $data->payment_model == 'SO')
				<option value="ONGKIR">Ongkos Kirim</option>
				@endif
			@else
			<option value="">Select Model Reference</option>
			@foreach($model as $key => $value)
			<option @isset($data) {{ $key == $data->payment_model ? 'selected="selected"' : '' }} @endisset value="{{ $key }}">
				{{ $value }}
			</option>
			@endforeach
			@endisset
		</select>
	</div>
	<label class="col-md-2 control-label">Reference Transaksi</label>
	<div class="col-md-4 {{ $errors->has('reference') ? 'has-error' : ''}}">
		<select class="form-control col-md-4" id="reference" name="reference">
			@isset($data)
			<option value="{{ $data->reference }}">{{ $data->reference }}</option>
			@endisset
		</select>
	</div>
</div>
<hr>
<div class="form-group">
	<label class="col-md-2 control-label">Tanggal Pembayaran</label>
	<div class="col-md-4 {{ $errors->has('payment_date') ? 'has-error' : ''}}">
		{!! Form::text('payment_date', null, ['class' => 'form-control col-md-4 datepicker']) !!}
	</div>
	<label class="col-md-2 control-label">Reference Person</label>
	<div class="col-md-4 {{ $errors->has('payment_person') ? 'has-error' : ''}}">
		{!! Form::text('payment_person', null, ['class' => 'form-control']) !!}
	</div>
</div>
<div class="form-group">
	<label class="col-md-2 control-label">Input Nilai</label>
	<div class="col-md-4 {{ $errors->has('payment_amount') ? 'has-error' : ''}}">
		{!! Form::number('payment_amount', null, ['class' => 'form-control']) !!}
	</div>
	<label class="col-md-2 control-label">Confirm Nilai</label>
	<div class="col-md-4 {{ $errors->has('approve_amount') ? 'has-error' : ''}}">
		{!! Form::number('approve_amount', null, ['class' => 'form-control']) !!}
	</div>
</div>
<div class="form-group">
	<label class="col-md-2 control-label">Attachment</label>
	<div class="col-md-4 {{ $errors->has('payment_attachment') ? 'has-error' : ''}}">
		{!! Form::file('files', ['class' => 'btn btn-default btn-sm btn-block']) !!}
	</div>
	<label class="col-md-2 control-label">Tipe Pembayaran</label>
	<div class="col-md-4 {{ $errors->has('payment_type') ? 'has-error' : ''}}">
		{{ Form::select('payment_type', ['PENDING' => 'Pending','IN' => 'Uang Masuk', 'OUT' => 'Uang Keluar'], null, ['class'=> 'form-control']) }}
	</div>
</div>
<hr>
<div class="form-group">
	<label class="col-md-2 control-label">Payment Description</label>
	<div class="col-md-4 {{ $errors->has('payment_description') ? 'has-error' : ''}}">
		{!! Form::textarea('payment_description', null, ['class' => 'form-control', 'rows' => '3']) !!}
	</div>
	<label class="col-md-2 control-label">Payment Status</label>
	<div class="col-md-4 {{ $errors->has('payment_status') ? 'has-error' : ''}}">
		{{ Form::select('payment_status', ['PENDING' => 'PENDING', 'APPROVED' => 'APPROVED','REJECT' => 'REJECT'], null, ['class'=> 'form-control']) }}
	</div>
	<label class="col-md-2 control-label">Payment Note</label>
	<div class="col-md-4 {{ $errors->has('payment_note') ? 'has-error' : ''}}">
		{!! Form::textarea('payment_note', null, ['class' => 'form-control', 'rows' => '1']) !!}
	</div>
</div>

<hr>
<div class="form-group">
	<label class="col-md-2 control-label">Email Penerima</label>
	<div class="col-md-10 {{ $errors->has('email') ? 'has-error' : ''}}">
		<input type="text" class="form-control" name="email" id="email">
		<input type="hidden" value="{{ isset($data->payment_voucher) ? $data->payment_voucher : ''}}" name="voucher">
	</div>
</div>

<style>
	#emailtags-input{
		width: 7em !important;
	}
</style>