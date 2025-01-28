<html>
<head>
    <title>Contractor Registration</title>
</head>
<body>
    <h1>New Contractor Registration</h1>

    <p><strong>Company Name:</strong> {{ $opportunities->first()->opportunity_name }}</p>
    
    <h3>Opportunities:</h3>
    <ul>
        @foreach($opportunities as $opportunity)
            <li>{{ $opportunity->opportunity_name }}</li>
        @endforeach
    </ul>

    <p>Thank you for registering with us!</p>
</body>
</html>