<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>EVTL INDIA CRM</title>

    <link rel="stylesheet" href="{{ url('public/assets/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ url('public/assets/bundles/bootstrap-social/bootstrap-social.css') }}">

    <link rel="stylesheet" href="{{ url('public/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ url('public/assets/css/components.css') }}">

    <link rel="stylesheet" href="{{ url('public/assets/css/custom.css') }}">
    <link rel='shortcut icon' type='image/x-icon' href="{{ asset('public/img/logo.svg') }}" />

    <!-- Custom style CSS -->
    <link rel="stylesheet" href="{{ url('public/assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/bundles/izitoast/css/iziToast.min.css') }}">
</head>

<style>
    .hello {
        background-image: url('public/img/img-2.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
        /* opacity: 0.3; */
    }


    body {
        background-color: #0cb4b3a3;
    }
</style>

<body>
    <div class="loader"></div>
    <div id="app">
        <section class="section">
            <div class="container mt-5">

                <div class="card">
                    <div class="card-header bg-primary">
                        <h4 class="text-white">Regsitration Form</h4>
                    </div>
                    <div class="card-body">
                        <form id="register_submit">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <label>First Name</label>
                                    <input id="first_name" type="text" class="form-control" name="first_name" autofocus>
                                </div>
                                <div class="col-md-4">
                                    <label>Last Name </label>
                                    <input id="last_name" type="text" class="form-control" name="last_name" autofocus>
                                </div>

                                <div class="col-md-4">
                                    <label>Password</label>
                                    <input id="password" type="password" class="form-control" name="password" autofocus>
                                </div>
                                <div class="col-md-4">
                                    <label>Confirm Password</label>
                                    <input id="password" type="password" class="form-control" name="confirm_password" autofocus>
                                </div>
                                <div class="col-md-4">
                                    <label>Email</label>
                                    <input id="email" type="email" class="form-control" name="email" autofocus>
                                </div>
                                <div class="col-md-4">
                                    <label>Mobile Number</label>
                                    <input id="tel" type="phone" class="form-control" name="phone" autofocus maxlength="10">
                                </div>
                                <div class="col-md-4">
                                    <label>Date of Birth</label>
                                    <input id="dob" type="date" class="form-control" name="dob" autofocus required>
                                </div>
                                <div class="col-md-4">
                                    <label>Gender</label>
                                    <select id="gender" class="form-control" name="gender" required>
                                        <option value="">--select--</option>
                                        <option value="1"> Male </option>
                                        <option value="2"> Female </option>
                                        <option value="3"> Other </option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label> Address</label>
                                    <textarea name="address" class="form-control" maxlength="200"></textarea>

                                </div>

                            </div>

                            <div class="mt-3">
                                <button class="btn btn-primary col-12">
                                    Register
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </section>
    </div>
    <script src="{{ url('public/assets/js/app.min.js') }}"></script>
    <script src="{{ url('public/assets/js/scripts.js') }}"></script>
    <script src="{{ url('public/assets/js/custom.js') }}"></script>

    <script src="{{ asset('public/assets/bundles/izitoast/js/iziToast.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/page/toastr.js') }}"></script>

    <script>
        $(function() {
            $('#register_submit').on('submit', function(e) {
                e.preventDefault();
                let fd = new FormData(this);
                fd.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: "{{ route('register_submit') }}",
                    type: "POST",
                    data: fd,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $("#load").show();
                    },
                    success: function(result) {
                        console.log(result);
                        if (result.status) {
                            iziToast.success({
                                message: result.msg,
                                position: 'topRight'
                            });

                            setTimeout(function() {
                                window.location.href = result.location;
                            }, 500);

                        } else {
                            iziToast.error({
                                message: result.msg,
                                position: 'topRight'
                            });
                        }
                    },
                    complete: function() {
                        $("#load").hide();
                    },
                    error: function(jqXHR, exception) {}
                });
            })
        });
    </script>
</body>

</html>