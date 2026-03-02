<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:v="urn:schemas-microsoft-com:vml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0; maximum-scale=1.0;" />
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,700" rel="stylesheet">
    <title>Welcome to Appex Trust Bank</title>
    <style type="text/css">
        body { width: 100%; background-color: #f4f7f6; margin: 0; padding: 0; -webkit-font-smoothing: antialiased; }
        p, h1, h2, h3, h4 { margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; }
        html { width: 100%; }
        table { font-size: 14px; border: 0; }
        
        .container590 { width: 590px; margin: 0 auto; background: #ffffff; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .header-bg { background: #3037ff; border-top-left-radius: 8px; border-top-right-radius: 8px; padding: 30px; text-align: center; }
        .content-area { padding: 40px; color: #51545E; font-family: "Work Sans", Calibri, sans-serif; line-height: 24px; }
        .account-box { background: #f8f9fa; border: 1px solid #e1e5eb; border-radius: 6px; padding: 20px; margin: 25px 0; text-align: center; }
        .account-label { font-size: 12px; text-transform: uppercase; color: #888; letter-spacing: 1px; font-weight: 600; margin-bottom: 10px; display: block; }
        .account-number { font-size: 28px; color: #3037ff; font-weight: 700; font-family: "Quicksand", sans-serif; letter-spacing: 2px; }
        
        .login-btn { display: inline-block; background: #c92041; color: #ffffff !important; text-decoration: none; padding: 12px 30px; border-radius: 4px; font-weight: 600; margin-top: 20px; }
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
                            <h2 style="color: #333; font-size: 22px; font-weight: 600; margin-bottom: 20px;">Welcome to Appex Trust Bank!</h2>
                            
                            <p style="font-size: 16px; margin-bottom: 15px;">Hello {{ $user->name }},</p>
                            
                            <p style="font-size: 16px; margin-bottom: 20px;">
                                We are thrilled to have you on board. Your account has been successfully created. You can now log in to manage your finances, make transfers, and access all our premium banking services.
                            </p>
                            
                            <div class="account-box">
                                <span class="account-label">Your New Account Number</span>
                                <div class="account-number">{{ $user->account_number }}</div>
                            </div>
                            
                            <div style="text-align: center; margin: 30px 0;">
                                <a href="{{ route('login') }}" class="login-btn">Login to Your Account</a>
                            </div>
                            
                            <p style="font-size: 15px; margin-top: 30px;">
                                If you did not create this account, please contact our support team immediately.
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
