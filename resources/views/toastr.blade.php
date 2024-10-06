@if(session()->has('toastr'))
        <link rel="stylesheet" href="{{ asset('vendor/toastr/css/toastr.css') }}">
        <script src="{{ asset('vendor/toastr/js/toastr.js') }}"></script>

    @php
        $notification = session('toastr');
    @endphp

    <script>
        LaravelToastr.options = {!! json_encode($notification['options']) !!};
        LaravelToastr["{{ $notification['type'] }}"](
            "{{ $notification['message'] }}",
            "{{ $notification['title'] }}",
            LaravelToastr.options
        );
    </script>
@endif