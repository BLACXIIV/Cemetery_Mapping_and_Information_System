<?php 

include("config.php");
$con=connect();


$news_events=$con->query("SELECT * FROM `news_events`");
$count_news=$news_events->num_rows;
$news_events_edit=$con->query("SELECT * FROM `news_events`");
$news_thumbnail=$con->query("SELECT * FROM `news_events`");

$slideshow_announcement=$con->query("SELECT * FROM `slideshow` WHERE `type`='Announcement'");
$slideshow_banner=$con->query("SELECT * FROM `slideshow` WHERE `type`='Banner'");

$stmt = $con->prepare("SELECT * FROM news_events WHERE news_id = ?");
$stmt->bind_param("i", $news_id);
$stmt->execute();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://kit.fontawesome.com/ec4303cca5.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="Assets/image/logopngplain1.png" type="image/x-icon">
    <title>Holy Gardens Matutum Memorial Park</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="Assets/css/01_User_Home.css">
    <link rel="stylesheet" href="Assets/css/style.css">
    <script src="Assets/js/index.js" defer></script>

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
    .navlogo{
        height:65px;
        width: 65px;
    }
    .btn-find{
        font-family: var(--Poppins);
        font-size: 1rem;
        color: var(--color2);
        background-color: var(--color1);
        border-radius: 5px;
        padding: .5em 1.2em;
        position: relative;
        height: 60px;
        }

    .primary-header {
        width: 100%;
        padding: 0 2.5em;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: fixed;
        z-index: 1;
        background-color: rgba(255, 255, 255, .5);
        backdrop-filter: blur(1rem);
        transition: all 0.3s ease;
    }

    .accordion-button{
        color: var(--color1);
    }

    .accordion-button:not(.collapsed) {
        background-color:var(--color1);
    }
    .primary-header.sticky {
        background-color: transparent;
        color: var(--color1);
        margin-top: -1em;
        padding: .5em 4em;
    }    
