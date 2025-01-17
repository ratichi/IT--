<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Contract</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .form-container {
            max-width: 600px;
            margin: 50px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
            color: #343a40;
        }

        .form-label {
            font-weight: bold;
            color: #495057;
        }

        .form-select, .form-control {
            border-radius: 6px;
        }

        .form-button {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        .form-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2 class="form-title">ახალი ხელშეკრულების შექმნა</h2>

    <form action="{{ route('contracts.store') }}" method="POST">
        @csrf

        <!-- Contract Name -->
        <div class="mb-3">
            <label for="contract_name" class="form-label">ხელშეკრულების სახელი</label>
            <input type="text" class="form-control" id="contract_name" name="contract_name" required>
        </div>

        <!-- Type -->
        <div class="mb-3">
            <label for="type" class="form-label">კატეგორია</label>
            <select name="type" id="type" class="form-select" required>
                <option value="ფიზიკური">ფიზიკური</option>
                <option value="ციფრული">ციფრული</option>
            </select>
        </div>

        <!-- Quantity -->
        <div class="mb-3">
            <label for="quantity" class="form-label">რაოდენობა</label>
            <input type="number" class="form-control" id="quantity" name="quantity" required>
        </div>

        <!-- Agreement Number -->
        <div class="form-group mb-3">
            <label for="agreement_number">ხელშეკრულების ნომერი</label>
            <input type="text" id="agreement_number" name="agreement_number" class="form-control" oninput="formatAgreementNumber(this)" >
        </div>

        <script>
            function formatAgreementNumber(input) {

                let value = input.value.replace('/', ''); // Remove existing slash
                if (value.length > 2) {
                    input.value = value.slice(0, 2) + '/' + value.slice(2);
                }
            }
        </script>

        <!-- Contract Date -->
        <div class="mb-3">
            <label for="contract_date" class="form-label">ხელშეკრულების თარიღი</label>
            <input type="date" class="form-control" id="contract_date" name="contract_date" required>
        </div>

        <!-- Contract Term -->
        <div class="mb-3">
            <label for="contract_term" class="form-label">ხელშეკრულების ვადა</label>
            <input type="date" class="form-control" id="contract_term" name="contract_term" required>
        </div>

        <!-- Receive Term -->
        <div class="mb-3">
            <label for="recive_term" class="form-label">ჩაბარების ვადა</label>
            <input type="date" class="form-control" id="recive_term" name="recive_term" required>
        </div>

        <!-- Organization -->
        <div class="mb-3">
            <label for="organization" class="form-label">ორგანიზაცია</label>
            <input type="text" class="form-control" id="organization" name="organization" required>
        </div>

        <!-- Purpose -->
        <div class="mb-3">
            <label for="purpose" class="form-label">მიზანი</label>
            <input type="text" class="form-control" id="purpose" name="purpose" required>
        </div>

        <!-- Funding Code -->
        <div class="mb-3">
            <label for="funding_code" class="form-label">დაფინასების კოდი</label>
            <input type="text" class="form-control" id="funding_code" name="funding_code" required>
        </div>

        <!-- Letter Initiator -->
        <div class="mb-3">
            <label for="letter_initiator" class="form-label">წერილის ინიციატორი</label>
            <input type="text" class="form-control" id="letter_initiator" name="letter_initiator" required>
        </div>
        <div class="form-group mb-3">
            <label for="guarantee_time">გარანტიის ვადა (ფორმატში: წელი/თვე):</label>
            <input 
                type="text" 
                id="guarantee_time" 
                name="guarantee_time" 
                class="form-control" 
                placeholder="2025/12" 
                required 
                pattern="\d{4}/\d{2}" 
                title="Enter in the format YYYY/MM"
            >
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" value="1" id="secret" name="secret">
            <label class="form-check-label" for="secret">
                საიდუმლო
            </label>
        </div>

        <!-- Submit Button -->
        <div class="text-center">
            <button type="submit" class="form-button">შექმნა</button>
        </div>
    </form>
</div>

</body>
</html>
