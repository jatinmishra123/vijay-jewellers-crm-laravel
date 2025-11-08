@extends('admin.layouts.app')

@section('content')
<div class="container py-4">

    <div class="card shadow-sm border-0">
        <div class="card-header bg-info text-white">
            <h4 class="mb-0">Add Scheme Payment</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('admin.scheme_payments.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Customer</label>
                        <select name="customer_id" class="form-select select2" required>
                            <option value="">Search Customer...</option>
                            @foreach($customers as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Scheme</label>
                        <select name="scheme_id" class="form-select select2" required>
                            <option value="">Search Scheme...</option>
                            @foreach($schemes as $s)
                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Amount</label>
                        <input type="number" name="amount" class="form-control" required placeholder="Enter Payment Amount">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Payment Duration</label>
                        <input type="text" name="payment_duration" class="form-control" required placeholder="e.g. 12 Months">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Payment Status</label>
                        <select name="status" class="form-select" required>
                            <option value="pending">Pending</option>
                            <option value="success">Success</option>
                            <option value="failed">Failed</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Payment Method</label>
                        <input type="text" name="method" class="form-control" placeholder="UPI / Cash / Bank Transfer">
                    </div>

                    <div class="col-12 mb-3 " >
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Any additional information"></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Due Date</label>
                        <input type="date" name="due_date" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">Paid At (If Paid)</label>
                        <input type="date" name="paid_at" class="form-control">
                    </div>
                </div>

                <div class="text-end">
                    <button class="btn btn-primary px-4">Save Payment</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Search here...",
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endsection
