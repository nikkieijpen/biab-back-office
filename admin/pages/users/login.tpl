<h2 class="product-head">
    Login
</h2>

<div class="panel-body">
    <form class="form-horizontal" role="form" name="checkoutForm" method="post" action="?s=categories&amp;p=list">
        <div class="form-group">
            <label for="email" class="col-lg-3 control-label">Email address:</label>
            <div class="col-sm-9">
                <input class="form-control" type="email" id="email" name="email">
            </div>
        </div>

        <div class="form-group">
            <label for="password" class="col-lg-3 control-label">Password:</label>
            <div class="col-sm-9">
                <input class="form-control" type="password" id="password" name="password">
            </div>
        </div>

        <div class="text-uppercase clearfix">
            <button type="submit" class="btn btn-default pull-right">
                    Login
            </button>
        </div>

        <input type="hidden" id="action" name="action" value="login">
    </form>
</div>
