<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Register</h2>
    <form id="registerform">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" required>
            <div id="nameError" class="text-danger"></div>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" required>
            <div id="emailError" class="text-danger"></div>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" required>
            <div id="passwordError" class="text-danger"></div>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
            <div id="password_confirmationError" class="text-danger"></div>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>


<script>
$(document).ready(function() {
    $('#registerform').on('submit', function(event) {
        event.preventDefault(); 

        $.ajax({
            url: "{{ route('register') }}",
            type: 'POST', 
            data: $(this).serialize(), 
            success: function(response) {
                
                Swal.fire({
                    title: 'Success!',
                    text: 'Registration successful. You will be redirected to the login page.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        
                        window.location.href = "{{ route('loginform') }}";
                    }
                });
            },
            error: function(xhr) {
                
                var errors = xhr.responseJSON.errors; 

                
                $('#nameError').text('');
                $('#emailError').text('');
                $('#passwordError').text('');
                $('#password_confirmationError').text('');

                
                if (errors.name) {
                    $('#nameError').text(errors.name[0]);
                }
                if (errors.email) {
                    $('#emailError').text(errors.email[0]);
                }
                if (errors.password) {
                    $('#passwordError').text(errors.password[0]);
                }
                if (errors.password_confirmation) {
                    $('#password_confirmationError').text(errors.password_confirmation[0]);
                }
            }
        });
    });
});
</script>


</body>
</html>
