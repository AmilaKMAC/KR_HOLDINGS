@extends('layout.app')

@section('content')
    <div class="container-fluid py-4">

        {{-- ── Main table ── --}}
        <div class="row justify-content-center">
            <div class="col-12 col-xxl-11">
                <div class="card shadow-sm">

                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center px-3">
                        <span class="fw-semibold">Technician Payment &mdash; {{ $currentMonth }}</span>
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-bordered align-middle text-center mb-0 data-table">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Month / Year</th>
                                    <th>
                                        Attendance
                                        <br><small class="fw-normal text-muted">(present / working days)</small>
                                    </th>
                                    <th>Basic Salary</th>
                                    <th>
                                        Projects Total
                                        <br><small class="fw-normal text-muted">(all projects)</small>
                                    </th>
                                    <th>Other Payment</th>
                                    <th>Grand Total</th>
                                    <th>Status</th>
                                    <th>Update Status</th>
                                    <th>History</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($technicians as $tech)
                                    <tr>
                                        <td>{{ $tech->iduser }}</td>
                                        <td class="text-start">{{ $tech->name }}</td>

                                        {{-- Month / Year --}}
                                        <td>
                                            @if ($tech->month && $tech->year)
                                                {{ DateTime::createFromFormat('!m', $tech->month)->format('F') }}
                                                {{ $tech->year }}
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>

                                        {{-- Attendance --}}
                                        <td>
                                            @if ($tech->days_attended > 0 || $tech->total_working_days > 0)
                                                <span class="fw-semibold">{{ $tech->days_attended }}</span>
                                                / {{ $tech->total_working_days }} days
                                                <div class="text-muted" style="font-size:11px">
                                                    {{ number_format($tech->attendance_bonus, 2) }} LKR
                                                </div>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>

                                        {{-- Basic Salary --}}
                                        <td>
                                            @if ($tech->basic_salary !== null)
                                                {{ number_format($tech->basic_salary, 2) }} LKR
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>

                                        {{-- Projects Total with Details button --}}
                                        <td>
                                            @if ($tech->process_total !== null)
                                                {{ number_format($tech->process_total, 2) }} LKR
                                                <div class="text-muted" style="font-size:11px">
                                                    {{ $tech->payment_processes->count() }} project(s)
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-info mt-1"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#projectModal_{{ $tech->idpayment }}">
                                                    <i class="bi bi-eye"></i> Details
                                                </button>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>

                                        {{-- Other Payment --}}
                                        <td>
                                            @if ($tech->idpayment)
                                                {{ number_format($tech->other_payment ?? 0, 2) }} LKR
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>

                                        {{-- Grand Total --}}
                                        <td class="fw-semibold">
                                            @if ($tech->total !== null)
                                                {{ number_format($tech->total, 2) }} LKR
                                                <div class="text-muted" style="font-size:10px">
                                                    {{ number_format($tech->basic_salary, 2) }}
                                                    + {{ number_format($tech->attendance_bonus, 2) }}
                                                    + {{ number_format($tech->process_total ?? 0, 2) }}
                                                    + {{ number_format($tech->other_payment ?? 0, 2) }}
                                                </div>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>

                                        {{-- Status --}}
                                        <td>
                                            @if ($tech->idpayment)
                                                <span
                                                    class="badge {{ $tech->payment_status == 1 ? 'bg-success' : 'bg-warning text-dark' }}">
                                                    {{ $tech->payment_status == 1 ? 'Paid' : 'Pending' }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">No Record</span>
                                            @endif
                                        </td>

                                        {{-- Update Status --}}
                                        <td>
                                            @if ($tech->idpayment)
                                                <form method="POST"
                                                    action="{{ route('payment_and_salary.updateStatus', $tech->idpayment) }}">
                                                    @csrf
                                                    <input type="hidden" name="payment_status"
                                                        value="{{ $tech->payment_status == 1 ? 0 : 1 }}">
                                                    <button type="submit"
                                                        class="btn btn-sm {{ $tech->payment_status == 1 ? 'btn-outline-warning' : 'btn-primary' }}">
                                                        Mark as {{ $tech->payment_status == 1 ? 'Pending' : 'Paid' }}
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-muted small">N/A</span>
                                            @endif
                                        </td>

                                        {{-- History --}}
                                        <td>
                                            <a href="{{ route('payment_and_salary.history', $tech->iduser) }}"
                                                class="btn btn-sm btn-success">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="text-muted py-4">No technicians found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>


    {{-- ── Project detail modals for main table ── --}}
    @foreach ($technicians as $tech)
        @if ($tech->idpayment && $tech->process_total !== null)
            <div class="modal fade" id="projectModal_{{ $tech->idpayment }}" tabindex="-1" aria-modal="true"
                role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content shadow">
                        <div class="modal-header bg-info text-white">
                            <h5 class="modal-title fw-semibold">
                                Project Details &mdash; {{ $tech->name }}
                                @if ($tech->month)
                                    &mdash; {{ DateTime::createFromFormat('!m', $tech->month)->format('F') }}
                                    {{ $tech->year }}
                                @endif
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered text-center align-middle mb-0">
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
                                    @foreach ($tech->payment_processes as $index => $process)
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
                                            {{-- Additional Works as badges --}}
                                            <td>
                                                @forelse ($process->additionalWorks as $aw)
                                                    <span class="badge bg-secondary me-1 mb-1">
                                                        {{ $aw->additionalWork->description ?? '—' }}
                                                    </span>
                                                @empty
                                                    <span class="text-muted">—</span>
                                                @endforelse
                                            </td>
                                            {{-- Additional Rates as badges --}}
                                            <td>
                                                @forelse ($process->additionalWorks as $aw)
                                                    <span>
                                                        {{ number_format($aw->additionalWork->rate, 2) }}
                                                    </span>
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
                                        <th>{{ number_format($tech->process_total, 2) }} LKR</th>
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


    {{-- =========================================================================
     BILL HISTORY MODAL
    ========================================================================= --}}
    @isset($openModal)
        <div class="modal fade" id="billModal" tabindex="-1" aria-labelledby="billModalLabel" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content shadow">

                    <div class="modal-header bg-dark text-white">
                        <h5 class="modal-title fw-semibold" id="billModalLabel">
                            Payment History &mdash; {{ $selectedTechnician->name ?? '' }}
                        </h5>
                        <a href="{{ route('payment_and_salary.index') }}" class="btn-close btn-close-white" title="Close"></a>
                    </div>

                    <div class="modal-body">

                        {{-- ── Current Month ── --}}
                        <h6 class="fw-bold text-primary mb-3">
                            Current Month
                            @if ($currentPayment)
                                &mdash;
                                {{ DateTime::createFromFormat('!m', $currentPayment->month)->format('F') }}
                                {{ $currentPayment->year }}
                            @endif
                        </h6>

                        <div class="table-responsive mb-4">
                            <table class="table table-bordered text-center align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Month / Year</th>
                                        <th>Attendance<br><small class="fw-normal text-muted">(present / working days)</small>
                                        </th>
                                        <th>Basic Salary<br><small class="fw-normal text-muted">(pro-rated)</small></th>
                                        <th>Projects Total<br><small class="fw-normal text-muted">(all projects)</small></th>
                                        <th>Other Payment</th>
                                        <th>Grand Total</th>
                                        <th>Status</th>
                                        <th>Update Status</th>
                                        <th>Update Other Payment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($currentPayment)
                                        @php $payment = $currentPayment; @endphp
                                        <tr>
                                            <td>
                                                {{ DateTime::createFromFormat('!m', $payment->month)->format('F') }}
                                                {{ $payment->year }}
                                            </td>
                                            <td>
                                                <span class="fw-semibold">{{ $payment->days_attended }}</span>
                                                / {{ $payment->total_working_days }} days
                                                <div class="text-muted" style="font-size:11px">
                                                    {{ number_format($payment->attendance_bonus, 2) }} LKR

                                                </div>
                                            </td>
                                            <td>{{ number_format($payment->basic_salary, 2) }} LKR</td>

                                            <td>
                                                @if ($payment->process_total !== null)
                                                    {{ number_format($payment->process_total, 2) }} LKR
                                                    <div class="text-muted" style="font-size:11px">
                                                        {{ $payment->payment_processes->count() }} project(s)
                                                    </div>
                                                    <button type="button" class="btn btn-sm btn-outline-info mt-1"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#projectModal_hist_{{ $payment->idpayment }}">
                                                        <i class="bi bi-eye"></i> Details
                                                    </button>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>{{ number_format($payment->other_payment ?? 0, 2) }} LKR</td>
                                            <td class="fw-semibold">
                                                {{ number_format($payment->total, 2) }} LKR
                                                <div class="text-muted" style="font-size:10px">
                                                    {{ number_format($payment->basic_salary, 2) }}
                                                    + {{ number_format($payment->attendance_bonus, 2) }}
                                                    + {{ number_format($payment->process_total ?? 0, 2) }}
                                                    + {{ number_format($payment->other_payment ?? 0, 2) }}
                                                </div>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge {{ $payment->payment_status == 1 ? 'bg-success' : 'bg-warning text-dark' }}">
                                                    {{ $payment->payment_status == 1 ? 'Paid' : 'Pending' }}
                                                </span>
                                            </td>
                                            <td>
                                                <form method="POST"
                                                    action="{{ route('payment_and_salary.updateStatus', $payment->idpayment) }}">
                                                    @csrf
                                                    <input type="hidden" name="payment_status"
                                                        value="{{ $payment->payment_status == 1 ? 0 : 1 }}">
                                                    <button type="submit"
                                                        class="btn btn-sm {{ $payment->payment_status == 1 ? 'btn-outline-warning' : 'btn-primary' }}">
                                                        Mark as {{ $payment->payment_status == 1 ? 'Pending' : 'Paid' }}
                                                    </button>
                                                </form>
                                            </td>
                                            <td style="min-width:180px">
                                                <form method="POST"
                                                    action="{{ route('payment_and_salary.updateOtherPayment', $payment->idpayment) }}">
                                                    @csrf
                                                    <div class="input-group input-group-sm">
                                                        <input type="number" name="other_payment" class="form-control"
                                                            value="{{ $payment->other_payment }}" min="0"
                                                            step="0.01" placeholder="0.00">
                                                        <button type="submit" class="btn btn-warning">Save</button>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td colspan="9" class="text-muted py-3">
                                                No payment record for this month yet.
                                                Records are created automatically when projects are approved.
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        {{-- ── Previous Bills ── --}}
                        <h6 class="fw-bold text-success mb-3">Previous Bills</h6>

                        <div class="table-responsive">
                            <table class="table table-bordered text-center align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Month / Year</th>
                                        <th>Attendance<br><small class="fw-normal text-muted">(present / working days)</small>
                                        </th>
                                        <th>Basic Salary<br><small class="fw-normal text-muted">(pro-rated)</small></th>
                                        <th>Projects Total<br><small class="fw-normal text-muted">(all projects)</small></th>
                                        <th>Other Payment</th>
                                        <th>Grand Total</th>
                                        <th>Status</th>
                                        <th>Update Status</th>
                                        <th>Update Other Payment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($previousPayments as $payment)
                                        <tr>
                                            <td>
                                                {{ DateTime::createFromFormat('!m', $payment->month)->format('F') }}
                                                {{ $payment->year }}
                                            </td>
                                            <td>
                                                <span class="fw-semibold">{{ $payment->days_attended }}</span>
                                                / {{ $payment->total_working_days }} days
                                                <div class="text-muted" style="font-size:11px">
                                                    {{ number_format($payment->attendance_bonus, 2) }} LKR

                                                </div>
                                            </td>
                                            <td>{{ number_format($payment->basic_salary, 2) }} LKR</td>

                                            <td>
                                                @if ($payment->process_total !== null)
                                                    {{ number_format($payment->process_total, 2) }} LKR
                                                    <div class="text-muted" style="font-size:11px">
                                                        {{ $payment->payment_processes->count() }} project(s)
                                                    </div>
                                                    <button type="button" class="btn btn-sm btn-outline-info mt-1"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#projectModal_hist_{{ $payment->idpayment }}">
                                                        <i class="bi bi-eye"></i> Details
                                                    </button>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>{{ number_format($payment->other_payment ?? 0, 2) }} LKR</td>
                                            <td class="fw-semibold">
                                                {{ number_format($payment->total, 2) }} LKR
                                                <div class="text-muted" style="font-size:10px">
                                                    {{ number_format($payment->basic_salary, 2) }}
                                                    + {{ number_format($payment->attendance_bonus, 2) }}
                                                    + {{ number_format($payment->process_total ?? 0, 2) }}
                                                    + {{ number_format($payment->other_payment ?? 0, 2) }}
                                                </div>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge {{ $payment->payment_status == 1 ? 'bg-success' : 'bg-warning text-dark' }}">
                                                    {{ $payment->payment_status == 1 ? 'Paid' : 'Pending' }}
                                                </span>
                                            </td>
                                            <td>
                                                <form method="POST"
                                                    action="{{ route('payment_and_salary.updateStatus', $payment->idpayment) }}">
                                                    @csrf
                                                    <input type="hidden" name="payment_status"
                                                        value="{{ $payment->payment_status == 1 ? 0 : 1 }}">
                                                    <button type="submit"
                                                        class="btn btn-sm {{ $payment->payment_status == 1 ? 'btn-outline-warning' : 'btn-primary' }}">
                                                        Mark as {{ $payment->payment_status == 1 ? 'Pending' : 'Paid' }}
                                                    </button>
                                                </form>
                                            </td>
                                            <td style="min-width:180px">
                                                <form method="POST"
                                                    action="{{ route('payment_and_salary.updateOtherPayment', $payment->idpayment) }}">
                                                    @csrf
                                                    <div class="input-group input-group-sm">
                                                        <input type="number" name="other_payment" class="form-control"
                                                            value="{{ $payment->other_payment }}" min="0"
                                                            step="0.01" placeholder="0.00">
                                                        <button type="submit" class="btn btn-warning">Save</button>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-muted py-3">No previous bills found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>{{-- /modal-body --}}

                    <div class="modal-footer">
                        <a href="{{ route('payment_and_salary.index') }}" class="btn btn-secondary">Close</a>
                    </div>

                </div>
            </div>
        </div>

        {{-- ── Project detail modals for history rows ── --}}
        @php
            $historyPayments = collect();
            if ($currentPayment) {
                $historyPayments->push($currentPayment);
            }
            foreach ($previousPayments as $p) {
                $historyPayments->push($p);
            }
        @endphp

        @foreach ($historyPayments as $payment)
            @if ($payment->idpayment && $payment->process_total !== null)
                <div class="modal fade" id="projectModal_hist_{{ $payment->idpayment }}" tabindex="-1" aria-modal="true"
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

                            <div class="modal-body">
                                <table class="table table-bordered text-center align-middle mb-0">
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
                                                {{-- Additional Works as badges --}}
                                                <td>
                                                    @forelse ($process->additionalWorks as $aw)
                                                        <span class="badge bg-secondary me-1 mb-1">
                                                            {{ $aw->additionalWork->description ?? '—' }}
                                                        </span>
                                                    @empty
                                                        <span class="text-muted">—</span>
                                                    @endforelse
                                                </td>
                                                {{-- Additional Rates as badges --}}
                                                <td>
                                                    @forelse ($process->additionalWorks as $aw)
                                                        <span">
                                                            {{ number_format($aw->additionalWork->rate, 2) }}
                                                            </span>
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

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                new bootstrap.Modal(document.getElementById('billModal'), {
                    backdrop: 'static'
                }).show();
            });
        </script>
    @endisset

@endsection
