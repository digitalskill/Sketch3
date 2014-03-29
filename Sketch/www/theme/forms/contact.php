<div class="contact-form">
    <h3>Contact Form</h3>
    <form role="form" method="post">
        <div class="form-group">
            <input class="form-control" type="text" placeholder="Name" name="name" data-validation="required"/>
        </div>
        <div class="form-group">
            <input class="form-control" type="email" placeholder="Email" name="email" data-validation="email" data-validation-help="Please enter your email address"/>
        </div>
        <div class="form-group">
            <input type="hidden" name="hp" value='' />
            <textarea class="form-control" rows="3" placeholder="Message..." name="message" data-validation="required"></textarea>
        </div>
        <button class="btn btn-danger btn-sm" type="submit">Send</button>&nbsp;
        <button class="btn btn-default btn-sm" type="reset">Reset</button>
    </form>
</div>
