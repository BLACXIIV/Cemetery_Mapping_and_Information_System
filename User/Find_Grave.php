<!DOCTYPE html>
<html lang="en">
<head>
    <script href="https://kit.fontawesome.com/ec4303cca5.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../Assets/image/logopngplain1.png" type="image/x-icon">
    <title>Holy Gardens Matutum Memorial Park</title>
    
    <link rel="stylesheet" href="../Assets/css/style.css">

    <script src="../Assets/js/index.js" defer></script>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>

</head>
<style>
    :root{
        --Poppins: 'Poppins', sans-serif;
        --Font2: 'Roboto', sans-serif;
        --Font3: 'Inter', sans-serif;

        --color1: #00563B;
        --color2: white;
        --color3: rgb(107, 21, 21);
    }
    .get-started-btn a{
        background-color: var(--color1);
    }
    .navlogo{
        height:65px;
        width: 65px;
    }
    .cont-1{
    width: 100%;
    text-align: center;
    margin:50px 0px -50px 0px;
    }
    .cont-1 p{
    width: 60%;
    margin: 0 auto;
    }
</style>
<body>

    <header class="primary-header">
        <div class="logo">
            <img src="../Assets/image/logopngplain1.png" alt="navLogo" class="navlogo">
        </div>

        <button aria-controls="primary-nav" aria-expanded="false" class="nav-toggle">
            <span class="sr-only">
                Menu
            </span>
        </button>

        <nav>
            <ul class="primary-nav" id="primary-nav" data-visible="false">
                <li> 
                    <a href="../index.php">HOME</a> 
                </li>
                <li> 
                    <a href="../index.php#service">SERVICES</a> 
                </li>
                <li> 
                    <a href="../index.php#faqs">FAQs</a> 
                </li>
                <li> 
                    <a href="../index.php#news">NEWS & EVENTS</a> 
                </li>
                <li> 
                    <a href="../index.php#contact">CONTACT</a> 
                </li>
            </ul>
        </nav>

    </header>

    <div class="findgrave-cont">
        <div class="findgrave-cont-main">
            <div class="main-cont cont-1">
                <h1>Finding Makes Easier</h1>
            </div>
            <div class="main-cont cont-2">
                <div class="cont-2-img first">
                    <img src="../Assets/image/step1.svg" alt="">
                    <h2>1. Enter Name</h2>
                </div>
                <div class="cont-2-img">
                    <img src="../Assets/image/step2.svg" alt="">
                    <h2>2. Location will Show</h2>
                </div>
                <div class="cont-2-img">
                    <img src="../Assets/image/step3.svg" alt="">
                    <h2>3. Convenient Visit</h2>
                </div>
            </div>
            <div class="main-cont cont-3" style="text-align: center">
                <div class="get-started-btn">
                    <a href="user_map.php">Get Started</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

</body>
</html>