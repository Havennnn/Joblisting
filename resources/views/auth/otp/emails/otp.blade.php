<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your OTP Code</title>
</head>
<body style="font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; color: #1F2937; line-height: 1.5; margin: 0; padding: 0; background-color: #f3f4f6;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <!-- Header -->
        <div style="background-color: #2563EB; color: white; padding: 24px; text-align: center; border-radius: 8px 8px 0 0;">
            <h1 style="margin: 0; font-size: 24px; font-weight: 700;">One-Time Password</h1>
        </div>

        <!-- Content -->
        <div style="background-color: white; padding: 24px; border-radius: 0 0 8px 8px; border: 1px solid #E5E7EB; border-top: none;">
            <p style="margin-bottom: 16px;">Hello,</p>

            <p style="margin-bottom: 16px;">You requested to change your email address. Your verification code is:</p>

            <div style="background-color: #F9FAFB; border: 1px solid #E5E7EB; border-radius: 6px; padding: 16px; margin: 20px 0; text-align: center; font-size: 24px; font-weight: 700; letter-spacing: 5px;">{{ $otp }}</div>

            <p style="margin-bottom: 16px;">Please enter this code on the verification page to complete your email change.</p>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ $url }}" style="display: inline-block; background-color: #2563EB; color: white; font-weight: 600; text-decoration: none; padding: 12px 24px; border-radius: 6px; text-align: center;">Go to Verification Page</a>
            </div>

            <p style="margin-bottom: 16px;">This code will expire in 10 minutes.</p>

            <p style="margin-bottom: 16px;">If you did not request this code, please ignore this email.</p>
        </div>

        <!-- Footer -->
        <div style="text-align: center; padding: 20px; font-size: 14px; color: #6B7280;">
            <p style="margin-bottom: 8px;">This is an automated email. Please do not reply.</p>
            <p style="margin: 0;">© {{ date('Y') }} NKS Virtual Job Fair. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
