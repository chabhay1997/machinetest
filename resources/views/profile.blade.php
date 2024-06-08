@include('include.header')

<section class="section ml-5">
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12 offset-1">
                <div class="login-brand">
                    {{ $profile->first_name }}
                </div>
                <div class="card card-primary">
                    <form id="profileUpdate" autocomplete="off">
                        <div class="row m-0">
                            <div class="col-12 col-md-12 col-lg-6 p-0">
                                <div class="card-header text-center">
                                    <h4>Personal Setting</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group floating-addon">
                                        <label>First Name</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="far fa-user"></i>
                                                </div>
                                            </div>
                                            <input id="first_name" type="text" class="form-control" name="first_name" value="{{ $profile->first_name}}" autofocus placeholder="Enter First Name">
                                        </div>
                                    </div>
                                    <div class="form-group floating-addon">
                                        <label>Last Name</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="far fa-user"></i>
                                                </div>
                                            </div>
                                            <input id="last_name" type="text" class="form-control" name="last_name" value="{{ $profile->last_name}}" autofocus placeholder="Enter Last Name">
                                        </div>
                                    </div>
                                    <div class="form-group floating-addon">
                                        <label>Email</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-envelope"></i>
                                                </div>
                                            </div>
                                            <input id="email" type="email" class="form-control" name="email" value="{{ $profile->email}}" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="form-group floating-addon">
                                        <label>Phone</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-phone"></i>
                                                </div>
                                            </div>
                                            <input id="phone" type="number" class="form-control" name="phone" value="{{ $profile->phone}}" placeholder="Phone" maxlength="10" autofocus>
                                        </div>
                                    </div>
                                    <div class="form-group floating-addon">
                                        <div class="input-group">
                                            @if(!empty($profile->profile))
                                            <img id="profilePreview" src="{{ asset('public/img/' . $profile->profile) }}" style="width:100px;">
                                            @else
                                            <img id="profilePreview" src="{{ asset('public/img/user.jpg') }}" style="width:100px;">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6 p-0">
                                <div class="card-header text-center">
                                    <h4>Change Password</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group floating-addon">
                                        <label>Change Password</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-lock"></i>
                                                </div>
                                            </div>
                                            <input id="password" type="password" class="form-control" name="password" autocomplete="new-password" placeholder="Change Password">
                                        </div>
                                    </div>
                                    <div class="form-group floating-addon">
                                        <label>Confirm Password</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-lock"></i>
                                                </div>
                                            </div>
                                            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" autofocus placeholder="Confirm Password">
                                        </div>
                                    </div>
                                    <div class="form-group floating-addon">
                                        <label>DOB</label>
                                        <div class="input-group">
                                            <input id="dob" type="date" class="form-control" name="dob" value="{{ $profile->dob}}">
                                        </div>
                                    </div>
                                    <div class="form-group floating-addon">
                                        <label>Gender</label>
                                        <div class="input-group">
                                            <select name="gender" id="gender" class="form-control">
                                                <option value="">--select--</option>
                                                <option value="1"> Male </option>
                                                <option value="2"> Female </option>
                                                <option value="3"> Other </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group floating-addon">
                                        <label>Profile</label>
                                        <div class="input-group">
                                            <input id="profile" type="file" class="form-control" name="profile" id="profile" onchange="validateFileUpload(this)" autofocus>
                                        </div>
                                        <small id="fileHelp" class="form-text text-muted">File types: PNG, JPG, JPEG</small>
                                    </div>

                                    <div class="form-group floating-addon">
                                        <label>Address</label>
                                        <div class="input-group">
                                            <textarea id="address" class="form-control" name="address">{{ $profile->address }} </textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary col-12">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@include('include.footer')

<script>
    $(document).ready(function() {
        var gender = "{{ $profile->gender ?? '' }}";

        $('#gender').val(gender);
    });
</script>
<script>
    function previewImage(input) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#profilePreview').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
</script>

<script>
    function validateFileUpload(input) {
        const allowedExtensions = /(\.png|\.jpg|\.jpeg)$/i;
        const maxFileSize = 1024 * 1024; // 1MB
        const minFileSize = 100 * 1024; // 100KB
        const file = input.files[0];
        
        if (!allowedExtensions.exec(file.name)) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid file type',
                text: 'Please upload a file with a PNG, JPG, or JPEG extension.',
            });
            input.value = '';
            return false;
        }

        if (file.size > maxFileSize) {
            Swal.fire({
                icon: 'error',
                title: 'File too large',
                text: 'Please upload a file smaller than 1MB.',
            });
            input.value = '';
            return false;
        }

        if (file.size < minFileSize) {
            Swal.fire({
                icon: 'error',
                title: 'File too small',
                text: 'Please upload a file larger than 100KB.',
            });
            input.value = '';
            return false;
        }

        previewImage(input);
        return true;
    }
</script>


<script>
    $('#profileUpdate').on('submit', function(e) {
        e.preventDefault();

        let $form = $(this);
        if ($form.data('submitted') === true) {

        }
        $form.data('submitted', true);

        let fd = new FormData(this);
        fd.append('_token', "{{ csrf_token() }}");
        $.ajax({
            url: "{{ route('profile.update') }}",
            type: "POST",
            data: fd,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function(result) {
                if (result.status) {
                    iziToast.success({
                        message: result.message,
                        position: 'topRight'
                    });
                    setTimeout(function() {
                        window.location.href = result.location;
                    }, 2000);
                } else {
                    iziToast.warning({
                        message: result.message,
                        position: 'topRight'
                    });
                }
            },
            error: function(jqXHR, exception) {},
            complete: function() {
                $form.data('submitted', false);
            }
        });

    });
</script>