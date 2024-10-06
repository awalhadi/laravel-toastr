@if(session()->has('toastr'))
<script src="https://raw.githubusercontent.com/awalhadi/easy-toast-js/refs/heads/main/dist/easyToast.min.js"></script>

<script>
    const toast = new ToastManager({
            !!json_encode(config('toastr.options')) !!
        }),

        @foreach(session('toastr') as $notification)
    toast.show("{{ $notification['message'] }}", "{{ $notification['type'] }}");
    @endforeach
</script>
@endif