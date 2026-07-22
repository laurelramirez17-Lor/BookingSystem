<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking Confirmation</title>
</head>
<body style="margin:0; padding:0; background:#f3f0e8; color:#1f2937; font-family:Arial, Helvetica, sans-serif;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f3f0e8; padding:24px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:720px; background:#ffffff; border:1px solid #e5d8a8; border-radius:10px; overflow:hidden;">
                    <tr>
                        <td style="background:#111111; padding:28px 24px; text-align:center;">
                            <div style="color:#FFD700; font-size:28px; font-weight:800; letter-spacing:4px;">{{ strtoupper($hotelName) }}</div>
                            <div style="color:#f8f0c7; font-size:13px; margin-top:8px; letter-spacing:1px;">Official Confirmed Reservation</div>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:28px 24px;">
                            <p style="margin:0 0 14px; font-size:16px;">Dear {{ $booking->customer_name }},</p>
                            <p style="margin:0 0 22px; line-height:1.7; font-size:15px;">
                                Your reservation has been approved and confirmed. We look forward to welcoming you to {{ $hotelName }}.
                            </p>

                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin-bottom:22px;">
                                <tr>
                                    <td style="background:#fff8dc; border:1px solid #ead58a; padding:16px;">
                                        <div style="font-size:12px; color:#8a6500; font-weight:800; letter-spacing:1px; text-transform:uppercase;">Booking ID</div>
                                        <div style="font-size:24px; color:#111; font-weight:800; margin-top:6px;">{{ $booking->booking_reference }}</div>
                                    </td>
                                </tr>
                            </table>

                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                                @php
                                    $rows = [
                                        ['Full Name', $booking->customer_name],
                                        ['Email Address', $booking->email],
                                        ['Room Name', $booking->roomName()],
                                        ['Room Type', $booking->room?->room_type ?? 'Hotel Room'],
                                        ['Number of Guests', $booking->number_of_guests],
                                        ['Check-in Date', optional($booking->booking_date)->format('F d, Y')],
                                        ['Check-out Date', optional($booking->checkout_date)->format('F d, Y')],
                                        ['Number of Nights', $booking->numberOfNights()],
                                        ['Total Price', $booking->formattedTotalPrice()],
                                        ['Payment Status', $booking->paymentStatusLabel()],
                                        ['Booking Status', $booking->bookingStatusLabel()],
                                        ['Booking Date & Time', optional($booking->created_at)->format('F d, Y h:i A')],
                                    ];
                                @endphp

                                @foreach($rows as [$label, $value])
                                    <tr>
                                        <td style="width:42%; padding:12px 10px; border-bottom:1px solid #eee2b8; color:#8a6500; font-size:12px; font-weight:800; text-transform:uppercase; letter-spacing:.8px;">{{ $label }}</td>
                                        <td style="padding:12px 10px; border-bottom:1px solid #eee2b8; color:#111827; font-size:15px; font-weight:600;">{{ $value ?: 'N/A' }}</td>
                                    </tr>
                                @endforeach
                            </table>

                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="margin-top:24px;">
                                <tr>
                                    <td style="background:#111111; border-radius:8px; padding:18px; color:#f8f0c7;">
                                        <div style="font-weight:800; color:#FFD700; margin-bottom:8px;">Front Desk Verification</div>
                                        <div style="line-height:1.6; font-size:14px;">Use the booking ID above or scan the QR code below to verify this reservation.</div>
                                        <div style="margin-top:14px; text-align:center;">
                                            <img src="{{ $qrCodeUrl }}" alt="Booking verification QR code" width="140" height="140" style="display:inline-block; background:#fff; border:8px solid #fff; border-radius:6px;">
                                            <div style="font-size:12px; margin-top:10px;">
                                                <a href="{{ $verificationUrl }}" style="color:#FFD700;">{{ $verificationUrl }}</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:24px 0 0; line-height:1.7; font-size:14px; color:#4b5563;">
                                If any details need to be changed, please contact us at {{ config('mail.from.address') }} before your check-in date.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="background:#fff8dc; padding:18px 24px; text-align:center; color:#8a6500; font-size:13px; font-weight:700;">
                            Thank you for booking with {{ $hotelName }}. We look forward to welcoming you.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
