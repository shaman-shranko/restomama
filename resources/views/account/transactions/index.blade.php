@extends('layouts.account')
@section('seo')
	<title>@lang('cabinet.transactions.page_title')</title>
@endsection
@section('main')
<div class="card">
	<div class="card-content">
		<h1 class="flow-text">@lang('cabinet.transactions.title')</h1>
		@if(isset ($transactions) && $transactions->count() > 0)
		<table class="responsive-table">
			<thead>
				<tr>
					<th>#</th>
					<th>@lang('cabinet.transactions.order')</th>
					<th>@lang('cabinet.transactions.type')</th>
					<th>@lang('cabinet.transactions.total')</th>
					<th>@lang('cabinet.transactions.initiator')</th>
					<th></th>
				</tr>

			</thead>
			<tbody>
				@foreach($transactions as $transaction)
				<tr>
					<td>{{ $transaction->id }}</td>
					<td>
						<a href="{{ route('my-orders.show', ['id' => $transaction->order_id]) }}">
							#{{ $transaction->order_id }}
						</a>
					</td>
					<td>{{ $transaction->type}}</td>
					<td>{{ $transaction->amount}}</td>
					<td>{{ $transaction->initiator->name }} {{ $transaction->initiator->surname }}</td>
					<td>
						<a href="{{ route('my-orders.show', ['id' => $transaction->id]) }}">
							<i class="material-icons">view</i>
						</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		@else
			@lang('cabinet.transactions.empty')
		@endif
	</div>
</div>
@endsection