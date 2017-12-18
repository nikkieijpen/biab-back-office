<h2 class="product-head">
    Add a product
</h2>

<div class="panel-body">
    <form class="form-horizontal" role="form" name="checkoutForm" method="post" action="">
        <div class="form-group">
            <label for="sku" class="col-lg-3 control-label">SKU:</label>
            <div class="col-sm-9">
                <input class="form-control" type="text" id="sku" name="sku" value="{{ sku }}" disabled>
            </div>
        </div>

        <div class="form-group">
            <label for="category" class="col-lg-3 control-label">Category:</label>
            <div class="col-sm-9">
                <select name="category" class="form-control">
                    {% for category in categories %}
                        <option value="{{ category._id }}">{{ category.name.en_GB }}</option>
                    {% endfor %}
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="brand" class="col-lg-3 control-label">Brand:</label>
            <div class="col-sm-9">
                <input class="form-control" type="text" id="brand" name="brand">
            </div>
        </div>

        <div class="form-group">
            <label for="fromPrice" class="col-lg-3 control-label">From price:</label>
            <div class="col-sm-9">
                <input class="form-control" type="text" id="fromPrice" name="fromPrice" placeholder="0.00">
            </div>
        </div>

        <div class="form-group">
            <label for="price" class="col-lg-3 control-label">Price:</label>
            <div class="col-sm-9">
                <input class="form-control" type="text" id="price" name="price" placeholder="0.00">
            </div>
        </div>

        <div class="form-group">
            <label for="stock" class="col-lg-3 control-label">Stock:</label>
            <div class="col-sm-9">
                <input class="form-control" type="text" id="stock" name="stock" placeholder="0">
            </div>
        </div>

        <div class="form-group">
            <label for="tags" class="col-lg-3 control-label">Tags:</label>
            <div class="col-sm-9">
                <div class="checkbox">
                    <label><input type="checkbox" name="tags[]" value="offer"> Offer</label>
                    <label><input type="checkbox" name="tags[]" value="bestseller"> Bestseller</label>
                </div>
            </div>
        </div>

        <hr>

        <div class="form-group">
            <label for="title_EN" class="col-lg-3 control-label">Title EN:</label>
            <div class="col-sm-9">
                <input class="form-control" type="text" id="title_EN" name="title_EN">
            </div>
        </div>

        <div class="form-group">
            <label for="description_EN" class="col-lg-3 control-label">Description EN:</label>
            <div class="col-sm-9">
                <textarea class="form-control" rows="3" id="description_EN" name="description_EN"></textarea>
            </div>
        </div>

        <hr>

        <div class="form-group">
            <label for="title_NL" class="col-lg-3 control-label">Title NL:</label>
            <div class="col-sm-9">
                <input class="form-control" type="text" id="title_NL" name="title_NL">
            </div>
        </div>

        <div class="form-group">
            <label for="description_NL" class="col-lg-3 control-label">Description NL:</label>
            <div class="col-sm-9">
                <textarea class="form-control" rows="3" id="description_NL" name="description_NL"></textarea>
            </div>
        </div>

        <hr>

        <div class="form-group">
            <label for="title_PT" class="col-lg-3 control-label">Title PT:</label>
            <div class="col-sm-9">
                <input class="form-control" type="text" id="title_PT" name="title_PT">
            </div>
        </div>

        <div class="form-group">
            <label for="description_PT" class="col-lg-3 control-label">Description PT:</label>
            <div class="col-sm-9">
                <textarea class="form-control" rows="3" id="description_PT" name="description_PT"></textarea>
            </div>
        </div>

        <div class="text-uppercase clearfix">
            <button type="submit" class="btn btn-default pull-right">
                    Save
            </button>
        </div>

        <input type="hidden" id="action" name="sku" value="{{ sku }}">
        <input type="hidden" id="action" name="action" value="product_create">
    </form>
</div>
