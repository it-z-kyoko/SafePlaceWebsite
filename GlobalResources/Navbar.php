<head>
    <link rel="shortcut icon" href="https://safeplace.infinityfreeapp.com/images/Logo.png" type="image/x-icon">
</head>

<header>
    <nav>
        <div class="Navbar">
            <img loading="lazy" srcset="images\Logo.png" class="navbar-image" />
            <div class="Nav-Element"><a href="#" style="color: #000000">Home</a></div>
            <div class="Nav-Element"><a href="#" style="color: #000000">Spieler</a></div>
            <div class="Nav-Element"><a href="#" style="color: #000000">Charaktere</a></div>
            <div class="Nav-Element"><a href="#" style="color: #000000">Erstelle einen Charakter</a></div>
            <div class="Nav-Element"><a href="#" style="color: #000000">Login</a></div>
            <div class="Nav-Element"><a href="#" style="color: #000000">Register</a></div>
        </div>
    </nav>
</header>

<style>
    body {
        font-family: 'Raleway', sans-serif;
        margin: 0;
        padding: 0;
        color: #fff;
        line-height: 120%;
        font-size: 18px;
    }
    .Navbar {
        border-radius: 40px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        display: flex;
        justify-content: space-evenly;
        gap: 20px;
        font-size: 0.9rem;
        color: #1e1e1e;
        font-weight: 500;
        text-align: center;
        letter-spacing: 1px;
        line-height: 1.5;
        padding: 1em 2em;
        align-items: center;
        flex-direction: row;
    }

    .navbar-image {
        max-height: 70px;
        width: auto;
        height: auto;
        object-position: center;
    }

    /* Responsive adjustments */
    @media only screen and (max-width: 768px) {
        .Navbar {
            flex-direction: column;
            padding: 1em;
        }

        .navbar-image {
            max-height: 80px;
        }
    }
</style>