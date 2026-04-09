	<div class="row-full">
		<div class="box box-info">
			<div class="box-body">
				<table style="width: 100%">
					<thead>
						<tr>
							<th colspan="8" style="text-align: center;">Report New Charges Description DataWiz API Invoice Period : {{ $periode }}</th>
						</tr>
					</thead>
				</table>
				<table style="width: 100%">
					<thead>
						<tr>
							<th style="border:1px solid black; text-align: center;">INV. PERIOD</th>
							<th style="border:1px solid black; text-align: center;">CUSTOMERNO</th>
							<th style="border:1px solid black; text-align: center;">CUSTOMERNAME</th>
							<th style="border:1px solid black; text-align: center;">DESCRIPTION</th>
							<th style="border:1px solid black; text-align: center;">AMOUNT</th>
							<th style="border:1px solid black; text-align: center;">SALESAGENT</th>
							<th style="border:1px solid black; text-align: center;">STATUSCODE</th>
							<th style="border:1px solid black; text-align: center;">ACTIVATIONDATE</th>
						</tr>
					</thead>
					<tbody>
						@foreach($data as $details)
							<tr>
								<td style="border:1px solid black; text-align: center;">{{ $details->PERIOD }}</td>
								<td style="border:1px solid black; text-align: center;">{{ $details->CUSTOMERNO }}</td>
								<td style="border:1px solid black; text-align: left;">{{ $details->company_name }}</td>
								<td style="border:1px solid black; text-align: left;">{{ $details->DESCRIPTION }}</td>
								<td style="border:1px solid black; text-align: right;">{{ $details->AMOUNT }}</td>
								<td style="border:1px solid black; text-align: center;">{{ $details->SALESAGENTNAME }}</td>
								<td style="border:1px solid black; text-align: center;">{{ $details->active }}</td>
								<td style="border:1px solid black; text-align: center;">{{ $details->activation_date }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
