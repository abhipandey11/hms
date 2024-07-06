<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Receipt - Hospital Management System</title>
    <link rel="stylesheet" href="l_style.css">
</head>
<body>
    <div class="receipt-container">
        <h2>Appointment Receipt</h2>
        <table border='1'>
            <tr>
                <th>Field</th>
                <th>Value</th>
            </tr>
            <tr>
                <td>Appointment ID</td>
                <td><?php echo $_GET['appointment_id']; ?></td>
            </tr>
            <tr>
                <td>Patient ID</td>
                <td><?php echo $_GET['patient_id']; ?></td>
            </tr>
            <tr>
                <td>Doctor ID</td>
                <td><?php echo $_GET['doctor_id']; ?></td>
            </tr>
            <tr>
                <td>Date</td>
                <td><?php echo $_GET['date']; ?></td>
            </tr>
            <tr>
                <td>Time From</td>
                <td><?php echo $_GET['time_from']; ?></td>
            </tr>
            <tr>
                <td>Time To</td>
                <td><?php echo $_GET['time_to']; ?></td>
            </tr>
        </table>

        

        <a href="appointments.php" class="appointments-btn">Go To Appointment's Page</a>
    </div>
</body>
</html>
