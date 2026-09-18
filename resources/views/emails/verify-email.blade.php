<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Mail Bestätigung</title>
</head>
<body style="margin:0; padding:0; background-color:#fbf1ef; font-family:Segoe UI, Helvetica, Arial, sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#fbf1ef; padding:24px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px; width:100%; background-color:#ffffff; border-radius:24px; overflow:hidden; box-shadow:0 10px 25px rgba(67,32,24,0.15);">
                    <!-- Header -->
                    <tr>
                        <td style="background-color:#432018; padding:24px; text-align:center; border-radius:16px; margin:8px;">
                            <img src="{{ asset('storage/images/idf-logo.png') }}" alt="Islamische Denkfabrik Logo" height="56" style="height:56px; border-radius:8px;">
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:40px 32px;">
                            <h1 style="margin:0 0 8px; font-size:24px; font-weight:700; color:#5a2a1d; text-align:center;">
                                E-Mail Bestätigung
                            </h1>
                            <p style="margin:0 0 24px; font-size:14px; color:#737373; text-align:center;">
                                Bestätigen Sie Ihre E-Mail-Adresse
                            </p>

                            <p style="margin:0 0 16px; font-size:15px; line-height:1.6; color:#404040;">
                                Hallo {{ $user->name }},
                            </p>
                            <p style="margin:0 0 24px; font-size:15px; line-height:1.6; color:#404040;">
                                vielen Dank für Ihre Registrierung bei der Islamischen Denkfabrik! Bitte bestätigen Sie Ihre E-Mail-Adresse, indem Sie auf den folgenden Button klicken.
                            </p>

                            <table role="presentation" cellpadding="0" cellspacing="0" style="margin:0 auto 24px;">
                                <tr>
                                    <td align="center" style="border-radius:12px; background-color:#ac4f3a;">
                                        <a href="{{ $url }}" target="_blank" style="display:inline-block; padding:14px 32px; font-size:15px; font-weight:600; color:#ffffff; text-decoration:none; border-radius:12px;">
                                            E-Mail-Adresse bestätigen
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:0 0 8px; font-size:13px; line-height:1.6; color:#737373;">
                                Falls der Button nicht funktioniert, kopieren Sie bitte den folgenden Link in Ihren Browser:
                            </p>
                            <p style="margin:0 0 24px; font-size:13px; line-height:1.6; word-break:break-all;">
                                <a href="{{ $url }}" style="color:#ac4f3a;">{{ $url }}</a>
                            </p>

                            <p style="margin:0; font-size:13px; line-height:1.6; color:#a3a3a3;">
                                Wenn Sie kein Konto erstellt haben, ist keine weitere Aktion erforderlich.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color:#432018; padding:24px 32px; text-align:center;">
                            <p style="margin:0 0 8px; font-size:13px; color:#ffffff;">
                                <a href="https://islamischedenkfabrik.de/datenschutzerklaerung/" style="color:#ffffff; text-decoration:underline;">Datenschutz</a>
                            </p>
                            <p style="margin:0; font-size:12px; color:#fbf1ef;">
                                Islamische Denkfabrik e.V.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
