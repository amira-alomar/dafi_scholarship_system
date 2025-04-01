<head>
    <link rel="stylesheet" href="{{ asset('css/header.css') }}"/>
</head>
<header class="reveal reveal-bottom">
    <nav>
        <div class="logo"><span>DAFI</span> Scholarship</div>
        <button class="menu-toggle" aria-label="Toggle Menu">&#9776;</button>
        <div class="menu">
            @foreach($links ?? [] as $name => $url)
                <a href="{{ url($url) }}">{{ $name }}</a>
            @endforeach
        </div>
    </nav>
</header>

