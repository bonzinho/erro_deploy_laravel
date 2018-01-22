@if(session()->has('message'))
        @push('js')
        <script type="text/javascript">
            $(document).ready(function (){
                let modal = $('#modal-flash-msg').iziModal();
                let message = {!! json_encode(session()->get('message')) !!};
                modal.iziModal('setTitle',  message);
                modal.iziModal('open');
            });
        </script>
        @endpush
    <div id="modal-flash-msg">
        <!-- Page content -->
    </div>
@endif

