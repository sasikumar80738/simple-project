<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Login</h2>
    <form id="loginform">
        @csrf
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div id="loginError" class="alert alert-danger d-none"></div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        $('#loginform').on('submit', function(event) {
            event.preventDefault(); 

            $.ajax({
                url: "{{ route('login') }}", 
                type: 'POST', 
                data: $(this).serialize(), 
                success: function(response) {
                    
                    window.location.href = "{{ route('dashboard') }}";
                },
                error: function(xhr) {
                    
                    var response = JSON.parse(xhr.responseText);
                    $('#loginError').text(response.message).removeClass('d-none');
                }
            });
        });
    });
</script>
</body>
</html>
