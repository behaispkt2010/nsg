@extends('layouts.pdf.render')

@section('title')
	ORDERS LIST
@stop

@section('content')
<link rel="stylesheet" type="text/css" href="{{asset('css/pdf/orders.css')}}">
<div class="container">
	<div class="row">
		<!-- icon logo Lien -->
			<?php
				$image = "/images/logo-w.png";
			 ?>
			<img src="{!! url('/') !!}/images/logo-w.png" width="100px" style="margin-top:10px;" class="left">
			<label class="w-tit left" style="font-size:10px;"> 
				<h4 class="label-option " align="center">
				</h4> 
			</label>
			<label class="w-tit-center left"> 
				<h2 class="label-option tit-size" align="center">
					Danh sách Đơn hàng
				</h2>
			</label>
			<label class="w-tit right martop"> 
				
			</label>
	</div>
	<div class="clear"></div>
	<div class="row">
		<table style="width: 100%;">
			<thead class="table-header">
				<tr class="table-header">
					<th >ID</th>
					<th >Name</th>
					<th >Phone Number</th>
					<th >Address</th>
					
				</tr>
			</thead>
			<tbody>		
				@if(count($arrAllOrders) != 0)
	                @foreach($arrAllOrders as $arrOrders)
						<tr>
							<td class="center">
								{{ $arrOrders->id }}
							</td>
							<td class="center">
								{{ $arrOrders->name }}
							</td>
							<td class="center">
								{{ $arrOrders->phone_number }}
							</td>
							<td class="center">
								{{$arrOrders->address }}
							</td>
						</tr>
					@endforeach
				@endif
			</tbody>
		</table>
	</div>
</div>
@stop