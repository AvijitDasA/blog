@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-primary text-white">Discount Calculator</div>
                <div class="card-body">
                    <form action="{{ route('discount.calculate') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="rate" class="form-label fw-bold">Rate (₹)</label>
                            <input type="number" name="rate" id="rate"
                                   class="form-control" value="{{ old('rate') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="percentage" class="form-label fw-bold">Discount (%)</label>
                            <input type="number" name="percentage" id="percentage"
                                   class="form-control" value="{{ old('percentage') }}" required>
                        </div>

                        <button type="submit" class="btn btn-success">Calculate</button>
                    </form>

                    @isset($result)
                        <hr>
                        <h5>Result:</h5>
                        <ul>
                            <li><strong>Original Price:</strong> ₹{{ $result['original'] }}</li>
                            <li><strong>Discount ({{ $result['percentage'] }}%):</strong> ₹{{ $result['discount'] }}</li>
                            <li><strong>Final Price:</strong> ₹{{ $result['final'] }}</li>
                        </ul>
                    @endisset
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
