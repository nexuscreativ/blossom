<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsletter Confirmation</title>
</head>
<body style="margin:0;padding:0;background:#f6f2f7;font-family:Inter,Arial,sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="padding:40px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background:#ffffff;border-radius:16px;overflow:hidden;border:1px solid #e8e0ea;">
                    <tr>
                        <td style="background:#5B2C6F;padding:28px 32px;">
                            <h1 style="margin:0;color:#ffffff;font-size:22px;letter-spacing:1px;">{{ $siteName }}</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:32px;">
                            <h2 style="margin:0 0 16px;color:#5B2C6F;font-size:20px;">You're on the list!</h2>
                            <p style="margin:0 0 16px;color:#3d3d3d;font-size:15px;line-height:1.7;">Thank you for subscribing to {{ $siteName }} ({{ $email }}). You'll receive the best stories, news, and insights from BLOSSOM.</p>
                            <p style="margin:0;color:#999;font-size:13px;">You can unsubscribe at any time using the link in our emails.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>