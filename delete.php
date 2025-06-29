<?php
require_once "./config.php";

if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $id = (int)trim($_GET["id"]);
    
    // First get the employee details for the confirmation message
    $sql = "SELECT first_name, last_name FROM employees WHERE id = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) == 1) {
                $employee = mysqli_fetch_assoc($result);
                $employeeName = $employee['first_name'] . ' ' . $employee['last_name'];
            }
        }
        mysqli_stmt_close($stmt);
    }
    
    // If confirmed, delete the record
    if (isset($_GET['confirm']) && $_GET['confirm'] == 'true') {
        $sql = "DELETE FROM employees WHERE id = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $id);
            
            if (mysqli_stmt_execute($stmt)) {
                header("Location: index.php?success=Employee+deleted+successfully");
                exit;
            } else {
                echo "<script>alert('Oops! Something went wrong. Please try again later.'); window.location.href='index.php';</script>";
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        // Show confirmation page
        ?>
        <!DOCTYPE html>
        <html lang="en">
        
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Confirm Delete</title>
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
          <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
          <style>
            :root {
              --primary: #4361ee;
              --danger: #dc3545;
              --light: #f8f9fa;
              --dark: #212529;
            }
            
            body {
              background-color: #f5f7fa;
              font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }
            
            .confirmation-card {
              max-width: 500px;
              margin: 0 auto;
              background: white;
              border-radius: 10px;
              box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
              overflow: hidden;
              animation: fadeInUp 0.5s ease-out;
            }
            
            .confirmation-header {
              background-color: var(--danger);
              color: white;
              padding: 20px;
              text-align: center;
            }
            
            .confirmation-body {
              padding: 30px;
              text-align: center;
            }
            
            .warning-icon {
              font-size: 4rem;
              color: var(--danger);
              margin-bottom: 20px;
            }
            
            .btn-danger {
              background-color: var(--danger);
              border: none;
              padding: 10px 25px;
              font-weight: 500;
              border-radius: 8px;
              transition: all 0.3s ease;
            }
            
            .btn-danger:hover {
              background-color: #bb2d3b;
              transform: translateY(-2px);
            }
            
            .btn-outline-secondary {
              border-radius: 8px;
              padding: 10px 25px;
              transition: all 0.3s ease;
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
          </style>
        </head>
        
        <body>
          <div class="container py-5">
            <div class="confirmation-card">
              <div class="confirmation-header">
                <h4 class="mb-0"><i class="bi bi-exclamation-triangle me-2"></i> Confirm Deletion</h4>
              </div>
              <div class="confirmation-body">
                <div class="warning-icon">
                  <i class="bi bi-exclamation-octagon"></i>
                </div>
                <h5 class="mb-4">Are you sure you want to delete this employee?</h5>
                <p class="mb-4"><strong><?= htmlspecialchars($employeeName) ?></strong> will be permanently removed from the system.</p>
                
                <div class="d-flex justify-content-center gap-3">
                  <a href="delete.php?id=<?= $id ?>&confirm=true" class="btn btn-danger">
                    <i class="bi bi-trash-fill me-2"></i> Yes, Delete
                  </a>
                  <a href="index.php" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle me-2"></i> Cancel
                  </a>
                </div>
              </div>
            </div>
          </div>
        
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        </body>
        </html>
        <?php
        exit;
    }
    mysqli_close($link);
} else {
    header("Location: index.php");
    exit;
}
?>