<?php 
$title = "Welcome";
include('includes/header.html');
if(isset($_SESSION['emp_id']) || isset($_SESSION['role'])){
    header('location: view_reservations.php');
}
?>

<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css" integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A==" crossorigin="anonymous"
  referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw=="
  crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="style.css?">
<body>
  <header class="header" id="navigation-menu">
    
  </header>
  
  <section class="home" id="home">
    <div class="head_container">
      <div class="box">
        <div class="text">
        <h1 >Welcome to Haunted Hotel</h1>
          <br><br><br><br><br><br>
        </div>
      </div>
      <div class="image">
        <img src="includes/hotel1.png" class="slide">
      </div>
      <div class="image_item">
        <?php
        include_once("../hotel/includes/hotel_connect.php");

        $q = "SELECT photo FROM gallery";
        $result = mysqli_query($dbc,$q);
        $count = 0;
        while($row = mysqli_fetch_assoc($result)){
            echo '<img src="'.$row['photo'].'" alt="" class="slide active" onclick="img(`'.$row['photo'].'`)">';
            $count++;
            if($count==4){
                break;
            }
        }
        ?>
      </div>
    </div>
  </section>
  <script>
    function img(anything) {
      document.querySelector('.slide').src = anything;
    }

    function change(change) {
      const line = document.querySelector('.image');
      line.style.background = change;
    }
  </script>

  <section class="about top" id="about">
    <div class="container flex">
      <div class="left">
        <div class="img">
          <img src="image/a1.jpg" alt="" class="image1">
          <img src="image/a2.jpg" alt="" class="image2">
        </div>
      </div>
      <div class="right">
        <div class="heading">
          <h5>RAISING COMFOMRT TO THE HIGHEST LEVEL</h5>
          <h1>Welcome to Haunted Hotel</h1>
          <p>Haunted Hotel is a stylish and contemporary haven situated in the heart of the vibrant city. Offering a perfect blend of comfort and sophistication, this modern hotel provides guests with an exceptional stay experience. With impeccable service, luxurious accommodations, and an array of amenities, Haunted Hotel is the ideal choice for both business and leisure travelers seeking a memorable stay in Albania. </p>
        </div>
      </div>
    </div>
  </section>
  <section class="wrapper top">
    <div class="container"><br><br><br><br>
    <img src="image/OIP.jpeg" alt="" class="image1">
      <div class="text">
      
        <h2>Our Amenities</h2>
        <p>Our hotel offers an extensive range of amenities to ensure a delightful and convenient stay for our guests. Stay active and energized at our fully equipped fitness center, complete with modern exercise equipment. Enjoy seamless connectivity with complimentary high-speed Wi-Fi throughout the premises. Experience utmost comfort and convenience with our round-the-clock concierge service, and attentive staff ready to cater to your every need. </p>
      </div>

    </div>
  </section>
  <section class="room top" id="room">
    <div class="container">
      <div class="heading_top flex1">
        <div class="heading">
          <h5>RAISING COMFORT TO THE HIGHEST LEVEL</h5>
          <h2>Rooms & Suites</h2>
        </div>
        <div class="link_rooms">
            <a href='rooms.php' id='viewRooms' style="text-decoration: none; font-size: large; border: 2px solid; padding: 10px; border-radius: 20px;"> VIEW ALL ROOMS</a>
        </div>
      </div>

      <div class="content grid">
        <div class="box">
          <div class="img">
            <img src="image/r1.jpg" alt="">
          </div>
          <div class="text">
            <h3>Standard Rooms</h3>
            <p> <span>LEK </span>15000 <span>/per night</span> </p>
          </div>
        </div>
        <div class="box">
          <div class="img">
            <img src="image/r2.jpg" alt="">
          </div>
          <div class="text">
            <h3>Family Rooms</h3>
            <p> <span>LEK </span>22000 <span>/per night</span> </p>
          </div>
        </div>
        <div class="box">
          <div class="img">
            <img src="image/r3.jpg" alt="">
          </div>
          <div class="text">
            <h3>Suite</h3>
            <p> <span>LEK </span>30000 <span>/per night</span> </p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="wrapper wrapper2 top">
    <div class="container">
      <div class="text">
        <div class="heading">
          <h5>AT THE HEART OF COMMUNICATION</h5>
          <h2>People Say</h2>
        </div>

        <div class="para">
          <p>Guests love Haunted Hotel for its impeccable service, modern accommodations, and exceptional amenities. The hotel's convenient city-center location adds to its appeal, providing easy access to nearby attractions. Overall, guests rave about their memorable stays at Haunted Hotel. </p>

          <div class="box flex">
            
          </div>
        </div>
      </div>
    </div>
  </section>


<script>
    var accItem = document.getElementsByClassName('accordionItem');
    var accHD = document.getElementsByClassName('accordionIHeading');

    for (i = 0; i < accHD.length; i++) {
      accHD[i].addEventListener('click', toggleItem, false);
    }

    function toggleItem() {
      var itemClass = this.parentNode.className;
      for (var i = 0; i < accItem.length; i++) {
        accItem[i].className = 'accordionItem close';
      }
      if (itemClass == 'accordionItem close') {
        this.parentNode.className = 'accordionItem open';
      }
    }
   
  </script>



  <section class="gallary mtop " id="gallary">
    <div class="container">
      <div class="heading_top flex1">
        <div class="heading">
          <h5>WELCOME TO OUR PHOTO GALLERY</h5>
          <h2>Photo Gallery of Our Hotel</h2>
        </div>
        <div class="button">
          <a class="btn1" style="font-size: large; border: 2px solid; padding: 10px; border-radius: 20px;" href="gallery.php">VIEW GALLERY</a>
        </div>
      </div>

      <div class="owl-carousel owl-theme">
        <div class="item">
          <img src="image/g1.jpg" alt="">
        </div>
        <div class="item">
          <img src="image/g2.jpg" alt="">
        </div>
        <div class="item">
          <img src="image/g3.jpg" alt="">
        </div>
        <div class="item">
          <img src="image/g4.jpg" alt="">
        </div>
        <div class="item">
          <img src="image/g5.jpg" alt="">
        </div>
        <div class="item">
          <img src="image/g6.jpg" alt="">
        </div>
        <div class="item">
          <img src="image/g7.jpg" alt="">
        </div>
        <div class="item">
          <img src="image/g8.jpg" alt="">
        </div>
      </div>

    </div>
  </section>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js" integrity="sha512-gY25nC63ddE0LcLPhxUJGFxa2GoIyA5FLym4UJqHDEMHjp8RET6Zn/SHo1sltt3WuVtqfyxECP38/daUc/WVEA==" crossorigin="anonymous"
    referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous"
    referrerpolicy="no-referrer"></script>
  <script>
    $('.owl-carousel').owlCarousel({
      loop: true,
      margin: 10,
      nav: true,
      dots: false,
      navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
      responsive: {
        0: {
          items: 1
        },
        768: {
          items: 2
        },
        1000: {
          items: 4
        }
      }
    })
  </script>



  <section class="map top">
  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2996.815542325854!2d19.81204904936287!3d41.312876226877414!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x135030fca07b0f31%3A0x43921e02f5c32698!2sArtificial%20Lake%20Park%20Playground!5e0!3m2!1sen!2s!4v1684067981566!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
   </section>
</body>

<?php 
include('includes/footer.html');
?>