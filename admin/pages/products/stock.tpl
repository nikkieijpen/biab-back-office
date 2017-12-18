<h2 class="product-head">
    Edit product stock
</h2>

<div class="panel-body">
    <form class="form-horizontal" role="form" name="checkoutForm" method="post" action="">
        <div class="form-group">
            <label for="stock" class="col-lg-3 control-label">Stock:</label>
            <div class="col-sm-9">
                <input class="form-control" type="text" id="stock" name="stock" value="{{ product.stock }}">
            </div>
        </div>

        <div class="text-uppercase clearfix">
            <button type="submit" class="btn btn-default pull-right">
                    Save
            </button>
        </div>

        <input type="hidden" id="action" name="id" value="{{ product._id }}">
        <input type="hidden" id="action" name="action" value="product_stock">
    </form>
</div>
