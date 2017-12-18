<h2 class="product-head">
    Reset user password
</h2>

<div class="panel-body">
    <form class="form-horizontal" role="form" name="checkoutForm" method="post" action="">
        <div class="form-group">
            <label for="password" class="col-lg-3 control-label">Password:</label>
            <div class="col-sm-9">
                <input class="form-control" type="password" id="password" name="password">
            </div>
        </div>

        <div class="form-group">
            <label for="password_confirm" class="col-lg-3 control-label">Confirm password:</label>
            <div class="col-sm-9">
                <input class="form-control" type="password" id="password_confirm" name="password_confirm">
            </div>
        </div>

        <div class="text-uppercase clearfix">
            <button type="submit" class="btn btn-default pull-right">
                    Save
            </button>
        </div>

        <input type="hidden" id="action" name="id" value="{{ user._id }}">
        <input type="hidden" id="action" name="action" value="user_password">
    </form>
</div>
