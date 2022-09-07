@extends('layouts.app')

@section('title', config('app.name', 'LaraPay'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card col-md-10 col-lg-8">
                <div class="card-body">
                    <h5 class="card-title">Payment Gateway 1</h5>
                    <hr>
                    <pre>
{
    "merchant_id": {{ $merchant_id }},
    "payment_id": {{ $payment_id }},
    "status": "{{ $status }}",
    "amount": {{ $amount }},
    "amount_paid": {{ $amount_paid }},
    "timestamp": {{ $timestamp }},
    "sign": "{{ $sign }}"
}
                    </pre>
                    <form id="payment_form" method="POST" action="{{ route('payment.store') }}">
                        @csrf
                        <input type="hidden" name="merchant_id" value="{{ $merchant_id }}">
                        <input type="hidden" name="payment_id" value="{{ $payment_id }}">
                        <input type="hidden" name="status" value="{{ $status }}">
                        <input type="hidden" name="amount" value="{{ $amount }}">
                        <input type="hidden" name="amount_paid" value="{{ $amount_paid }}">
                        <input type="hidden" name="timestamp" value="{{ $timestamp }}">
                        <input type="hidden" name="sign" value="{{ $sign }}">
                        <button type="submit" class="btn btn-primary">Send request</button>
                    </form>

                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-md-10 col-lg-8">
                Go to <a href="{{ route('gateway.gateway2') }}">Payment gateway 2</a>
            </div>
        </div>
    </div>

    {{-- Should be a Blade component --}}
    <div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Response</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Hello, world! This is a toast message.
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
        function sendData(form) {
            // Bind the FormData object and the form element
            const formData = new FormData(form);
            const data = Object.fromEntries(formData);

            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json;charset=UTF-8',
                        'X-CSRF-Token': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify(data)
                })
                .then((response) => response.json())
                .then((data) => showToast(data.message))
                .catch(function(error) {
                    console.log(error);
                });
        }

        window.addEventListener('DOMContentLoaded', (event) => {
            const form = document.getElementById('payment_form');
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                sendData(form);
            });
        });
    </script>
@endpush
