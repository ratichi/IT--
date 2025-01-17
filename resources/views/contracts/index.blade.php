<!-- contracts/index.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Contracts List</title>
</head>
<style>
    .small-font {
        font-size: 9px; /* Adjust this value as needed */
    }
    .big-font {
        font-size: 19px; /* Adjust this value as needed */
    }
</style>
<body>
<div class=" mt-5">
    <h1 class="mb-4"></h1>

    <!-- Button to redirect to the Create Contract form -->
    <a href="{{ route('contracts.create') }}" class="btn btn-primary mb-4">ახალი ხელშეკრულების დამატება</a>

    <!-- Display success message if a contract is created -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="GET" action="{{ route('contracts.index') }}" class="mb-4">
    <div style="display: flex; flex-wrap: wrap; gap: 1rem;">
        <!-- Type Dropdown -->
        <div>
            <label for="type">კატეგორია</label>
            <select name="type" id="type" class="form-control">
                <option value="">ყველა</option>
                <option value="ციფრული" {{ request('type') == 'ციფრული' ? 'selected' : '' }}>ციფრული</option>
                <option value="ფიზიკური" {{ request('type') == 'ფიზიკური' ? 'selected' : '' }}>ფიზიკური</option>
            </select>
        </div>

        <!-- Secret Checkbox -->
        <div>
            <label for="secret" style="display: block;">საიდუმლო</label>
            <input type="checkbox" name="secret" id="secret" value="1" {{ request('secret') == '1' ? 'checked' : '' }}>
        </div>

        <!-- Status Input -->
        <div>
            <label for="status">სტატუსი</label>
            <select name="status" id="status" class="form-control">
                <option value="">ყველა</option>
                <option value="მიმდინარე" {{ request('status') == 'მიმდინარე' ? 'selected' : '' }}>მიმდინარე</option>
                <option value="ჩაბარებული" {{ request('status') == 'ჩაბარებული' ? 'selected' : '' }}>ჩაბარებული</option>
            </select>
        </div>

        <!-- Agreement Number Input -->
        <div>
            <label for="agreement_number">ხელშეკრულების ნომერი</label>
            <input type="text" name="agreement_number" id="agreement_number" class="form-control" value="{{ request('agreement_number') }}">
        </div>

        <!-- Contract Date Input -->
        <div>
            <label for="contract_date">ხელშეკრულების თარიღი</label>
            <input type="date" name="contract_date" id="contract_date" class="form-control" value="{{ request('contract_date') }}">
        </div>

        <!-- Funding Code Input -->
        <div>
            <label for="funding_code">დაფინასების კოდი</label>
            <input type="text" name="funding_code" id="funding_code" class="form-control" value="{{ request('funding_code') }}">
        </div>

        <!-- Submit Button -->
        <div style="align-self: flex-end;">
            <button type="submit" class="btn btn-primary">ძებნა</button>
            <a href="{{ route('contracts.index') }}" class="btn btn-secondary">Reset</a>
        </div>
    </div>
</form>

    <!-- Contracts Table -->
    <table class="table table-bordered small-font">
    <thead>
        <tr>
            <th>#</th>
            <th>კატეგორია</th>
            <th>ხელშეკრულების სახელი</th>
            <th>ორგანიზაცია</th>
            <th>რაოდენობა</th>
            <th>ხელშეკრულების ნომერი</th>
            <th>ხელშეკრულების თარიღი</th>
            <th>ხელშეკრულების ვადა</th>
            <th>მოწოდების ვადა</th>
            <th>მიზანი</th>
            <th>დაფინასების კოდი</th>
            <th>გარანტიის ვადა</th>
            <th>წერილის ინიციატორი</th>
            <th>სტატუსი</th>
            <th>შესაბამისობის აქტები</th>
            <th>აქტის დამატება / სტატუსის შეცვლა</th>
        </tr>
    </thead>
    <tbody>
        @foreach($contracts as $contract)
            <tr>
                <td>{{ $contract->id }}</td>
                <td>{{ $contract->type }}</td>
                <td>{{ $contract->contract_name }}</td>
                <td>{{ $contract->organization }}</td>
                <td>{{ $contract->quantityRatio() }}</td>
                <td>{{ $contract->agreement_number }}</td>
                <td>{{ $contract->contract_date }}</td>
                <td>{{ $contract->contract_term }}</td>
                <td>{{ $contract->remaining_receiving_term }}</td>
                <td>{{ $contract->purpose }}</td>
                <td>{{ $contract->funding_code }}</td>
                <td>{{ $contract->remaining_time }}</td>
                <td>{{ $contract->letter_initiator }}</td>
                <td>{{ $contract->status }}</td>
                <td><a href="{{ route('contracts.acts.index', $contract->id) }}" class="btn btn-warning btn-sm small-font">აქტების ნახვა</a></td>
                <td style="display:flex; text-align:center; gap:10px; width:150px;" >
                    <a href="{{ route('contracts.edit', $contract->id) }}" class="btn btn-warning btn-sm small-font"  style="height:30px">ედიტი</a>
                    <a href="{{ route('acts.create', ['contract' => $contract->id]) }}" class="btn btn-primary btn-sm small-font">აქტის დამატება</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

</div>

</body>
</html>
