<?php
include "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
    $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $contactNumber = filter_input(INPUT_POST, 'contactNumber', FILTER_SANITIZE_STRING);
    $country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING);
    $state = filter_input(INPUT_POST, 'state', FILTER_SANITIZE_STRING);
    $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
    $lotBlk = filter_input(INPUT_POST, 'lotBlk', FILTER_SANITIZE_STRING);
    $street = filter_input(INPUT_POST, 'street', FILTER_SANITIZE_STRING);
    $phaseSubdivision = filter_input(INPUT_POST, 'phaseSubdivision', FILTER_SANITIZE_STRING);
    $barangay = filter_input(INPUT_POST, 'barangay', FILTER_SANITIZE_STRING);

    // Check if all fields are filled and passwords match
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($contactNumber) || empty($country) || empty($state) || empty($city) || empty($lotBlk) || empty($street) || empty($phaseSubdivision) || empty($barangay)) {
        echo "All fields are required.";
        exit;
    } elseif ($_POST['password'] !== $_POST['repeatPassword']) {
        echo "Passwords do not match.";
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO tbl_users (first_name, last_name, email, password, contact_number, country, state, city, lot_blk, street, phase_subdivision, barangay) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssssssssss", $firstName, $lastName, $email, $hashedPassword, $contactNumber, $country, $state, $city, $lotBlk, $street, $phaseSubdivision, $barangay);

    if ($stmt->execute()) {
        echo "New record created successfully. <br>";
        echo '<a href="javascript:history.go(-1)">Go Back</a>'; // Go back button
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>

    <!-- Navigation bar -->
    <nav>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="feedbacks.php">Feedbacks</a></li>
        </ul>
    </nav>
        <div class="feedbacks-container">
            <div class="transparent-box">
                <div class="container">
                    <form id="registrationForm" action="" method="post">
                        <h2>Registration</h2>
                        <h3>Full Name</h3>
                        <div class="form-group">
                            <label for="lastName">Last Name</label>
                            <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Enter Last Name" required>
                        </div>
                        <div class="form-group">
                            <label for="firstName">First Name</label>
                            <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Enter First Name" required>
                        </div>

                        <h3>Address</h3>
                        <div class="form-group">
                            <label for="country">Country</label>
                            <select class="form-control" id="country" name="country" required>
                                <option selected>Choose...</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="state">State/Province</label>
                            <select class="form-control" id="state" name="state" required>
                                <option selected>Choose...</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="city">City/Municipality</label>
                            <select class="form-control" id="city" name="city" required>
                                <option selected>Choose...</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="lotBlk">Lot/Block</label>
                            <input type="text" class="form-control" id="lotBlk" name="lotBlk" placeholder="Enter Lot/Block" required>
                        </div>
                        <div class="form-group">
                            <label for="street">Street</label>
                            <input type="text" class="form-control" id="street" name="street" placeholder="Enter Street" required>
                        </div>
                        <div class="form-group">
                            <label for="phaseSubdivision">Phase/Subdivision</label>
                            <input type="text" class="form-control" id="phaseSubdivision" name="phaseSubdivision" placeholder="Enter Phase/Subdivision" required>
                        </div>
                        <div class="form-group">
                            <label for="barangay">Barangay</label>
                            <input type="text" class="form-control" id="barangay" name="barangay" placeholder="Enter Barangay" required>
                        </div>
                        <div class="form-group">
                            <label for="contactNumber">Contact Number</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="phoneCode" readonly>
                                <input type="text" class="form-control" id="contactNumber" name="contactNumber" placeholder="Enter Contact Number">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="repeatPassword" name="repeatPassword" placeholder="Repeat Password" required>
                            <p id="passwordError" style="color: red;"></p>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                </div>
            </div>
        </div>



<script>

let data = [];

document.addEventListener('DOMContentLoaded', function() {
    fetch('https://raw.githubusercontent.com/dr5hn/countries-states-cities-database/master/countries%2Bstates%2Bcities.json')
        .then(response => response.json())
        .then(jsonData => {
            data = jsonData;
            const countries = data.map(country => country.name);
            populateDropdown('country', countries);
        })
        .catch(error => console.error('Error fetching countries:', error));
});

function populateDropdown(dropdownId, data) {
    const dropdown = document.getElementById(dropdownId);
    dropdown.innerHTML = '';
    data.forEach(item => {
        const option = document.createElement('option');
        option.value = item;
        option.text = item;
        dropdown.add(option);
    });
}

document.getElementById('country').addEventListener('change', function() {
    const selectedCountry = this.value;
    const countryData = data.find(country => country.name === selectedCountry);
    if (countryData && countryData.states) {
        const states = countryData.states.map(state => state.name);
        populateDropdown('state', states);
    }
    const phoneCode = countryData ? countryData.phone_code : '';
    document.getElementById('phoneCode').value = phoneCode;
});

document.getElementById('state').addEventListener('change', function() {
    const selectedState = this.value;
    const countryData = data.find(country => country.name === document.getElementById('country').value);
    if (countryData) {
        const stateData = countryData.states.find(state => state.name === selectedState);
        if (stateData && stateData.cities) {
            const cities = stateData.cities.map(city => city.name);
            populateDropdown('city', cities);
        } else {
            console.log('No cities found for state:', selectedState);
        }
    } else {
        console.log('Country data not found for state:', selectedState);
    }
});

// Function to check if passwords match
function checkPasswords() {
    const password = document.getElementById('password').value;
    const repeatPassword = document.getElementById('repeatPassword').value;

    // Check if passwords match
    if (password !== repeatPassword) {
        // Display error message
        document.getElementById('passwordError').innerText = "Passwords do not match";
        return false; // Prevent form submission
    } else {
        // Clear error message
        document.getElementById('passwordError').innerText = "";
        return true; // Allow form submission
    }
}

// Event listener for form submission
document.getElementById('registrationForm').addEventListener('submit', function(event) {
    // Check passwords before submitting the form
    if (!checkPasswords()) {
        event.preventDefault(); // Prevent form submission if passwords don't match
    }
});

</script>

</body>
</html>
