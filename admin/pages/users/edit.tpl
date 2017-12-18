<h2 class="product-head">
    Edit user
</h2>

<div class="panel-body">
    <form class="form-horizontal" role="form" name="checkoutForm" method="post" action="">
        <div class="form-group">
            <label for="name" class="col-lg-3 control-label">Name:</label>
            <div class="col-sm-9">
                <input class="form-control" type="text" id="name" name="name" value="{{ user.name }}">
            </div>
        </div>

        <div class="form-group">
            <label for="email" class="col-lg-3 control-label">Email address:</label>
            <div class="col-sm-9">
                <input class="form-control" type="email" id="email" name="email" value="{{ user.email }}">
            </div>
        </div>

        <div class="text-uppercase clearfix">
            <button type="submit" class="btn btn-default pull-right">
                    Save
            </button>
        </div>

        <input type="hidden" id="action" name="id" value="{{ user._id }}">
        <input type="hidden" id="action" name="action" value="user_edit">
    </form>
</div>
