<script>

    @if(session('message_session_mailing_list'))

        Swal.fire({
            type: "{{ session('type_message') }}",
            text: "{{ session('message_session_mailing_list') }}",
            showConfirmButton: false,
            timer: 4000
        })

    @endif

</script>
