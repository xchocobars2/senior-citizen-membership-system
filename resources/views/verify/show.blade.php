<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership Verification</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-lg p-8 max-w-md w-full text-center">
        <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
            ✓
        </div>
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Valid Membership</h1>
        <p class="text-gray-500 mb-6">This membership is authentic</p>

        <div class="text-left space-y-2 border-t pt-4">
            <p><span class="font-medium">Name:</span> {{ $member->name }}</p>
            <p><span class="font-medium">Membership ID:</span> {{ $member->membership_id }}</p>
            <p><span class="font-medium">Status:</span> 
                <span class="px-2 py-0.5 rounded text-sm
                    @if($member->membership_status === 'active') bg-green-100 text-green-800
                    @elseif($member->membership_status === 'inactive') bg-red-100 text-red-800
                    @else bg-yellow-100 text-yellow-800 @endif">
                    {{ ucfirst($member->membership_status) }}
                </span>
            </p>
            <p><span class="font-medium">Valid Until:</span> {{ $member->expiry_date?->format('F d, Y') ?? 'N/A' }}</p>
        </div>
    </div>
</body>
</html>