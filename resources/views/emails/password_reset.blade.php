<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin-bottom: 25px;">
    <h3>Dear {{ $name }},</h3>
    <p>Forget your account password. Don't worry click the button (Reset Password) below and reset your password</p>
    <a style="background: #1490d8;padding: 10px;border-radius: 4px;font-weight: bold;color: #fff;text-decoration: none;" href="{{ URL::route('resetPasswordForm') }}?token={{ $token }}">Reset Password</a>
</body>
</html>