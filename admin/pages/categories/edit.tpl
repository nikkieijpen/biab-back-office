<h2 class="product-head">
    Edit category
</h2>

<div class="panel-body">
    <form class="form-horizontal" role="form" name="checkoutForm" method="post" action="">
        <div class="form-group">
            <label for="name_EN" class="col-lg-3 control-label">Name EN:</label>
            <div class="col-sm-9">
                <input class="form-control" type="text" id="name_EN" name="name_EN" value="{{ category.name.en_GB }}">
            </div>
        </div>

        <div class="form-group">
            <label for="name_NL" class="col-lg-3 control-label">Name NL:</label>
            <div class="col-sm-9">
                <input class="form-control" type="text" id="name_NL" name="name_NL" value="{{ category.name.nl_NL }}">
            </div>
        </div>

        <div class="form-group">
            <label for="name_PT" class="col-lg-3 control-label">Name PT:</label>
            <div class="col-sm-9">
                <input class="form-control" type="text" id="name_NL" name="name_PT" value="{{ category.name.pt_BR }}">
            </div>
        </div>

        <div class="text-uppercase clearfix">
            <button type="submit" class="btn btn-default pull-right">
                    Save
            </button>
        </div>

        <input type="hidden" id="action" name="id" value="{{ category._id }}">
        <input type="hidden" id="action" name="action" value="category_edit">
    </form>
</div>
