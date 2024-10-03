@if(session()->has('toastr'))
<!-- @if(!Session::has('toastr_loaded')) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- @php(Session::put('toastr_loaded', true)) -->
<!-- @endif -->

<script>
    toastr.options = {
        !!json_encode(config('toastr.options')) !!
    };
    @foreach(session('toastr') as $notification)
    toastr["{{ $notification['type'] }}"]("{{ $notification['message'] }}", "{{ $notification['title'] }}", {
        !!json_encode($notification['options']) !!
    });
    @endforeach
</script>
@endif