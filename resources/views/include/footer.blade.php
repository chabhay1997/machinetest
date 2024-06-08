<div class="settingSidebar">
  <a href="javascript:void(0)" class="settingPanelToggle"> <i class="fa fa-spin fa-cog"></i>
  </a>
  <div class="settingSidebar-body ps-container ps-theme-default">
    <div class=" fade show active">
      <div class="setting-panel-header">Setting Panel
      </div>
      <div class="p-15 border-bottom">
        <h6 class="font-medium m-b-10">Select Layout</h6>
        <div class="selectgroup layout-color w-50">
          <label class="selectgroup-item">
            <input type="radio" name="value" value="1" class="selectgroup-input-radio select-layout" checked>
            <span class="selectgroup-button">Light</span>
          </label>
          <label class="selectgroup-item">
            <input type="radio" name="value" value="2" class="selectgroup-input-radio select-layout">
            <span class="selectgroup-button">Dark</span>
          </label>
        </div>
      </div>
      <div class="p-15 border-bottom">
        <h6 class="font-medium m-b-10">Sidebar Color</h6>
        <div class="selectgroup selectgroup-pills sidebar-color">
          <label class="selectgroup-item">
            <input type="radio" name="icon-input" value="1" class="selectgroup-input select-sidebar">
            <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip" data-original-title="Light Sidebar"><i class="fas fa-sun"></i></span>
          </label>
          <label class="selectgroup-item">
            <input type="radio" name="icon-input" value="2" class="selectgroup-input select-sidebar" checked>
            <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip" data-original-title="Dark Sidebar"><i class="fas fa-moon"></i></span>
          </label>
        </div>
      </div>
      <div class="p-15 border-bottom">
        <h6 class="font-medium m-b-10">Color Theme</h6>
        <div class="theme-setting-options">
          <ul class="choose-theme list-unstyled mb-0">
            <li title="white" class="active">
              <div class="white"></div>
            </li>
            <li title="cyan">
              <div class="cyan"></div>
            </li>
            <li title="black">
              <div class="black"></div>
            </li>
            <li title="purple">
              <div class="purple"></div>
            </li>
            <li title="orange">
              <div class="orange"></div>
            </li>
            <li title="green">
              <div class="green"></div>
            </li>
            <li title="red">
              <div class="red"></div>
            </li>
          </ul>
        </div>
      </div>
      <div class="p-15 border-bottom">
        <div class="theme-setting-options">
          <label class="m-b-0">
            <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" id="mini_sidebar_setting">
            <span class="custom-switch-indicator"></span>
            <span class="control-label p-l-10">Mini Sidebar</span>
          </label>
        </div>
      </div>
      <div class="p-15 border-bottom">
        <div class="theme-setting-options">
          <label class="m-b-0">
            <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" id="sticky_header_setting">
            <span class="custom-switch-indicator"></span>
            <span class="control-label p-l-10">Sticky Header</span>
          </label>
        </div>
      </div>
      <div class="mt-4 mb-4 p-3 align-center rt-sidebar-last-ele">
        <a href="#" class="btn btn-icon icon-left btn-primary btn-restore-theme">
          <i class="fas fa-undo"></i> Restore Default
        </a>
      </div>
    </div>
  </div>
</div>
</div>
<footer class="main-footer">
  <div class="footer-left">
    <a href=""></a></a>
  </div>
  <div class="footer-right">
  </div>
</footer>
</div>
</div>
<!-- General JS Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/cdbootstrap/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/cdbootstrap/js/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/cdbootstrap/js/cdb.min.js"></script>  


<script src="{{ asset('public/assets/js/app.min.js') }}"></script>
<!-- JS Libraies -->
<script src="{{ asset('public/assets/bundles/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('public/assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Page Specific JS File -->
<script src="{{ asset('public/assets/js/page/datatables.js') }}"></script>
<!-- Template JS File -->
<script src="{{ asset('public/assets/js/scripts.js') }}"></script>
<!-- Custom JS File -->
<script src="{{ asset('public/assets/js/custom.js') }}"></script>
<script src="{{ asset('public/assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>


<script src="{{ asset('public/assets/bundles/izitoast/js/iziToast.min.js') }}"></script>
<script src="{{ asset('public/assets/js/page/toastr.js') }}"></script>
<script src="{{asset('public/assets/bundles/summernote/summernote-bs4.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>


<script>
      // public/js/theme.js
      $(document).ready(function() {
          // Function to handle theme selection
          $('.choose-theme li').click(function() {
              var selectedTheme = $(this).attr('title');

              // Store the selected theme in Local Storage
              localStorage.setItem('selectedTheme', selectedTheme);

              // Apply the selected theme
              applyTheme(selectedTheme);
          });

          // Function to apply the selected theme
          function applyTheme(theme) {
              // Remove existing theme classes
              $('body').removeClass('theme-white theme-cyan theme-black theme-purple theme-orange theme-green theme-red');

              // Add class for the selected theme
              $('body').addClass('theme-' + theme);
          }

          // Check if a theme is already selected
          var storedTheme = localStorage.getItem('selectedTheme');
          if (storedTheme) {
              // Apply the stored theme
              applyTheme(storedTheme);
          }

          // Event listener for "Restore Default" button
          $('.btn-restore-theme').click(function(event) {
              event.preventDefault();
              console.log("Restore Default button clicked"); // Add this line for debugging
              restoreDefaultTheme();
          });

          // Function to restore default theme
          function restoreDefaultTheme() {
              // Simulate click on the default theme option
              var defaultTheme = 'white'; // Change 'white' to your default theme
              $('.choose-theme li[title="' + defaultTheme + '"]').click();
          }

      });
  </script>

</body>

</html>