<?php
/**
 * @var common\models\Office $office
 * @var common\models\OfficeMedia $officeMedias
 */
?>


<!-- Footer Start -->
<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="footer-widget">
                    <h3 class="title">Get in Touch</h3>
                    <div class="contact-info">
                        <p><i class="fa fa-map-marker"></i><?=$office->address;?></p>
                        <p><i class="fa fa-envelope"></i><?=$office->email;?></p>
                        <p><i class="fa fa-phone"></i><?=$office->phone_number;?></p>
                        <div class="social">
                            <?php foreach ($officeMedias as $officeMediaItem) {  ?>
                                <a href="<?= $officeMediaItem->description; ?>">
                                    <i class="<?= $officeMediaItem->title; ?>"></i></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="footer-widget">
                    <h3 class="title">Useful Links</h3>
                    <ul>
                        <li><a href="#">Lorem ipsum</a></li>
                        <li><a href="#">Pellentesque</a></li>
                        <li><a href="#">Aenean vulputate</a></li>
                        <li><a href="#">Vestibulum sit amet</a></li>
                        <li><a href="#">Nam dignissim</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="footer-widget">
                    <h3 class="title">Newsletter</h3>
                    <div class="newsletter">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus sed porta dui. Class aptent
                            taciti sociosqu
                        </p>
                        <form>
                            <input class="form-control" type="email" placeholder="Your email here">
                            <button class="btn">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->


<!-- Footer Menu Start -->
<div class="footer-menu">
    <div class="container">
        <div class="f-menu">
            <a href="">Terms of use</a>
            <a href="">Privacy policy</a>
            <a href="">Cookies</a>
            <a href="">Accessibility help</a>
            <a href="">Advertise with us</a>
            <a href="">Contact us</a>
        </div>
    </div>
</div>
<!-- Footer Menu End -->

<!-- Footer Bottom Start -->
<div class="footer-bottom">
    <div class="container">
        <div class="row">
            <div class="col-md-6 copyright">
                <p>Copyright &copy; <a href="https://daraspace.com">Daraspace</a>. All Rights Reserved</p>
            </div>

            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
            <div class="col-md-6 template-by">
                <p>Designed By <a href="https://htmlcodex.com">HTML Codex</a></p>
            </div>
        </div>
    </div>
</div>
<!-- Footer Bottom End -->