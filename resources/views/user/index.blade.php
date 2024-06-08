<title>
  User-List Table
</title>
@include('include.header')

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-primary text-white-all">
        @include('breadcrumb')
        <li class="breadcrumb-item active mt-1" aria-current="page"><i class="fas fa-user-cog"></i> User-List </li>
      </ol>
    </nav>
    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header bg-primary">
              <h4 class="text-white"> User-List </h4>
              <div class="card-header-action">
                <a href="{{ route('user.create') }}" class="btn btn-dark br-0"> Add User </a>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table data-table table-striped table-bordered nowrap">
                  <thead>
                    <tr>
                      <th>Sn</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Profile</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  @include('include.footer')
  <script type="text/javascript">
    $(function() {
      var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        "scrollX": true,
        ajax: "{{ route('user.index') }}",
        dom: 'Bfrtip',
        buttons: [{
            extend: 'excel'
          },
          {
            extend: 'pageLength'
          }
        ],
        columns: [{
            data: null,
            name: 'index',
            orderable: false,
            searchable: false
          },
          {
            data: 'first_name',
            name: 'first_name'
          },
          {
            data: 'email',
            name: 'email'
          },
          {
            data: 'phone',
            name: 'phone'
          },
          {
            data: 'profile',
            name: 'profile',
            orderable: false,
            searchable: false
          },
          {
            data: 'action',
            orderable: false,
            searchable: false
          }
        ],
        drawCallback: function(settings) {
          var api = this.api();
          var startIndex = api.context[0]._iDisplayStart;
          api.column(0).nodes().each(function(cell, i) {
            cell.innerHTML = startIndex + i + 1;
          });
        }
      });

      function handleDelete(id) {
        let fd = new FormData();
        fd.append('id', id);
        fd.append('_token', $('meta[name="csrf-token"]').attr('content'));
        $.confirm({
          title: 'Confirm!',
          content: 'Sure you want to delete this User?',
          buttons: {
            yes: function() {
              $.ajax({
                  url: "{{ route('user.delete') }}",
                  type: 'POST',
                  data: fd,
                  dataType: "JSON",
                  contentType: false,
                  processData: false,
                })
                .done(function(result) {
                  if (result.status) {
                    iziToast.success({
                      message: result.message,
                      position: 'topRight'
                    });
                    table.ajax.reload();
                  } else {
                    iziToast.error({
                      message: result.message,
                      position: 'topRight'
                    });
                  }
                })
                .fail(function(jqXHR, exception) {
                  console.log(jqXHR.responseText);
                });
            },
            no: function() {}
          }
        });
      }

      $('.data-table').on('click', '.delete', function() {
        var id = $(this).data('id');
        handleDelete(id);
      });
    });
  </script>