<?php
ob_start();
?>

<section class="about section bd-container" id="about">
                <div class="about__container  bd-grid">
                    <div class="about__data">
                        <span class="section-subtitle about__initial">About us</span>
                        <h2 class="section-title about__initial">We cook the best <br> tasty food</h2>
                        <p class="about__description">We cook the best food in the entire city, with excellent customer service, the best meals and at the best price, visit us.</p>
                        <a href="#" class="button">Explore history</a>
                    </div>

                    <img src="assets/img/about.jpg" alt="" class="about__img">
                </div>
            </section>


<?php
$page = ob_get_clean();
?>