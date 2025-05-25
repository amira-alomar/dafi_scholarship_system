<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Exam Invitation</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 40px; color: #333;">

  <div style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 10px; box-shadow: 0 0 15px rgba(0,0,0,0.1); padding: 30px;">
    
    <h1 style="color: #0056b3;">Hello {{ $applicant->fname }},</h1>

    <p style="font-size: 16px;">We’re pleased to inform you that you’ve been invited to take your upcoming exam. Below are the details:</p>

    <table style="width: 100%; margin-top: 20px; border-collapse: collapse;">
      <tr>
        <td style="padding: 10px 0; font-weight: bold;">📅 Exam Date & Time:</td>
        <td style="padding: 10px 0;">{{ date('F j, Y \a\t g:i A', strtotime($examDate)) }}</td>
      </tr>
      <tr>
        <td style="padding: 10px 0; font-weight: bold;">📘 Subject:</td>
        <td style="padding: 10px 0;">{{ $examSubject }}</td>
      </tr>
      @if($examDetails)
      <tr>
        <td style="padding: 10px 0; font-weight: bold; vertical-align: top;">📝 Details:</td>
        <td style="padding: 10px 0;">{!! nl2br(e($examDetails)) !!}</td>
      </tr>
      @endif
    </table>

    <p style="margin-top: 30px; font-size: 16px;">Please make sure to arrive on time and bring any necessary materials.</p>

    <p style="margin-top: 20px;">Best of luck!<br><strong>The Examination Committee</strong></p>

  </div>

</body>
</html>
