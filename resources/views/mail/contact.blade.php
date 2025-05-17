<div class="content">
    <h2>New Contact Inquiry Received</h2>

    <p>Hello Support Team,</p>

    <p>A new contact inquiry has been submitted through our website. Here are the details:</p>

    <div class="highlight-box">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 30%; padding: 8px 0; border-bottom: 1px solid #eee;"><strong>Inquiry ID:</strong></td>
                <td style="padding: 8px 0; border-bottom: 1px solid #eee;">{{ $inquiry->id }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; border-bottom: 1px solid #eee;"><strong>Name:</strong></td>
                <td style="padding: 8px 0; border-bottom: 1px solid #eee;">{{ $inquiry->name }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; border-bottom: 1px solid #eee;"><strong>Email:</strong></td>
                <td style="padding: 8px 0; border-bottom: 1px solid #eee;">{{ $inquiry->email }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; border-bottom: 1px solid #eee;"><strong>Subject:</strong></td>
                <td style="padding: 8px 0; border-bottom: 1px solid #eee;">{{ $inquiry->subject }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0;"><strong>Submitted at:</strong></td>
                <td style="padding: 8px 0;">    {{ \Carbon\Carbon::createFromFormat('d/m/Y', $inquiry->created_at)->format('F j, Y g:i a') }}</td>
            </tr>
        </table>
    </div>

    <div class="message-content" style="margin: 20px 0; padding: 15px; background: #f9f9f9; border-left: 4px solid #ddd;">
        <h3 style="margin-top: 0;">Message:</h3>
        <p style="white-space: pre-line;">{{ $inquiry->message }}</p>
    </div>

    <p>Please respond to this inquiry within 24-48 hours.</p>

    <p>Thank you,</p>
    <p>The Skillmate Team</p>
</div>

<div class="footer">
    <p>&copy; {{ date('Y') }} Skillmate. All rights reserved.</p>
</div>
