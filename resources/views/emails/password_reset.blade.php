<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:v="urn:schemas-microsoft-com:vml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0; maximum-scale=1.0;" />
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,700" rel="stylesheet">
    <title>Reset Your Password - Appex Trust Bank</title>
    <style type="text/css">
        body { width: 100%; background-color: #f4f7f6; margin: 0; padding: 0; -webkit-font-smoothing: antialiased; }
        p, h1, h2, h3, h4 { margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; }
        html { width: 100%; }
        table { font-size: 14px; border: 0; }
        .container590 { width: 590px; margin: 0 auto; background: #ffffff; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .header-bg { background: #3037ff; border-top-left-radius: 8px; border-top-right-radius: 8px; padding: 30px; text-align: center; }
        .content-area { padding: 40px; color: #51545E; font-family: "Work Sans", Calibri, sans-serif; line-height: 24px; }
        .reset-btn { display: inline-block; background: #3037ff; color: #ffffff !important; text-decoration: none; padding: 14px 35px; border-radius: 4px; font-weight: 600; font-size: 16px; margin-top: 10px; }
        .footer-area { padding: 30px; text-align: center; color: #888888; font-size: 12px; font-family: "Work Sans", Calibri, sans-serif; background: #f4f7f6; }
        @media only screen and (max-width: 640px) {
            .container590 { width: 100% !important; border-radius: 0; }
            .header-bg { border-radius: 0; }
            .content-area { padding: 20px; }
        }
    </style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="#f4f7f6" style="padding: 40px 0;">
        <tr>
            <td align="center">
                <table border="0" width="590" cellpadding="0" cellspacing="0" class="container590">
                    <tr>
                        <td class="header-bg">
                            <h1 style="color: #ffffff; font-family: 'Quicksand', sans-serif; font-size: 24px; margin: 0;">Appex Trust Bank</h1>
                        </td>
                    </tr>
                    <tr>
                        <td class="content-area">
                            <h2 style="color: #333; font-size: 22px; font-weight: 600; margin-bottom: 20px;">Password Reset Request</h2>

                            <p style="font-size: 16px; margin-bottom: 15px;">Hello,</p>

                            <p style="font-size: 16px; margin-bottom: 20px;">
                                We received a request to reset your password. Click the button below to set a new password. This link will expire in 60 minutes.
                            </p>

                            <div style="text-align: center; margin: 30px 0;">
                                <a href="{{ $url }}" class="reset-btn">Reset Password</a>
                            </div>

                            <p style="font-size: 14px; color: #888; margin-top: 25px;">
                                If you did not request a password reset, no further action is required. Your password will remain unchanged.
                            </p>

                            <p style="font-size: 14px; color: #888; margin-top: 15px;">
                                If the button above doesn't work, copy and paste this link into your browser:<br>
                                <a href="{{ $url }}" style="color: #3037ff; word-break: break-all;">{{ $url }}</a>
                            </p>

                            <p style="font-size: 16px; margin-top: 25px; font-weight: 500;">
                                Best Regards,<br>
                                <span style="color: #3037ff; font-weight: 600;">Appex Trust Bank Team</span>
                            </p>
                        </td>
                    </tr>
                </table>

                <table border="0" width="590" cellpadding="0" cellspacing="0" class="container590" style="background: transparent; box-shadow: none;">
                    <tr>
                        <td class="footer-area">
                            <p>&copy; {{ date('Y') }} Appex Trust Bank. All Rights Reserved.</p>
                            <p style="margin-top: 10px;">
                                <a href="mailto:support@appextb.com" style="color: #666; text-decoration: none;">support@appextb.com</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
