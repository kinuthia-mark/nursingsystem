<?php
// regimen_form.php
include 'dbconnect.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $patient_name = $_POST["patientName"];
  $medication = $_POST["medication"];
  $dosage = $_POST["dosage"];
  $frequency = $_POST["frequency"];
  $route = $_POST["route"];
  $start_date = $_POST["startDate"];
  $end_date = $_POST["endDate"];
  $doctor = $_POST["doctor"];
  $notes = $_POST["notes"];

  $stmt = $conn->prepare("INSERT INTO treatment_regimen (
    patient_name, medication, dosage, frequency, route,
    start_date, end_date, doctor, notes
  ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

  $stmt->bind_param(
    "sssssssss",
    $patient_name, $medication, $dosage, $frequency, $route,
    $start_date, $end_date, $doctor, $notes
  );

  if ($stmt->execute()) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
          <script>
            Swal.fire({
              title: 'Success!',
              text: 'Regimen added successfully.',
              icon: 'success',
              confirmButtonText: 'OK'
            }).then(() => {
              window.location.href = 'regimen_form.php';
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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Regimen Form & Table</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #eef2f7;
      padding: 20px;
    }

    .form-container, .table-container {
      max-width: 900px;
      margin: auto;
      background: #fff;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      margin-bottom: 40px;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-top: 10px;
      font-weight: bold;
    }

    input, select, textarea {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .btn {
      background: #28a745;
      color: #fff;
      padding: 10px;
      margin-top: 15px;
      border: none;
      width: 100%;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
    }

    .btn:hover {
      background: #218838;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      border: 1px solid #ccc;
      padding: 8px;
      text-align: left;
    }

    th {
      background: #007bff;
      color: white;
    }

    tr:nth-child(even) {
      background: #f2f2f2;
    }
  </style>
</head>
<body>

<div class="form-container">
  <h2>Treatment Regimen Form</h2>
  <form method="post" action="regimen_form.php">
    <label for="patientName">Patient Name</label>
    <input type="text" id="patientName" name="patientName" required>

    <label for="medication">Medication Name</label>
    <input type="text" id="medication" name="medication" required>

    <label for="dosage">Dosage (e.g., 250mg)</label>
    <input type="text" id="dosage" name="dosage" required>

    <label for="frequency">Frequency</label>
    <select id="frequency" name="frequency" required>
      <option value="">--Select Frequency--</option>
      <option value="Once a day">Once a day</option>
      <option value="Twice a day">Twice a day</option>
      <option value="Every 8 hours">Every 8 hours</option>
      <option value="As needed">As needed</option>
    </select>

    <label for="route">Route</label>
    <select id="route" name="route" required>
      <option value="">--Select Route--</option>
      <option value="Oral">Oral</option>
      <option value="Injection">Injection</option>
      <option value="IV Drip">IV Drip</option>
      <option value="Topical">Topical</option>
    </select>

    <label for="startDate">Start Date</label>
    <input type="date" id="startDate" name="startDate" required>

    <label for="endDate">End Date</label>
    <input type="date" id="endDate" name="endDate" required>

    <label for="doctor">Prescribing Doctor</label>
    <input type="text" id="doctor" name="doctor" required>

    <label for="notes">Additional Notes</label>
    <textarea id="notes" name="notes" rows="3"></textarea>

    <button type="submit" class="btn">Save Regimen</button>
  </form>
</div>

<div class="table-container">
  <h2>All Saved Treatment Regimens</h2>
  <table>
    <thead>
      <tr>
        <th>Patient</th>
        <th>Medication</th>
        <th>Dosage</th>
        <th>Frequency</th>
        <th>Route</th>
        <th>Start</th>
        <th>End</th>
        <th>Doctor</th>
        <th>Notes</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Fetch regimens
      $result = $conn->query("SELECT * FROM treatment_regimen ORDER BY start_date DESC");

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "<tr>
            <td>" . htmlspecialchars($row['patient_name']) . "</td>
            <td>" . htmlspecialchars($row['medication']) . "</td>
            <td>" . htmlspecialchars($row['dosage']) . "</td>
            <td>" . htmlspecialchars($row['frequency']) . "</td>
            <td>" . htmlspecialchars($row['route']) . "</td>
            <td>" . htmlspecialchars($row['start_date']) . "</td>
            <td>" . htmlspecialchars($row['end_date']) . "</td>
            <td>" . htmlspecialchars($row['doctor']) . "</td>
            <td>" . htmlspecialchars($row['notes']) . "</td>
          </tr>";
        }
      } else {
        echo "<tr><td colspan='9'>No regimens found.</td></tr>";
      }

      $conn->close();
      ?>
    </tbody>
  </table>
</div>

</body>
</html>
