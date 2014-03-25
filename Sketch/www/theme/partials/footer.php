<div class="footer padd">
    <div class="container">
        <div class="row hidden">
            <div class="col-md-3 col-sm-6">
                <div class="footer-widget">
                    <div class="logo">
                            <img class="img-responsive" src="img/logo.png" alt="" />
                            <h1><?php echo $this->getSiteValues('sitename'); ?></h1>
                    </div>
                    <p><?php echo $this->getSiteValues('footertext'); ?></p>
                    <hr />
                    <h6>On-line Payment Clients</h6>
                    <!--<a href="#"><img class="payment img-responsive" src="img/payment/2co.gif" alt="" /></a>// !-->
                    <!--<a href="#"><img class="payment img-responsive" src="img/payment/authorizenet.gif" alt="" /></a>// !-->
                    <!--<a href="#"><img class="payment img-responsive" src="img/payment/discover.gif" alt="" /></a>// !-->
                    <!-- <a href="#"><img class="payment img-responsive" src="img/payment/egold.gif" alt="" /></a> // !-->
                    <a href="#"><img class="payment img-responsive" src="img/payment/mastercard.gif" alt="" /></a>
                    <a href="#"><img class="payment img-responsive" src="img/payment/paypal.gif" alt="" /></a>
                    <a href="#"><img class="payment img-responsive" src="img/payment/visa.gif" alt="" /></a>
                    <!--<a href="#"><img class="payment img-responsive" src="img/payment/worldpay.gif" alt="" /></a>// !-->
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="footer-widget">
                    <h4>Famous Dishes</h4>
                    <a href="#"><img class="dish img-responsive" src="img/dish/dish1.jpg" alt="" /></a>
                    <a href="#"><img class="dish img-responsive" src="img/dish/dish1.jpg" alt="" /></a>
                    <a href="#"><img class="dish img-responsive" src="img/dish/dish1.jpg" alt="" /></a>
                    <a href="#"><img class="dish img-responsive" src="img/dish/dish1.jpg" alt="" /></a>
                    <a href="#"><img class="dish img-responsive" src="img/dish/dish1.jpg" alt="" /></a>
                    <a href="#"><img class="dish img-responsive" src="img/dish/dish1.jpg" alt="" /></a>
                    <a href="#"><img class="dish img-responsive" src="img/dish/dish1.jpg" alt="" /></a>
                    <a href="#"><img class="dish img-responsive" src="img/dish/dish1.jpg" alt="" /></a>
                    <a href="#"><img class="dish img-responsive" src="img/dish/dish1.jpg" alt="" /></a>
                </div>
            </div>
            <div class="clearfix visible-sm"></div>
            <div class="col-md-3 col-sm-6">
                <div class="footer-widget">
                    <h4>Email Us Today</h4>
                    <p>Fill out the form below to contact <?php echo $this->getSiteValues('sitename'); ?></p>
                    <form role="form" method="post">
                            <div class="form-group">
                                    <input class="form-control" type="text" placeholder="Your name" />
                            </div>
                            <div class="form-group">
                                    <input class="form-control" type="email" placeholder="Your email" />
                            </div>
                            <button class="btn btn-danger" type="button">Subscribe</button>
                    </form>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="footer-widget">
                    
                    <h4>Contact Us</h4>
                    <div class="contact-details">
                            <i class="fa fa-map-marker br-red"></i> 
                                    <span><?php echo $this->getSiteValues("siteaddress"); ?>
                                    <br /><?php echo $this->getSiteValues("sitestate"); ?>,
                                    <br /><?php echo $this->getSiteValues("sitecountry");?> - <?php echo $this->getSiteValues("sitezip"); ?>
                                    </span>
                            <div class="clearfix"></div>
                            <i class="fa fa-phone br-green"></i> <span><?php echo $this->getSiteValues("sitephone"); ?></span>
                            <div class="clearfix"></div>
                            <i class="fa fa-envelope-o br-lblue"></i> <span><a href="mailto:<?php echo $this->getSiteValues("siteemail"); ?>"><?php echo $this->getSiteValues("siteemail"); ?></a></span>
                            <div class="clearfix"></div>
                    </div>
                    <!-- Social media icon -->
                    <div class="social">
                            <a href="#" class="facebook"><i class="fa fa-facebook"></i></a>
                            <a href="#" class="google-plus"><i class="fa fa-google-plus"></i></a>
                            <a href="#" class="twitter"><i class="fa fa-twitter"></i></a>
                            <a href="#" class="pinterest"><i class="fa fa-pinterest"></i></a>
                    </div>
                </div>
            </div>
        </div>
 
        <div class="footer-copyright">
                <p>&copy; Copyright 2014 <a href="<?php echo $this->basePath(); ?>"><?php echo $this->getSiteValues('sitename'); ?></a></p>
        </div>
    </div>
</div>
<?php
echo $this->inlineScript()
                ->prependFile($this->basePath('Assets/Bootstrap/v1/js/bootstrap.min.js'))
                ->prependFile($this->basePath('Assets/Stickyfooter/v1/js/stickyfooter.js'))
                ->prependFile($this->basePath('Assets/jquery/v11/js/jquery-ui-1.10.4.custom.min.js'))
                ->prependFile($this->basePath('Assets/jquery/v11/js/jquery.11.js'))
                ->appendFile($this->basePath("Assets/Prettyphoto/v1/js/prettyphoto.js"))    
                ->appendFile($this->basePath("Assets/Tools/v1/js/tools.min.js"))
                ->appendFile($this->basePath("Assets/Revolution/v1/js/revolution.min.js"))
                ->appendFile($this->basePath("Assets/Flexslider/v1/js/flexslider.min.js"))
                ->appendFile($this->basePath('js/custom.js'))
                ->minify();                    
?>
</body>
</html>