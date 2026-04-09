	<div class="row-full">
		<div class="box box-info">
			<div class="box-body">
				<table style="width: 100%">
					<thead>
						<tr>
							<th style="border:1px solid black; text-align: center;">Company Name</th>
							<th style="border:1px solid black; text-align: center;">Products</th>
							<th style="border:1px solid black; text-align: center;">Period</th>
							<th style="border:1px solid black; text-align: center;">Billing Type</th>
							<th style="border:1px solid black; text-align: center;">Total Success</th>
							<th style="border:1px solid black; text-align: center;">Total Failed</th>
						</tr>
					</thead>
					<tbody>
						@foreach($data as $details)
							<tr>
								<td style="border:1px solid black; text-align: left;">{{ $details->company_name }}</td>
								<td style="border:1px solid black; text-align: left;">{{ $details->product }}</td>
								<td style="border:1px solid black; text-align: center;">{{ $details->periode }}</td>
								<td style="border:1px solid black; text-align: center;">{{ $details->billingtype }}</td>
								<td style="border:1px solid black; text-align: center;">{{ $details->tot_sukses }}</td>
								<td style="border:1px solid black; text-align: center;">{{ $details->tot_failed }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
