<?php 
require_once 'session.php';
require_once 'dbconnect.php';
include 'recognize.php'; 


$status_msg = "";
$status_type = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize inputs
    $medical_history = $_POST['medical_history'] ?? '';
    $condition_field = $_POST['condition'] ?? '';
    $weight          = $_POST['weight'] ?? '';
    $height          = $_POST['height'] ?? '';
    $wasting         = $_POST['wasting'] ?? '';
    $oedema          = $_POST['oedema'] ?? '';
    $pallor          = $_POST['pallor'] ?? '';
    $cyanosis        = $_POST['cyanosis'] ?? '';
    $clubbing        = $_POST['clubbing'] ?? '';
    $jaundice        = $_POST['jaundice'] ?? '';
    $parotids        = $_POST['parotids'] ?? '';
    $respiratory     = $_POST['respiratory'] ?? '';
    $cvs             = $_POST['cvs'] ?? '';
    $abdomen         = $_POST['abdomen'] ?? '';
    $lymph_nodes     = $_POST['lymph_nodes'] ?? '';
    $eyes            = $_POST['eyes'] ?? '';
    $ent             = $_POST['ent'] ?? '';
    $mouth           = $_POST['mouth'] ?? '';
    $ulcers          = $_POST['ulcers'] ?? '';
    $thrush          = $_POST['thrush'] ?? '';
    $teeth           = $_POST['teeth'] ?? '';
    $hair            = $_POST['hair'] ?? '';
    $skin            = $_POST['skin'] ?? '';
    $bcg_scar        = $_POST['bcg_scar'] ?? '';
    $cns             = $_POST['cns'] ?? '';
    $masculoskeletal = $_POST['masculoskeletal'] ?? '';
    $gross_motor     = $_POST['gross_motor'] ?? '';
    $fine_motor      = $_POST['fine_motor'] ?? '';
    $social          = $_POST['social'] ?? '';
    $language        = $_POST['language'] ?? '';
    $summary         = $_POST['summary'] ?? '';
    $plan            = $_POST['plan'] ?? '';

    $stmt = $conn->prepare("
        INSERT INTO admission_examination 
        (
            medical_history, condition_field, weight, height, wasting, oedema, pallor, cyanosis, clubbing, jaundice, 
            parotids, respiratory, cvs, abdomen, lymph_nodes, eyes, ent, mouth, ulcers, thrush, 
            teeth, hair, skin, bcg_scar, cns, masculoskeletal, gross_motor, fine_motor, social, language, summary, plan
        ) 
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
    ");

    $stmt->bind_param(
        "ssssssssssssssssssssssssssssssss",
        $medical_history, $condition_field, $weight, $height, $wasting, $oedema, $pallor, $cyanosis, $clubbing, $jaundice,
        $parotids, $respiratory, $cvs, $abdomen, $lymph_nodes, $eyes, $ent, $mouth, $ulcers, $thrush,
        $teeth, $hair, $skin, $bcg_scar, $cns, $masculoskeletal, $gross_motor, $fine_motor, $social, $language, $summary, $plan
    );

    if ($stmt->execute()) {
        $status_type = "success";
        $status_msg = "Admission record finalized successfully.";
    } else {
        $status_type = "danger";
        $status_msg = "Critical Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'head.php'; ?>

    <style>
        /* FIXING STYLES AS PER REFERENCE IMAGE */
        .panel {
            background: white;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            padding: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }

        .section-header {
            background: #f8fafc;
            border-radius: 8px;
            padding: 12px 20px;
            margin: 25px 0 20px 0;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #2563eb;
            font-weight: 800;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.05em;
            border-left: 5px solid #2563eb;
        }

        .form-grid-4 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        .main-input {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 0.9rem;
            background: #fff;
            transition: all 0.2s;
        }

        .main-input:focus {
            border-color: #2563eb;
            outline: none;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        label {
            display: block;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            color: #64748b;
            margin-bottom: 6px;
            letter-spacing: 0.025em;
        }

        textarea.main-input {
            min-height: 100px;
            line-height: 1.5;
        }

        .btn-submit {
            background: #2563eb;
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: 0.2s;
        }

        .btn-submit:hover { background: #1d4ed8; }
    </style>
</head>
<body>

<div class="dashboard-container">
    <?php include 'sidenav.php'; ?>

    <main class="main-content">
        <header class="top-bar">
            <div class="header-left">
                <span style="font-weight: 700; color: #1e293b;"><i class="fa-solid fa-notes-medical"></i> Clinical Examination</span>
            </div>
            <div class="header-right">
                <div class="live-clock"><i class="fa-regular fa-clock"></i> <span id="digital-clock">00:00:00</span></div>
            </div>
        </header>

        <div class="scroll-area" style="padding: 2rem;">
            <div class="content-header">
                <h1>Admission Assessment</h1>
                <p>Detailed physical and developmental registry for pediatric intake.</p>
            </div>

            <?php if ($status_msg): ?>
                <div style="padding:15px; border-radius:8px; margin-bottom:20px; background:<?= $status_type=='success'?'#dcfce7':'#fee2e2' ?>; color:<?= $status_type=='success'?'#166534':'#991b1b' ?>;">
                    <i class="fa-solid fa-circle-check"></i> <?= $status_msg ?>
                </div>
            <?php endif; ?>

            <div class="panel">
                <form method="POST">
                    
                    <div class="section-header"><i class="fa-solid fa-clipboard-user"></i> General History & Condition</div>
                    <div class="form-grid-4">
                        <div style="grid-column: span 1;">
                            <label>Medical History</label>
                            <textarea name="medical_history" class="main-input" placeholder="Notes..."></textarea>
                        </div>
                        <div>
                            <label>General Condition</label>
                            <input type="text" name="condition" class="main-input" placeholder="State">
                        </div>
                        <div>
                            <label>Weight (KG)</label>
                            <input type="text" name="weight" class="main-input" placeholder="0.0">
                        </div>
                        <div>
                            <label>Height (CM)</label>
                            <input type="text" name="height" class="main-input" placeholder="0.0">
                        </div>
                    </div>

                    <div class="section-header"><i class="fa-solid fa-stethoscope"></i> Physical Examination</div>
                    <div class="form-grid-4">
                        <div><label>Wasting</label><input type="text" name="wasting" class="main-input"></div>
                        <div><label>Oedema</label><input type="text" name="oedema" class="main-input"></div>
                        <div><label>Pallor</label><input type="text" name="pallor" class="main-input"></div>
                        <div><label>Cyanosis</label><input type="text" name="cyanosis" class="main-input"></div>
                        <div><label>Clubbing</label><input type="text" name="clubbing" class="main-input"></div>
                        <div><label>Jaundice</label><input type="text" name="jaundice" class="main-input"></div>
                        <div><label>Respiratory</label><input type="text" name="respiratory" class="main-input"></div>
                        <div><label>CNS</label><input type="text" name="cns" class="main-input"></div>
                    </div>

                    <div class="section-header"><i class="fa-solid fa-child-reaching"></i> Development & Plan</div>
                    <div class="form-grid-4">
                        <div><label>Gross Motor</label><input type="text" name="gross_motor" class="main-input"></div>
                        <div><label>Fine Motor</label><input type="text" name="fine_motor" class="main-input"></div>
                        <div style="grid-column: span 2;"><label>Social & Language</label><textarea name="social" class="main-input"></textarea></div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px;">
                        <div>
                            <label>Clinical Summary</label>
                            <textarea name="summary" class="main-input"></textarea>
                        </div>
                        <div>
                            <label>Management Plan</label>
                            <textarea name="plan" class="main-input"></textarea>
                        </div>
                    </div>

                    <div style="text-align: right; margin-top: 30px; border-top: 1px solid #f1f5f9; padding-top: 20px;">
                        <button type="submit" class="btn-submit">
                            <i class="fa-solid fa-cloud-arrow-up"></i> Finalize Examination
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </main>
</div>

<script>
    function updateClock() {
        const el = document.getElementById('digital-clock');
        if (el) el.textContent = new Date().toLocaleTimeString('en-GB');
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>

</body>
</html>