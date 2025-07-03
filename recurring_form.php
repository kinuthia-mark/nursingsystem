<?php
include 'dbconnect.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Assign POST values
  $child_name = $_POST["child_name"];
  $child_id = $_POST["child_id"];
  $room_no = $_POST["room_no"];
  $dob = $_POST["dob"];
  $review_date = $_POST["review_date"];
  $reviewed_by = $_POST["reviewed_by"];
  $new_diagnoses = $_POST["new_diagnoses"];
  $allergy_changes = $_POST["allergy_changes"];
  $medication_updates = $_POST["medication_updates"];
  $hospitalizations = $_POST["hospitalizations"];
  $disabilities = $_POST["disabilities"];
  $new_vaccines = $_POST["new_vaccines"];
  $booster_doses = $_POST["booster_doses"];
  $vaccine_dates = $_POST["vaccine_dates"];
  $weight = $_POST["weight"];
  $height = $_POST["height"];
  $blood_pressure = $_POST["blood_pressure"];
  $temperature = $_POST["temperature"];
  $observations = $_POST["observations"];
  $mood_changes = $_POST["mood_changes"];
  $incidents = $_POST["incidents"];
  $referrals = $_POST["referrals"];
  $social_notes = $_POST["social_notes"];
  $referred = $_POST["referred"];
  $referral_purpose = $_POST["referral_purpose"];
  $next_appointment = $_POST["next_appointment"];
  $nurse_signature = $_POST["nurse_signature"];
  $social_signature = $_POST["social_signature"];
  $completion_date = $_POST["completion_date"];

  $stmt = $conn->prepare("INSERT INTO recurring_medical_history (
    child_name, child_id, room_no, dob, review_date, reviewed_by,
    new_diagnoses, allergy_changes, medication_updates, hospitalizations, disabilities,
    new_vaccines, booster_doses, vaccine_dates,
    weight, height, blood_pressure, temperature, observations,
    mood_changes, incidents, referrals, social_notes,
    referred, referral_purpose, next_appointment,
    nurse_signature, social_signature, completion_date
  ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

  $stmt->bind_param(
  "sssssssssssssssssssssssssssss", // 29 's'
  $child_name, $child_id, $room_no, $dob, $review_date, $reviewed_by,
  $new_diagnoses, $allergy_changes, $medication_updates, $hospitalizations, $disabilities,
  $new_vaccines, $booster_doses, $vaccine_dates,
  $weight, $height, $blood_pressure, $temperature, $observations,
  $mood_changes, $incidents, $referrals, $social_notes,
  $referred, $referral_purpose, $next_appointment,
  $nurse_signature, $social_signature, $completion_date
);


    if ($stmt->execute()) {
      echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
              Swal.fire({
                title: 'Success!',
                text: 'Medical info added successfully.',
                icon: 'success',
                confirmButtonText: 'OK'
              }).then(() => {
                window.location.href = 'recurring_form.php';
              });
            </script>";
    } else {
      echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
              Swal.fire({
                title: 'Error!',
                text: 'Failed to execute statement.',
                icon: 'error',
                confirmButtonText: 'OK'
              });
            </script>";
    }

    $stmt->close();
  } else {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
          <script>
            Swal.fire({
              title: 'Error!',
              text: 'Failed to prepare statement.',
              icon: 'error',
              confirmButtonText: 'OK'
            });
          </script>";
  }

  $conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Recurring Medical History Form – Children's Home</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #eafcff;
      margin: 0;
      padding: 40px 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
      min-height: 100vh;
    }

    h1.login-title {
      color: #fff;
      background: #00bcd4;
      border-radius: 8px;
      padding: 8px 16px;
      margin-bottom: 24px;
      text-shadow: 0 0 10px #00fff7, 0 0 20px #00fff7, 0 0 40px #00fff7;
      font-size: 2.5em;
      text-align: center;
    }

    form {
      width: 100%;
      max-width: 1000px;
    }

    section {
      background-color: #fff;
      padding: 32px;
      border-radius: 16px;
      margin-bottom: 24px;
      box-shadow: 0 0 16px rgba(1, 247, 255, 0.5);
    }

    h2 {
      font-size: 1.2rem;
      margin-top: 0;
      border-bottom: 1px solid #ccc;
      padding-bottom: 5px;
      color: #015e6b;
    }

    .form-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
      margin-top: 10px;
    }

    .form-group {
      display: flex;
      flex-direction: column;
    }

    label {
      font-size: 1.1em;
      color: #015e6b;
      margin-bottom: 4px;
    }

    input[type="text"],
    input[type="date"],
    textarea {
      font-size: 1.1em;
      padding: 8px;
      margin-bottom: 16px;
      border: 1px solid #b2ebf2;
      border-radius: 6px;
      background: #f7feff;
      box-sizing: border-box;
    }

    textarea {
      resize: vertical;
      height: 60px;
    }

    .full-width {
      grid-column: span 2;
    }

    .submit-section {
      text-align: center;
      margin-top: 40px;
    }

    button {
      background-color: #00bcd4;
      color: #fff;
      padding: 12px 28px;
      font-size: 1.1em;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      box-shadow: 0 0 10px #00fff7, 0 0 20px #00fff7, 0 0 30px #00fff7;
      transition: all 0.3s ease;
    }

    button:hover {
      background-color: #0097a7;
      box-shadow: 0 0 15px #00fff7, 0 0 25px #00fff7;
    }

    @media (max-width: 700px) {
      .form-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>

  <h1 class="login-title">Recurring Medical History Form</h1>

  <form method="post" action="recurring_form.php">

    <section>
      <h2>Child's Info</h2>
      <div class="form-grid">
        <div class="form-group">
          <label>Full Name</label>
          <input type="text" name="child_name" required>
        </div>
        <div class="form-group">
          <label>Assigned ID</label>
          <input type="text" name="child_id" required>
        </div>
        <div class="form-group">
          <label>Room No</label>
          <input type="text" name="room_no">
        </div>
        <div class="form-group">
          <label>Date of Birth</label>
          <input type="date" name="dob">
        </div>
      </div>
    </section>

    <section>
      <h2>Medical Review</h2>
      <div class="form-grid">
        <div class="form-group">
          <label>Date of Review</label>
          <input type="date" name="review_date" required>
        </div>
        <div class="form-group">
          <label>Reviewed By</label>
          <input type="text" name="reviewed_by" required>
        </div>
      </div>
    </section>

    <section>
      <h2>Medical Updates</h2>
      <div class="form-grid">
        <div class="form-group full-width">
          <label>New Diagnoses</label>
          <textarea name="new_diagnoses"></textarea>
        </div>
        <div class="form-group">
          <label>Allergy Changes</label>
          <textarea name="allergy_changes"></textarea>
        </div>
        <div class="form-group">
          <label>Medication Updates</label>
          <textarea name="medication_updates"></textarea>
        </div>
        <div class="form-group">
          <label>Recent Hospitalizations</label>
          <textarea name="hospitalizations"></textarea>
        </div>
        <div class="form-group">
          <label>Disabilities</label>
          <textarea name="disabilities"></textarea>
        </div>
      </div>
    </section>

    <section>
      <h2>Immunization Updates</h2>
      <div class="form-grid">
        <div class="form-group">
          <label>New Vaccines</label>
          <textarea name="new_vaccines"></textarea>
        </div>
        <div class="form-group">
          <label>Booster Doses</label>
          <textarea name="booster_doses"></textarea>
        </div>
        <div class="form-group full-width">
          <label>Vaccine Dates & Types</label>
          <textarea name="vaccine_dates"></textarea>
        </div>
      </div>
    </section>

    <section>
      <h2>Current Health</h2>
      <div class="form-grid">
        <div class="form-group">
          <label>Weight</label>
          <input type="text" name="weight">
        </div>
        <div class="form-group">
          <label>Height</label>
          <input type="text" name="height">
        </div>
        <div class="form-group">
          <label>Blood Pressure</label>
          <input type="text" name="blood_pressure">
        </div>
        <div class="form-group">
          <label>Temperature</label>
          <input type="text" name="temperature">
        </div>
        <div class="form-group full-width">
          <label>General Observations</label>
          <textarea name="observations"></textarea>
        </div>
      </div>
    </section>

    <section>
      <h2>Mental & Emotional Health</h2>
      <div class="form-grid">
        <div class="form-group">
          <label>Mood / Behavior Changes</label>
          <textarea name="mood_changes"></textarea>
        </div>
        <div class="form-group">
          <label>Incidents or Improvements</label>
          <textarea name="incidents"></textarea>
        </div>
        <div class="form-group">
          <label>New or Ongoing Referrals</label>
          <textarea name="referrals"></textarea>
        </div>
        <div class="form-group">
          <label>Social Interaction Notes</label>
          <textarea name="social_notes"></textarea>
        </div>
      </div>
    </section>

    <section>
      <h2>Follow-Up</h2>
      <div class="form-grid">
        <div class="form-group">
          <label>Referred to Clinic/Hospital?</label>
          <input type="text" name="referred">
        </div>
        <div class="form-group">
          <label>Referral Purpose</label>
          <textarea name="referral_purpose"></textarea>
        </div>
        <div class="form-group">
          <label>Next Appointment</label>
          <input type="date" name="next_appointment">
        </div>
      </div>
    </section>

    <section>
      <h2>Signatures</h2>
      <div class="form-grid">
        <div class="form-group">
          <label>Nurse Signature</label>
          <input type="text" name="nurse_signature">
        </div>
        <div class="form-group">
          <label>Social Worker Signature</label>
          <input type="text" name="social_signature">
        </div>
        <div class="form-group full-width">
          <label>Date of Completion</label>
          <input type="date" name="completion_date">
        </div>
      </div>
    </section>

    <div class="submit-section">
      <button type="submit">Submit Form</button>
    </div>
  </form>

</body>
</html>
