<?php 
// dbconnect.php
include 'dbconnect.php';
// error reporting settings
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Safely get POST values or set to empty string if not set
    $medical_history = $_POST['medical_history'] ?? '';
    $condition_field = $_POST['condition'] ?? '';
    $weight = $_POST['weight'] ?? '';
    $height = $_POST['height'] ?? '';
    $wasting = $_POST['wasting'] ?? '';
    $oedema = $_POST['oedema'] ?? '';
    $pallor = $_POST['pallor'] ?? '';
    $cyanosis = $_POST['cyanosis'] ?? '';
    $clubbing = $_POST['clubbing'] ?? '';
    $jaundice = $_POST['jaundice'] ?? '';
    $parotids = $_POST['parotids'] ?? '';
    $respiratory = $_POST['respiratory'] ?? '';
    $cvs = $_POST['cvs'] ?? '';
    $abdomen = $_POST['abdomen'] ?? '';
    $lymph_nodes = $_POST['lymph_nodes'] ?? '';
    $eyes = $_POST['eyes'] ?? '';
    $ent = $_POST['ent'] ?? '';
    $mouth = $_POST['mouth'] ?? '';
    $ulcers = $_POST['ulcers'] ?? '';
    $thrush = $_POST['thrush'] ?? '';
    $teeth = $_POST['teeth'] ?? '';
    $hair = $_POST['hair'] ?? '';
    $skin = $_POST['skin'] ?? '';
    $bcg_scar = $_POST['bcg_scar'] ?? '';
    $cns = $_POST['cns'] ?? '';
    $masculoskeletal = $_POST['masculoskeletal'] ?? '';
    $gross_motor = $_POST['gross_motor'] ?? '';
    $fine_motor = $_POST['fine_motor'] ?? '';
    $social = $_POST['social'] ?? '';
    $language = $_POST['language'] ?? '';
    $summary = $_POST['summary'] ?? '';
    $plan = $_POST['plan'] ?? '';

    // Use prepared statements to prevent SQL injection
    // Fix this line: use the SAME var name everywhere
    $stmt = $conn->prepare("
    INSERT INTO admission_examination 
    (
        medical_history, condition_field , weight, height, wasting, oedema, pallor, cyanosis, clubbing, jaundice, 
        parotids, respiratory, cvs, abdomen, lymph_nodes, eyes, ent, mouth, ulcers, thrush, 
        teeth, hair, skin, bcg_scar, cns, masculoskeletal, gross_motor, fine_motor, social, language, summary, plan
    ) 
    VALUES 
    (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
    )
    ");


    $stmt->bind_param(
        "ssssssssssssssssssssssssssssssss",
        $medical_history, $condition_field , $weight, $height, $wasting, $oedema, $pallor, $cyanosis, $clubbing, $jaundice,
        $parotids, $respiratory, $cvs, $abdomen, $lymph_nodes, $eyes, $ent, $mouth, $ulcers, $thrush,
        $teeth, $hair, $skin, $bcg_scar, $cns, $masculoskeletal, $gross_motor, $fine_motor, $social, $language, $summary, $plan
    );
        if ($stmt->execute()) {
            echo "<div style='color: green; text-align: center;'>Data saved successfully.</div>";
        } else {
            echo "<div style='color: red; text-align: center;'>Error saving data: " . $stmt->error . "</div>";
        }

        $stmt->close();
    }

    //include sweet alert library
    // echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    // echo '<script>
    // document.addEventListener("DOMContentLoaded", function() {
    //     Swal.fire({
    //         title: "Admission Examination",
    //         text: "Please fill out the form carefully.",
    //         icon: "info",
    //         confirmButtonText: "Got it!",
    //         customClass: {
    //             popup: "swal-popup",
    //             title: "swal-title",
    //             content: "swal-content",
    //             confirmButton: "swal-confirm-button"
    //         }
    //     });
    // });
    // </script>';

