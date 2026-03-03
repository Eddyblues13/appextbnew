<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appex Trust Bank</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f7f6;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333333;
            -webkit-font-smoothing: antialiased;
        }
        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #f4f7f6;
            padding-bottom: 60px;
        }
        .main {
            background-color: #ffffff;
            margin: 0 auto;
            width: 100%;
            max-width: 600px;
            border-spacing: 0;
            color: #333333;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            overflow: hidden;
            margin-top: 40px;
        }
        .header {
            text-align: center;
            padding: 30px;
            background-color: #ffffff;
            border-bottom: 2px solid #f2f2fd;
        }
        .header img {
            max-width: 180px;
            height: auto;
        }
        .content {
            padding: 40px;
            font-size: 16px;
            line-height: 1.6;
        }
        .footer {
            text-align: center;
            padding: 30px;
            font-size: 13px;
            color: #888888;
            background-color: #f4f7f6;
            max-width: 600px;
            margin: 0 auto;
        }
        .button {
            display: inline-block;
            background-color: #3037ff;
            color: #ffffff !important;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 6px;
            font-weight: 600;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .button:hover {
            background-color: #1a22d4;
        }
        .data-box {
            background: #f8f9fa;
            border: 1px solid #e1e5eb;
            border-radius: 6px;
            padding: 20px;
            margin: 25px 0;
        }
        .data-box p {
            margin-bottom: 10px;
            margin-top: 0;
        }
        .data-box p:last-child {
            margin-bottom: 0;
        }
        .text-center {
            text-align: center;
        }
        .amount-highlight {
            font-size: 32px;
            font-weight: bold;
            color: #3037ff;
            margin: 15px 0;
        }
        h1, h2, h3 {
            color: #111111;
            margin-top: 0;
            margin-bottom: 20px;
        }
        p {
            margin-bottom: 20px;
        }
        a {
            color: #3037ff;
        }
        .security-tips {
            font-size: 14px;
            color: #666666;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e1e5eb;
        }
        .security-tips ul {
            padding-left: 20px;
            margin-bottom: 0;
        }
        .security-tips li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <table class="main" width="100%">
            <tr>
                <td class="header">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('uploads/logo.png') }}" alt="Appex Trust Bank">
                    </a>
                </td>
            </tr>
            <tr>
                <td class="content">
                    @yield('content')
                </td>
            </tr>
        </table>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Appex Trust Bank. All Rights Reserved.</p>
            <p>
                <a href="mailto:support@appextb.com" style="color: #888888; text-decoration: none;">support@appextb.com</a>
            </p>
        </div>
    </div>
</body>
</html>
