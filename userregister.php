<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 50px;
        }

        .form-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            max-width: 400px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-container label {
            display: block;
            margin-bottom: 8px;
        }

        .form-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-container button {
            width: 100%;
            padding: 10px;
            background: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-container button:hover {
            background: #0056b3;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>User Registration</h2>
        <form action="userregister.php" method="post">
            <label for="username">Full Name</label>
            <input type="text" id="username" name="username" required>

            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <button type="submit">Register</button>
        </form>
    </div>
</body>

</html>

<?php
// Database connection settings
$servername = "localhost";   // usually localhost
$username   = "root";        // your MySQL username
$password   = "";            // your MySQL password
$dbname     = "mydatabase";  // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

// Collect form data
$name     = $_POST['username'];
$email    = $_POST['email'];
$password = $_POST['password'];
$confirm  = $_POST['confirm_password'];

// Basic validation
if ($password !== $confirm) {
    die("Passwords do not match!");
    }

// Hash the password for security
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Prepare SQL statement
$stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $hashedPassword);

// Execute and check
if ($stmt->execute()) {
    echo "Registration successful!";
    }
else {
    echo "Error: " . $stmt->error;
    }

// Close connections
$stmt->close();
$conn->close();
?>
<?php
// Database connection settings
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "mydatabase";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

// Query to get all users
$sql    = "SELECT id, name, email FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registered Users</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 50px;
        }

        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }

        th {
            background: #007BFF;
            color: #fff;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }
    </style>
</head>

<body>
    <h2 style="text-align:center;">Registered Users</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            // Output each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td>" . $row["name"] . "</td>
                    <td>" . $row["email"] . "</td>
                  </tr>";
                }
            }
        else {
            echo "<tr><td colspan='3'>No users found</td></tr>";
            }
        $conn->close();
        ?>
    </table>
</body>

</html>