</style>
<body>

    <header class="primary-header" >
        <div class="logo">
            <img src="Assets/image/logopngplain1.png" alt="navLogo" class="navlogo">
        </div>

        <nav>
            <ul class="primary-nav" id="primary-nav" data-visible="false">
                <li> 
                    <a href="#about">HOME</a> 
                </li>
                <li> 
                    <a href="#service">SERVICES</a> 
                </li>
                <li> 
                    <a href="#faqs">FAQs</a> 
                </li>
                <li> 
                    <a href="#news">NEWS & EVENTS</a> 
                </li>
                <li> 
                    <a href="#contact">CONTACT</a> 
                </li>
            </ul>
        </nav>

    </header>

    <div class="about" id="about">
        <div class="about-pic">
            <h1>Your Sadness is Our Happiness</h1>
            <p>Find your loved ones with ease in a serene sanctuary dedicated to honoring life’s journey. Our grounds offer a lasting legacy of love and support, providing a peaceful space for remembrance and reflection.
            </p>
            <p></p>
            <a href="User/Find_Grave.php"> 
                        <button type="submit" class="btn-find"><b>TRY IT NOW</b></button>
            </a>
            
        </div>
        <div class="about-content" id="service">
            <h1 class="service-text">INTERMENT TYPES</h1>
            <div class="services">
                <div class="service-type">
                    <div class="type-img">
                        <img src="Assets/image/service-type2.jpg" alt="">
                    </div>
                    <div class="type-content">
                        <i class="fa fa-chess-pawn"></i>
                        <h1>STANDARD</h1>
                        <p>Holy Gardens Matutum Memorial Park offers a serene environment for traditional ground burials, allowing families to remain together in a more private setting.
                        Our Standard Lawn Lots, sized at 2.44 square meters, accommodate single-lot and underground burials with double interment, providing a dignified resting place for your loved ones.
                        </p>
                    </div>
                </div>
                <div class="service-type">
                    <div class="type-img">
                        <img src="Assets/image/service-type3.jpg" alt="">
                    </div>
                    <div class="type-content">
                        <i class="fa fa-chess-king"></i>
                        <h1>DELUXE</h1>
                        <p>Holy Gardens Matutum Memorial Park provides a serene and private setting for families. Our Deluxe Lawn Lots, sized at 3.5 square meters, offer both single-lot and underground options with double interment, ensuring a peaceful and dignified resting place for your loved ones.
                        </p>
                    </div>
                </div>
            </div>
            <div class="service-type mt-5">
                    <div class="type-img">
                        <img src="Assets/image/service-type1.jpg" alt="">
                    </div>
                    <div class="type-content">
                        <i class="fa fa-archway"></i>
                        <h1>PREMIUM</h1>
                        <p>Our Premium Mausoleums offer the privacy of a dry, sanitary tomb at a cost comparable to or even lower than traditional ground burials.
                        Each mausoleum occupies a 30-square meter lot (7.5m x 4m) and allows for unlimited interments, providing a spacious and dignified resting place for your loved ones.</p>
                    </div>
                </div>
        </div>
        <p></p>
        <p></p>
            <a href="User/booking.php"> 
                <div class="text-center">
                        <button type="submit" class="btn-find"><b>BOOK NOW</b></button>
                </div>
            </a>
    </div>
    <br>
    <div id="faqs" style="height:1px;"></div>
    <div class="faq mt-5" id="faq">
        <div class="container faq-cont">
            <div class="faq-title text-center py-5">
                <h1>FREQUENTLY ASKED QUESTIONS (FAQs)</h1>
            </div>
            <div class="row row-cols-md-2">
                <div class="col-md-6 d-flex align-items-center">
                    <div class="accordion w-100" id="accordionPanelsStayOpenExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne" aria-label="Toggle FAQ item">
                                Where I can find your location?
                            </button>
                            </h2>
                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                            <div class="accordion-body">
                                
                                <p> Our <strong> Main Site </strong> is Located at <strong> Door 1, Prudente BLDG, Pioneer Ave, Polomolok South Cotabato </strong> at the side of Pinetown Veterinary Clinic</p>
                                <p> <strong> Main Office</strong> is Located at <strong> Brgy. Poblacion, 16 Dama de Noche St. Polomolok South Cotabato </strong>. You can view our contact page for more info</p>
                                
                            </div>  
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                What day is available to visit?
                            </button>
                            </h2>
                            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                            <div class="accordion-body">
                                <p>You can visit Holy Gardens Matutum Memorial Park  daily at <strong>8:00 AM - 5:30 PM</strong></p>
                                <p>Our main office opens <strong>Monday-Friday 8:00 AM - 6:00 PM</strong> , and <Strong>closed on Sundays</Strong> </p>
                                
                                
                            </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                                What are the requirements in purchasing Lawn Lot?
                            </button>
                            </h2>
                            <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                            <div class="accordion-body">
                                <p>It only needs <strong> Valid ID, Proof of Billing and Buyers Form (BAF) </strong></p>

                                <p>- Assists Buyer and Seller on choosing their desired lot location </p>
                                <p>- Discuss about product type and description, payment, plan, term and other park policies </p>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-none d-sm-block">
                    <div class="faq-img">
                        <img src="Assets/image/faq1.svg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="news"></div>
    <section class="news pt-5 mt-5">
        <div class="news-header">
            <h1>NEWS AND EVENTS</h1>
        </div>
        <div class="container">
            <?php if($count_news!=0){ ?>
            <div class="row row-cols-lg-3 row-cols-sm-1">
                <?php while($row=$news_events->fetch_array()){ ?>
                    <div class="col-lg-4 col-md-6 col-sm-12 p-2 pt-5">
                        <div class="card news-section shadow news-card h-100">
                            <div class="news-img" style="height: 25vh;">
                                <img style="width: 100%; height: 100%" src="Admin/files/news_img/<?php echo $row["news_img"] ?>">
                            </div>
                            <div class="card-body pb-4">
                                <p class="date-txt fw-light">
                                    <?php echo date("M j, Y", strtotime($row["news_date"]))?>
                                </p>
                                <h4 class="card-title fw-bold">
                                    <?php echo $row["news_title"] ?>
                                </h4>
                                <h4 class="lead fst-italic" style="font-size: 1rem;">
                                    <?php echo $row["news_subtitle"] ?>
                                </h4>
                                <div class="text-desc mb-5">
                                    <p class="card-text">
                                        <?php echo $row["news_description"] ?>
                                    </p>
                                </div>
                                <div class="card-footer">
                                    <a href="User/news_and_events.php?item=<?php echo $row['news_id']?>">
                                        <button class="btn btn-success" style="position: absolute; bottom: 15px;">
                                            See More
                                        </button>
                                    </a>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                <?php }?>
            </div>
            <?php } else { ?>
            <div class="row mt-5 text-center">
                <h1>No News and Events Available</h1>
            </div>
            <?php }?>
            <div class="loadmore">
                <div class="box loadmorebtn">
                    <i class="fa fa-plus"></i>
                    <h2>LOAD MORE</h2>
                </div>

                <div class="box loadlessbtn">
                    <i class="fa fa-plus"></i>
                    <h2>LOAD LESS</h2>
                </div>`
            
            </div>
        </div>
    </section>

    <div class="contact-us" id="contact">
        <div class="contact-div1">
            <div class="contact-div1-img">
                <img src="Assets/image/undraw_personal_email_re_4lx71.svg" alt="">
            </div>
            <div class="contact-div1-content1">
                <div class="content-1">
                    <h1>GET IN TOUCH</h1>
                    <p>Want to get in touch? We'd love to hear from you. Here's how you can reach us...</p>
                </div>
                <div class="content-2">
                    <div class="soc-med">
                        <div class="soc-med-img">
                            <img src="Assets/image/square-facebook-brands-solid1.svg" alt="">
                        </div>
                        <div class="soc-med-link">
                            <a href="">https://www.facebook.com/ Holy-Gardens-Matutum-Memorial-Park</a>
                        </div>
                    </div>
                    <div class="soc-med">
                        <div class="soc-med-img">
                            <img src="Assets/image/phone-solid1.svg" alt="">
                        </div>
                        <div class="soc-med-link">
                            <a href="tel:(083) 500 8287">0917 714 5097 / (083) 500 8287</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="contact-div2">
            <h1>WE'RE HERE</h1>
            <div class="content first">
                <div class="map-text">
                    <h2 class="title"> Main Site</h2>
                    <div class="container">
                        <img src="Assets/image/location-dot-solid1.svg" alt="loc-icon">
                        <h2>ADDRESS</h2>
                        <p> 
                        Door 1, Prudente BLDG, Pioneer Ave, Polomolok South Cotabato
                        </p>
                    </div>
                    <div class="container">
                        <img src="Assets/image/clock-solid1.svg" alt="">
                        <h2>OPEN HOURS</h2>
                        <p>8:00 AM - 5:30 PM</p>
                    </div>
                </div>
                <div class="map-img">
                    <iframe src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=holy%20gardens%20matutum%20memorial%20park+(My%20Business%20Name)&amp;t=&amp;z=17&amp;ie=UTF8&amp;iwloc=B&amp;output=embed" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
            <div class="content second">
                <div class="map-img">
                    <iframe src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=Holy%20Gardens%20Memorial%20Park%20Office+(My%20Business%20Name)&amp;t=&amp;z=18&amp;ie=UTF8&amp;iwloc=B&amp;output=embed" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
                <div class="map-text">
                    <h2 class="title"> Main Office</h2>
                    <div class="container">
                        <img src="Assets/image/location-dot-solid1.svg" alt="loc-icon">
                        <h2>ADDRESS</h2>
                        <p> 
                            Brgy. Poblacion, 16 Dama de Noche St. Polomolok South Cotabato
                        </p>
                    </div>
                    <div class="container">
                        <img src="Assets/image/clock-solid1.svg" alt="clock-icon">
                        <h2>OPEN HOURS</h2>
                        <p>8:00 AM - 6:00 PM</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Messenger Chat Plugin Code -->
    <div id="fb-root"></div>

    <!-- Your Chat Plugin code -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>

    <script>
      var chatbox = document.getElementById('fb-customer-chat');
      chatbox.setAttribute("page_id", "113919594640619");
      chatbox.setAttribute("attribution", "biz_inbox");
    </script>

    <!-- Your SDK code -->
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          xfbml            : true,
          version          : 'v13.0'
        });
      };

      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>
</body>
    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="Assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</html>
