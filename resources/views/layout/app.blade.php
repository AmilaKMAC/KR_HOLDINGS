@include('includes.header.start')
@include('includes.header.end')
@include('includes.navbar.left')
@include('includes.navbar.top')

<div class="container-fluid">
    <div class="p-3 d-flex justify-content-end">
        <button type="button" class="btn btn-primary me-4">
            <i class="bi bi-bell"></i>
            Alert
        </button>
    </div>
</div>


<div class="content">
    @yield('content')







</div>



@include('includes.footer.start')
@include('includes.footer.end')
