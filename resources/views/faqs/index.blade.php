<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ Page</title>
    <link rel="stylesheet" href="path/to/your/css/style.css">
</head>
<body>
<header>
    <!-- Include header content -->
    <x-head />
</header>

<main>
    @foreach($faqs as $faq)
        <div class="faq">
            <h3 style="padding: 10px" class="faq-username">username: {{ $faq->username }}</h3>
            <h3 style="padding: 15px" class="faq-question"> Q: {{ $faq->question }}</h3>
            <p style="padding: 10px" class="faq-answer">ANS: {{ $faq->answer }}</p>
        </div>
    @endforeach
</main>


    <x-footer />
</body>
</html>
