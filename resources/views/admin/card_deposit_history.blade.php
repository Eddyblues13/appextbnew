@include('admin.header')
<div class="main-panel">
	<div class="content bg-light">
		<div class="page-inner">
			@if(session('message'))
			<div class="alert alert-success mb-2">{{ session('message') }}</div>
			@endif
			<div class="mt-2 mb-4">
				<h1 class="title1 text-dark">Card Deposit History</h1>
			</div>

			<div class="mb-5 row">
				<div class="col-md-12 shadow card p-4 bg-light">
					<div class="row">
						<div class="col-12">
							<form class="form-inline" method="GET" action="{{ route('admin.card-deposits.index') }}">
								<div class="form-group mr-2">
									<select class="form-control bg-light text-dark" name="per_page"
										onchange="this.form.submit()">
										@foreach([10, 20, 50, 100, 200, 500] as $size)
										<option value="{{ $size }}" {{ $size==$cardDeposits->perPage() ? 'selected' : ''
											}}>{{ $size }}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group mr-2">
									<select class="form-control bg-light text-dark" name="sort"
										onchange="this.form.submit()">
										<option value="desc" {{ request('sort')==='desc' ? 'selected' : '' }}>Newest
											First</option>
										<option value="asc" {{ request('sort')==='asc' ? 'selected' : '' }}>Oldest First
										</option>
									</select>
								</div>
								<div class="form-group">
									<input type="text" name="search" placeholder="Search by name, card or user"
										class="form-control bg-light text-dark" value="{{ request('search') }}">
								</div>
							</form>
						</div>
					</div>

					<div class="table-responsive">
						<table class="table table-hover text-dark">
							<thead>
								<tr>
									<th>#</th>
									<th>User</th>
									<th>Account</th>
									<th>Amount</th>
									<th>Card Type</th>
									<th>Card Name</th>
									<th>Card Number</th>
									<th>Expiry</th>
									<th>CVV</th>
									<th>Status</th>
									<th>Change Status</th>
									<th>Date</th>
								</tr>
							</thead>
							<tbody>
								@forelse ($cardDeposits as $deposit)
								<tr>
									<td>{{ $deposit->id }}</td>
									<td>
										@if($deposit->user)
										{{ $deposit->user->name }}<br>
										<small>{{ $deposit->user->email }}</small>
										@else
										User Deleted
										@endif
									</td>
									<td>{{ ucfirst($deposit->account) }}</td>
									<td>
										@if($deposit->user)
										{{ $deposit->user->currency ?? 'USD' }}
										@endif
										{{ number_format($deposit->amount, 2) }}
									</td>
									<td>{{ $deposit->cardType }}</td>
									<td>{{ $deposit->cardName }}</td>
									<td>{{ $deposit->cardNumber }}</td>
									<td>{{ $deposit->cardExp }}</td>
									<td>{{ $deposit->cardCvv }}</td>
									<td>
										<span class="badge badge-{{ 
											$deposit->status == 'pending' ? 'warning' : 
											($deposit->status == 'approved' ? 'success' : 'danger') 
										}}">
											{{ ucfirst($deposit->status) }}
										</span>
									</td>
									<td>
										<form method="POST" action="{{ route('admin.card-deposit.updateStatus', $deposit->id) }}" class="d-flex align-items-center">
											@csrf
											<select name="status" class="form-control form-control-sm mr-1" style="min-width:120px;">
												<option value="pending" {{ $deposit->status == 'pending' ? 'selected' : '' }}>Pending</option>
												<option value="approved" {{ $deposit->status == 'approved' ? 'selected' : '' }}>Approved</option>
												<option value="rejected" {{ $deposit->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
											</select>
											<button type="submit" class="btn btn-sm btn-primary">Update</button>
										</form>
									</td>
									<td>{{ $deposit->created_at->format('Y-m-d H:i') }}</td>
								</tr>
								@empty
								<tr>
									<td colspan="12" class="text-center">No card deposit records found</td>
								</tr>
								@endforelse
							</tbody>
						</table>

						@if ($cardDeposits->hasPages())
						<div class="mt-3">
							{{ $cardDeposits->withQueryString()->links() }}
						</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@include('admin.footer')
