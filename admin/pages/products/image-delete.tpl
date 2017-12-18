<h2 class="product-head">
    Delete product image
</h2>

<div class="panel-body">
    <form class="form-horizontal" role="form" name="checkoutForm" method="post" action="">
        <p>
            Are you sure you want to delete this product image?

            <dl class="dl-horizontal">
                <dt>SKU:</dt>
                <dd>{{ product.sku }}</dd>
                <dt>Position:</dt>
                <dd>{{ position }}</dd>
                <dt>Image:</dt>
                <dd><img src="{{ src }}" alt="120" style="width: 120px;"></dd>
            </dl>

        </p>

        <div class="text-uppercase clearfix">
            <button type="submit" class="btn btn-danger pull-left">
                    Delete product image
            </button>
        </div>

        <input type="hidden" id="id" name="id" value="{{ product._id }}">
        <input type="hidden" id="position" name="position" value="{{ position }}">
        <input type="hidden" id="action" name="action" value="product_image_delete">
    </form>
</div>
