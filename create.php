<?php
require_once "./config.php";

$errors = [];
$fields = [
    'fname' => '', 'lname' => '', 'email' => '', 
    'age' => '', 'gender' => '', 'designation' => '', 'date' => ''
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $fields['fname'] = trim($_POST["fname"] ?? '');
    $fields['lname'] = trim($_POST["lname"] ?? '');
    $fields['email'] = filter_var($_POST["email"] ?? '', FILTER_SANITIZE_EMAIL);
    $fields['age'] = trim($_POST["age"] ?? '');
    $fields['gender'] = $_POST["gender"] ?? '';
    $fields['designation'] = $_POST["designation"] ?? '';
    $fields['date'] = $_POST["date"] ?? '';

    // Validation
    if (empty($fields['fname'])) $errors['fname'] = "First name is required";
    elseif (!ctype_alpha($fields['fname'])) $errors['fname'] = "Only letters allowed";
    
    if (empty($fields['lname'])) $errors['lname'] = "Last name is required";
    elseif (!ctype_alpha($fields['lname'])) $errors['lname'] = "Only letters allowed";
    
    if (empty($fields['email'])) $errors['email'] = "Email is required";
    elseif (!filter_var($fields['email'], FILTER_VALIDATE_EMAIL)) $errors['email'] = "Invalid email format";
    
    if (empty($fields['age'])) $errors['age'] = "Age is required";
    elseif (!ctype_digit($fields['age'])) $errors['age'] = "Age must be a number";
    elseif ($fields['age'] < 18 || $fields['age'] > 65) $errors['age'] = "Age must be between 18-65";
    
    if (empty($fields['gender'])) $errors['gender'] = "Gender is required";
    if (empty($fields['designation'])) $errors['designation'] = "Designation is required";
    if (empty($fields['date'])) $errors['date'] = "Joining date is required";
    elseif (strtotime($fields['date']) > time()) $errors['date'] = "Joining date cannot be in the future";

    // If no errors, insert into database
    if (empty($errors)) {
        $sql = "INSERT INTO employees (first_name, last_name, email, age, gender, designation, joining_date) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "sssisss", 
                $fields['fname'], $fields['lname'], $fields['email'], 
                $fields['age'], $fields['gender'], $fields['designation'], $fields['date']);
            
            if (mysqli_stmt_execute($stmt)) {
                header("Location: index.php?success=Employee+added+successfully");
                exit;
            } else {
                $errors['database'] = "Error: " . mysqli_error($link);
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Employee</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    :root {
      --primary: #4361ee;
      --secondary: #3f37c9;
      --light: #f8f9fa;
      --dark: #212529;
    }
    <?php
require_once "./config.php";

$errors = [];
$fields = [
    'fname' => '', 'lname' => '', 'email' => '', 
    'age' => '', 'gender' => '', 'designation' => '', 'date' => ''
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $fields['fname'] = trim($_POST["fname"] ?? '');
    $fields['lname'] = trim($_POST["lname"] ?? '');
    $fields['email'] = filter_var($_POST["email"] ?? '', FILTER_SANITIZE_EMAIL);
    $fields['age'] = trim($_POST["age"] ?? '');
    $fields['gender'] = $_POST["gender"] ?? '';
    $fields['designation'] = $_POST["designation"] ?? '';
    $fields['date'] = $_POST["date"] ?? '';

    // Validation
    if (empty($fields['fname'])) $errors['fname'] = "First name is required";
    elseif (!ctype_alpha($fields['fname'])) $errors['fname'] = "Only letters allowed";
    
    if (empty($fields['lname'])) $errors['lname'] = "Last name is required";
    elseif (!ctype_alpha($fields['lname'])) $errors['lname'] = "Only letters allowed";
    
    if (empty($fields['email'])) $errors['email'] = "Email is required";
    elseif (!filter_var($fields['email'], FILTER_VALIDATE_EMAIL)) $errors['email'] = "Invalid email format";
    
    if (empty($fields['age'])) $errors['age'] = "Age is required";
    elseif (!ctype_digit($fields['age'])) $errors['age'] = "Age must be a number";
    elseif ($fields['age'] < 18 || $fields['age'] > 65) $errors['age'] = "Age must be between 18-65";
    
    if (empty($fields['gender'])) $errors['gender'] = "Gender is required";
    if (empty($fields['designation'])) $errors['designation'] = "Designation is required";
    if (empty($fields['date'])) $errors['date'] = "Joining date is required";
    elseif (strtotime($fields['date']) > time()) $errors['date'] = "Joining date cannot be in the future";

    // If no errors, insert into database
    if (empty($errors)) {
        $sql = "INSERT INTO employees (first_name, last_name, email, age, gender, designation, joining_date) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "sssisss", 
                $fields['fname'], $fields['lname'], $fields['email'], 
                $fields['age'], $fields['gender'], $fields['designation'], $fields['date']);
            
            if (mysqli_stmt_execute($stmt)) {
                header("Location: index.php?success=Employee+added+successfully");
                exit;
            } else {
                $errors['database'] = "Error: " . mysqli_error($link);
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Employee</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    :root {
      --primary: #4361ee;
      --secondary: #3f37c9;
      --light: #f8f9fa;
      --dark: #212529;
    }
    
    body {
      background-color: #f5f7fa;
    }
    
    .form-container {
      max-width: 700px;
      margin: 0 auto;
      background: white;
      border-radius: 10px;
      box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }
    
    .form-header {
      background-color: var(--primary);
      color: white;
      padding: 20px;
    }
    
    .form-body {
      padding: 30px;
    }
    
    .form-control, .form-select {
      border-radius: 8px;
      padding: 12px 15px;
      border: 1px solid #e0e0e0;
    }
    
    .form-control:focus, .form-select:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
    }
    
    .btn-submit {
      background-color: var(--primary);
      border: none;
      padding: 12px 25px;
      font-weight: 500;
      border-radius: 8px;
      transition: all 0.3s ease;
    }
    
    .btn-submit:hover {
      background-color: var(--secondary);
      transform: translateY(-2px);
    }
    
    .animate-in {
      animation: fadeInUp 0.5s ease-out;
    }
    
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    .error-message {
      font-size: 0.85rem;
      color: #dc3545;
      margin-top: 5px;
    }
    
    .back-link {
      color: var(--primary);
      text-decoration: none;
      transition: color 0.2s ease;
    }
    
    .back-link:hover {
      color: var(--secondary);
    }
  </style>
</head>

<body>
  <div class="container py-5">
    <div class="form-container animate__animated animate__fadeIn">
      <div class="form-header">
        <h3 class="mb-0"><i class="bi bi-person-plus me-2"></i> Add New Employee</h3>
      </div>
      <div class="form-body">
        <?php if (!empty($errors['database'])): ?>
          <div class="alert alert-danger"><?= $errors['database'] ?></div>
        <?php endif; ?>
        
        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
          <div class="row g-3">
            <div class="col-md-6 animate-in">
              <label for="fname" class="form-label">First Name</label>
              <input type="text" class="form-control <?= !empty($errors['fname']) ? 'is-invalid' : '' ?>" 
                     id="fname" name="fname" value="<?= htmlspecialchars($fields['fname']) ?>">
              <?php if (!empty($errors['fname'])): ?>
                <div class="error-message"><?= $errors['fname'] ?></div>
              <?php endif; ?>
            </div>
            
            <div class="col-md-6 animate-in">
              <label for="lname" class="form-label">Last Name</label>
              <input type="text" class="form-control <?= !empty($errors['lname']) ? 'is-invalid' : '' ?>" 
                     id="lname" name="lname" value="<?= htmlspecialchars($fields['lname']) ?>">
              <?php if (!empty($errors['lname'])): ?>
                <div class="error-message"><?= $errors['lname'] ?></div>
              <?php endif; ?>
            </div>
            
            <div class="col-12 animate-in">
              <label for="email" class="form-label">Email Address</label>
              <input type="email" class="form-control <?= !empty($errors['email']) ? 'is-invalid' : '' ?>" 
                     id="email" name="email" value="<?= htmlspecialchars($fields['email']) ?>">
              <?php if (!empty($errors['email'])): ?>
                <div class="error-message"><?= $errors['email'] ?></div>
              <?php endif; ?>
            </div>
            
            <div class="col-md-6 animate-in">
              <label for="age" class="form-label">Age</label>
              <input type="number" class="form-control <?= !empty($errors['age']) ? 'is-invalid' : '' ?>" 
                     id="age" name="age" min="18" max="65" value="<?= htmlspecialchars($fields['age']) ?>">
              <?php if (!empty($errors['age'])): ?>
                <div class="error-message"><?= $errors['age'] ?></div>
              <?php endif; ?>
            </div>
            
            <div class="col-md-6 animate-in">
              <label for="gender" class="form-label">Gender</label>
              <select class="form-select <?= !empty($errors['gender']) ? 'is-invalid' : '' ?>" id="gender" name="gender">
                <option value="" disabled selected>Select Gender</option>
                <option value="Male" <?= $fields['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
                <option value="Female" <?= $fields['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
                <option value="Other" <?= $fields['gender'] === 'Other' ? 'selected' : '' ?>>Other</option>
              </select>
              <?php if (!empty($errors['gender'])): ?>
                <div class="error-message"><?= $errors['gender'] ?></div>
              <?php endif; ?>
            </div>
            
            <div class="col-md-6 animate-in">
              <label for="designation" class="form-label">Designation</label>
              <select class="form-select <?= !empty($errors['designation']) ? 'is-invalid' : '' ?>" id="designation" name="designation">
                <option value="" disabled selected>Select Designation</option>
                <option value="UI Designer" <?= $fields['designation'] === 'UI Designer' ? 'selected' : '' ?>>UI Designer</option>
                <option value="Frontend Developer" <?= $fields['designation'] === 'Frontend Developer' ? 'selected' : '' ?>>Frontend Developer</option>
                <option value="PHP Developer" <?= $fields['designation'] === 'PHP Developer' ? 'selected' : '' ?>>PHP Developer</option>
                <option value="Android Developer" <?= $fields['designation'] === 'Android Developer' ? 'selected' : '' ?>>Android Developer</option>
              </select>
              <?php if (!empty($errors['designation'])): ?>
                <div class="error-message"><?= $errors['designation'] ?></div>
              <?php endif; ?>
            </div>
            
            <div class="col-md-6 animate-in">
              <label for="date" class="form-label">Joining Date</label>
              <input type="date" class="form-control <?= !empty($errors['date']) ? 'is-invalid' : '' ?>" 
                     id="date" name="date" value="<?= htmlspecialchars($fields['date']) ?>">
              <?php if (!empty($errors['date'])): ?>
                <div class="error-message"><?= $errors['date'] ?></div>
              <?php endif; ?>
            </div>
            
            <div class="col-12 mt-4 animate-in">
              <button type="submit" class="btn btn-primary btn-submit">
                <i class="bi bi-save me-2"></i> Save Employee
              </button>
              <a href="index.php" class="back-link ms-3">
                <i class="bi bi-arrow-left me-1"></i> Back to list
              </a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Add animation delay to form elements
    document.querySelectorAll('.animate-in').forEach((el, index) => {
      el.style.animationDelay = `${index * 0.1}s`;
    });
    
    // Set max date to today for joining date
    document.getElementById('date').max = new Date().toISOString().split('T')[0];
  </script>
</body>
</html>
   