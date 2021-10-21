@extends('layouts.account')

@section('main')
<div class="card">
	<div class="card-content">
		<h1 class="flow-text">Кошелёк</h1>
		@if(isset ($orders) && $orders->count() > 0)
		<table class="responsive-table">
			<thead>
				<tr>
					<th>#</th>
					<th>Ресторан</th>
					<th>Дата и время</th>
					<th>Статус</th>
					<th></th>
				</tr>

			</thead>
			<tbody>
				@foreach($orders as $order)
				<tr>
					<td>{{ $loop->iteration }}</td>
					<td>{{ $orders_langs[$order->id][app()->getLocale()]['restaurant'] }}</td>
					<td>{{ $order->date }} {{ $order->time }}</td>
					<td>@lang('order.'.$order->status)</td>
					<td>
						<a href="{{ route('my-orders.show', ['id' => $order->id]) }}"><i
								class="material-icons">create</i></a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>

		@else
		Кошелёк пустой
		@endif
	</div>
</div>
@endsection