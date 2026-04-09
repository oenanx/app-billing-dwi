	<div class="row-full">
		<div class="box box-info">
			<div class="box-body">
				<table style="width: 100%">
					<thead>
						<tr>
							<th colspan="16" style="text-align: center;">Report New Charges Detail DataWiz API Invoice Period : {{ $periode }}</th>
						</tr>
					</thead>
				</table>
				<table style="width: 100%">
					<thead>
						<tr>
							<th style="border:1px solid black; text-align: center;">INV. PERIOD</th>
							<th style="border:1px solid black; text-align: center;">CUSTOMERNO</th>
							<th style="border:1px solid black; text-align: center;">CUSTOMERNAME</th>
							<th style="border:1px solid black; text-align: center;">ACTIVATIONDATE</th>

							<th style="border:1px solid black; text-align: center;">USAGEADJUSTMENT</th>
							<th style="border:1px solid black; text-align: center;">TOTALDISCOUNT</th>
							<th style="border:1px solid black; text-align: center;">PREVIOUSBALANCE</th>
							<th style="border:1px solid black; text-align: center;">BALANCEADJUSTMENT</th>
							<th style="border:1px solid black; text-align: center;">PREVIOUSPAYMENT</th>
							<th style="border:1px solid black; text-align: center;">TOTALAMOUNT</th>
							<th style="border:1px solid black; text-align: center;">REVENUE</th>
							<th style="border:1px solid black; text-align: center;">TOTALVAT</th>
							<th style="border:1px solid black; text-align: center;">NEWCHARGE</th>
							<th style="border:1px solid black; text-align: center;">TOTALUSAGE</th>
							<th style="border:1px solid black; text-align: center;">NEWBALANCE</th>
							
							<th style="border:1px solid black; text-align: center;">SALESAGENTNAME</th>
						</tr>
					</thead>
					<tbody>
						@foreach($data as $details)
							<tr>
								<td style="border:1px solid black; text-align: center;">{{ $details->PERIOD }}</td>
								<td style="border:1px solid black; text-align: center;">{{ $details->CUSTOMERNO }}</td>
								<td style="border:1px solid black; text-align: left;">{{ $details->company_name }}</td>
								<td style="border:1px solid black; text-align: center;">{{ $details->activation_date }}</td>
								
								<td style="border:1px solid black; text-align: right;">{{ $details->USAGEADJUSTMENT }}</td>
								<td style="border:1px solid black; text-align: right;">{{ $details->TOTALDISCOUNT }}</td>
								<td style="border:1px solid black; text-align: right;">{{ $details->PREVIOUSBALANCE }}</td>
								<td style="border:1px solid black; text-align: right;">{{ $details->BALANCEADJUSTMENT }}</td>
								<td style="border:1px solid black; text-align: right;">{{ $details->PREVIOUSPAYMENT }}</td>
								<td style="border:1px solid black; text-align: right;">{{ $details->TOTALAMOUNT }}</td>
								<td style="border:1px solid black; text-align: right;">{{ $details->REVENUE }}</td>
								<td style="border:1px solid black; text-align: right;">{{ $details->TOTALVAT }}</td>
								<td style="border:1px solid black; text-align: right;">{{ $details->NEWCHARGE }}</td>
								<td style="border:1px solid black; text-align: right;">{{ $details->TOTALUSAGE }}</td>
								<td style="border:1px solid black; text-align: right;">{{ $details->NEWBALANCE }}</td>
								
								<td style="border:1px solid black; text-align: center;">{{ $details->SALESAGENTNAME }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
