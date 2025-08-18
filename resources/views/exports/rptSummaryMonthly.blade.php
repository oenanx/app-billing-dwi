	<div class="row-full">
		<div class="box box-info">
			<div class="box-body">
				<table style="width: 100%">
					<thead>
						<tr>
							<th style="border:1px solid black; text-align: center; width: 15%;"><B>Customer No</B></th>
							<th style="border:1px solid black; text-align: center; width: 25%;"><B>Company Name</B></th>
							<th style="border:1px solid black; text-align: center; width: 25%;"><B>Nama File Result</B></th>
							<th style="border:1px solid black; text-align: center; width: 15%;"><B>Jml Result</B></th>
							<th style="border:1px solid black; text-align: center; width: 20%;"><B>Created At</B></th>
						</tr>
					</thead>
					<tbody>
						@foreach($data as $details)
							<tr>
								<td style="border:1px solid black; text-align: center; width: 15%;">{{ $details->customerno }}</td>
								<td style="border:1px solid black; text-align: left; width: 25%;">{{ $details->company_name }}</td>
								<td style="border:1px solid black; text-align: left; width: 25%;">{{ $details->nama_file_result }}</td>
								<td style="border:1px solid black; text-align: right; width: 15%;">{{ $details->jml_result }}</td>
								<td style="border:1px solid black; text-align: right; width: 20%;">{{ $details->created_at }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
