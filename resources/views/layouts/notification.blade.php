@if (! empty(session('message')))
    <script>
        Toastify({
            text: "{!! session('message') !!}",
            duration: 3000,
            newWindow: true,
            close: true,
            gravity: "top", // `top` or `bottom`
            positionRight: true, // `true` or `false`
            backgroundColor: "linear-gradient(to right, #399b2e, #0b6d00)"
        }).showToast();
    </script>
@endif

@if (session()->has('status'))
    <script>
        Toastify({
            text: "{!! session()->get('status') !!}",
            duration: 3000,
            newWindow: true,
            close: true,
            gravity: "top", // `top` or `bottom`
            positionRight: true, // `true` or `false`
            backgroundColor: "linear-gradient(to right, #2e789b, #005d6d)"
        }).showToast();
    </script>
@endif

@if (count($errors) > 0)
    @foreach ($errors->all() as $error)
        <script>
            Toastify({
                text: "{{ $error }}",
                duration: 3000,
                newWindow: true,
                close: true,
                gravity: "top", // `top` or `bottom`
                positionRight: true, // `true` or `false`
                backgroundColor: "linear-gradient(to right, #9b2e2e, #6d0000)"
            }).showToast();
        </script>
    @endforeach
@endif


