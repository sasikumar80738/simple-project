<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Dashboard</h2>
    
    <!-- User Information -->
    @if(Auth::check())
        <p>Welcome, {{ Auth::user()->name }}!</p>
        <p>Email: {{ Auth::user()->email }}</p>

        @if(Auth::user()->profile)
            <p>Father's Name: {{ Auth::user()->profile->father_name ?? 'Not provided' }}</p>
            <p>Mother's Name: {{ Auth::user()->profile->mother_name ?? 'Not provided' }}</p>
        @else
            <p>Profile information is not available.</p>
        @endif
    @else
        <p>Please log in to view your dashboard.</p>
    @endif

    <!-- Update Profile -->
    <h3>Update Profile</h3>
    <form id="addparent">
        @csrf
        <div class="form-group">
            <label for="father_name">Father's Name</label>
            <input type="text" name="father_name" class="form-control" value="{{ Auth::user()->father_name ?? '' }}" required>
        </div>
        <div class="form-group">
            <label for="mother_name">Mother's Name</label>
            <input type="text" name="mother_name" class="form-control" value="{{ Auth::user()->mother_name ?? '' }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>

    <!-- Addresses List -->
    <h3>Addresses</h3>
    @if(Auth::check() && Auth::user()->addresses->isNotEmpty())
        <ul class="list-group">
            @foreach(Auth::user()->addresses as $address)
                <li class="list-group-item">
                    {{ $address->address1 }}, {{ $address->address2 }}, {{ $address->pincode }}
                    <a href="#" data-toggle="modal" data-target="#updateAddressModal-{{ $address->id }}" class="btn btn-warning btn-sm float-right ml-2">Update</a>
                </li>

                <!-- Update Address Modal -->
                <div class="modal fade" id="updateAddressModal-{{ $address->id }}" tabindex="-1" role="dialog" aria-labelledby="updateAddressLabel-{{ $address->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="updateAddressLabel-{{ $address->id }}">Update Address</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="updateAddressForm" method="POST" action="{{ route('updateAddress', $address->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="address1">Address 1</label>
                        <input type="text" name="address1" class="form-control" value="{{ $address->address1 }}" required>
                    </div>
                    <div class="form-group">
                        <label for="address2">Address 2</label>
                        <input type="text" name="address2" class="form-control" value="{{ $address->address2 }}">
                    </div>
                    <div class="form-group">
                        <label for="pincode">Pincode</label>
                        <input type="text" name="pincode" class="form-control" value="{{ $address->pincode }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </ul>
    @else
        <p>No addresses found.</p>
    @endif

    <!-- Add Address Form -->
    <h3>Add Address</h3>
    <form id="addAddressForm">
        @csrf
        <div class="form-group">
            <label for="address1">Address 1</label>
            <input type="text" name="address1" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="address2">Address 2</label>
            <input type="text" name="address2" class="form-control">
        </div>
        <div class="form-group">
            <label for="pincode">Pincode</label>
            <input type="text" name="pincode" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Address</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <script>
    $(document).ready(function() {
        $('#addAddressForm').on('submit', function(event) {
            event.preventDefault(); 

            $.ajax({
                url:"{{ route('addAddress') }}",
                type: 'POST', 
                data: $(this).serialize(), 
                success: function(response) {
                    window.location.href = "{{ route('dashboard') }}";
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });

        $('#addparent').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url:"{{ route('updateProfile') }}", 
                type: 'POST', 
                data: $(this).serialize(), 
                success: function(response) {
                    
                    window.location.href = "{{ route('dashboard') }}";
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });

        $('#updateAddressForm').on('submit', function(event) {
        event.preventDefault(); 

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST', 
            data: $(this).serialize(), 
            success: function(response) {
                
                $('#updateAddressModal').modal('hide');
                window.location.href = "{{ route('dashboard') }}"; 
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    });
    });
</script>

</script>
</body>
</html>