?>


<!DOCTYPE html>
<?php include 'head.php'; ?>
<body>

    <h2>GENERAL EXAMINATION</h2>

    <div class="form-container">
  <form method="POST" action="">

    <section>
    <h1 class="form-title" style="text-align: center;">Admission Examination</h1>
    <hr><br>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="medical_history">Medical History:</label>
            <textarea name="medical_history" id="medical_history" maxlength="255" class="form-control"></textarea>
          </div>
          <div class="col-md-6 mb-3">
            <label for="condition">Condition</label>
            <input type="text" name="condition" id="condition" class="form-control" required />
          </div>
        </div>
    
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>Wasting</label>
              <input type="text" name="wasting" required />
            </div>
            <div class="form-group">
              <label>Pallor</label>
              <input type="text" name="pallor" required />
            </div>
            <div class="form-group">
              <label>Clubbing</label>
              <input type="text" name="clubbing" required />
            </div>
            <div class="form-group">
              <label>Parotids</label>
              <input type="text" name="parotids" required />
            </div>
            <div class="form-group">
              <label>CVS</label>
              <input type="text" name="cvs" required />
            </div>
            <div class="form-group">
              <label>Lymph Nodes</label>
              <input type="text" name="lymph_nodes" />
            </div>
            <div class="form-group">
              <label>ENT</label>
              <input type="text" name="ent" />
            </div>
            <div class="form-group">
              <label>Ulcers</label>
              <input type="text" name="ulcers" />
            </div>
            <div class="form-group">
              <label>Teeth</label>
              <input type="text" name="teeth" />
            </div>
            <div class="form-group">
              <label>Skin</label>
              <input type="text" name="skin" />
            </div>
            <div class="form-group">
              <label>CNS</label>
              <input type="text" name="cns" />
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Oedema</label>
              <input type="text" name="oedema" required />
            </div>
            <div class="form-group">
              <label>Cyanosis</label>
              <input type="text" name="cyanosis" required />
            </div>
            <div class="form-group">
              <label>Jaundice</label>
              <input type="text" name="jaundice" required />
            </div>
            <div class="form-group">
              <label>Respiratory System</label>
              <input type="text" name="respiratory" required />
            </div>
            <div class="form-group">
              <label>Abdomen</label>
              <input type="text" name="abdomen" required />
            </div>
            <div class="form-group">
              <label>Eyes</label>
              <input type="text" name="eyes" />
            </div>
            <div class="form-group">
              <label>Mouth</label>
              <input type="text" name="mouth" />
            </div>
            <div class="form-group">
              <label>Thrush</label>
              <input type="text" name="thrush" />
            </div>
            <div class="form-group">
              <label>Hair</label>
              <input type="text" name="hair" />
            </div>
            <div class="form-group">
              <label>BCG Scar</label>
              <input type="text" name="bcg_scar" />
            </div>
            <div class="form-group">
              <label>Masculoskeletal</label>
              <input type="text" name="masculoskeletal" />
            </div>
          </div>
        </div>
    
        <br><hr>
        <h2 style="text-align: center;">Development</h2>
        <hr><br>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>Gross Motor</label>
              <input type="text" name="gross_motor" />
            </div>
            <div class="form-group">
              <label>Social</label>
              <textarea name="social" maxlength="255"></textarea>
            </div>
            <div class="form-group">
              <label>Summary</label>
              <textarea name="summary"></textarea>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Fine Motor</label>
              <input type="text" name="fine_motor" />
            </div>
            <div class="form-group">
              <label>Language</label>
              <textarea name="language"></textarea>
            </div>
            <div class="form-group">
              <label>Plan</label>
              <textarea name="plan"></textarea>
            </div>
          </div>
        </div>
        <div style="text-align: center;">
          <button type="submit">Submit</button>
        </div>
    </section>
      </form>
      </div>
    
</body>
</html>

    </div>