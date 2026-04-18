<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Booking Cancelled — {{ $booking->invoice_number }}</title>
<style>
  body { font-family: 'Segoe UI', Arial, sans-serif; background: #F9FAFB; margin: 0; padding: 0; }
  .wrap { max-width: 600px; margin: 30px auto; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,.08); }
  .header { background: linear-gradient(135deg, #742A2A, #C53030); padding: 36px 36px 28px; text-align: center; color: #fff; }
  .header-icon { font-size: 2.5rem; margin-bottom: 12px; }
  .header h1 { margin: 0 0 6px; font-size: 1.5rem; font-weight: 800; }
  .header p { margin: 0; opacity: .85; font-size: .9rem; }
  .body { padding: 32px 36px; }
  .invoice-badge { display: inline-block; background: #FFF5F5; color: #C53030; padding: 6px 18px; border-radius: 20px; font-weight: 700; font-size: .9rem; margin-bottom: 24px; border: 1px solid #FED7D7; }
  .section-title { font-size: .7rem; font-weight: 700; color: #9CA3AF; text-transform: uppercase; letter-spacing: .08em; margin: 24px 0 10px; }
  .detail-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #F3F4F6; font-size: .88rem; }
  .detail-row:last-child { border-bottom: none; }
  .detail-key { color: #6B7280; }
  .detail-val { font-weight: 600; color: #111827; text-align: right; }
  .cancel-box { background: #FFF5F5; border: 2px solid #FED7D7; border-radius: 12px; padding: 20px 22px; margin: 20px 0; text-align: center; }
  .cancel-box .icon { font-size: 2.5rem; display: block; margin-bottom: 10px; }
  .cancel-box h3 { color: #C53030; margin: 0 0 8px; font-size: 1.1rem; }
  .cancel-box p { color: #744210; font-size: .85rem; margin: 0; }
  .tip-box { background: #EBF8FF; border: 1px solid #BEE3F8; border-radius: 10px; padding: 14px 18px; font-size: .85rem; color: #2B6CB0; margin-top: 20px; }
  .footer { background: #F9FAFB; padding: 20px 36px; text-align: center; font-size: .78rem; color: #9CA3AF; border-top: 1px solid #F3F4F6; }
</style>
</head>
<body>
<div class="wrap">
  <div class="header">
    <div class="header-icon">❌</div>
    <h1>Booking Auto-Cancelled</h1>
    <p>Payment was not received within the required time</p>
  </div>
  <div class="body">
    <div class="invoice-badge">{{ $booking->invoice_number }}</div>

    <div class="cancel-box">
      <span class="icon">⏰</span>
      <h3>Booking Cancelled</h3>
      <p>This booking was automatically cancelled because payment was not received within <strong>4 hours</strong> of the booking creation time.</p>
    </div>

    <div class="section-title">Cancelled Booking Details</div>
    <div class="detail-row">
      <span class="detail-key">Category</span>
      <span class="detail-val">{{ $booking->category }}</span>
    </div>
    <div class="detail-row">
      <span class="detail-key">PNR</span>
      <span class="detail-val">{{ $booking->pnr ?? 'N/A' }}</span>
    </div>
    <div class="detail-row">
      <span class="detail-key">Lead Passenger</span>
      <span class="detail-val">{{ $booking->customer_name }}</span>
    </div>
    <div class="detail-row">
      <span class="detail-key">Travel Date</span>
      <span class="detail-val">{{ $booking->travel_date ? $booking->travel_date->format('d M Y') : 'N/A' }}</span>
    </div>
    <div class="detail-row">
      <span class="detail-key">Adults</span>
      <span class="detail-val">{{ $booking->adults ?? 1 }}</span>
    </div>
    <div class="detail-row">
      <span class="detail-key">Total Amount</span>
      <span class="detail-val">PKR {{ number_format($booking->total_amount) }}</span>
    </div>
    <div class="detail-row">
      <span class="detail-key">Cancelled At</span>
      <span class="detail-val">{{ now()->format('d M Y, h:i A') }}</span>
    </div>

    <div class="tip-box">
      💡 <strong>Need to rebook?</strong> You can create a new booking anytime from your vendor portal. Make sure to complete payment within 4 hours of booking.
    </div>
  </div>
  <div class="footer">
    This is an automated notification from Travel Portal. Please do not reply to this email.
  </div>
</div>
</body>
</html>
