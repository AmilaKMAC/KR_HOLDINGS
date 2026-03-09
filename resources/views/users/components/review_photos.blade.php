@extends('layout.app')

@section('content')

<div class="container-fluid py-4">


    <!-- ================= PROJECT TABLE ================= -->
    <div class="row justify-content-center">
        <div class="col-12 col-xxl-11">

            <div class="card shadow-sm">

                <div class="card-body table-responsive">

                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Project ID</th>
                                <th>Customer Name</th>
                                <th>Location</th>
                                <th>Capacity</th>
                                <th>Partner Company</th>
                                <th>Technician ID</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>P001</td>
                                <td>Kasun Perera</td>
                                <td>Colombo</td>
                                <td>10kW</td>
                                <td>ABC Solar</td>
                                <td>T01</td>
                                <td>
                                    <button class="btn btn-sm btn-primary view-btn">
                                        View
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>

                <!-- Bottom Controls -->
                <div class="d-flex justify-content-between align-items-center px-3 py-2 bg-light border-top">
                        @include('others.limit_btn_group')

                    </div>
                </div>

            </div>
        </div>
    </div>

</div>


<!-- ================= PHOTO REVIEW MODAL ================= -->
<div class="modal fade" id="photoModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content shadow">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-semibold">Installation Photo Review</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <!-- Download All Button -->
                <div class="text-end mb-4">
                    <a href="#" class="btn btn-success">
                        Download All Photos
                    </a>
                </div>

                @php
                    $sections = [
                        "Panel Installation",
                        "Waterproofing (Roof Top)",
                        "Railing Installation",
                        "DC Wiring",
                        "Inverter Installation",
                        "Combiner Boxes",
                        "Hybrid Battery (Optional)",
                        "Casing",
                        "Grounding",
                        "Additional Work (Optional)"
                    ];
                @endphp

                @foreach($sections as $section)
                <div class="mb-5">
                    <h6 class="fw-bold text-primary mb-3">{{ $section }}</h6>

                    <div class="row g-3">

                        <!-- SAMPLE IMAGES -->
                        <div class="col-6 col-md-4 col-lg-3">
                            <img src="https://via.placeholder.com/600x400"
                                 class="img-fluid rounded shadow-sm preview-image"
                                 style="cursor:pointer"
                                 alt="Photo">
                        </div>

                        <div class="col-6 col-md-4 col-lg-3">
                            <img src="https://via.placeholder.com/600x400"
                                 class="img-fluid rounded shadow-sm preview-image"
                                 style="cursor:pointer"
                                 alt="Photo">
                        </div>

                    </div>
                </div>
                @endforeach

            </div>

        </div>
    </div>
</div>


<!-- ================= IMAGE PREVIEW MODAL ================= -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content bg-dark">

            <div class="modal-header border-0">
                <button type="button" class="btn-close btn-close-white"
                        data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">

                <img id="previewImage"
                     src=""
                     class="img-fluid rounded mb-3"
                     style="max-height:75vh;">

                <div>
                    <a id="downloadImageBtn"
                       href="#"
                       download
                       class="btn btn-success">
                        Download Image
                    </a>
                </div>

            </div>

        </div>
    </div>
</div>


<script>
document.addEventListener("DOMContentLoaded", function () {

    const photoModal  = new bootstrap.Modal(document.getElementById('photoModal'));
    const previewModal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));

    // Open main modal
    document.querySelectorAll('.view-btn').forEach(button => {
        button.addEventListener('click', function () {
            photoModal.show();
        });
    });

    // Image click preview
    document.querySelectorAll('.preview-image').forEach(img => {
        img.addEventListener('click', function () {
            const imageSrc = this.getAttribute('src');
            document.getElementById('previewImage').src = imageSrc;
            document.getElementById('downloadImageBtn').href = imageSrc;
            previewModal.show();
        });
    });

    // Limit buttons
    document.querySelectorAll('.limit-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.limit-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });

});
</script>

@endsection