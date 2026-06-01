<?php
require_once __DIR__ . '/lib.php';
render_header('Dashboard');

try {
    $stats = array(
        'Customers' => scalar_query('SELECT COUNT(*) FROM customer'),
        'Products' => scalar_query('SELECT COUNT(*) FROM product'),
        'Orders' => scalar_query('SELECT COUNT(*) FROM sales_order'),
        'Paid Sales' => 'RM ' . number_format((float)scalar_query("SELECT NVL(SUM(paymentAmount), 0) FROM payment WHERE paymentStatus = 'PAID'"), 2)
    );

    echo '<section class="grid stats">';
    foreach ($stats as $label => $value) {
        echo '<div class="card stat-card">';
        echo '<div class="stat-label">' . h($label) . '</div>';
        echo '<div class="stat-value">' . h($value) . '</div>';
        echo '</div>';
    }
    echo '</section>';

    $orders = execute_query(
        "SELECT so.orderID, c.customerName, so.orderDate, so.orderStatus, so.totalAmount, p.paymentStatus
         FROM sales_order so
         JOIN customer c ON so.customerID = c.customerID
         JOIN payment p ON so.orderID = p.orderID
         ORDER BY so.orderDate DESC FETCH FIRST 8 ROWS ONLY"
    );

    echo '<section class="card" style="margin-top:16px">';
    echo '<h2>Recent Orders</h2>';
    echo '<div class="table-wrap"><table>';
    echo '<tr><th>Order ID</th><th>Customer</th><th>Date</th><th>Order Status</th><th>Payment</th><th>Total</th></tr>';
    foreach ($orders as $row) {
        echo '<tr>';
        echo '<td>' . h($row['ORDERID']) . '</td>';
        echo '<td>' . h($row['CUSTOMERNAME']) . '</td>';
        echo '<td>' . h($row['ORDERDATE']) . '</td>';
        echo '<td><span class="badge">' . h($row['ORDERSTATUS']) . '</span></td>';
        echo '<td>' . h($row['PAYMENTSTATUS']) . '</td>';
        echo '<td>RM ' . h(number_format((float)$row['TOTALAMOUNT'], 2)) . '</td>';
        echo '</tr>';
    }
    echo '</table></div>';
    echo '</section>';
} catch (Exception $e) {
    render_error($e->getMessage());
}

render_footer();
?>

