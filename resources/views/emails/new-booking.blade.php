<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>New Booking — {{ $booking->invoice_number }}</title>
<style>
  body { font-family: 'Segoe UI', Arial, sans-serif; background: #F9FAFB; margin: 0; padding: 0; }
  .wrap { max-width: 600px; margin: 30px auto; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,.08); }
  .header { background: linear-gradient(135deg, #C53030, #E53E3E); padding: 36px 36px 28px; text-align: center; color: #fff; }
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
  .amount-box { background: #FFF5F5; border: 2px solid #FED7D7; border-radius: 12px; padding: 18px 22px; margin: 20px 0; display: flex; justify-content: space-between; align-items: center; }
  .amount-label { font-weight: 600; color: #C53030; }
  .amount-value { font-size: 1.4rem; font-weight: 800; color: #C53030; }
  .warning-box { background: #FEEBC8; border: 1px solid #F6AD55; border-radius: 10px; padding: 14px 18px; font-size: .85rem; color: #744210; margin-top: 20px; }
  .footer { background: #F9FAFB; padding: 20px 36px; text-align: center; font-size: .78rem; color: #9CA3AF; border-top: 1px solid #F3F4F6; }
</style>
</head>
<body>
<div class="wrap">
  <div class="header">
    <div class="header-icon">✈️</div>
    <h1>New Booking Created</h1>
    <p>A new travel booking has been submitted</p>
  </div>
  <div class="body">
    <div class="invoice-badge">{{ $booking->invoice_number }}</div>

    <div class="section-title">Booking Summary</div>
    <div class="detail-row">
      <span class="detail-key">Category</span>
      <span class="detail-val">{{ $booking->category }}</span>
    </div>
    <div class="detail-row">
      <span class="detail-key">PNR</span>
      <span class="detail-val">{{ $booking->pnr ?? 'N/A' }}</span>
    </div>
    <div class="detail-row">
      <span class="detail-key">Group</span>
      <span class="detail-val">{{ $booking->group_name ?? 'N/A' }}</span>
    </div>
    <div class="detail-row">
      <span class="detail-key">Travel Date</span>
      <span class="detail-val">{{ $booking->travel_date ? $booking->travel_date->format('d M Y') : 'N/A' }}</span>
    </div>
    @if($booking->return_date)
    <div class="detail-row">
      <span class="detail-key">Return Date</span>
      <span class="detail-val">{{ $booking->return_date->format('d M Y') }}</span>
    </div>
    @endif

    <div class="section-title">Passenger Info</div>
    <div class="detail-row">
      <span class="detail-key">Lead Passenger</span>
      <span class="detail-val">{{ $booking->customer_name }}</span>
    </div>
    <div class="detail-row">
      <span class="detail-key">Phone</span>
      <span class="detail-val">{{ $booking->customer_phone }}</span>
    </div>
    <div class="detail-row">
      <span class="detail-key">Adults</span>
      <span class="detail-val">{{ $booking->adults ?? 1 }}</span>
    </div>
    <div class="detail-row">
      <span class="detail-key">Children</span>
      <span class="detail-val">{{ $booking->children ?? 0 }}</span>
    </div>

    <div class="amount-box">
      <span class="amount-label">Total Amount</span>
      <span class="amount-value">PKR {{ number_format($booking->total_amount) }}</span>
    </div>

    <div class="warning-box">
      ⏰ <strong>Payment Deadline:</strong> Payment must be received by
      <strong>{{ $booking->payment_deadline ? $booking->payment_deadline->format('d M Y, h:i A') : 'N/A' }}</strong>.
      Failure to pay will result in automatic cancellation.
    </div>
  </div>
  <div class="footer">
    This is an automated notification from Travel Portal. Please do not reply to this email.
  </div>
</div>
</body>
</html>
