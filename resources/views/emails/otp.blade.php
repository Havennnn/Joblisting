<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your OTP Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4a6cf7;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 20px;
            background-color: #f9f9f9;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #777;
        }
        .otp-box {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
            font-size: 24px;
            letter-spacing: 5px;
            font-weight: bold;
        }
        .btn {
            display: inline-block;
            background-color: #4a6cf7;
            color: #ffffff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>One-Time Password</h1>
        </div>

        <div class="content">
            <p>Hello,</p>

            <p>Your one-time password (OTP) for verification is:</p>

            <div class="otp-box">{{ $otp }}</div>

            <p>This code will expire in 10 minutes.</p>

            <p>If you did not request this code, please ignore this email.</p>

        </div>

        <div class="footer">
            <p>This is an automated email. Please do not reply.</p>
            <p>© 2025 NKS Virtual Job Fair. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
