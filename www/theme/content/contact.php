<div class="contactus">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="contact-details">
                            <h4>Location</h4>
                            <i class="fa fa-map-marker br-red"></i>
                            <span>
                                    <?php echo $this->getSiteValues("siteaddress"); ?>
                                    <br /><?php echo $this->getSiteValues("sitestate"); ?>,
                                    <br /><?php echo $this->getSiteValues("sitecountry");?> - <?php echo $this->getSiteValues("sitezip"); ?>
                            </span>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="contact-details">
                            <h4>On-line Order</h4>
                            <i class="fa fa-phone br-green"></i> <span><?php echo $this->getSiteValues("sitephone"); ?></span>
                            <div class="clearfix"></div>
                            <i class="fa fa-envelope-o br-lblue"></i> <span><a href="mailto:<?php echo $this->getsiteValues('siteemail'); ?>"><?php echo $this->getsiteValues('siteemail'); ?></a></span>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <?php echo $this->form("Contact"); ?>
            </div>
            <div class="col-md-6">
                <div class="map-container">
                    <iframe src="https://maps.google.co.in/?ie=UTF8&amp;ll=12.953997,77.63094&amp;spn=0.815042,1.352692&amp;t=m&amp;z=10&amp;output=embed"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
