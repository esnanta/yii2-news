<?php
/**
 * @var Office      $office
 * @var OfficeMedia $officeMedias
 */

use common\models\Office;
use common\models\OfficeSocialAccount;
use rmrevin\yii\fontawesome\FAS;

$siteLinks = OfficeSocialAccount::find()->limit(6)
    ->orderBy(['id' => SORT_ASC])->all()
;
?>


<!-- Footer Start -->
<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="footer-widget">
                    <h3 class="title">Get in Touch</h3>
                    <div class="contact-info">
                        <p><i class="fa fa-map-marker"></i><?php echo $office->address; ?></p>
                        <p><i class="fa fa-envelope"></i><?php echo $office->email; ?></p>
                        <p><i class="fa fa-phone"></i><?php echo $office->phone_number; ?></p>

                    </div>
                </div>
            </div>

            <div class="col-lg-5 col-md-5">
                <div class="footer-widget">
                    <h3 class="title">Useful Links</h3>
                    <ul>
                        <?php foreach ($siteLinks as $siteLinkItem) {  ?>
                            <li><a href="<?php echo $siteLinkItem->description; ?>">
                                    <?php echo $siteLinkItem->title; ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>

            <div class="col-lg-3 col-md-3">
                <div class="footer-widget">
                    <h3 class="title">Social</h3>
                    <div class="footer-widget">
                        <div class="social">
                            <?php foreach ($officeMedias as $officeMediaItem) {  ?>
                                <a href="<?php echo $officeMediaItem->description; ?>">
                                    <i class="<?php echo $officeMediaItem->title; ?>"></i></a>
                            <?php } ?>
                        </div>

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
                <p><?php echo FAS::icon('globe'); ?> <a href="https://daraspace.com"> DARASPACE</a> | Some Rights Reserved</p>
            </div>

            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
            <div class="col-md-6 template-by">
                <p>Designed By <a href="https://htmlcodex.com">HTML Codex</a></p>
            </div>
        </div>
    </div>
</div>
<!-- Footer Bottom End -->