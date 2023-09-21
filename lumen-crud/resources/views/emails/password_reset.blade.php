<!-- resources/views/emails/password_reset.blade.php -->
<p>Hello,</p>
<p>You are receiving this email because we received a password reset request for your account.</p>
<p>Click the link below to reset your password:</p>
<p><a href="{{ $resetUrl }}">{{ $resetUrl }}</a></p>
<p>If you didn't request a password reset, please ignore this email.</p>
