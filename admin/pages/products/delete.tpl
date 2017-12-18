<h2 class="product-head">
    Delete product
</h2>

<div class="panel-body">
    <form class="form-horizontal" role="form" name="checkoutForm" method="post" action="">
        <p>
            Are you sure you want to delete this product?

            <dl class="dl-horizontal">
                <dt>ID:</dt>
                <dd>{{ product._id }}</dd>
                <dt>Number:</dt>
                <dd>{{ product.sku }}</dd>
                <dt>Name EN:</dt>
                <dd>{{ product.title.en_GB }}</dd>
                <dt>Name NL:</dt>
                <dd>{{ product.title.nl_NL }}</dd>
                <dt>Name PT:</dt>
                <dd>{{ product.title.pt_BR }}</dd>
            </dl>

        </p>

        <div class="text-uppercase clearfix">
            <button type="submit" class="btn btn-danger pull-left">
                    Delete product
            </button>
        </div>

        <input type="hidden" id="action" name="id" value="{{ product._id }}">
        <input type="hidden" id="action" name="action" value="product_delete">
    </form>
</div>
