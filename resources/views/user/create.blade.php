@include('include.header')
<title>
    @if($users->id ?? null)
    Edit User-List
    @else
    Add User-List
    @endif
</title>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-primary text-white-all">
                @include('breadcrumb')
                <li class="breadcrumb-item active mt-1" aria-current="page"><a href="{{ route('user.index') }}"> <i class="fas fa-user-cog"></i> User-List Table </a></li>
            </ol>
        </nav>
        <div class="section-body">
            <form id="userstore">
                <input type="hidden" name="id" value="{{ $users->id ?? null }}">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h4 class="text-white">Add User</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label for="name" class="text-dark"> User Name <span class="text-danger">*</span></label>
                                <input name="name" type="text" class="form-control" value="{{ $users->name ?? null }}" placeholder="User Name" id="name" autocomplete="off">
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="text-dark"> User Email <span class="text-danger">*</span></label>
                                <input name="email" type="email" class="form-control" value="{{ $users->email ?? null }}" placeholder="User Email" id="email">
                            </div>

                            <div class="col-md-6 mt-2">
                                <label for="email" class="text-dark"> Role <span class="text-danger">*</span></label>
                                <select name="role_id" id="" class="form-control">
                                    <option value="">--select--</option>
                                    @foreach(initialize_models()['role']::all() as $role)
                                    <option value="{{ $role->id }}" {{ isset($users) && $role->id == $users->role_id ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mt-2">
                                <label for="phone" class="text-dark">Mobile No. <span class="text-danger">*</span></label>
                                <input name="phone" type="number" class="form-control" value="{{ $users->phone ?? null }}" placeholder="Phone No" id="phone">
                            </div>

                            <div class="col-md-6 mt-2">
                                <label for="password" class="text-dark">Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input name="password" type="password" class="form-control" placeholder="Enter Password" id="password">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mt-2">
                                <label for="profile" class="text-dark">Profile </label>
                                <input name="profile" type="file" class="form-control" id="profile" onchange="validateFileUpload(this)">
                                <small id="fileHelp" class="form-text text-muted">File types: PNG, JPG, JPEG</small>
                            </div>

                            <div class="col-md-6 mt-2">
                                <label for="profile" class="text-dark"> Status <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">InActive</option>
                                </select>

                            </div>

                            <div class="col-md-6 mt-2">
                                @if(isset($users->id) && !empty($users->profile))
                                <img id="profilePreview" src="{{ asset('public/user/' . $users->profile) }}" style="width:100px;">
                                @else
                                <img id="profilePreview" src="{{ asset('public/user/user.jpg') }}" style="width:100px;">
                                @endif
                            </div>

                        </div>
                    </div>
                    <div>
                        <button class="btn btn-primary col-12">
                            {{ isset($users->id) ? 'Update' : 'Submit' }}
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </section>
    @include('include.footer')

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
            const fileName = input.value;
            if (!allowedExtensions.exec(fileName)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid file type',
                    text: 'Please upload a file with a PNG, JPG, or JPEG extension.',
                });
                input.value = '';
                return false;
            }
            previewImage(input);
            return true;
        }
    </script>

    <script>
        const phoneInput = document.getElementById('phone');

        phoneInput.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '');
        });
    </script>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('active');
        });
    </script>

    <script>
        $('#userstore').on('submit', function(e) {
            e.preventDefault();
            let $form = $(this);
            if ($form.data('submitted') === true) {
                return;
            }
            $form.data('submitted', true);

            let fd = new FormData(this);
            fd.append('_token', "{{ csrf_token() }}");
            $.ajax({
                url: "{{ route('user.store') }}",
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