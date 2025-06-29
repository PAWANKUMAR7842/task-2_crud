<?php
require_once "./config.php";

$sql = "SELECT * FROM employees ORDER BY joining_date DESC";
$result = mysqli_query($link, $sql);
$employees = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result);
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employee Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <style>
    :root {
      --primary: #4361ee;
      --secondary: #3f37c9;
      --accent: #4895ef;
      --light: #f8f9fa;
      --dark: #212529;
    }
    
    body {
      background-color: #f5f7fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .navbar-brand {
      font-weight: 600;
      color: var(--primary);
    }
    
    .card {
      border: none;
      border-radius: 10px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    
    .table-responsive {
      border-radius: 10px;
      overflow: hidden;
    }
    
    .table {
      margin-bottom: 0;
    }
    
    .table th {
      background-color: var(--primary);
      color: white;
      font-weight: 500;
    }
    
    .action-btn {
      width: 35px;
      height: 35px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      transition: all 0.2s ease;
    }
    
    .action-btn:hover {
      transform: scale(1.1);
    }
    
    .badge {
      font-weight: 500;
      padding: 5px 10px;
    }
    
    .empty-state {
      height: 300px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }
    
    .fade-in {
      animation: fadeIn 0.5s ease-in;
    }
    
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .search-box {
      position: relative;
      max-width: 300px;
    }
    
    .search-box i {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #6c757d;
    }
    
    .search-box input {
      padding-left: 40px;
      border-radius: 50px;
      border: 1px solid #dee2e6;
    }
    
    .toast {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 1000;
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
      <a class="navbar-brand" href="#">
        <i class="bi bi-people-fill me-2"></i>Employee Manager
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a href="./create.php" class="btn btn-primary btn-sm ms-2">
              <i class="bi bi-plus-circle me-1"></i> Add Employee
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container py-5">
    <div class="row mb-4">
      <div class="col-md-6">
        <h3 class="fw-bold">Employee Directory</h3>
        <p class="text-muted">Manage your organization's employees</p>
      </div>
      <div class="col-md-6">
        <div class="search-box ms-md-auto">
          <i class="bi bi-search"></i>
          <input type="text" id="searchInput" class="form-control" placeholder="Search employees...">
        </div>
      </div>
    </div>

    <div class="card animate__animated animate__fadeIn">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead>
              <tr>
                <th>Employee</th>
                <th>Contact</th>
                <th>Details</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="employeeTable">
              <?php if (count($employees) > 0): ?>
                <?php foreach ($employees as $employee): ?>
                  <tr class="fade-in">
                    <td>
                      <div class="d-flex align-items-center">
                        <div class="symbol symbol-45px symbol-circle me-3">
                          <span class="symbol-label bg-light-primary text-primary fs-4 fw-bold">
                            <?= strtoupper(substr($employee['first_name'], 0, 1)) . substr($employee['last_name'], 0, 1) ?>
                          </span>
                        </div>
                        <div>
                          <div class="fw-bold"><?= $employee['first_name'] . ' ' . $employee['last_name'] ?></div>
                          <div class="text-muted small"><?= $employee['designation'] ?></div>
                        </div>
                      </div>
                    </td>
                    <td>
                      <div><?= $employee['email'] ?></div>
                      <div class="text-muted small">Joined <?= date('M d, Y', strtotime($employee['joining_date'])) ?></div>
                    </td>
                    <td>
                      <div class="d-flex gap-2">
                        <span class="badge bg-light-primary">Age: <?= $employee['age'] ?></span>
                        <span class="badge bg-light-secondary"><?= $employee['gender'] ?></span>
                      </div>
                    </td>
                    <td>
                      <div class="d-flex gap-2">
                        <a href="./update.php?id=<?= $employee['id'] ?>" class="action-btn btn btn-sm btn-primary" title="Edit">
                          <i class="bi bi-pencil"></i>
                        </a>
                        <a href="./delete.php?id=<?= $employee['id'] ?>" class="action-btn btn btn-sm btn-danger delete-btn" title="Delete">
                          <i class="bi bi-trash"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="4">
                    <div class="empty-state text-center py-5">
                      <i class="bi bi-people display-4 text-muted mb-3"></i>
                      <h5 class="fw-bold">No employees found</h5>
                      <p class="text-muted">Add your first employee to get started</p>
                      <a href="./create.php" class="btn btn-primary mt-3">
                        <i class="bi bi-plus-circle me-2"></i> Add Employee
                      </a>
                    </div>
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="toast align-items-center text-white bg-success border-0" role="alert" id="successToast">
    <div class="d-flex">
      <div class="toast-body">
        <i class="bi bi-check-circle-fill me-2"></i>
        <span id="toastMessage">Operation successful</span>
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Delete confirmation
    document.querySelectorAll('.delete-btn').forEach(btn => {
      btn.addEventListener('click', function(e) {
        if (!confirm('Are you sure you want to delete this employee?')) {
          e.preventDefault();
        }
      });
    });

    // Search functionality
    document.getElementById('searchInput').addEventListener('input', function() {
      const searchTerm = this.value.toLowerCase();
      const rows = document.querySelectorAll('#employeeTable tr');
      
      rows.forEach(row => {
        if (row.querySelector('td')) {
          const text = row.textContent.toLowerCase();
          row.style.display = text.includes(searchTerm) ? '' : 'none';
        }
      });
    });

    // Show toast notification if there's a success message in URL
    document.addEventListener('DOMContentLoaded', function() {
      const urlParams = new URLSearchParams(window.location.search);
      if (urlParams.has('success')) {
        const toast = new bootstrap.Toast(document.getElementById('successToast'));
        const message = urlParams.get('success');
        if (message) {
          document.getElementById('toastMessage').textContent = decodeURIComponent(message);
        }
        toast.show();
      }
    });
  </script>
</body>
</html>