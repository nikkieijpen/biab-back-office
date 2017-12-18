<h2 class="product-head">
    Orders
</h2>

{% if orders %}
    <table>
        <tr>
            <th>Number</th>
            <th>Customer</th>
            <th>Total price</th>
            <th>Status</th>
            <th style="width: 50px;">Action</th>
        </tr>

        {% for order in orders %}
        <tr>
            <td>{{ order.number }}</td>
            <td>{{ order.shippingAddress.name }}<br /><em>{{ order.shippingAddress.city }}</em></td>
            <td>{{ order.amount }}</td>
            <td>{{ order.status }}</td>
            <td>
                <a href="?s=orders&amp;p=view&amp;id={{ order._id }}" class="btn btn-warning">
				    <i class="fa fa-edit"></i>
				</a>
            </td>
        </tr>
        {% endfor %}

    </table>
{% else %}
    <div class="alert alert-info">
        There are no orders.
    </div>
{% endif %}
