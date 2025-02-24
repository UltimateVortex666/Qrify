<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Event Manager</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">
<link rel="stylesheet" href="css/animate.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="style.css"/>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
  <div class="container"> <a class="navbar-brand navbar-logo" href="index.html"> <img src="images/logo.png" alt="logo" height="70px" width="200px" class="logo-1"> </a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav">
        <li class="nav-item"> <a class="nav-link" href="" data-scroll-nav="0">Home</a> </li>
        <li class="nav-item"> <a class="nav-link" href="#" data-scroll-nav="1">About</a> </li>
        <li class="nav-item"> <a class="nav-link" href="#" data-scroll-nav="2">Demo</a> </li>
        <li class="nav-item"> <a class="nav-link" href="#" data-scroll-nav="3">Clubs</a> </li>
        <li class="nav-item"> <a class="nav-link" href="#" data-scroll-nav="4">Feedback</a> </li>
      </ul>

      <div class="d-flex">
        <a href="signup.php"><button class="btn btn-primary mr-2" >Sign Up</button></a>
        <a href="login.php"><button class="btn btn-outline-secondary" >Login</button></a>
      </div>
    </div>
    
  </div>
</nav>
<!-- End Navbar --> 

<!-------Banner Start---->
<section class="banner" data-scroll-index='0'>
  <div class="banner-overlay">
      <img src="images/bg_home.jpg" height="911px" width="1520px" />
          <div class="banner-text">Campus Event <br>    Manager</div>   
    </div>
  </div>
   </section>
  
<!--------Banner End------->

<!-----Upcoming Events Start----->

<div class="events-container wow fadeInUp" data-wow-delay="0.1s">
    <h2>Upcoming Events</h2>
    <div id="events"></div>
</div>

<script>
// Fetch events dynamically from PHP
fetch('fetch_events.php')
    .then(response => response.json())
    .then(events => {
        const eventsContainer = document.getElementById('events');

        // Check if no events are available
        if (events.length === 0) {
            eventsContainer.innerHTML = '<p>No upcoming events found.</p>';
            return;
        }

        // Render the closest 3 events dynamically
        events.forEach((event, index) => {
            const eventDateTime = new Date(`${event.event_date}T${event.event_time}`);

            // Convert the date to dd/mm/yyyy format
            const formattedDate = `${String(eventDateTime.getDate()).padStart(2, '0')}/` +
                                  `${String(eventDateTime.getMonth() + 1).padStart(2, '0')}/` +
                                  `${eventDateTime.getFullYear()}`;

            // Encode the event name for safe URL usage
            const encodedEventName = encodeURIComponent(event.title);

            // Create the event HTML dynamically
            const eventDiv = document.createElement('div');
            eventDiv.classList.add('event');
            eventDiv.innerHTML = `
                <div class="event-details">
                    <h3>${event.title}</h3>
                    <p class="event-time">Date: ${formattedDate} | Time: ${event.event_time} | Venue: ${event.venue}</p>
                    <p class="event-description">${event.description}</p>
                    <p id="countdown-${index}" class="countdown"></p>
                </div>
                <button class="attendance-btn" onclick="markAttendance('${encodedEventName}')">Mark Attendance</button>
            `;
            
            eventsContainer.appendChild(eventDiv);

            // Countdown Timer
            const countdown = document.getElementById(`countdown-${index}`);
            function updateCountdown() {
                const now = new Date();
                const timeLeft = eventDateTime - now;

                if (timeLeft > 0) {
                    const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                    countdown.textContent = `${days}d ${hours}h ${minutes}m ${seconds}s`;
                } else {
                    countdown.textContent = "Event Started!";
                }
            }

            updateCountdown();
            setInterval(updateCountdown, 1000);
        });
    })
    .catch(error => console.error('Error fetching events:', error));

function markAttendance(eventName) {
    window.location.href = 'attendance.php?event_name=' + eventName;
}

