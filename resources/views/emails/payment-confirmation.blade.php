<!DOCTYPE html>
<html>

<body style="margin:0;padding:0;background-color:#f5f8fc;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#f5f8fc">
        <tr>
            <td align="center" style="padding:24px 12px;">

                <table role="presentation" width="600" cellpadding="0" cellspacing="0" border="0"
                    style="width:100%;max-width:600px;background-color:#ffffff;border:1px solid #d5dfec;">

                    <tr>
                        <td align="center" bgcolor="#083b78" style="background-color:#083b78;padding:28px 24px;">
                            <div
                                style="font-family:Arial,Helvetica,sans-serif;font-size:24px;font-weight:bold;color:#ffffff;">
                                DiCD2026 Delhi</div>
                            <div
                                style="font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#ffffff;margin-top:4px;">
                                The flagship conference of IAAD</div>
                            <div
                                style="font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#f2c65a;margin-top:14px;">
                                <strong>Theme:</strong> THE CLINICAL EDGE - Where Diagnosis Meets Practice</div>
                            <div
                                style="font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#ffffff;margin-top:8px;">
                                <strong>Venue:</strong> The Leela Ambience, Gurugram</div>
                            <div
                                style="font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#ffffff;margin-top:2px;">
                                <strong>Date:</strong> 19 - 21 December 2026</div>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#d69c1a" height="4"
                            style="background-color:#d69c1a;height:4px;font-size:0;line-height:0;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td style="padding:28px 28px 8px;font-family:Arial,Helvetica,sans-serif;">
                            <div style="font-size:22px;font-weight:bold;color:#083b78;">Registration confirmed</div>
                        </td>
                    </tr>

                    <tr>
                        <td
                            style="padding:8px 28px;font-family:Arial,Helvetica,sans-serif;font-size:15px;line-height:22px;color:#12243a;">
                            Hello, {{ $registration->user->title }} {{ $registration->user->name }}<br><br>
                            We have received your payment. Your registration for <strong>DiCD 2026</strong> is
                            confirmed.
                            Your receipt is attached to this email as a PDF.
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:12px 28px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                                bgcolor="#f5f8fc" style="background-color:#f5f8fc;border-left:4px solid #d69c1a;">
                                <tr>
                                    <td colspan="2"
                                        style="padding:14px 16px 6px;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:bold;letter-spacing:1px;color:#083b78;">
                                        PAYMENT DETAILS</td>
                                </tr>
                                <tr>
                                    <td width="150"
                                        style="padding:6px 16px;font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#65758b;">
                                        Registration no.</td>
                                    <td
                                        style="padding:6px 16px;font-family:Arial,Helvetica,sans-serif;font-size:14px;font-weight:bold;color:#12243a;">
                                        {{ $registration->registration_number }}</td>
                                </tr>
                                <tr>
                                    <td width="150"
                                        style="padding:6px 16px;font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#65758b;">
                                        Amount paid</td>
                                    <td
                                        style="padding:6px 16px;font-family:Arial,Helvetica,sans-serif;font-size:14px;font-weight:bold;color:#12243a;">
                                        ₹{{ number_format($registration->total) }} (incl. GST)</td>
                                </tr>
                                <tr>
                                    <td width="150"
                                        style="padding:6px 16px 14px;font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#65758b;">
                                        Payment reference</td>
                                    <td
                                        style="padding:6px 16px 14px;font-family:Arial,Helvetica,sans-serif;font-size:14px;font-weight:bold;color:#12243a;">
                                        {{ $registration->payment_reference }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:12px 28px 28px;">
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td bgcolor="#d69c1a" style="background-color:#d69c1a;">
                                        <a href="{{ url('/dashboard') }}"
                                            style="display:inline-block;padding:13px 28px;font-family:Arial,Helvetica,sans-serif;font-size:15px;font-weight:bold;color:#052a56;text-decoration:none;">Go
                                            to your dashboard</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td bgcolor="#083b78" align="center"
                            style="background-color:#083b78;padding:16px 24px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#ffffff;">
                            DiCD 2026 · The Clinical Edge
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>
</body>

</html>
