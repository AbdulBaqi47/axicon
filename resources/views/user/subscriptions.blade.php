<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form method="post" action="{{ url('/subscriptions/create') }}">
                @csrf
                <div id="dropin-container"></div>
                <hr />
                <button type="submit" class="btn btn-outline-dark d-none" id="payment-button">Subscribe</button>
            </form>
        </div>
    </div>
</div>

<script src="https://js.braintreegateway.com/js/braintree-2.32.1.min.js"></script>

<script>
    jQuery.ajax({
        url: "{{ route('token') }}",
    })
    .done(function(res) {
        braintree.setup(res.data.token, 'dropin', {
            container: 'dropin-container',
            onReady: function() {
                jQuery('#payment-button').removeClass('d-none')
            }
        });
    });
</script>