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
                <div class="contact-form">      
                    <h3>Contact Form</h3>
                    <form role="form" method="post">
                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="Name" />
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="email" placeholder="Email" />
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" rows="3" placeholder="Message..."></textarea>
                        </div>
                        <button class="btn btn-danger btn-sm" type="submit">Send</button>&nbsp;
                        <button class="btn btn-default btn-sm" type="reset">Reset</button>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="map-container">
                    <iframe src="https://maps.google.co.in/?ie=UTF8&amp;ll=12.953997,77.63094&amp;spn=0.815042,1.352692&amp;t=m&amp;z=10&amp;output=embed"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>