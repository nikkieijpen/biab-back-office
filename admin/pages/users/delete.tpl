<h2 class="product-head">
    Delete user
</h2>

<div class="panel-body">
    <form class="form-horizontal" role="form" name="checkoutForm" method="post" action="">
        <p>
            Are you sure you want to delete this user?

            <dl class="dl-horizontal">
                <dt>ID:</dt>
                <dd>{{ user._id }}</dd>
                <dt>Name:</dt>
                <dd>{{ user.name }}</dd>
                <dt>Email address:</dt>
                <dd>{{ user.email }}</dd>
            </dl>

        </p>

        <div class="text-uppercase clearfix">
            <button type="submit" class="btn btn-danger pull-left">
                    Delete user
            </button>
        </div>

        <input type="hidden" id="action" name="id" value="{{ user._id }}">
        <input type="hidden" id="action" name="action" value="user_delete">
    </form>
</div>
