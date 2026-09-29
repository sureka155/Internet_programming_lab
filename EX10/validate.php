<?php
// Check whether the form was submitted using POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get and trim values from the form
    $username   = trim($_POST["username"] ?? "");
    $password   = $_POST["password"] ?? "";
    $name       = trim($_POST["name"] ?? "");
    $email      = trim($_POST["email"] ?? "");
    $phone      = trim($_POST["phone"] ?? "");
    $jobTitle   = trim($_POST["jobTitle"] ?? "");
    $experience = trim($_POST["experience"] ?? "");
    $skills     = trim($_POST["skills"] ?? "");
    $card       = trim($_POST["card"] ?? "");

    // Array to store errors
    $errors = array();

    /*
     * 1. EMPTY / REQUIRED FIELDS VALIDATION
     */
    $requiredFields = [
        'username'  => 'User Name',
        'password'  => 'Password',
        'name'      => 'Full Name',
        'email'     => 'Email Address',
        'phone'     => 'Phone Number',
        'jobTitle'  => 'Applying for Position',
        'experience'=> 'Years of Experience',
        'skills'    => 'Key Skills',
        'card'      => 'Credit Card Number'
    ];

    foreach ($requiredFields as $field => $label) {
        if (!isset($$field) || trim($$field) === '') {
            $errors[] = "$label is a required field.";
        }
    }

    /*
     * 2. DATA TYPE & CONTENT VALIDATION
     */
    
    // Username validation: Letters, numbers, and underscores only, 3-20 chars
    if (!empty($username) && !preg_match("/^[a-zA-Z0-9_]{3,20}$/", $username)) {
        $errors[] = "Username must be between 3 and 20 characters and contain only letters, numbers, or underscores.";
    }

    // Password: At least 8 characters, 1 uppercase, 1 lowercase, 1 number, 1 special character
    $passwordRegex = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[^A-Za-z0-9]).{8,}$/";
    if (!empty($password) && !preg_match($passwordRegex, $password)) {
        $errors[] = "Password must contain at least 8 characters, one uppercase letter, one lowercase letter, one number, and one special character.";
    }

    // Full Name: Letters and spaces only (2-50 characters)
    if (!empty($name) && !preg_match("/^[a-zA-Z\s']{2,50}$/", $name)) {
        $errors[] = "Full Name must contain only letters and spaces (2-50 characters).";
    }

    // Email: PHP Native Validation
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }

    // Phone: Strictly exactly 10 digits only
    if (!empty($phone) && !preg_match("/^[0-9]{10}$/", $phone)) {
        $errors[] = "Phone number must contain exactly 10 digits.";
    }

    // Job Title Dropdown Whitelist Validation
    $allowedRoles = ["Software Engineer", "Data Analyst", "UI/UX Designer", "Project Manager"];
    if (!empty($jobTitle) && !in_array($jobTitle, $allowedRoles)) {
        $errors[] = "Please select a valid job position from the list.";
    }

    // Experience: Strict numeric range validation (0 to 40)
    if ($experience !== '') {
        if (!is_numeric($experience)) {
            $errors[] = "Years of Experience must be a number.";
        } else {
            $expInt = (int)$experience;
            if ($expInt < 0 || $expInt > 40) {
                $errors[] = "Years of Experience must be between 0 and 40.";
            }
        }
    }

    // Key Skills: Min length validation
    if (!empty($skills) && strlen($skills) < 3) {
        $errors[] = "Please list at least some valid key skills.";
    }

    /*
     * 3. CREDIT CARD STRICT 16-DIGIT VALIDATION
     */
    if (!empty($card)) {
        $cleanCard = str_replace([' ', '-'], '', $card);
        if (!preg_match("/^[0-9]{16}$/", $cleanCard)) {
            $errors[] = "Credit card number must contain exactly 16 digits.";
        }
    }

    /*
     * 4. DISPLAY RESULT
     */
    if (count($errors) > 0) {
        // Validation failed page
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head>";
        echo "<meta charset='UTF-8'>";
        echo "<title>Registration Error</title>";
        echo "<style>";
        echo "body { font-family: Arial, sans-serif; background-color: #f4f7f6; }";
        echo ".container { width: 500px; margin: 50px auto; padding: 30px; background-color: white; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }";
        echo "h2 { color: red; }";
        echo "li { margin: 10px 0; color: #cc0000; font-size: 14px; }";
        echo "a { display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #0275d8; color: white; text-decoration: none; border-radius: 5px; }";
        echo "</style>";
        echo "</head>";
        echo "<body>";
        echo "<div class='container'>";
        echo "<h2>Registration Failed</h2>";
        echo "<p>Please correct the following errors:</p>";
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li>" . htmlspecialchars($error) . "</li>";
        }
        echo "</ul>";
        echo "<a href='registration.html'>Go Back</a>";
        echo "</div>";
        echo "</body>";
        echo "</html>";
    } else {
        // Validation successful page
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head>";
        echo "<meta charset='UTF-8'>";
        echo "<title>Registration Successful</title>";
        echo "<style>";
        echo "body { font-family: Arial, sans-serif; background-color: #f4f7f6; }";
        echo ".container { width: 500px; margin: 50px auto; padding: 30px; background-color: white; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }";
        echo "h2 { color: green; text-align: center; }";
        echo "p { padding: 5px; }";
        echo ".success { color: green; font-weight: bold; text-align: center; }";
        echo "</style>";
        echo "</head>";
        echo "<body>";
        echo "<div class='container'>";
        echo "<h2>Registration Successful!</h2>";
        echo "<p class='success'> All fields passed server-side validation. </p>";
        echo "<hr>";
        echo "<p><strong>Username:</strong> " . htmlspecialchars($username) . "</p>";
        echo "<p><strong>Full Name:</strong> " . htmlspecialchars($name) . "</p>";
        echo "<p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>";
        echo "<p><strong>Phone:</strong> " . htmlspecialchars($phone) . "</p>";
        echo "<p><strong>Job Position:</strong> " . htmlspecialchars($jobTitle) . "</p>";
        echo "<p><strong>Experience:</strong> " . htmlspecialchars($experience) . " years</p>";
        echo "<p><strong>Skills:</strong> " . htmlspecialchars($skills) . "</p>";
        echo "<p><strong>Credit Card:</strong> ************" . substr($cleanCard, -4) . "</p>"; 
        echo "</div>";
        echo "</body>";
        echo "</html>";
    }
} else {
    echo "Invalid request method.";
}
?>
