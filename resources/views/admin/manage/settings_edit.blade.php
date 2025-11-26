@extends('admin.layouts.app')

@section('title', 'Edit Scheme Setting')

@section('head')
{{-- Bootstrap Icons CDN को यहाँ रहने दें --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
@endsection

@section('content')

<style>
    #emiTable input.form-control {
        height: 35px; 
        padding: 0.375rem 0.75rem; /* पैडिंग को थोड़ा कम करें */
        font-size: 0.875rem; /* फ़ॉन्ट साइज छोटा करें */
    }
    /* छोटे लेबल को थोड़ा और स्पष्ट करें */
    .form-group label.small, .row label.small {
        font-weight: 500;
        color: #555;
        margin-bottom: 0.2rem;
        display: block; 
    }
</style>

<div class="container-fluid mt-3">

    <div class="card shadow-sm">
        <div class="card-header fw-bold bg-primary text-white"> 
            <i class="bi bi-pencil-square me-2"></i> Edit Scheme Setting
        </div>

        <div class="card-body">

            <form action="{{ route('admin.manage.settings.update', $setting->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- SECTION 1: Scheme Details --}}
                <div class="row g-3"> 
                    {{-- Scheme Plan --}}
                    <div class="col-md-2">
                        <label class="small">Scheme Plan</label>
                        <input type="text" name="scheme_plan" class="form-control @error('scheme_plan') is-invalid @enderror"
                               value="{{ old('scheme_plan', $setting->scheme_plan) }}">
                        @error('scheme_plan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Scheme Name --}}
                    <div class="col-md-3">
                        <label class="small">Scheme Name</label>
                        {{-- एरर दिखाने के लिए @error का उपयोग किया गया है --}}
                        <select name="scheme_id" class="form-select @error('scheme_id') is-invalid @enderror">
                            <option value="">Select Scheme</option>
                            @foreach($schemes as $scheme)
                                <option value="{{ $scheme->id }}"
                                    {{ $scheme->id == old('scheme_id', $setting->scheme_id) ? 'selected' : '' }}>
                                    {{ $scheme->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('scheme_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Cash / Metal --}}
                    <div class="col-md-2">
                        <label class="small">Cash / Metal</label>
                        <input name="cash_metal" type="text" class="form-control @error('cash_metal') is-invalid @enderror"
                               value="{{ old('cash_metal', $setting->cash_metal) }}">
                        @error('cash_metal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- User Group --}}
                    <div class="col-md-2">
                        <label class="small">User Group</label>
                        <input name="user_group" type="text" class="form-control @error('user_group') is-invalid @enderror"
                               value="{{ old('user_group', $setting->user_group) }}">
                        @error('user_group') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- No Of Users --}}
                    <div class="col-md-1">
                        <label class="small">Users</label>
                        <input name="no_of_users" type="number" class="form-control @error('no_of_users') is-invalid @enderror"
                               value="{{ old('no_of_users', $setting->no_of_users) }}">
                        @error('no_of_users') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-1">
                        <label class="small">EMI Count</label>
                        <input name="no_of_emi" type="number" class="form-control @error('no_of_emi') is-invalid @enderror"
                               value="{{ old('no_of_emi', $setting->no_of_emi) }}">
                        @error('no_of_emi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>


                <h5 class="mt-4 mb-3 text-secondary">Financial & Token Settings</h5> {{-- नया उप-शीर्षक --}}
                <div class="row g-3">
                    <div class="col-md-2">
                        <label class="small">EMI Amount</label>
                        <input name="emi_amt" type="number" class="form-control @error('emi_amt') is-invalid @enderror"
                               value="{{ old('emi_amt', $setting->emi_amt) }}">
                        @error('emi_amt') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-2">
                        <label class="small">Bonus Amount</label>
                        <input name="bonus_amount" type="number" class="form-control @error('bonus_amount') is-invalid @enderror"
                               value="{{ old('bonus_amount', $setting->bonus_amount) }}">
                        @error('bonus_amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-2">
                        <label class="small">Interest Type</label>
                        <input name="interest_type" type="text" class="form-control @error('interest_type') is-invalid @enderror"
                               value="{{ old('interest_type', $setting->interest_type) }}">
                        @error('interest_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-2">
                        <label class="small">Start Token</label>
                        <input name="start_token_no" class="form-control @error('start_token_no') is-invalid @enderror"
                               value="{{ old('start_token_no', $setting->start_token_no) }}">
                        @error('start_token_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-2">
                        <label class="small">End Token</label>
                        <input name="end_token_no" class="form-control @error('end_token_no') is-invalid @enderror"
                               value="{{ old('end_token_no', $setting->end_token_no) }}">
                        @error('end_token_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>


                <h5 class="mt-4 mb-3 text-secondary">Fees and Discount Settings</h5> {{-- नया उप-शीर्षक --}}
                <div class="row g-3">
                    <div class="col-md-2">
                        <label class="small">EMI Late Fee %</label>
                        <input name="emi_late_fee" class="form-control @error('emi_late_fee') is-invalid @enderror"
                               value="{{ old('emi_late_fee', $setting->emi_late_fee) }}">
                        @error('emi_late_fee') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-2">
                        <label class="small">Late Fee Days</label>
                        <input name="late_fee_days" class="form-control @error('late_fee_days') is-invalid @enderror"
                               value="{{ old('late_fee_days', $setting->late_fee_days) }}">
                        @error('late_fee_days') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-2">
                        <label class="small">Gold Bonus %</label>
                        <input name="gold_bonus_percent" class="form-control @error('gold_bonus_percent') is-invalid @enderror"
                               value="{{ old('gold_bonus_percent', $setting->gold_bonus_percent) }}">
                        @error('gold_bonus_percent') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-2">
                        <label class="small">Diamond Bonus %</label>
                        <input name="diamond_bonus_percent" class="form-control @error('diamond_bonus_percent') is-invalid @enderror"
                               value="{{ old('diamond_bonus_percent', $setting->diamond_bonus_percent) }}">
                        @error('diamond_bonus_percent') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-2">
                        <label class="small">Gold Mkg Discount</label>
                        <input name="gold_mkg_discount" class="form-control @error('gold_mkg_discount') is-invalid @enderror"
                               value="{{ old('gold_mkg_discount', $setting->gold_mkg_discount) }}">
                        @error('gold_mkg_discount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-2">
                        <label class="small">Diamond Mkg Discount</label>
                        <input name="diamond_mkg_discount" class="form-control @error('diamond_mkg_discount') is-invalid @enderror"
                               value="{{ old('diamond_mkg_discount', $setting->diamond_mkg_discount) }}">
                        @error('diamond_mkg_discount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>


                {{-- Convert Bonus Checkbox --}}
                <div class="row mt-4">
                    <div class="col-md-3">
                        <div class="form-check pt-2"> {{-- टॉप पैडिंग जोड़ी --}}
                            <input type="checkbox" class="form-check-input"
                                   name="convert_bonus_to_gold"
                                   value="1"
                                   id="convertBonusCheck" {{-- ID जोड़ा --}}
                                   {{ $setting->convert_bonus_to_gold ? 'checked' : '' }}>
                            <label class="form-check-label small" for="convertBonusCheck">Convert Bonus to Gold</label>
                        </div>
                    </div>
                </div>

                <div class="card mt-4 border-info"> 
                    <div class="card-header bg-info text-white fw-bold"> 
                        <i class="bi bi-list-ol me-1"></i> EMI Rows
                        <button type="button" class="btn btn-dark btn-sm float-end" id="addEmiRow">
                            <i class="bi bi-plus-circle-fill me-1"></i> Add Row
                        </button>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover table-sm align-middle" id="emiTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>EMI No</th>
                                        <th>Discount%</th>
                                        <th>Bonus%</th>
                                        <th style="width: 100px;">Action</th> 
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($setting->emi_rows ?? [] as $i => $row)
                                    <tr>
                                        {{-- इनपुट में 'emi-row-input' क्लास जोड़ा ताकि CSS लागू हो सके --}}
                                        <td><input name="emi_rows[{{ $i }}][emi_no]" type="number" class="form-control"
                                                   value="{{ old("emi_rows.$i.emi_no", $row['emi_no'] ?? '') }}"></td>

                                        <td><input name="emi_rows[{{ $i }}][discount]" type="number" step="0.01" class="form-control"
                                                   value="{{ old("emi_rows.$i.discount", $row['discount'] ?? '') }}"></td>

                                        <td><input name="emi_rows[{{ $i }}][bonus]" type="number" step="0.01" class="form-control"
                                                   value="{{ old("emi_rows.$i.bonus", $row['bonus'] ?? '') }}"></td>

                                        <td>
                                            <button type="button" class="btn btn-outline-danger btn-sm remove-row" title="Remove Row">
                                                <i class="bi bi-x-circle"></i> {{-- आइकन बदला --}}
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>


                {{-- Submit Button --}}
                <div class="mt-4 border-top pt-3">
                    <button type="submit" class="btn btn-success btn-lg shadow-sm"> {{-- बटन को बड़ा और हरा किया --}}
                        <i class="bi bi-check-circle-fill me-2"></i> Update Scheme Settings
                    </button>
                    <a href="{{ route('admin.manage.settings') }}" class="btn btn-secondary btn-lg ms-2"> {{-- कैंसिल बटन --}}
                        <i class="bi bi-arrow-left-circle me-2"></i> Back
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

{{-- JavaScript --}}
<script>
    // Laravel के पुराने डेटा को ध्यान में रखते हुए, हम index को सही ढंग से सेट करते हैं
    let emiIndex = {{ count(old('emi_rows', $setting->emi_rows ?? [])) }};

    document.getElementById('addEmiRow').addEventListener('click', function() {
        let tbody = document.querySelector('#emiTable tbody');
        let newRow = tbody.insertRow(); // नया row इन्सर्ट करें

        // EMI No
        let cell1 = newRow.insertCell();
        cell1.innerHTML = `<input name="emi_rows[${emiIndex}][emi_no]" type="number" class="form-control" value="">`;

        // Discount
        let cell2 = newRow.insertCell();
        cell2.innerHTML = `<input name="emi_rows[${emiIndex}][discount]" type="number" step="0.01" class="form-control" value="">`;

        // Bonus
        let cell3 = newRow.insertCell();
        cell3.innerHTML = `<input name="emi_rows[${emiIndex}][bonus]" type="number" step="0.01" class="form-control" value="">`;

        // Action Button
        let cell4 = newRow.insertCell();
        cell4.innerHTML = `<button type="button" class="btn btn-outline-danger btn-sm remove-row" title="Remove Row"><i class="bi bi-x-circle"></i></button>`;
        cell4.style.width = '100px'; // एक्शन सेल की चौड़ाई सेट करें

        emiIndex++;
    });

    // रिमूव बटन पर क्लिक हैंडलर
    document.addEventListener('click', function(e){
        if (e.target.classList.contains('remove-row') || e.target.closest('.remove-row')) {
            e.target.closest('tr').remove();
        }
    });
</script>

@endsection