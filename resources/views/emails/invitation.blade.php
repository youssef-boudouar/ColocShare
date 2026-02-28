<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body style="margin: 0; padding: 0; background-color: #f9fafb; font-family: Arial, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f9fafb; padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="500" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 12px; padding: 40px; border: 1px solid #e5e7eb;">
                    <tr>
                        <td style="text-align: center;">
                            <h1 style="color: #10b981; font-size: 24px; margin: 0 0 24px 0;">ColocShare</h1>
                            <p style="color: #111827; font-size: 16px; margin: 0 0 16px 0;">Bonjour !</p>
                            <p style="color: #374151; font-size: 14px; line-height: 1.6; margin: 0 0 24px 0;">
                                Vous avez été invité à rejoindre la colocation <strong>{{ $colocation->name }}</strong> sur ColocShare.
                            </p>
                            <a href="{{ $url }}"
                               style="display: inline-block; background-color: #10b981; color: #ffffff; text-decoration: none; font-weight: bold; font-size: 14px; padding: 12px 32px; border-radius: 8px;">
                                Rejoindre la colocation
                            </a>
                            <p style="color: #9ca3af; font-size: 12px; margin: 32px 0 0 0;">
                                Si vous n'avez pas demandé cette invitation, ignorez cet email.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
