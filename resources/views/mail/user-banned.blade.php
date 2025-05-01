
<div class="content">
    <h2>Account Suspension Notice</h2>

    <p>Dear {{ $user->username }},</p>

    <p>We regret to inform you that your account has been temporarily suspended due to a violation of our terms of service.</p>

    <p><strong>Reason for suspension:</strong> Multiple violations of our community guidelines.</p>

    <p>If you believe this action was taken in error, or if you would like to appeal this decision, please contact our support team.</p>

    <div style="text-align: center; margin: 25px 0;">
        <a href="{{ url('/contact') }}" class="button">Contact Support</a>
    </div>

    <p>Please include any relevant information that may help us review your case.</p>

    <p>Thank you for your understanding.</p>
</div>

<div class="footer">
    <p>&copy; {{ date('Y') }} SkillMAte. All rights reserved.</p>
</div>
