<h2 class="product-head">
    Product images: {{ product.sku }} - {{ product.title.en_GB }}
</h2>
<a href="?s=products&amp;p=images&amp;id={{ product._id }}" class="create btn btn-default">
    <i class="fa fa-plus"></i>
    Add a new image
</a>
{% if product.imageCount > 0 %}
    <table>
        <tr>
            <th>Position</th>
            <th>Afbeelding</th>
            <th style="width: 250px;">Action</th>
        </tr>

        {% for i in 0..product.imageCount-1 %}
        <tr>
            <td>{{ i }}.</td>
            <td><img src="{{ root }}{{ product.sku }}-{{ i }}-220.png" alt="{{ i }}-220" style="width: 100px;"></td>
            <td>
                <a href="?s=products&amp;p=images&amp;id={{ product._id }}&amp;position={{ i }}" class="btn btn-warning">
				    <i class="fa fa-edit"></i>
				</a>
                <a href="?s=products&amp;p=image-delete&amp;id={{ product._id }}&amp;position={{ i }}" class="btn btn-danger">
				    <i class="fa fa-ban"></i>
				</a>
            </td>
        </tr>
        {% endfor %}

    </table>
{% else %}
    <div class="alert alert-info">
        There are no images.
    </div>
{% endif %}
