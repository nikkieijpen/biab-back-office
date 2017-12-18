<h2 class="product-head">
    Users
</h2>
<a href="?s=users&amp;p=create" class="create btn btn-default">
    <i class="fa fa-plus"></i>
    Add a new user
</a>
{% if users %}
    <table>
        <tr>
            <th>Name</th>
            <th>Email address</th>
            <th style="width: 150px;">Action</th>
        </tr>

        {% for user in users %}
        <tr>
            <td>{{ user.name }}</td>
            <td>{{ user.email }}</td>
            <td>
                <a href="?s=users&amp;p=password&amp;id={{ user._id }}" class="btn btn-info">
				    <i class="fa fa-key"></i>
				</a>
                <a href="?s=users&amp;p=edit&amp;id={{ user._id }}" class="btn btn-warning">
				    <i class="fa fa-edit"></i>
				</a>
                <a href="?s=users&amp;p=delete&amp;id={{ user._id }}" class="btn btn-danger">
				    <i class="fa fa-ban"></i>
				</a>
            </td>
        </tr>
        {% endfor %}

    </table>
{% else %}
    <div class="alert alert-info">
        There are no users.
    </div>
{% endif %}
