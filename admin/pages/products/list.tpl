<h2 class="product-head">
    Products
</h2>
<a href="?s=products&amp;p=create" class="create btn btn-default">
    <i class="fa fa-plus"></i>
    Add a new product
</a>
{% if products %}
    <table>
        <tr>
            <th>SKU</th>
            <th>Title (EN)</th>
            <th>From price</th>
            <th>Price</th>
            <th>Stock</th>
            <th style="width: 250px;">Action</th>
        </tr>

        {% for product in products %}
        <tr>
            <td>{{ product.sku }}.</td>
            <td>{{ product.title.en_GB }}</td>
            <td>{{ product.fromPrice }}</td>
            <td>{{ product.price }}</td>
            <td>{{ product.stock }}</td>
            <td>
                <a href="?s=products&amp;p=stock&amp;id={{ product._id }}" class="btn btn-info">
				    <i class="fa fa-cubes"></i>
				</a>
                <a href="?s=products&amp;p=price&amp;id={{ product._id }}" class="btn btn-info">
				    <i class="fa fa-euro"></i>
				</a>
                <a href="?s=products&amp;p=image-list&amp;id={{ product._id }}" class="btn btn-info">
				    <i class="fa fa-picture-o"></i>
				</a>
                <a href="?s=products&amp;p=edit&amp;id={{ product._id }}" class="btn btn-warning">
				    <i class="fa fa-edit"></i>
				</a>
                <a href="?s=products&amp;p=delete&amp;id={{ product._id }}" class="btn btn-danger">
				    <i class="fa fa-ban"></i>
				</a>
            </td>
        </tr>
        {% endfor %}

    </table>
{% else %}
    <div class="alert alert-info">
        There are no products.
    </div>
{% endif %}
