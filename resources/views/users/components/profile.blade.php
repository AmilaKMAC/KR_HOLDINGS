@extends('layout.app')

@section('content')
    <div class="container-fluid py-4">

        <!-- ================= PROFILE SECTION ================= -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">

                        <!-- Profile Image -->
                        <div class="text-center mb-4">
                            <div class="rounded-circle border mx-auto d-flex align-items-center justify-content-center"
                                style="width:150px; height:150px;">
                                <i class="bi bi-person" style="font-size:70px;"></i>
                            </div>
                        </div>
                    

                        <!-- Profile Details -->
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Name</label>
                            <input type="text" class="form-control"
                                value="{{ ucwords(strtolower(trim($user->first_name . ' ' . $user->last_name))) }}"
                                readonly>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Technician ID</label>
                            <input type="text" class="form-control"
                                value="T{{ str_pad($user->TechnicianRegistration->idtechnician_registration ?? '—', 4, '0', STR_PAD_LEFT) }}"
                                readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Start Date</label>
                            <input type="text" class="form-control"
                                value="{{ $user->created_at?->format('Y-m-d') ?? '—' }}" readonly>
                        </div>
                </div>

                    </div>


                    <!-- ================= PAYMENT DETAILS ================= -->
                    <div class="card mt-4">
                        <div class="card-header text-center fw-bold bg-dark text-white">
                            Payment Details
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive p-2">
                                <table class="table table-bordered data-table text-center align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Month / Year</th>
                                            <th>Attendance<br><small class="fw-normal text-muted">(present / working
                                                    days)</small></th>
                                            <th>Basic Salary<br>
                                            </th>
                                            <th>Projects Total</th>
                                            <th>Other Payment</th>
                                            <th>Grand Total</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($previousPayments as $payment)
                                            <tr>
                                                <td>
                                                    {{ DateTime::createFromFormat('!m', $payment->month)->format('F') }}
                                                    {{ $payment->year }}
                                                </td>

                                                {{-- ATTENDANCE --}}
                                                <td>
                                                    <span class="fw-semibold">{{ $payment->days_attended }}</span>
                                                    / {{ $payment->total_working_days }} days
                                                    <div class="text-muted" style="font-size:11px">
                                                        Bonus: {{ number_format($payment->attendance_bonus, 2) }} LKR
                                                    </div>
                                                </td>

                                                {{-- BASIC SALARY --}}
                                                <td>{{ number_format($payment->basic_salary, 2) }} LKR</td>

                                                {{-- PROJECTS TOTAL --}}
                                                <td>
                                                    @if ($payment->process_total !== null)
                                                        {{ number_format($payment->process_total, 2) }} LKR
                                                        <div class="text-muted" style="font-size:11px">
                                                            {{ $payment->payment_processes->count() }} project(s)
                                                        </div>
                                                        <button type="button" class="btn btn-sm btn-outline-info mt-1"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#projectModal_prof_{{ $payment->idpayment }}">
                                                            <i class="bi bi-eye"></i> Details
                                                        </button>
                                                    @else
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </td>

                                                {{-- OTHER PAYMENT --}}
                                                <td>{{ number_format($payment->other_payment ?? 0, 2) }} LKR</td>

                                                {{-- GRAND TOTAL --}}
                                                <td class="fw-semibold">
                                                    {{ number_format($payment->total, 2) }} LKR
                                                    <div class="text-muted" style="font-size:10px">
                                                        {{ number_format($payment->basic_salary, 2) }}
                                                        + {{ number_format($payment->attendance_bonus, 2) }}
                                                        + {{ number_format($payment->process_total ?? 0, 2) }}
                                                        + {{ number_format($payment->other_payment ?? 0, 2) }}
                                                    </div>
                                                </td>

                                                {{-- STATUS --}}
                                                <td>
                                                    <span
                                                        class="badge {{ $payment->payment_status == 1 ? 'bg-success' : 'bg-warning text-dark' }}">
                                                        {{ $payment->payment_status == 1 ? 'Paid' : 'Pending' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-muted py-3">No previous bills found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- ================================================= -->

            </div>
        </div>

    </div>


    {{-- ===== PROJECT DETAIL MODALS (one per payment) ===== --}}
    @foreach ($previousPayments as $payment)
        @if ($payment->idpayment && $payment->process_total !== null)
            <div class="modal fade" id="projectModal_prof_{{ $payment->idpayment }}" tabindex="-1" aria-modal="true"
                role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content shadow">
                        <div class="modal-header bg-info text-white">
                            <h5 class="modal-title fw-semibold">
                                Project Details &mdash;
                                {{ DateTime::createFromFormat('!m', $payment->month)->format('F') }}
                                {{ $payment->year }}
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body p-2">
                            <table class="table table-bordered data-table text-center align-middle mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Customer Name</th>
                                        <th>Solar Capacity</th>
                                        <th>Solar Rate (LKR)</th>
                                        <th>Additional Work</th>
                                        <th>Additional Rate (LKR)</th>
                                        <th>Project Total (LKR)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payment->payment_processes as $index => $process)
                                        @php $solar = $process->project->solar ?? null; @endphp
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $process->project->customer_name ?? '—' }}</td>
                                            <td>
                                                <span class="badge bg-warning text-dark">
                                                    {{ $solar->capacity ?? '—' }} kW
                                                </span>
                                            </td>
                                            <td>{{ number_format($solar->rate ?? 0, 2) }}</td>
                                            <td>
                                                @forelse ($process->additionalWorks as $aw)
                                                    <span class="badge bg-secondary me-1 mb-1">
                                                        {{ $aw->additionalWork->description ?? '—' }}
                                                    </span>
                                                @empty
                                                    <span class="text-muted">—</span>
                                                @endforelse
                                            </td>
                                            <td>
                                                @forelse ($process->additionalWorks as $aw)
                                                    <span>{{ number_format($aw->additionalWork->rate, 2) }}</span>
                                                @empty
                                                    <span class="text-muted">—</span>
                                                @endforelse
                                            </td>
                                            <td class="fw-semibold">{{ number_format($process->total, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="6" class="text-end">Projects Total</th>
                                        <th>{{ number_format($payment->process_total, 2) }} LKR</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endsection
