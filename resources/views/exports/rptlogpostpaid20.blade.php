	<div class="row-full">
		<div class="box box-info">
			<div class="box-body">
				<table style="width: 100%">
					<thead>
						<tr>
							<th style="border:1px solid black; text-align: center;">Tgl. Hits</th>
							<th style="border:1px solid black; text-align: center;">API Id.</th>
							<th style="border:1px solid black; text-align: center;">Status</th>
							<th style="border:1px solid black; text-align: center;">Phone No. Input</th>
							<th style="border:1px solid black; text-align: center;">Phone No.</th>
							<th style="border:1px solid black; text-align: center;">Regist. Date</th>
						</tr>
					</thead>
					<tbody>
						@foreach($data as $details)
							<tr>
								<td style="border:1px solid black; text-align: left;">{{ $details->tgl_hit }}</td>
								<td style="border:1px solid black; text-align: left;">{{ $details->noapi_id }}</td>
								<td style="border:1px solid black; text-align: center;">{{ $details->status_hit }}</td>
								<td style="border:1px solid black; text-align: center;">{{ $details->data_input }}</td>
								<td style="border:1px solid black; text-align: center;">{{ $details->phone }}</td>
								<td style="border:1px solid black; text-align: center;">{{ $details->tanggal }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
