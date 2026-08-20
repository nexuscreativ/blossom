<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Message Notification</title>
</head>
<body style="margin:0;padding:0;background:#f6f2f7;font-family:Inter,Arial,sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="padding:40px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background:#ffffff;border-radius:16px;overflow:hidden;border:1px solid #e8e0ea;">
                    <tr>
                        <td style="background:#5B2C6F;padding:28px 32px;">
                            <h1 style="margin:0;color:#ffffff;font-size:22px;letter-spacing:1px;">{{ $siteName ?? 'BLOSSOM' }} — Contact Message</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:32px;">
                            <p style="margin:0 0 16px;color:#3d3d3d;font-size:15px;line-height:1.6;"><strong>From:</strong> {{ $name }} &lt;{{ $email }}&gt;</p>
                            <p style="margin:0 0 16px;color:#3d3d3d;font-size:15px;line-height:1.6;"><strong>Topic:</strong> {{ $topic }}</p>
                            <div style="margin:0 0 24px;padding:16px 20px;background:#faf8fb;border-left:3px solid #5B2C6F;border-radius:8px;">
                                <p style="margin:0;color:#3d3d3d;font-size:15px;line-height:1.7;white-space:pre-line;">{{ $message }}</p>
                            </div>
                            <p style="margin:0;color:#999;font-size:13px;">Sent via the BLOSSOM contact form.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>