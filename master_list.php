<?php
require_once 'session.php';
require_once 'dbconnect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'head.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    
    <style>
        /* Modern Clinical Theme */
        :root { --primary: #4361ee; --bg-soft: #f8f9ff; }
        body { background-color: #f5f7fb; font-family: 'Plus Jakarta Sans', sans-serif; }

        .panel { 
            background: white; 
            border-radius: 16px; 
            border: none; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.04); 
            padding: 25px;
        }

        /* DATA TABLES & PAGINATION FIXES */
        /* This section removes the bullets and fixes the layout from your screenshots */
        .dataTables_paginate ul.pagination {
            list-style-type: none !important;
            padding: 0 !important;
            display: flex !important;
            gap: 6px;
        }
        .dataTables_paginate li { list-style: none !important; }
        
        .page-link {
            border: none !important;
            background: var(--bg-soft) !important;
            color: var(--primary) !important;
            border-radius: 8px !important;
            font-weight: 600;
            padding: 8px 16px;
        }
        .page-item.active .page-link {
            background: var(--primary) !important;
            color: white !important;
        }

        /* Clinical Table Styling */
        .clinical-table thead th {
            background: #fcfcfd;
            color: #b5b5c3;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 15px;
            border-bottom: 2px solid #f1f1f4;
        }
        .clinical-table tbody td {
            padding: 15px !important;
            vertical-align: middle;
            border-bottom: 1px solid #f1f1f4;
        }

        /* Status Tags */
        .acuity-tag {
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 0.7rem;
            font-weight: 700;
            display: inline-block;
        }
        .stable { background: #e8fff3; color: #50cd89; }
        .warning { background: #fff8dd; color: #ffc700; }
        .danger { background: #fff5f8; color: #f1416c; }

        /* Modal Grid Layout */
        .action-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .action-item {
            display: flex; align-items: center; gap: 12px; padding: 15px;
            background: #f8f9fa; border-radius: 12px; text-decoration: none;
            color: #3f4254; transition: 0.3s; border: 1px solid transparent;
        }
        .action-item:hover {
            background: #fff; border-color: var(--primary);
            color: var(--primary); transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.1);
        }
        .section-title {
            grid-column: span 2; font-size: 0.7rem; font-weight: 800;
            color: #b5b5c3; text-transform: uppercase; margin-top: 15px;
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <?php include 'sidenav.php'; ?>

    <main class="main-content">
        <header class="top-bar">
            <div class="search-wrapper">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="globalSearch" placeholder="Search Patient Registry...">
            </div>
            <div class="header-right">
                <div class="live-clock"><i class="fa-regular fa-clock"></i> <span id="digital-clock">00:00:00</span></div>
            </div>
        </header>

        <div class="scroll-area p-4">
            <div class="panel">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h3 class="fw-bold mb-0">Master Registry</h3>
                        <p class="text-muted small">Select a patient to manage clinical operations.</p>
                    </div>
                    <a href="register_child.php" class="btn btn-primary rounded-pill px-4 shadow-sm">
                        <i class="fa-solid fa-plus me-2"></i>Register New Child
                    </a>
                </div>

                <div class="table-responsive">
                    <table id="masterListTable" class="table clinical-table w-100">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Full Name</th>
                                <th>Age</th>
                                <th>Gender</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM children ORDER BY id DESC";
                            $result = $conn->query($sql);
                            if ($result && $result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $status = strtoupper($row['status'] ?? 'STABLE');
                                    $tagClass = ($status == 'CRITICAL') ? 'danger' : (($status == 'OBSERVATION') ? 'warning' : 'stable');
                                    
                                    echo "<tr>";
                                    echo "<td class='fw-bold text-primary'>#C-".str_pad($row['id'],3,'0',STR_PAD_LEFT)."</td>";
                                    echo "<td class='fw-bold'>".htmlspecialchars($row['name'])."</td>";
                                    echo "<td>".$row['age']."</td>";
                                    echo "<td>".$row['gender']."</td>";
                                    echo "<td><span class='acuity-tag $tagClass'>$status</span></td>";
                                    echo "<td class='text-end'>
                                            <button type='button' class='btn btn-sm btn-light border px-3 open-actions' 
                                                data-id='".$row['id']."' 
                                                data-name='".htmlspecialchars($row['name'])."'
                                                data-bs-toggle='modal' data-bs-target='#actionModal'>
                                                <i class='fa-solid fa-gear me-1'></i> Manage
                                            </button>
                                          </td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<div class="modal fade" id="actionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <div>
                    <h5 class="fw-bold mb-0" id="modalPatientName">Patient Name</h5>
                    <small class="text-muted" id="modalPatientID">ID: #000</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="action-grid">
                    <div class="section-title">Clinical Entry</div>
                    <a href="#" id="link-exam" class="action-item"><i class="fa-solid fa-notes-medical text-danger"></i> <span>Exam</span></a>
                    <a href="#" id="link-lab" class="action-item"><i class="fa-solid fa-flask-vial text-info"></i> <span>Lab</span></a>
                    <a href="#" id="link-diag" class="action-item"><i class="fa-solid fa-microscope text-primary"></i> <span>Diagnostic</span></a>
                    <a href="#" id="link-sib" class="action-item"><i class="fa-solid fa-people-group text-success"></i> <span>Siblings</span></a>
                    
                    <div class="section-title">Treatment</div>
                    <a href="#" id="link-arv" class="action-item"><i class="fa-solid fa-pills text-primary"></i> <span>ARV</span></a>
                    <a href="#" id="link-vac" class="action-item"><i class="fa-solid fa-syringe text-warning"></i> <span>Vaccine</span></a>
                    
                    <div class="section-title">Outcome</div>
                    <a href="#" id="link-progress" class="action-item"><i class="fa-solid fa-file-waveform text-info"></i> <span>Progress</span></a>
                    <a href="#" id="link-discharge" class="action-item"><i class="fa-solid fa-file-export text-danger"></i> <span>Discharge</span></a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        // 1. Initialize Table
        var table = $('#masterListTable').DataTable({
            "pageLength": 10,
            "dom": "rt<'d-flex justify-content-between align-items-center mt-3'ip>", // Better layout
            "language": {
                "paginate": { "previous": "<i class='fa-solid fa-angle-left'></i>", "next": "<i class='fa-solid fa-angle-right'></i>" }
            }
        });

        // 2. Link Top Search Bar
        $('#globalSearch').on('keyup', function() { table.search(this.value).draw(); });

        // 3. Dynamic Modal Logic (Recognition)
        $('.open-actions').on('click', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            
            $('#modalPatientName').text(name);
            $('#modalPatientID').text('Patient ID: #C-' + id.toString().padStart(3, '0'));

            // The system "recognizes" the child by appending the ID to the URL
            $('#link-exam').attr('href', 'admission_examination.php?id=' + id);
            $('#link-lab').attr('href', 'laboratory.php?id=' + id);
            $('#link-diag').attr('href', 'hiv_test.php?id=' + id);
            $('#link-arv').attr('href', 'arv_therapy.php?id=' + id);
            $('#link-vac').attr('href', 'vaccination.php?id=' + id);
            $('#link-sib').attr('href', 'HIV_+ve_siblings.php?id=' + id);
            $('#link-progress').attr('href', 'medical_progress_report.php?id=' + id);
            $('#link-discharge').attr('href', 'discharge_abstract.php?id=' + id);
        });
    });

    function runClock() {
        const now = new Date();
        const clock = document.getElementById('digital-clock');
        if(clock) clock.textContent = now.toLocaleTimeString('en-GB');
    }
    setInterval(runClock, 1000);
</script>
</body>
</html>