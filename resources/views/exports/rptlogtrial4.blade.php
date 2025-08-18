	<div class="row-full">
		<div class="box box-info">
			<div class="box-body">
				<table style="width: 100%">
					<thead>
						<tr>
							<th style="border:1px solid black; text-align: center; width: 30%;">Tgl. Hits</th>
							<th style="border:1px solid black; text-align: center; width: 35%;">API Id.</th>
							<th style="border:1px solid black; text-align: center; width: 15%;">Status</th>
							<th style="border:1px solid black; text-align: center; width: 20%;">Data Input.</th>
						</tr>
					</thead>
					<tbody>
						@foreach($data as $details)
							<tr>
								<td style="border:1px solid black; text-align: left;">{{ $details->tgl_hit }}</td>
								<td style="border:1px solid black; text-align: left;">{{ $details->noapi_id }}</td>
								<td style="border:1px solid black; text-align: center;">{{ $details->status_hit }}</td>
								<td style="border:1px solid black; text-align: left;">{{ "'".$details->data_input }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