</script>



<!-----Upcoming Events End----->

<!-------About Start------->

<section class="about section-padding prelative" data-scroll-index='1'>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="sectioner-header text-center">
          <h3>About</h3>
          <span class="line"></span>
          <p>Our College Event Management platform is designed to cater to the unique needs of educational institutions. 
            Whether its cultural festivals, academic conferences, workshops or sports meets, 
            we provide the tools to make event planning and execution hassle free. 
            From online registrations to attendance tracking, our platform is your all in one solution for managing campus events.</p>
            <a href="#" class="about-btn">Learn More</a><br><br><br><br>
            <h3>Why Choose Us? </h3>
            <span class="line"></span>
        </div>
       
        <div class="section-content text-center">
          <div class="row">
            <div class="col-md-4">
              <div class="icon-box wow fadeInUp" data-wow-delay="0.2s"> <i class="fas fa-mobile" aria-hidden="true"></i>
                <h5>User Friendly</h5>
                <p>Intuitive interface for students and staff alike.</p>
              </div>
            </div>
            <div class="col-md-4">
              <div class="icon-box wow fadeInUp" data-wow-delay="0.4s"> <i class="fas fa-building" aria-hidden="true"></i>
                <h5>Tailored for Colleges</h5>
                <p>Designed specifically for academic institutions.</p>
              </div>
            </div>
            <div class="col-md-4">
              <div class="icon-box wow fadeInUp" data-wow-delay="0.6s"> <i class="fas fa-lock" aria-hidden="true"></i>
                <h5>Data Security</h5>
                <p>Ensure participants information is secure and private.</p>
              </div>
            </div>
          </div>
           </div>
      </div>
    </div>
  </div>
</section>
<!-------About End-------> 

<!-------Video Start------->
<section class="video-section prelative text-center white" data-scroll-index='2'>
  <div class="section-padding video-overlay">
    <div class="container">
      <h3>Demo</h3>
      <i class="fa fa-play" id="video-icon" aria-hidden="true"></i>
      <div class="video-popup">
        <div class="video-src">
          <div class="iframe-src">
          <iframe 
  src="https://www.youtube.com/embed/tVzUXW6siu0?list=PLu0W_9lII9agq5TrH9XLIKQvv0iaF2X3w&showinfo=0" 
  frameborder="0" 
  allow="autoplay; encrypted-media" 
  allowfullscreen>
</iframe>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-------Video End-------> 

<!-------Club Start------->
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event management";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, name, description FROM clubs";
$result = $conn->query($sql);

$clubs = [];
while ($row = $result->fetch_assoc()) {
    $clubs[] = $row;
}
$conn->close();
?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .carousel-item {
            text-align: center;
        }
        .club-detail img {
            width: 200px;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
                    }
          .carousel-control-prev, .carousel-control-next {
                width: 2%; /* Adjust width as needed */
                opacity: 1; /* Ensure visibility */
            }

            .carousel-control-prev {
                left: -2%; /* Move the previous button further left */
            }

            .carousel-control-next {
                right: -2%; /* Move the next button further right */
            }

    </style>
</head>
<body>

