<form role="form" method="post" action="/Contact/Subscribe">
    <input type="hidden" name="hp" value="" />
    <div class="form-group">
        <input class="form-control" type="text" name="name" data-validation="required" data-validation-error-msg="Please provide your full name" data-validation-length="min5"  placeholder="Your name" />
    </div>
    <div class="form-group">
        <input class="form-control" type="email" name="email" data-validation="email"  data-validation-error-msg="Please provide a valid email" placeholder="Your email" />
    </div>
    <button class="btn btn-danger" type="submit">Subscribe</button>
</form>