<?php include("./source/header.php");?>
  <main>
    <article>

      <!-- 
        - #HERO
      -->

      <section id="hero" style="background: url('../assets/images/hero-banner.jpg') no-repeat;background-size: cover;  background-position: top center;  margin-top: 90px;  padding: var(--section-padding) 0;  height: 100vh; /** Default: 100vh**/  max-height: 1000px;  display: flex;  justify-content: center;  align-items: center;  text-align: center;">
        <div class="container">

          <p class="hero-subtitle">Meet the</p>

          <h1 class="h1 hero-title">Masters</h1>

          <div class="btn-group">

              <button class="btn btn-primary" onclick="location.href='#id';">
              <span>Join now</span>

              <ion-icon name="play-circle"></ion-icon>
            </button>

            <button class="btn btn-link" onclick="location.href='#about';">Learn more</button>
          </div>

        </div>
      </section>





      <div class="section-wrapper">

        <!-- 
          - #ABOUT
        -->

        <section class="about" id="about">
          <div class="container">
            <figure class="about-banner">
                <img src="../assets/images/about-img.jpg" alt="M shape" class="about-img">
            </figure>
              
            <div class="about-content">

              <p class="about-subtitle">About section</p>

              <h2 class="about-title">Experience for genshin <strong>players</strong> </h2>

              <p class="about-text">
                  Meet the Genshin masters to learn tips and tricks that only Pro players know!
                  Join us to stand a chance on teaming with masters for a match!
              </p>

              <p class="about-bottom-text">
                <ion-icon name="arrow-forward-circle-outline"></ion-icon>

                <span>Will learned Genshin tips and tricks</span>
              </p>

            </div>

          </div>
        </section>

        <!-- 
          - #GALLERY
        -->
        
        <section class="gallery">
          <div class="container">

            <ul class="gallery-list has-scrollbar">

              <li>
                <figure class="gallery-item">
                  <img src="../assets/images/gallery-img-1.jpg" alt="Gallery image">
                </figure>
              </li>

              <li>
                <figure class="gallery-item">
                  <img src="../assets/images/gallery-img-2.jpg" alt="Gallery image">
                </figure>
              </li>

              <li>
                <figure class="gallery-item">
                  <img src="../assets/images/gallery-img-3.jpg" alt="Gallery image">
                </figure>
              </li>

              <li>
                <figure class="gallery-item">
                  <img src="../assets/images/gallery-img-4.jpg" alt="Gallery image">
                </figure>
              </li>

            </ul>

          </div>
        </section>
        




        <!-- 
          - #TEAM (Speakers)
        -->

        <section class="speaker" id="speaker">
          <div class="container">

            <h2 class="h2 section-title">Our Speakers</h2>

            <ul class="speaker-list">
              <li>
                <a href="#" class="speaker-member">
                  <figure>
                    <img src="../assets/images/speaker-member-1.png" alt="Speaker image">
                  </figure>

                  <ion-icon name="link-outline"></ion-icon>
                </a>
              </li>
              
              <li>
                <a href="#" class="speaker-member">
                  <figure>
                    <img src="../assets/images/speaker-member-2.png" alt="Speaker image">
                  </figure>

                  <ion-icon name="link-outline"></ion-icon>
                </a>
              </li>

              <li>
                <a href="#" class="speaker-member">
                  <figure>
                    <img src="../assets/images/speaker-member-3.png" alt="Speaker image">
                  </figure>

                  <ion-icon name="link-outline"></ion-icon>
                </a>
              </li>
              
            <!--
            <button class="btn btn-primary">view all members</button>
            -->
          </div>
        </section>
  
  <?php include("./source/footer.php");?>
  
  <!-- 
    - #GO TO TOP
  -->

  <a href="#top" class="btn btn-primary go-top" data-go-top>
    <ion-icon name="chevron-up-outline"></ion-icon>
  </a>

  <!-- 
    - custom js link
  -->
  <script src="./assets/js/script.js"></script>

  <!-- 
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>
</html>

