<h2 class="product-head">
    Delete category
</h2>

{% if numProducts > 0 %}
<div class="alert alert-danger">
    <strong>Warning!</strong> There are still {{ numProducts }} product(s) in this category. Move them to an other category first!
</div>
{% endif %}

{% if numProducts == 0 %}
<div class="alert alert-success">
    <strong>OK!</strong> There are no products in this category. It can be safely deleted.
</div>
{% endif %}

<div class="panel-body">
    <form class="form-horizontal" role="form" name="checkoutForm" method="post" action="">
        <p>
            Are you sure you want to delete this category?

            <dl class="dl-horizontal">
                <dt>ID:</dt>
                <dd>{{ category._id }}</dd>
                <dt>Number:</dt>
                <dd>{{ category.number }}</dd>
                <dt>Name EN:</dt>
                <dd>{{ category.name.en_GB }}</dd>
                <dt>Name NL:</dt>
                <dd>{{ category.name.nl_NL }}</dd>
                <dt>Name PT:</dt>
                <dd>{{ category.name.pt_BR }}</dd>
            </dl>

        </p>

        {% if numProducts == 0 %}
        <div class="text-uppercase clearfix">
            <button type="submit" class="btn btn-danger pull-left">
                    Delete category
            </button>
        </div>
        {% endif %}

        <input type="hidden" id="action" name="id" value="{{ category._id }}">
        <input type="hidden" id="action" name="action" value="category_delete">
    </form>
</div>
