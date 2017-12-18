<h2 class="product-head">
    Edit product stock
</h2>

<div class="panel-body">
    <form class="form-horizontal" role="form" name="checkoutForm" method="post" action="">
        <div class="form-group">
            <label for="fromPrice" class="col-lg-3 control-label">From price:</label>
            <div class="col-sm-9">
                <input class="form-control" type="text" id="fromPrice" name="fromPrice" value="{{ product.fromPrice }}">
            </div>
        </div>

        <div class="form-group">
            <label for="price" class="col-lg-3 control-label">Price:</label>
            <div class="col-sm-9">
                <input class="form-control" type="text" id="price" name="price" value="{{ product.price }}">
            </div>
        </div>

        <div class="text-uppercase clearfix">
            <button type="submit" class="btn btn-default pull-right">
                    Save
            </button>
        </div>

        <input type="hidden" id="action" name="id" value="{{ product._id }}">
        <input type="hidden" id="action" name="action" value="product_price">
    </form>
</div>
