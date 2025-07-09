<?php
include 'dbconnect.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect all fields
    $fields = [
        'report_date', 'school', 'problems_last_review', 'adherence', 'missed_doses',
        'counselling_on_adherence', 'present_problems', 'arv_therapy', 'date_started',
        'age_at_start', 'duration_therapy', 'current_drugs', 'weight', 'height',
        'z_score', 'bmi', 'pallor', 'jaundice', 'cyanosis', 'clubbing', 'oedema',
        'wasting', 'parotids', 'lymph_nodes', 'eyes', 'ears_discharge', 'hearing_test',
        'throat', 'mouth', 'thrush', 'ulcers', 'teeth', 'describe_teeth', 'skin',
        'describe_skin', 'normal_rs', 'rs_rate', 'recession', 'percussion',
        'breath_sounds', 'creps', 'rhonchi', 'state_location', 'normal_cvs', 'cvs_rate',
        'apex', 'precordium', 'heart_sounds', 'murmurs', 'describe_heart',
        'abdomen_normal', 'gas', 'ascites', 'masses', 'describe_abdomen', 'liver_cm',
        'spleen_cm', 'normal_cns', 'tone', 'tendon_reflexes', 'affected_parts',
        'joints', 'describe_joints', 'motor', 'tanner_stage', 'summary',
        'clinical', 'immunological', 'other_lab', 'plan', 'lab', 'xray', 'adjust_arv',
        'change_arv', 'additional_drugs', 'refer', 'clinician_name'
    ];

    $data = [];
    foreach ($fields as $field) {
        $data[$field] = isset($_POST[$field]) ? $_POST[$field] : null;
    }

    // Build query dynamically
    $columns = implode(", ", array_keys($data));
    $placeholders = implode(", ", array_fill(0, count($data), "?"));

    $stmt = $conn->prepare("INSERT INTO medical_progress ($columns) VALUES ($placeholders)");

    $types = str_repeat("s", count($data)); // all fields treated as strings
    $stmt->bind_param($types, ...array_values($data));

    // Execute and feedback
    if ($stmt->execute()) {
        echo "✅ Medical progress report saved successfully.";
    } else {
        echo "❌ Error saving record: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} 
?>


<!DOCTYPE html>
<html lang="en">
<?php include 'head.php'; ?>
<body>

<div class="form-container">
  <h2>Medical Progress Report</h2>
  <form action="medical_progress_report.php" method="post">
    <div class="form-row">
      <!-- COLUMN 1 -->
      <div class="column">
        
        <div class="form-group">
          <label>Report Date</label>
          <input type="date" name="report_date">
        </div>




        <div class="form-group"><label>School</label><input type="text" name="school"></div>
        <div class="form-group"><label>Problems Since Last Review</label><textarea name="problems_last_review"></textarea></div>
        <div class="form-group"><label>Adherence</label><input type="text" name="adherence"></div>
        <div class="form-group"><label>Missed Doses (Per Week/Month)</label><input type="text" name="missed_doses"></div>
        <div class="form-group"><label>Counselling on Adherence</label><input type="text" name="counselling_on_adherence"></div>
        <div class="form-group"><label>Present Problems</label><textarea name="present_problems"></textarea></div>
        <div class="form-group"><label>ARV Therapy</label><input type="text" name="arv_therapy"></div>
        <div class="form-group"><label>Date Started</label><input type="date" name="date_started"></div>
        <div class="form-group"><label>Age at Start of Therapy</label><input type="number" name="age_at_start"></div>
        <div class="form-group"><label>Duration of Therapy (auto)</label><input type="text" name="duration_therapy" readonly></div>
        <div class="form-group"><label>Current Drugs</label><input type="text" name="current_drugs"></div>
        <div class="form-group"><label>Weight (kg)</label><input type="number" name="weight"></div>
        <div class="form-group"><label>Height (cm)</label><input type="number" name="height"></div>
        <div class="form-group"><label>Z-Score</label><input type="text" name="z_score"></div>
        <div class="form-group"><label>BMI (auto)</label><input type="text" name="bmi" readonly></div>
        <div class="form-group"><label>Pallor</label><input type="text" name="pallor"></div>
        <div class="form-group"><label>Jaundice</label><input type="text" name="jaundice"></div>
        <div class="form-group"><label>Cyanosis</label><input type="text" name="cyanosis"></div>
        <div class="form-group"><label>Clubbing</label><input type="text" name="clubbing"></div>
        <div class="form-group"><label>Oedema</label><input type="text" name="oedema"></div>
        <div class="form-group"><label>Wasting</label><input type="text" name="wasting"></div>
        <div class="form-group"><label>Parotids</label><input type="text" name="parotids"></div>
        <div class="form-group"><label>Lymph Nodes</label><input type="text" name="lymph_nodes"></div>
        <div class="form-group"><label>Eyes</label><input type="text" name="eyes"></div>
        <div class="form-group"><label>Ears Discharge</label><input type="text" name="ears_discharge"></div>
        <div class="form-group"><label>Hearing Test</label><input type="text" name="hearing_test"></div>
        <div class="form-group"><label>Throat</label><input type="text" name="throat"></div>
        <div class="form-group"><label>Mouth</label><input type="text" name="mouth"></div>
        <div class="form-group"><label>Thrush</label><input type="text" name="thrush"></div>
        <div class="form-group"><label>Ulcers</label><input type="text" name="ulcers"></div>
        <div class="form-group"><label>Teeth</label><input type="text" name="teeth"></div>
        <div class="form-group"><label>Describe Teeth</label><textarea name="describe_teeth"></textarea></div>
        <div class="form-group"><label>Skin</label><input type="text" name="skin"></div>
        <div class="form-group"><label>Describe Skin</label><textarea name="describe_skin"></textarea></div>
        <div class="form-group"><label>Normal Respiratory System</label><input type="text" name="normal_rs"></div>
        <div class="form-group"><label>RS Rate per min</label><input type="number" name="rs_rate"></div>
        <div class="form-group"><label>Recession</label><input type="text" name="recession"></div>
        <div class="form-group"><label>Percussion</label><input type="text" name="percussion"></div>
        <div class="form-group"><label>Breath Sounds</label><input type="text" name="breath_sounds"></div>
      </div>

      <!-- COLUMN 2 -->
      <div class="column">
        <div class="form-group"><label>Creps</label><input type="text" name="creps"></div>
        <div class="form-group"><label>Rhonchi</label><input type="text" name="rhonchi"></div>
        <div class="form-group"><label>State Location</label><input type="text" name="state_location"></div>
        <div class="form-group"><label>Normal CVS</label><input type="text" name="normal_cvs"></div>
        <div class="form-group"><label>CVS Rate</label><input type="number" name="cvs_rate"></div>
        <div class="form-group"><label>Apex</label><input type="text" name="apex"></div>
        <div class="form-group"><label>Precordium</label><input type="text" name="precordium"></div>
        <div class="form-group"><label>Normal Heart Sounds</label><input type="text" name="heart_sounds"></div>
        <div class="form-group"><label>Murmurs</label><input type="text" name="murmurs"></div>
        <div class="form-group"><label>Describe</label><textarea name="describe_heart"></textarea></div>
        <div class="form-group"><label>Abdomen Normal</label><input type="text" name="abdomen_normal"></div>
        <div class="form-group"><label>Gas</label><input type="text" name="gas"></div>
        <div class="form-group"><label>Ascites</label><input type="text" name="ascites"></div>
        <div class="form-group"><label>Masses</label><input type="text" name="masses"></div>
        <div class="form-group"><label>Describe Abdomen</label><textarea name="describe_abdomen"></textarea></div>
        <div class="form-group"><label>Liver (cm)</label><input type="number" name="liver_cm"></div>
        <div class="form-group"><label>Spleen (cm)</label><input type="number" name="spleen_cm"></div>
        <div class="form-group"><label>Normal CNS</label><input type="text" name="normal_cns"></div>
        <div class="form-group"><label>Tone</label><input type="text" name="tone"></div>
        <div class="form-group"><label>Tendon Reflexes</label><input type="text" name="tendon_reflexes"></div>
        <div class="form-group"><label>Affected Parts</label><input type="text" name="affected_parts"></div>
        <div class="form-group"><label>Joints</label><input type="text" name="joints"></div>
        <div class="form-group"><label>Describe Joints</label><textarea name="describe_joints"></textarea></div>
        <strong> Development</strong> <br>
        <div class="form-group"><label>Motor</label><input type="text" name="motor"></div>
        <div class="form-group"><label>Sexual (Tanner Stage)</label><input type="text" name="tanner_stage"></div>
        <div class="form-group"><label>Summary of Noted Problems</label><textarea name="summary" maxlength="255"></textarea></div>
        <div class="form-group"><label>Clinical</label><input type="text" name="clinical"></div>
        <div class="form-group"><label>Immunological</label><input type="text" name="immunological"></div>
        <div class="form-group"><label>Other Lab Findings</label><input type="text" name="other_lab"></div>
        <div class="form-group"><label>Plan</label><textarea name="plan" maxlength="255"></textarea></div>
        <div class="form-group"><label>Lab</label><input type="text" name="lab"></div>
        <div class="form-group"><label>X-ray / Imaging</label><input type="text" name="xray"></div>
        <div class="form-group"><label>Adjust ARV Dosage</label><input type="text" name="adjust_arv"></div>
        <div class="form-group"><label>Change ARV</label><input type="text" name="change_arv"></div>
        <div class="form-group"><label>Additional Drugs</label><input type="text" name="additional_drugs"></div>
        <div class="form-group"><label>Refer</label><input type="text" name="refer"></div>
        <div class="form-group"><label>Clinician Name</label><input type="text" name="clinician_name"></div>
      </div>
    </div>

    <button type="submit">Submit Medical Report</button>
  </form>
</div>

<script>
  // Function to calculate BMI
  function calculateBMI() {
    const weight = parseFloat(document.querySelector('input[name="weight"]').value);
    const heightCm = parseFloat(document.querySelector('input[name="height"]').value);
    const bmiField = document.querySelector('input[name="bmi"]');

    if (!isNaN(weight) && !isNaN(heightCm) && heightCm > 0) {
      const heightM = heightCm / 100;
      const bmi = weight / (heightM * heightM);
      bmiField.value = bmi.toFixed(2);
    } else {
      bmiField.value = '';
    }
  }

  // Function to calculate Duration of Therapy
  function calculateDuration() {
    const startDate = document.querySelector('input[name="date_started"]').value;
    const durationField = document.querySelector('input[name="duration_therapy"]');

    if (startDate) {
      const start = new Date(startDate);
      const now = new Date();

      const years = now.getFullYear() - start.getFullYear();
      const months = now.getMonth() - start.getMonth();
      const totalMonths = years * 12 + months;

      if (totalMonths >= 0) {
        const yearsPart = Math.floor(totalMonths / 12);
        const monthsPart = totalMonths % 12;
        durationField.value = `${yearsPart}y ${monthsPart}m`;
      } else {
        durationField.value = '';
      }
    } else {
      durationField.value = '';
    }
  }

  // Attach events
  document.addEventListener("DOMContentLoaded", function () {
    const weightField = document.querySelector('input[name="weight"]');
    const heightField = document.querySelector('input[name="height"]');
    const startDateField = document.querySelector('input[name="date_started"]');

    weightField.addEventListener("input", calculateBMI);
    heightField.addEventListener("input", calculateBMI);
    startDateField.addEventListener("change", calculateDuration);
  });
</script>
</body>
</html>
