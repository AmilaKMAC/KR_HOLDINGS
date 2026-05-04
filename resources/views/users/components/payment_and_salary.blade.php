@extends('layout.app')

@section('content')
    <div class="container-fluid py-4">

        {{-- ── Flash messages ── --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

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
                                    <th>
                                        Basic Salary
                                        <br><small class="fw-normal text-muted">(pro-rated)</small>
                                    </th>
                                    <th>
                                        Projects Total
                                        <br><small class="fw-normal text-muted">(Solar + Additional)</small>
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

                                        {{-- Month / Year: only if payment exists --}}
                                        <td>
                                            @if ($tech->month && $tech->year)
                                                {{ DateTime::createFromFormat('!m', $tech->month)->format('F') }}
                                                {{ $tech->year }}
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>

                                        {{-- Attendance: always shown live regardless of payment --}}
                                        <td>
                                            @if ($tech->days_attended > 0 || $tech->total_working_days > 0)
                                                <span class="fw-semibold">{{ $tech->days_attended }}</span>
                                                / {{ $tech->total_working_days }} days
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>

                                        {{-- Basic salary: stored pro-rated value --}}
                                        <td>
                                            @if ($tech->basic_salary !== null)
                                                {{ number_format($tech->basic_salary, 2) }} LKR
                                                <div class="text-muted" style="font-size:11px">
                                                    {{ number_format($tech->level_basic_salary, 2) }}
                                                    × {{ $tech->days_attended }}/{{ $tech->total_working_days ?: 1 }}
                                                </div>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>

                                        {{-- Projects total: solar + additional work --}}
                                        <td>
                                            @if ($tech->process_total !== null)
                                                {{ number_format($tech->process_total, 2) }} LKR
                                                <div class="text-muted" style="font-size:11px">
                                                    Solar: {{ number_format($tech->solar_rate ?? 0, 2) }}
                                                    + Addl: {{ number_format($tech->additional_work_rate ?? 0, 2) }}
                                                </div>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>

                                        {{-- Other payment --}}
                                        <td>
                                            @if ($tech->idpayment)
                                                {{ number_format($tech->other_payment ?? 0, 2) }} LKR
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>

                                        {{-- Grand total = basic_salary + process_total + other_payment --}}
                                        <td class="fw-semibold">
                                            @if ($tech->total !== null)
                                                {{ number_format($tech->total, 2) }} LKR
                                                <div class="text-muted" style="font-size:10px">
                                                    {{ number_format($tech->basic_salary, 2) }}
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
                                                <span class="badge {{ $tech->payment_status == 1 ? 'bg-success' : 'bg-warning text-dark' }}">
                                                    {{ $tech->payment_status == 1 ? 'Paid' : 'Pending' }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">No Record</span>
                                            @endif
                                        </td>

                                        {{-- Update status --}}
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
                                        <td colspan="11" class="text-muted py-4">No technicians found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>


    {{-- =========================================================================
         BILL HISTORY MODAL
         Rendered only when history() passes $openModal = true
    ========================================================================= --}}
    @isset($openModal)
        <div class="modal fade" id="billModal" tabindex="-1"
            aria-labelledby="billModalLabel" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content shadow">

                    <div class="modal-header bg-dark text-white">
                        <h5 class="modal-title fw-semibold" id="billModalLabel">
                            Payment History &mdash; {{ $selectedTechnician->name ?? '' }}
                        </h5>
                        <a href="{{ route('payment_and_salary.index') }}"
                            class="btn-close btn-close-white" title="Close"></a>
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
                                        <th>
                                            Attendance
                                            <br><small class="fw-normal text-muted">(present / working days)</small>
                                        </th>
                                        <th>
                                            Basic Salary
                                            <br><small class="fw-normal text-muted">(pro-rated)</small>
                                        </th>
                                        <th>
                                            Projects Total
                                            <br><small class="fw-normal text-muted">(Solar + Additional)</small>
                                        </th>
                                        <th>Other Payment</th>
                                        <th>Grand Total</th>
                                        <th>Status</th>
                                        <th>Update Status</th>
                                        <th>Update Other Payment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($currentPayment)
                                        <tr>
                                            <td>
                                                {{ DateTime::createFromFormat('!m', $currentPayment->month)->format('F') }}
                                                {{ $currentPayment->year }}
                                            </td>

                                            {{-- Attendance + formula --}}
                                            <td>
                                                <span class="fw-semibold">{{ $currentPayment->days_attended }}</span>
                                                / {{ $currentPayment->total_working_days }} days
                                                <div class="text-muted" style="font-size:11px">
                                                    {{ number_format($currentPayment->level_basic_salary, 2) }}
                                                    × {{ $currentPayment->days_attended }}
                                                    / {{ $currentPayment->total_working_days ?: 1 }}
                                                </div>
                                            </td>

                                            {{-- Stored pro-rated basic salary --}}
                                            <td>{{ number_format($currentPayment->basic_salary, 2) }} LKR</td>

                                            {{-- Projects total --}}
                                            <td>
                                                {{ number_format($currentPayment->process_total, 2) }} LKR
                                                <div class="text-muted" style="font-size:11px">
                                                    Solar: {{ number_format($currentPayment->solar_rate, 2) }}
                                                    + Addl: {{ number_format($currentPayment->additional_work_rate, 2) }}
                                                </div>
                                            </td>

                                            {{-- Other payment --}}
                                            <td>{{ number_format($currentPayment->other_payment, 2) }} LKR</td>

                                            {{-- Grand total with breakdown --}}
                                            <td class="fw-semibold">
                                                {{ number_format($currentPayment->total, 2) }} LKR
                                                <div class="text-muted" style="font-size:10px">
                                                    {{ number_format($currentPayment->basic_salary, 2) }}
                                                    + {{ number_format($currentPayment->process_total, 2) }}
                                                    + {{ number_format($currentPayment->other_payment, 2) }}
                                                </div>
                                            </td>

                                            {{-- Status --}}
                                            <td>
                                                <span class="badge {{ $currentPayment->payment_status == 1 ? 'bg-success' : 'bg-warning text-dark' }}">
                                                    {{ $currentPayment->payment_status == 1 ? 'Paid' : 'Pending' }}
                                                </span>
                                            </td>

                                            {{-- Update status --}}
                                            <td>
                                                <form method="POST"
                                                    action="{{ route('payment_and_salary.updateStatus', $currentPayment->idpayment) }}">
                                                    @csrf
                                                    <input type="hidden" name="payment_status"
                                                        value="{{ $currentPayment->payment_status == 1 ? 0 : 1 }}">
                                                    <button type="submit"
                                                        class="btn btn-sm {{ $currentPayment->payment_status == 1 ? 'btn-outline-warning' : 'btn-primary' }}">
                                                        Mark as {{ $currentPayment->payment_status == 1 ? 'Pending' : 'Paid' }}
                                                    </button>
                                                </form>
                                            </td>

                                            {{-- Update other_payment --}}
                                            <td style="min-width:180px">
                                                <form method="POST"
                                                    action="{{ route('payment_and_salary.updateOtherPayment', $currentPayment->idpayment) }}">
                                                    @csrf
                                                    <div class="input-group input-group-sm">
                                                        <input type="number" name="other_payment"
                                                            class="form-control"
                                                            value="{{ $currentPayment->other_payment }}"
                                                            min="0" step="0.01" placeholder="0.00">
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
                                        <th>
                                            Attendance
                                            <br><small class="fw-normal text-muted">(present / working days)</small>
                                        </th>
                                        <th>
                                            Basic Salary
                                            <br><small class="fw-normal text-muted">(pro-rated)</small>
                                        </th>
                                        <th>
                                            Projects Total
                                            <br><small class="fw-normal text-muted">(Solar + Additional)</small>
                                        </th>
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

                                            {{-- Attendance + formula --}}
                                            <td>
                                                <span class="fw-semibold">{{ $payment->days_attended }}</span>
                                                / {{ $payment->total_working_days }} days
                                                <div class="text-muted" style="font-size:11px">
                                                    {{ number_format($payment->level_basic_salary, 2) }}
                                                    × {{ $payment->days_attended }}
                                                    / {{ $payment->total_working_days ?: 1 }}
                                                </div>
                                            </td>

                                            {{-- Stored pro-rated basic salary --}}
                                            <td>{{ number_format($payment->basic_salary, 2) }} LKR</td>

                                            {{-- Projects total --}}
                                            <td>
                                                {{ number_format($payment->process_total, 2) }} LKR
                                                <div class="text-muted" style="font-size:11px">
                                                    Solar: {{ number_format($payment->solar_rate, 2) }}
                                                    + Addl: {{ number_format($payment->additional_work_rate, 2) }}
                                                </div>
                                            </td>

                                            {{-- Other payment --}}
                                            <td>{{ number_format($payment->other_payment, 2) }} LKR</td>

                                            {{-- Grand total with breakdown --}}
                                            <td class="fw-semibold">
                                                {{ number_format($payment->total, 2) }} LKR
                                                <div class="text-muted" style="font-size:10px">
                                                    {{ number_format($payment->basic_salary, 2) }}
                                                    + {{ number_format($payment->process_total, 2) }}
                                                    + {{ number_format($payment->other_payment, 2) }}
                                                </div>
                                            </td>

                                            {{-- Status --}}
                                            <td>
                                                <span class="badge {{ $payment->payment_status == 1 ? 'bg-success' : 'bg-warning text-dark' }}">
                                                    {{ $payment->payment_status == 1 ? 'Paid' : 'Pending' }}
                                                </span>
                                            </td>

                                            {{-- Update status --}}
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

                                            {{-- Update other_payment --}}
                                            <td style="min-width:180px">
                                                <form method="POST"
                                                    action="{{ route('payment_and_salary.updateOtherPayment', $payment->idpayment) }}">
                                                    @csrf
                                                    <div class="input-group input-group-sm">
                                                        <input type="number" name="other_payment"
                                                            class="form-control"
                                                            value="{{ $payment->other_payment }}"
                                                            min="0" step="0.01" placeholder="0.00">
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
                        <a href="{{ route('payment_and_salary.index') }}" class="btn btn-secondary">
                            Close
                        </a>
                    </div>

                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                new bootstrap.Modal(document.getElementById('billModal'), {
                    backdrop: 'static'
                }).show();
            });
        </script>
    @endisset
@endsection