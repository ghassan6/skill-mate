<link rel="stylesheet" href="{{asset('css/mails/ban.css')}}">
<div class="content">
    <h2>Account Restored Successfully</h2>

    <p>Dear {{ $user->username }},</p>

    <p>We're pleased to inform you that after reviewing your appeal, we've decided to restore your account.</p>

    <div class="highlight-box">
        <p><strong>Your account ban has been lifted</strong> and you can now access all features again.</p>
    </div>

    <p>We appreciate your patience during this process and we're glad to have you back in our community.</p>

    <div style="text-align: center; margin: 25px 0;">
        <a href="{{ url('/login') }}" class="button">Sign In to Your Account</a>
    </div>

    <p>As a reminder, please review our <a href="{{ url('/legal/terms-and-conditions') }}">Terms of Service</a>  to ensure a positive experience for all users.</p>

    <p>If you have any questions or need further assistance, please don't hesitate to contact our support team.</p>

    <p>Welcome back!</p>
</div>

<div class="footer">
    <p>&copy; {{ date('Y') }} Skillmate. All rights reserved.</p>

</div>
