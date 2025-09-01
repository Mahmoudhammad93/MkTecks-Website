</div>
<!-- footer start-->
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 footer-copyright text-center">
                <p class="mb-0"><span >{{ trans('admin.Created & Developed by') }}</span> <a target="__blank" href="https://mk-techs.com/">MK Techs</a> </p>
            </div>
        </div>
    </div>
</footer>
</div>
</div>
<script>
    var base_url = "{{ aurl('') }}";
    var asset_url = "{{ asset('') }}";
</script>
<!-- latest jquery-->
<script src="{{ asset('dashboard') }}/assets/js/jquery-3.5.1.min.js"></script>
<!-- Bootstrap js-->
<script src="{{ asset('dashboard') }}/assets/js/bootstrap/bootstrap.bundle.min.js"></script>
<!-- feather icon js-->
<script src="{{ asset('dashboard') }}/assets/js/icons/feather-icon/feather.min.js"></script>
<script src="{{ asset('dashboard') }}/assets/js/icons/feather-icon/feather-icon.js"></script>
<!-- scrollbar js-->
<script src="{{ asset('dashboard') }}/assets/js/scrollbar/simplebar.js"></script>
<script src="{{ asset('dashboard') }}/assets/js/scrollbar/custom.js"></script>
<!-- Sidebar jquery-->
<script src="{{ asset('dashboard') }}/assets/js/config.js"></script>
<!-- Plugins JS start-->
<script src="{{ asset('dashboard') }}/assets/js/sidebar-menu.js"></script>
<script src="{{ asset('dashboard') }}/assets/js/tooltip-init.js"></script>
<!-- Plugins JS Ends-->
<!-- Theme js-->
<script src="{{ asset('dashboard') }}/assets/js/script.js"></script>
<script src="{{ asset('dashboard') }}/assets/js/notify/bootstrap-notify.min.js"></script>
<script src="{{ asset('dashboard') }}/assets/js/notify/notify-script.js"></script>

<script src="{{ asset('dashboard') }}/ion-sound/ion.sound.js"></script>
<script src="{{ asset('dashboard') }}/ion-sound/ion.sound.min.js"></script>
<script src="{{ asset('dashboard') }}/assets/js/custom.js"></script>
<script src="{{ asset('dashboard') }}/assets/js/select2/select2.full.min.js"></script>
{{-- <script src="{{ asset('dashboard') }}/assets/js/theme-customizer/customizer.js"></script> --}}
<!-- login js-->
<!-- Plugin used-->

<script>
    $(document).ready(function(){
        var close_icon = localStorage.getItem('close_icon')
        if(close_icon == 'true'){
            $('.sidebar-wrapper').addClass('close_icon')
            $('.page-header').addClass('close_icon')
        }else{
            $('.sidebar-wrapper').removeClass('close_icon')
            $('.page-header').removeClass('close_icon')
        }
    })
</script>

@stack('script')

</body>

</html>
