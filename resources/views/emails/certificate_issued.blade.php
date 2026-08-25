<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Your Certificate is Ready</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f9fafb; color: #111827; line-height: 1.6; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .header { background-color: #8B0000; padding: 30px 20px; text-align: center; }
        .header img { height: 50px; }
        .content { padding: 40px 30px; }
        .btn { display: inline-block; background-color: #8B0000; color: #ffffff; text-decoration: none; padding: 12px 24px; border-radius: 6px; font-weight: 600; margin-top: 20px; }
        .footer { background-color: #f3f4f6; padding: 20px; text-align: center; font-size: 12px; color: #6b7280; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="color: white; margin: 0; font-family: serif;">Umera Business School</h1>
        </div>
        
        <div class="content">
            <h2 style="margin-top: 0;">Congratulations, {{ $certificate->recipient_name }}!</h2>
            
            <p>We are pleased to inform you that you have successfully completed the <strong>{{ $certificate->course_name }}</strong> course.</p>
            
            <p>Your official, verifiable digital certificate is now available to view, download, and share.</p>
            
            <p><strong>Certificate ID:</strong> {{ $certificate->certificate_number }}</p>
            
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/certificate/' . $certificate->certificate_number) }}" class="btn">View Your Certificate</a>
            </div>
            
            <p>You can also attach this certificate to your LinkedIn profile or share it directly with employers.</p>
            
            <p>Best regards,<br>The Umera Business School Team</p>
        </div>
        
        <div class="footer">
            &copy; {{ date('Y') }} Umera Business School. All rights reserved.<br>
            If you have any questions, please contact us at support@umera.ng.
        </div>
    </div>
</body>
</html>
