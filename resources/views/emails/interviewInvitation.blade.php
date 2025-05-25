<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Interview Invitation</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="padding: 40px 10px;">
                <table width="600" cellpadding="0" cellspacing="0"
                    style="background-color: #ffffff; border-radius: 10px; padding: 30px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                    <tr>
                        <td align="center" style="padding-bottom: 20px;">
                            <h1 style="color: #2c3e50;">Hello {{ $applicant->fname }},</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="color: #333333; font-size: 16px; line-height: 1.6;">
                            <p>Your interview has been scheduled for
                                <strong
                                    style="color: #2980b9;">{{ date('F j, Y \a\t g:i A', strtotime($date)) }}</strong>
                                at <strong style="color: #2980b9;">{{ $location }}</strong>.
                            </p>

                            @if ($details)
                                <p style="margin-top: 15px;">
                                    <strong style="color: #2c3e50;">Details:</strong><br>
                                    <span style="white-space: pre-line;">{!! nl2br(e($details)) !!}</span>
                                </p>
                            @endif

                            <p style="margin-top: 30px;">
                                Wishing you the best of luck!<br>
                                <strong style="color: #27ae60;">See you then!</strong>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding-top: 30px;">
                            <p style="font-size: 12px; color: #999999;">This is an automated message. Please do not
                                reply.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
