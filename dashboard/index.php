
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Donation Platform</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="header-container">
            <img src="image/logo1.jpg" alt="" class="logo">
            <h1>Blood Donation Platform</h1>
<nav>
    <ul>
        <li><a href="#home">Home</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="#who-should-donate">Who Should Donate</a></li>
        <li><a href="#contact">Contact</a></li>
        <li><a href="login.php">Login</a></li>
    </ul>
</nav>
        </div>
    </header>
    <main>
       <section class="hero">
            <div class="hero-text">
                <h2>Welcome to the Blood Donation Platform</h2>
                <p>Give blood,save many lives</p>
            </div>
        </section>
        <section id="about">
         <div class="about-content">
         <div class="about-image">
            <img src="image/giving.jpg" alt="">
        </div>
        <div class="about-text">
            <h2><b>About</b></h2>
            <p >The Blood Donation Platform aims to connect blood donors with donation centers in real-time, facilitating the process of blood donation and ultimately saving lives. It serves as a centralized platform for individuals in need of blood transfusions to find suitable donors efficiently.</p>
            <p>With features designed to streamline the donation process, the platform empowers donors to make a difference and save lives with ease. From real-time matching to an interactive donation map, users can access essential resources and information, making blood donation a seamless and rewarding experience.</p>
        </div>  
         </div>
         </div>
    </section>
    <section id="who-should-donate">
    <div class="container">
        <div class="section-heading">
            <h2><b>Who Supposed to Donate</b></h2>
        </div>
        <div class="section-content">
            <p>The Blood Donation Platform encourages individuals from all walks of life to consider donating blood. Whether you're in good health and meet the eligibility criteria, your donation can make a significant difference in saving lives.</p>
            <p>Common groups encouraged to donate include:</p>
            <ul>
                <li>Healthy adults aged 18-65</li>
                <li>Individuals with a minimum weight of 50kg</li>
                <li>Non-smokers and non-drug users</li>
                <li>Those without recent tattoos or piercings</li>
                <li>People with no history of blood-borne diseases</li>
            </ul>
        </div>
    </div>
</section>
</div>
           
        <section id="contact">
            <div class="container mt-5">
                <div class="section-heading">
                    <h2>Contact Us</h2>
                </div>
                <form action="contact_form_handler.php" method="post">
                    <div class="mb-3">
                        <label for="contact_name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="contact_name" name="contact_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="contact_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="contact_email" name="contact_email" required>
                    </div>
                    <div class="mb-3">
                        <label for="contact_subject" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="contact_phone" name="contact_phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="contact_message" class="form-label">Message</label>
                        <textarea class="form-control" id="contact_message" name="contact_message" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>
        </section>


        </main>
   
        <footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#who-should-donate">Who Should Donate</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li><a href="login.php">Login</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h4>Contact Us</h4>
                <p>Email: info@blooddonation.com</p>
                <p>Phone: +1234567890</p>
            </div>
            <div class="col-md-4">
                <h4>Follow Us</h4>
                <ul class="social-icons">
                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <p>© 2024 Blood Donation Platform. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>



    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
      
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        // Smooth scrolling on click of nav links
        $('nav a[href^="#"]').on('click', function(event) {
            var target = $($(this).attr('href'));
            if (target.length) {
                event.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top - $('header').outerHeight() // Adjusted for fixed header
                }, 1000);
            }
        });
    });
</script>


  
</body>
</html>