<section class="club section-padding text-center" data-scroll-index='3'>
    <div class="container">
        <h3>Clubs</h3>
        <span class="line"></span>

        <div id="clubsCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php 
                $active = 'active';
                for ($i = 0; $i < count($clubs); $i += 4) { // Display 4 clubs per slide
                    echo '<div class="carousel-item ' . $active . '"><div class="row justify-content-center">';
                    $active = ''; // Only the first slide is active

                    for ($j = 0; $j < 4 && ($i + $j) < count($clubs); $j++) {
                        $club = $clubs[$i + $j];
                        $descriptionWords = explode(' ', $club["description"]);
                        $shortDescription = implode(' ', array_slice($descriptionWords, 0, 15));
                        $remainingDescription = implode(' ', array_slice($descriptionWords, 15));
                        $clubId = $club["id"];

                        echo '
                        <div class="col-md-3">
                            <div class="club-detail">
                                <img src="getImage.php?id=' . $clubId . '" class="img-fluid" alt="' . htmlspecialchars($club["name"]) . '"/>
                                <h4>' . htmlspecialchars($club["name"]) . '</h4>
                                <p id="desc' . $clubId . '">' . htmlspecialchars($shortDescription) . '<span id="more' . $clubId . '" style="display: none;"> ' . htmlspecialchars($remainingDescription) . '</span></p>
                                <a href="javascript:void(0);" class="toggle-description" onclick="toggleDescription(' . $clubId . ')">Read More</a>
                            </div>
                        </div>';
                    }

                    echo '</div></div>';
                }
                ?>
            </div>

            <!-- Left and Right Navigation Arrows (Now inside the carousel div) -->
            <button class="carousel-control-prev" type="button" data-bs-target="#clubsCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
            </button>

            <button class="carousel-control-next" type="button" data-bs-target="#clubsCarousel" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
              </button>

        </div>
    </div>
</section>

<script>
function toggleDescription(clubId) {
    var moreText = document.getElementById('more' + clubId);
    var toggleLink = moreText.parentNode.nextElementSibling;

    if (moreText.style.display === 'none') {
        moreText.style.display = 'inline';
        toggleLink.innerText = 'Read Less';
    } else {
        moreText.style.display = 'none';
        toggleLink.innerText = 'Read More';
    }
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-------Club End-------> 
<?php
include 'db.php';

// Fetch feedbacks from the database
$sql = "SELECT * FROM feedbacks ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!------- Feedbacks Section ------->
<section class="feedback section-padding">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="sectioner-header text-center white">
          <h3>Feedbacks</h3>
          <span class="line"></span>
        </div>
        <div class="section-content">
          <div class="row">
            <div class="offset-md-2 col-md-8 col-sm-12">
              <div class="slider">
                <?php while($row = $result->fetch_assoc()): ?>
                  <div class="slider-item">
                    <div class="test-text">
                      <span class="title">
                        <strong><?php echo htmlspecialchars($row['name']); ?></strong> (<?php echo htmlspecialchars($row['email']); ?>)
                      </span>
                      <p><strong>Subject:</strong> <?php echo htmlspecialchars($row['subject']); ?></p>
                      <p><?php echo htmlspecialchars($row['message']); ?></p>
                    </div>
                  </div>
                <?php endwhile; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!------- Feedbacks End ------->

<!------- Your Feedback Form ------->
<section class="yourfeedback section-padding">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="sectioner-header text-center">
          <h3>Give Your Feedback Here</h3>
          <span class="line"></span>
        </div>
        <div class="section-content center">
          <div class="row">
            <div class="offset-md-2 col-md-8 col-sm-12">
              <form id="yourfeedback_form" action="submit_feedback.php" method="POST">
                <div class="row">
                  <div class="col">
                    <input type="text" class="form-input w-100" name="name" placeholder="Full Name" required>
                  </div>
                  <div class="col">
                    <input type="email" class="form-input w-100" name="email" placeholder="Email" required>
                  </div>
                </div>
                <input type="text" class="form-input w-100" name="subject" placeholder="Subject" required>
                <textarea class="form-input w-100" name="message" placeholder="Your Feedback" required></textarea>
                <button class="btn-grad w-100 text-uppercase" type="submit">Submit</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!------- Your Feedback Form End ------->

<footer class="footer-copy">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <p>2024 &copy; QRify Events | Campus Event Manager</a></p>
      </div>
    </div>
  </div>
</footer>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
<script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script> 
<!-- scrollIt js --> 
<script src="js/scrollIt.min.js"></script> 
<script src="js/wow.min.js"></script> 
<script src="function.js">

</script>
</body>
</html>
