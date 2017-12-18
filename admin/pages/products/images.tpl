<h2 class="product-head">
    Edit product images
</h2>

<div class="panel-body">
    <form class="form-horizontal" role="form" name="checkoutForm" method="post" action="" enctype="multipart/form-data">
        <div class="form-group">
            <label for="position" class="col-lg-3 control-label">Position:</label>
            <div class="col-sm-9">
                <input class="form-control" type="text" id="position" name="position" value="{{ position }}" disabled>
            </div>
        </div>

        {% for size,src in images %}
            <div class="form-group">
                <label for="{{ size }}" class="col-lg-3 control-label">{{ size}}x{{ size }}:</label>
                <div class="col-sm-6">
                    <input class="form-control" type="file" id="{{ size }}" name="{{ size }}">
                </div>
                <div class="col-sm-3">
                {% if src == 'null' %}
                    &nbsp;
                {% else %}
                    <img src="{{ src }}" alt="{{ size }}" style="width: 100px;">
                {% endif %}
                </div>
            </div>
        {% endfor %}

        <div class="text-uppercase clearfix">
            <button type="submit" class="btn btn-default pull-right">
                    Save
            </button>
        </div>

        <input type="hidden" id="action" name="id" value="{{ product._id }}">
        <input type="hidden" id="action" name="position" value="{{ position }}">
        <input type="hidden" id="action" name="action" value="product_image">
    </form>
</div>
