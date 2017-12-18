<h2 class="product-head">
    Categories
</h2>
<a href="?s=categories&amp;p=create" class="create btn btn-default">
    <i class="fa fa-plus"></i>
    Add a new category
</a>
{% if categories %}
    <table>
        <tr>
            <th>Number</th>
            <th>Name (EN)</th>
            <th>Name (NL)</th>
            <th>Name (PT)</th>
            <th style="width: 100px;">Action</th>
        </tr>

        {% for category in categories %}
        <tr>
            <td>{{ category.number }}.</td>
            <td>{{ category.name.en_GB }}</td>
            <td>{{ category.name.nl_NL }}</td>
            <td>{{ category.name.pt_BR }}</td>
            <td>
                <a href="?s=categories&amp;p=edit&amp;id={{ category._id }}" class="btn btn-warning">
				    <i class="fa fa-edit"></i>
				</a>
                <a href="?s=categories&amp;p=delete&amp;id={{ category._id }}" class="btn btn-danger">
				    <i class="fa fa-ban"></i>
				</a>
            </td>
        </tr>
        {% endfor %}

    </table>
{% else %}
    <div class="alert alert-info">
        There are no categories.
    </div>
{% endif %}
