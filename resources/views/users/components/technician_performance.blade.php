@extends('layout.app')

@section('content')

    <!-- Technician Performance -->
    <div class="container mt-5">
        <div class="d-grid gap-4 col-8 mx-auto">

            <button class="btn btn-primary p-4" data-bs-toggle="modal" data-bs-target="#completionModal">
                Technician Completion of Work
            </button>

            <button class="btn btn-success p-4" data-bs-toggle="modal" data-bs-target="#rateModal">
                Completion Rate
            </button>

            <button class="btn btn-secondary p-4" data-bs-toggle="modal" data-bs-target="#attendanceModal">
                Attendance Reliability
            </button>

        </div>
    </div>

    <!-- ============================== MODALS =================================== -->

    <!-- COMPLETION OF WORK Modal-->
    <div class="modal fade" id="completionModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Technician Completion of Work</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center align-middle data-table" id="completionTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Technician ID</th>
                                    <th>Technician Name</th>
                                    <th>Project ID</th>
                                    <th>Customer Name</th>
                                    <th>Location</th>
                                    <th>Capacity</th>
                                    <th>Completion Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>T001</td><td>John Silva</td><td>P101</td><td>ABC Pvt Ltd</td><td>Colombo</td><td>High</td><td>2026-02-15</td></tr>
                                <tr><td>T002</td><td>Kasun Perera</td><td>P102</td><td>XYZ Holdings</td><td>Kandy</td><td>Medium</td><td>2026-02-18</td></tr>
                                <tr><td>T003</td><td>Ruwan Perera</td><td>P103</td><td>LMN Corp</td><td>Galle</td><td>Low</td><td>2026-02-20</td></tr>
                                <tr><td>T004</td><td>Nimal Silva</td><td>P104</td><td>PQR Ltd</td><td>Matara</td><td>High</td><td>2026-02-22</td></tr>
                                <tr><td>T005</td><td>Sandun Kumara</td><td>P105</td><td>DEF Pvt Ltd</td><td>Negombo</td><td>Medium</td><td>2026-02-25</td></tr>
                                <tr><td>T006</td><td>Tharindu Perera</td><td>P106</td><td>GHI Corp</td><td>Colombo</td><td>High</td><td>2026-02-28</td></tr>
                            
                            </tbody>
                        </table>
                    </div>

                    <!-- Bottom Controls -->
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-muted small" id="completionInfo"></span>
                            <button class="btn btn-outline-dark btn-sm" onclick="printTable('completionTable', 'Technician Completion of Work')">Print</button>
                            <button class="btn btn-outline-success btn-sm">Export Excel</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!-- COMPLETION RATE  -->
    <div class="modal fade" id="rateModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Completion Rate</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center align-middle data-table" id="rateTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Technician ID</th>
                                    <th>Technician Name</th>
                                    <th>Assigned Projects</th>
                                    <th>Completed Projects</th>
                                    <th>Completion Rate (%)</th>
                                    <th>Time Frame</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>T001</td><td>John Silva</td><td>10</td><td>9</td><td>90%</td><td>Jan 2026</td></tr>
                                <tr><td>T002</td><td>Kasun Perera</td><td>8</td><td>6</td><td>75%</td><td>Jan 2026</td></tr>
                                <tr><td>T003</td><td>Ruwan Perera</td><td>12</td><td>11</td><td>92%</td><td>Jan 2026</td></tr>
                                <tr><td>T004</td><td>Nimal Silva</td><td>7</td><td>5</td><td>71%</td><td>Jan 2026</td></tr>
                                <tr><td>T005</td><td>Sandun Kumara</td><td>9</td><td>9</td><td>100%</td><td>Jan 2026</td></tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Bottom Controls -->
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-muted small" id="rateInfo"></span>
                            <button class="btn btn-outline-dark btn-sm" onclick="printTable('rateTable', 'Completion Rate')">Print</button>
                            <button class="btn btn-outline-success btn-sm">Export Excel</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!-- ATTENDANCE RELIABILITY  -->
    <div class="modal fade" id="attendanceModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title">Attendance Reliability</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center align-middle data-table" id="attendanceTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Technician ID</th>
                                    <th>Technician Name</th>
                                    <th>Total Workdays</th>
                                    <th>Present Days</th>
                                    <th>Attendance Reliability (%)</th>
                                    <th>Time Frame</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>T001</td><td>John Silva</td><td>22</td><td>21</td><td>95%</td><td>Jan 2026</td></tr>
                                <tr><td>T002</td><td>Kasun Perera</td><td>22</td><td>19</td><td>86%</td><td>Jan 2026</td></tr>
                                <tr><td>T003</td><td>Ruwan Perera</td><td>22</td><td>22</td><td>100%</td><td>Jan 2026</td></tr>
                                <tr><td>T004</td><td>Nimal Silva</td><td>22</td><td>18</td><td>82%</td><td>Jan 2026</td></tr>
                                <tr><td>T005</td><td>Sandun Kumara</td><td>22</td><td>20</td><td>91%</td><td>Jan 2026</td></tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Bottom Controls -->
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-muted small" id="attendanceInfo"></span>
                            <button class="btn btn-outline-dark btn-sm" onclick="printTable('attendanceTable', 'Attendance Reliability')">Print</button>
                            <button class="btn btn-outline-success btn-sm">Export Excel</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <script>
        

        // ── Print ─────────────────────────────────────────────────────────────────────
        function printTable(tableId, title) {
            const table = document.getElementById(tableId).outerHTML;
            const win   = window.open('', '_blank');
            win.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>${title}</title>
                    <link rel="stylesheet">
                    <style>
                        body { padding: 24px; font-family: Arial, sans-serif; }
                        h5   { margin-bottom: 16px; }
                        @media print { body { padding:0; } @page { margin:15mm; } }
                    </style>
                </head>
                <body>
                    <h5>${title}</h5>
                    ${table}
                    <script>window.onload = function(){ window.print(); window.close(); }<\/script>
                </body>
                </html>`);
            win.document.close();
        }
    </script>
@endsection