@include('includes.header.start')
@include('includes.header.end')
@include('includes.navbar.left')
@include('includes.navbar.top')

<div class="p-3 d-flex justify-content-end">
    <button type="button" class="btn btn-primary">
                <i class="bi bi-bell"></i>
                Alert
              </button>
</div>


<div class="content">
    @yield('content')







</div>



@include('includes.footer.start')
@include('includes.footer.end')
