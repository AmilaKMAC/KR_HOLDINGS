{{-- ================= ALERT BUTTON ================= --}}

<div class="container-fluid">
    <div class="p-3 d-flex justify-content-end">
        <button type="button" class="btn btn-primary me-4">
            <i class="bi bi-bell"></i>
            Alert
        </button>
    </div>
</div>



{{-- ================= ALERT MESSAGES ================= --}}
<div class="col-10 mx-auto">
    @if (session('success'))
        <div id="successAlert" class="alert alert-success alert-dismissible fade show shadow-sm mt-3" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div id="errorAlert" class="alert alert-danger alert-dismissible fade show shadow-sm mt-3" role="alert">
            <strong>Error!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div id="validationAlert" class="alert alert-danger alert-dismissible fade show shadow-sm mt-3" role="alert">
            <strong>Validation Error!</strong>
            <ul class="mb-0 mt-2 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

</div>





<script>
    setTimeout(() => {
        let successAlert = document.getElementById('successAlert');
        let errorAlert = document.getElementById('errorAlert');
        let validationAlert = document.getElementById('validationAlert');

        [successAlert, errorAlert, validationAlert].forEach(alert => {
            if (alert) {
                let bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        });
    }, 4000);
</script>
