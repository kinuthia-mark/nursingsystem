<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Nursing DBMS</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome 4 (if still needed) -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- Optional: Custom external CSS -->
  <link rel="stylesheet" href="css/main.css">

  <!-- Bootstrap 5 JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Optional: jQuery if used elsewhere -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <style>
    body {
      font-family: Arial, sans-serif;
      background: #eafcff;
      padding: 30px;
    }

    .form-container {
      max-width: 60%;
      margin: auto;
      background-color: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .form-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
    }

    .form-title {
      color: #fff;
      text-shadow: 0 0 10px #00fff7, 0 0 20px #00fff7, 0 0 40px #00fff7;
      background: #00bcd4;
      text-align: center;
      border-radius: 8px;
      padding: 8px 0;
      margin-bottom: 16px;
      grid-column: 1 / -1;
    }

    h2 {
      text-align: center;
      margin-bottom: 25px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
    }

    input[type="text"],
    input[type="number"],
    input[type="date"],
    textarea,
    select {
      width: 100%;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }

    textarea {
      height: 80px;
      width: 100%;
      resize: vertical;
    }

    button {
      margin: 20px auto 0;
      display: block;
      width: 50%;
      padding: 12px;
      background-color: #007BFF;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
    }

    button:hover {
      background-color: #0056b3;
    }

    .top-right-link {
      text-align: right;
      margin-bottom: 10px;
    }
  </style>
</head>
