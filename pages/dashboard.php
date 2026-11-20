<?php
require_once '../config/session.php';
require_once '../functions/church.php';
require_once '../functions/report.php';
requireLogin();

$totalChurches = count(getAllChurches());
$totalReports = count(getAllReports());
$riskSummary = getRiskSummary();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SADIWA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    
    <div class="container mt-4">
        <h2 class="mb-4">Dashboard</h2>
        
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card border-primary">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Total Churches</h5>
                        <h2 class="mb-0"><?php echo $totalChurches; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-success">
                    <div class="card-body">
                        <h5 class="card-title text-success">Total Reports</h5>
                        <h2 class="mb-0"><?php echo $totalReports; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-info">
                    <div class="card-body">
                        <h5 class="card-title text-info">Your Role</h5>
                        <h2 class="mb-0"><?php echo htmlspecialchars($_SESSION['role']); ?></h2>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Risk Summary -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Risk Level Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Risk Level</th>
                                        <th>Number of Churches</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($riskSummary as $risk): ?>
                                    <tr>
                                        <td>
                                            <span class="badge" style="background-color: <?php echo htmlspecialchars($risk['color_code']); ?>">
                                                <?php echo htmlspecialchars($risk['level_name']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo $risk['church_count']; ?></td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar" role="progressbar" 
                                                     style="width: <?php echo ($risk['church_count'] / $totalChurches * 100); ?>%; background-color: <?php echo htmlspecialchars($risk['color_code']); ?>">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>