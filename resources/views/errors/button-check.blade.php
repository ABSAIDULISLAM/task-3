{{-- this code to disabled btn code when required field are empty  --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('button[type="submit"]').prop('disabled', true);
            $('.form-control').on('input', function() {
                var form = $(this).closest('form');
                var requiredFields = form.find('.form-control[required]');
                var invalidFields = requiredFields.filter(function() {
                    return !$(this).val();
                });
                $('button[type="submit"]').prop('disabled', invalidFields.length > 0);
            });
        });
</script>
{{-- bellow code for show select auto input field data by click  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('input[type="text"],input[type="email"],input[type="password"], input[type="number"], textarea');

        inputs.forEach(input => {
            input.addEventListener('click', function() {
                this.select();
            });
        });
    });
</script>

