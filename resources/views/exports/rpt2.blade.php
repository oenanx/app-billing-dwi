	<div class="row-full">
		<div class="box box-info">
			<div class="box-body">
				<table style="width: 100%">
					<thead>
						<tr>
							<th style="border:1px solid black; text-align: center; width: 25%;">Phone No.</th>
							<th style="border:1px solid black; text-align: center; width: 15%;">Status No.</th>
						</tr>
					</thead>
					<tbody>
						@foreach($data as $details)
							<tr>
								<td style="border:1px solid black; text-align: left; width: 25%;">{{ $details->Phone }}</td>
								<td style="border:1px solid black; text-align: center; width: 15%;">{{ $details->Status_no }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
