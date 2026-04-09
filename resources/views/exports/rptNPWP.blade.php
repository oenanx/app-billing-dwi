	<div class="row-full">
		<div class="box box-info">
			<div class="box-body">
				<table style="width: 100%">
					<thead>
						<tr>
							<th colspan="8" style="text-align: center;">Report NPWP DataWiz API Invoice Period : {{ $periode }}</th>
						</tr>
					</thead>
				</table>
				<table style="width: 100%">
					<thead>
						<tr>
							<th style="border:1px solid black; text-align: center;">Periode</th>
							<th style="border:1px solid black; text-align: center;">Customer No.</th>
							<th style="border:1px solid black; text-align: center;">Invoice No.</th>
							<th style="border:1px solid black; text-align: center;">Company Name</th>
							<th style="border:1px solid black; text-align: center;">NPWP No.</th>
							<th style="border:1px solid black; text-align: center;">NPWP Address</th>
							<th style="border:1px solid black; text-align: center;">Total Amount</th>
							<th style="border:1px solid black; text-align: center;">Total VAT</th>
						</tr>
					</thead>
					<tbody>
						@foreach($data as $details)
							<tr>
								<td style="border:1px solid black; text-align: center;">{{ $details->PERIOD }}</td>
								<td style="border:1px solid black; text-align: center;">{{ $details->customerno }}</td>
								<td style="border:1px solid black; text-align: center;">{{ $details->bsno }}</td>
								<td style="border:1px solid black; text-align: left;">{{ $details->company_name }}</td>
								<td style="border:1px solid black; text-align: center;">{{ $details->npwpno }}</td>
								<td style="border:1px solid black; text-align: left;">{{ $details->address_npwp }}</td>
								<td style="border:1px solid black; text-align: right;">{{ $details->TOTALAMOUNT }}</td>
								<td style="border:1px solid black; text-align: right;">{{ $details->TOTALVAT }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
