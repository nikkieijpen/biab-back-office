<h2 class="product-head">
    Edit order status
</h2>

<div class="panel-body">
    <form class="form-horizontal" role="form" name="checkoutForm" method="post" action="">
        <p>
            Are you sure you want to set this order to a new status?

            <dl class="dl-horizontal">
                <dt>New status:</dt>
                <dd>{{ status }}</dd>
                <dt>Actions:</dt>
                <dd>
                    {% if status == 'PAID' %}
                    Email: Order confirmation<br />
                    Stock change: product quantities may be deducted from stock
                    {% endif %}
                    {% if status == 'PACKED' %}
                    Email: Order ready for delivery<br />
                    Stock change: product quantities may be deducted from stock
                    {% endif %}
                    {% if status == 'DELIVERED' %}
                    None
                    {% endif %}
                    {% if status == 'CANCELLED' %}
                    Email: None<br />
                    Stock change: product quantities may be added to stock
                    {% endif %}
                    {% if status == 'EXPIRED' %}
                    Email: None<br />
                    Stock change: product quantities may be added to stock
                    {% endif %}
                </dd>
            </dl>

        </p>

        <div class="text-uppercase clearfix">
            <button type="submit" class="btn btn-danger">
                    Set new order status
            </button>
        </div>

        <input type="hidden" id="status" name="status" value="{{ status }}">
        <input type="hidden" id="action" name="id" value="{{ order._id }}">
        <input type="hidden" id="action" name="action" value="order_status">
    </form>
</div>
