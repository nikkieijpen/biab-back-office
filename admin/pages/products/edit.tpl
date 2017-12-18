<h2 class="product-head">
    Edit a product
</h2>

<div class="panel-body">
    <form class="form-horizontal" role="form" name="checkoutForm" method="post" action="">
        <div class="form-group">
            <label for="category" class="col-lg-3 control-label">Category:</label>
            <div class="col-sm-9">
                <select name="category" class="form-control">
                    {% for category in categories %}
                        <option value="{{ category._id }}"
                        {% if category._id == product.category %}
                            selected="selected"
                        {% endif %}
                        >{{ category.name.en_GB }}</option>
                    {% endfor %}
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="brand" class="col-lg-3 control-label">Brand:</label>
            <div class="col-sm-9">
                <input class="form-control" type="text" id="brand" name="brand" value="{{ product.brand }}">
            </div>
        </div>

        <div class="form-group">
            <label for="tags" class="col-lg-3 control-label">Tags:</label>
            <div class="col-sm-9">
                <div class="checkbox">
                    <label><input type="checkbox" name="tags[]" value="offer"{% if 'offer' in product.tags %} checked="checked" {% endif %}> Offer</label>
                    <label><input type="checkbox" name="tags[]" value="bestseller"{% if 'bestseller' in product.tags %} checked="checked" {% endif %}> Bestseller</label>
                </div>
            </div>
        </div>

        <hr>

        <div class="form-group">
            <label for="title_EN" class="col-lg-3 control-label">Title EN:</label>
            <div class="col-sm-9">
                <input class="form-control" type="text" id="title_EN" name="title_EN" value="{{ product.title.en_GB }}">
            </div>
        </div>

        <div class="form-group">
            <label for="description_EN" class="col-lg-3 control-label">Description EN:</label>
            <div class="col-sm-9">
                <textarea class="form-control" rows="3" id="description_EN" name="description_EN">{{ product.description.en_GB }}</textarea>
            </div>
        </div>

        <hr>

        <div class="form-group">
            <label for="title_NL" class="col-lg-3 control-label">Title NL:</label>
            <div class="col-sm-9">
                <input class="form-control" type="text" id="title_NL" name="title_NL" value="{{ product.title.nl_NL }}">
            </div>
        </div>

        <div class="form-group">
            <label for="description_NL" class="col-lg-3 control-label">Description NL:</label>
            <div class="col-sm-9">
                <textarea class="form-control" rows="3" id="description_NL" name="description_NL">{{ product.description.nl_NL }}</textarea>
            </div>
        </div>

        <hr>

        <div class="form-group">
            <label for="title_PT" class="col-lg-3 control-label">Title PT:</label>
            <div class="col-sm-9">
                <input class="form-control" type="text" id="title_PT" name="title_PT" value="{{ product.title.pt_BR }}">
            </div>
        </div>

        <div class="form-group">
            <label for="description_PT" class="col-lg-3 control-label">Description PT:</label>
            <div class="col-sm-9">
                <textarea class="form-control" rows="3" id="description_PT" name="description_PT">{{ product.description.pt_BR }}</textarea>
            </div>
        </div>

        <div class="text-uppercase clearfix">
            <button type="submit" class="btn btn-default pull-right">
                    Save
            </button>
        </div>

        <input type="hidden" id="action" name="id" value="{{ product._id }}">
        <input type="hidden" id="action" name="action" value="product_edit">
    </form>
</div>
