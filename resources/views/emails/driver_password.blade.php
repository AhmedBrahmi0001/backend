<!DOCTYPE html>
<html>

<head>
    <title>Your Driver Account Details</title>
</head>

<body>
    <p>Hello {{ $driverName }},</p>
    <p>Your driver account has been created successfully.</p>
    <p>Your login details are as follows:</p>
    <p>Email: {{ $email }}</p>
    <p>Password: {{ $password }}</p>
    <p>Please make sure to change your password after your first login.</p>
    <p>Thank you,</p>
    <p>Your Company Name</p>
</body>

</html>
