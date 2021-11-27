@push('script')
    <script type="text/javascript">
        function delete_row(route, row_id) {

            var table_row = '#row_' + row_id;
            var url = "{{url('')}}"+'/admin/'+route+row_id;
            Swal.fire({
                title: '{{ __('Are you sure?') }}',
                text: "{{ __('You will not be able to revert this') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '{{ __('Yes delete it!') }}'
            }).then((confirmed) => {
                if (confirmed.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            id: row_id,
                            _method: 'delete'
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: url,
                    })
                        .done(function(response) {
                            console.log(response);
                            Swal.fire(
                                response.title,
                                response.message,
                                response.status
                            ).then((confirmed) => {
                                location.reload();
                            });
                            if (response.status != 'error'){
                                $(table_row).fadeOut(2000);
                            }
                        })
                        .fail(function(error) {
                            Swal.fire('{{ __("Ops..!") }}', '{{ __('Something went wrong with ajax!') }}', 'error');
                        })
                }
            });
        }
    </script>
@endpush
