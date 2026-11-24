<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Membership ID Card</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .card {
            width: 350px;
            border: 2px solid #4f46e5;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
        }
        .header {
            background: #4f46e5;
            color: white;
            padding: 10px;
            border-radius: 8px 8px 0 0;
            margin: -20px -20px 15px -20px;
            font-size: 18px;
            font-weight: bold;
        }
        .photo {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #4f46e5;
            margin-bottom: 10px;
        }
        .name {
            font-size: 18px;
            font-weight: bold;
            margin: 8px 0 4px;
        }
        .id {
            font-size: 14px;
            color: #555;
            margin-bottom: 12px;
        }
        .info {
            text-align: left;
            font-size: 13px;
            margin-bottom: 15px;
        }
        .info p {
            margin: 4px 0;
        }
        .qr {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">SENIOR CITIZEN MEMBERSHIP</div>

        @if($membership->profile_photo)
            <img src="{{ public_path('storage/'.$membership->profile_photo) }}" class="photo">
        @else
            <div style="width:90px;height:90px;background:#e5e7eb;border-radius:50%;margin:0 auto 10px;"></div>
        @endif

        <div class="name">{{ $membership->name }}</div>
        <div class="id">{{ $membership->membership_id }}</div>

        <div class="info">
            <p><strong>Status:</strong> {{ ucfirst($membership->membership_status) }}</p>
            <p><strong>Valid Until:</strong> {{ $membership->expiry_date?->format('M d, Y') ?? 'N/A' }}</p>
            <p><strong>Contact:</strong> {{ $membership->contact_number ?? 'N/A' }}</p>
        </div>

        <div class="qr">
            <img src="data:image/png;base64,{{ $qrCode }}" width="120">
            <p style="font-size:11px;color:#666;">Scan to Verify</p>
        </div>
    </div>
</body>
</html>