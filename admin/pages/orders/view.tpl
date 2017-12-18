<h2 class="product-head">
    Order {{ order.number }}
</h2>

<div class="panel panel-smart text-right">
    <a href="?s=orders&amp;p=status&amp;status=paid&amp;id={{ order._id }}" class="btn btn-info">
        <i class="fa fa-euro"></i>
    </a>
    <a href="?s=orders&amp;p=status&amp;status=packed&amp;id={{ order._id }}" class="btn btn-info">
        <i class="fa fa-cube"></i>
    </a>
    <a href="?s=orders&amp;p=status&amp;status=delivered&amp;id={{ order._id }}" class="btn btn-info">
        <i class="fa fa-home"></i>
    </a>
    <a href="?s=orders&amp;p=status&amp;status=cancelled&amp;id={{ order._id }}" class="btn btn-info">
        <i class="fa fa-ban"></i>
    </a>
    <a href="?s=orders&amp;p=status&amp;status=expired&amp;id={{ order._id }}" class="btn btn-info">
        <i class="fa fa-clock-o"></i>
    </a>
</div>

<div class="panel panel-smart">
    <div class="panel-heading">
        <h3 class="panel-title">
            Products
        </h3>
    </div>
    <p>&nbsp;</p>
    <table>
        <thead>
            <tr>
                <th>
                    Product
                </th>
                <th class="text-right">
                    Quantity
                </th>
                <th class="text-right">
                    Item price
                </th>
                <th class="text-right">
                    Total price
                </th>
            </tr>
        </thead>
        <tbody>
            {% for item in order.items %}
            <tr>
                <td>
                    {{ item.sku }} - {{ item.title }}
                </td>
                <td class="text-right">
                    {{ item.quantity }}
                </td>
                <td class="text-right">
                    &euro; {{ item.price }}
                </td>
                <td class="text-right">
                    &euro; {{ item.price * item.quantity }}
                </td>
            </tr>
            {% endfor %}
        </tbody>
    </table>
</div>

<section class="registration-area">
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-smart">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Status changes
                    </h3>
                </div>
                <div class="panel-body">
                    {% if order.statusChanges|length > 0 %}
                    {% for change in order.statusChanges %}
                    <dl class="dl-horizontal">
                        <dt>By:</dt>
                        <dd>{{ change.user }}</dd>
                        <dt>Date:</dt>
                        <dd>{{ change.time.sec | date('d-m-Y H:i') }}</dd>
                        <dt>Change:</dt>
                        <dd>{{ change.oldStatus }} -&gt; {{ change.newStatus }}</dd>
                    </dl>
                    <hr>
                    {% endfor %}
                    {% else %}
                    <p>This order hasn't changed status yet.</p>
                    {% endif %}
                </div>
            </div>

            <div class="panel panel-smart">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Payment details
                    </h3>
                </div>
                <div class="panel-body">
                    {% if order.payments|length > 0 %}
                    {% for payment in order.payments %}
                    <dl class="dl-horizontal">
                        <dt>Status:</dt>
                        <dd>{{ payment.status }}</dd>
                        <dt>Date:</dt>
                        <dd>{{ payment.time.sec | date('d-m-Y H:i') }}</dd>
                        <dt>Amount:</dt>
                        <dd>&euro; {{ order.amount }}</dd>
                        <dt>Method:</dt>
                        <dd>{{ payment.method }}</dd>
                    </dl>
                    <hr>
                    {% endfor %}
                    {% else %}
                    <p>No payment details available.</p>
                    {% endif %}
                </div>
            </div>

            <div class="panel panel-smart">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Sent emails
                    </h3>
                </div>
                <div class="panel-body">
                    {% if order.emails|length > 0 %}
                    {% for email in order.emails %}
                    <dl class="dl-horizontal">
                        <dt>Email:</dt>
                        <dd>{{ email.email }}</dd>
                        <dt>Date:</dt>
                        <dd>{{ email.time.sec | date('d-m-Y H:i') }}</dd>
                    </dl>
                    <hr>
                    {% endfor %}
                    {% else %}
                    <p>No emails have been sent to the customer.</p>
                    {% endif %}
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="panel panel-smart">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Order details
                    </h3>
                </div>
                <div class="panel-body">
                    <dl class="dl-horizontal">
                        <dt>ID:</dt>
                        <dd>{{ order._id }}</dd>
                        <dt>Number:</dt>
                        <dd>{{ order.number }}</dd>
                        <dt>Date:</dt>
                        <dd>{{ order.time.sec | date('d-m-Y H:i') }}</dd>
                        <dt>Order Status:</dt>
                        <dd>{{ order.status }}</dd>
                    </dl>
                    <hr>
                    <dl class="dl-horizontal total">
                        <dt>Total:</dt>
                        <dd>&euro; {{ order.amount }}</dd>
                    </dl>
                </div>
            </div>

            <div class="panel panel-smart">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Delivery address
                    </h3>
                </div>
                <div class="panel-body">
                    <dl class="dl-horizontal">
                        <dt>Name:</dt>
                        <dd>{{ order.shippingAddress.name }}</dd>
                        <dt>Address:</dt>
                        <dd>{{ order.shippingAddress.address }}</dd>
                        <dt>Postal Code:</dt>
                        <dd>{{ order.shippingAddress.postalCode }}</dd>
                        <dt>City:</dt>
                        <dd>{{ order.shippingAddress.city }}</dd>
                        <dt>Email address:</dt>
                        <dd>{{ order.shippingAddress.email }}</dd>
                        <dt>Phone number:</dt>
                        <dd>{{ order.shippingAddress.phone }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
<section>
