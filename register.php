<?php 
session_start();
include("connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            width: 400px;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input[type="text"],
        input[type="password"],
        input[type="email"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            margin-bottom: 10px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .btn-container {
            display: flex;
            justify-content: space-between;
        }

        p {
            text-align: center;
            margin-top: 10px;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
    <script>
        function toggleFields() {
            var role = document.getElementById("role").value;
            var subjectField = document.getElementById("subject-field");
            var gradeField = document.getElementById("grade-field");
            
            if (role === "Teacher") {
                subjectField.style.display = "block";
                gradeField.style.display = "block";
            } else if (role === "Admin") {
                subjectField.style.display = "none";
                gradeField.style.display = "none";
            }
        }
    </script>
</head>
<body>
    <div class="register-container">
        <form method="POST">
            <a href="../home/login.php">Back</a>
            <h1>Create Account</h1>
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="address" placeholder="Email Address" required>
            <select name="role" id="role" onchange="toggleFields()" required>
                <option value="">Select Role</option>
                <option value="Admin">Admin</option>
                <option value="Teacher">Teacher</option>
            </select>
            <div id="subject-field">
                <input type="text" name="subject" placeholder="Subject">
            </div>
            <div id="grade-field">
                <input type="text" name="gradelevelclass" placeholder="Grade Level/Class">
            </div>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" name="submit" value="Submit">
        </form>
        
        <?php 
        if(isset($_POST["submit"])){
            $fullname = $_POST["name"];
            $address = $_POST["address"];
            $role = $_POST["role"];
            $username = $_POST["username"];
            $password = $_POST["password"];
            $subject = isset($_POST["subject"]) ? $_POST["subject"] : null;
            $gradelevelclass = isset($_POST["gradelevelclass"]) ? $_POST["gradelevelclass"] : null;

            // Validate if all required fields are filled
            if(empty($fullname) || empty($address) || empty($role) || empty($username) || empty($password)){
                echo "<p style='color: red;'>Error: Please fill in all required fields.</p>";
            } else {
                // Proceed with database insertion
                $sql_create = "INSERT INTO USER (NAME, ADDRESS, PASSWORD, USERNAME, ROLE, SUBJECT, GRADELEVELCLASS) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $statement = mysqli_stmt_init($connection);
                if(mysqli_stmt_prepare($statement, $sql_create)){
                    mysqli_stmt_bind_param($statement, "sssssss", $fullname, $address, $password, $username, $role, $subject, $gradelevelclass);
                    mysqli_stmt_execute($statement);
                    echo "<p style='color: green;'>Successfully Registered!</p>";
                    header("refresh:1;url=../home/login.php"); // Redirect after 1 second
                    exit(); // Stop further execution
                } else {
                    echo "<p style='color: red;'>Error: Could not prepare statement.</p>";
                }
            }
        }
        ?>
    </div>
</body>
</html>
