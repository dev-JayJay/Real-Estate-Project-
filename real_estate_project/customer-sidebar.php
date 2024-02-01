<div class="card">
    <ul class="list-group list-group-flush">
        <li class="list-group-item 
        <?php
        if ($cur_page == 'customer-dashboard.php') {
            echo 'active';
        }
        ?>
        ">
            <a href="<?php echo BASE_URL; ?>customer-dashboard">Dashboard</a>
        </li>
        <li class="list-group-item">
            <a href="user-payment.html">Make Payment</a>
        </li>
        <li class="list-group-item">
            <a href="user-orders.html">Orders</a>
        </li>
        <li class="list-group-item">
            <a href="user-property-add.html">Add Property</a>
        </li>
        <li class="list-group-item">
            <a href="user-properties.html">All Properties</a>
        </li>
        <li class="list-group-item">
            <a href="user-wishlist.html">Wishlist</a>
        </li>
        <li class="list-group-item">
            <a href="user-edit-profile.html">Edit Profile</a>
        </li>
        <li class="list-group-item">
            <a href="<?php echo BASE_URL; ?>customer-logout">Logout</a>
        </li>
    </ul>
</div>