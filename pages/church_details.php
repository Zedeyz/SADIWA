<?php
require_once '../config/session.php';
require_once '../functions/church.php';
require_once '../functions/report.php';
requireLogin();

$churchId = $_GET['id'] ?? null;
if (!$churchId) {
    header('Location: churches.php');
    exit();
}

$church = getChurchById($churchId);
if (!$church) {
    header('Location: churches.php');
    exit();
}

$reports = getReportsByChurch($churchId);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($church['name']); ?> - SADIWA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        #miniMap { height: 300px; }
    </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    
    <div class="container mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="churches.php">Churches</a></li>
                <li class="breadcrumb-item active"><?php echo htmlspecialchars($church['name']); ?></li>
            </ol>
        </nav>
        
        <h2 class="mb-4"><?php echo htmlspecialchars($church['name']); ?></h2>
        
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Church Information</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Municipality:</th>
                                <td><?php echo htmlspecialchars($church['municipality']); ?></td>
                            </tr>
                            <tr>
                                <th>Year Built:</th>
                                <td><?php echo htmlspecialchars($church['year_built'] ?? 'Unknown'); ?></td>
                            </tr>
                            <tr>
                                <th>Architectural Style:</th>
                                <td><?php echo htmlspecialchars($church['architectural_style'] ?? 'Unknown'); ?></td>
                            </tr>
                            <tr>
                                <th>Coordinates:</th>
                                <td><?php echo htmlspecialchars($church['latitude']); ?>, <?php echo htmlspecialchars($church['longitude']); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Location</h5>
                    </div>
                    <div class="card-body p-0">
                        <div id="miniMap"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Damage Reports</h5>
            </div>
            <div class="card-body">
                <?php if (count($reports) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Risk Level</th>
                                <th>Contributor</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reports as $report): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($report['report_date']); ?></td>
                                <td><?php echo htmlspecialchars($report['damage_description']); ?></td>
                                <td>
                                    <?php if (!empty($report['image_path'])): ?>
                                        <span class="badge" 
                                            style="background-color: #0dcaf0; cursor: pointer;"
                                            onclick="viewImage('../uploads/<?php echo $report['image_path']; ?>')">
                                            View Image
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">No Image</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge" style="background-color: <?php echo htmlspecialchars($report['color_code']); ?>">
                                        <?php echo htmlspecialchars($report['risk_name']); ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($report['contributor_name']); ?></td>
                                <td>
                                    <?php 
                                    $statusClass = $report['status'] === 'Approved' ? 'success' : ($report['status'] === 'Pending' ? 'warning' : 'danger');
                                    ?>
                                    <span class="badge bg-<?php echo $statusClass; ?>"><?php echo htmlspecialchars($report['status']); ?></span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <p class="text-muted">No damage reports found for this church.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var map = L.map('miniMap').setView([<?php echo $church['latitude']; ?>, <?php echo $church['longitude']; ?>], 14);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);
        
        L.marker([<?php echo $church['latitude']; ?>, <?php echo $church['longitude']; ?>])
            .bindPopup('<strong><?php echo htmlspecialchars($church['name']); ?></strong>')
            .addTo(map);
    </script>


    <script>
    function viewImage(imageSrc) {
        document.getElementById('modalImage').src = imageSrc;
        var modal = new bootstrap.Modal(document.getElementById('imageModal'));
        modal.show();
    }
    </script>
        <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Damage Image</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body text-center">
            <img id="modalImage" src="" class="img-fluid rounded">
        </div>
        </div>
    </div>
    </div>


</body>
</html>