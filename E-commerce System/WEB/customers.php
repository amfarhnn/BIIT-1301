<?php
require_once __DIR__ . '/lib.php';
render_header('Customers');

try {
    $customers = execute_query(
        "SELECT c.customerID,
                c.customerName,
                c.customerEmail,
                c.customerPhone,
                COUNT(so.orderID) AS totalOrders,
                NVL(SUM(CASE WHEN p.paymentStatus = 'PAID' THEN p.paymentAmount ELSE 0 END), 0) AS totalSpent
         FROM customer c
         LEFT JOIN sales_order so ON c.customerID = so.customerID
         LEFT JOIN payment p ON so.orderID = p.orderID
         GROUP BY c.customerID, c.customerName, c.customerEmail, c.customerPhone
         ORDER BY c.customerID"
    );
?>

<div class="table-wrap">
  <table>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Orders</th>
      <th>Total Spent</th>
    </tr>
    <?php foreach ($customers as $customer): ?>
      <tr>
        <td><?php echo h($customer['CUSTOMERID']); ?></td>
        <td><?php echo h($customer['CUSTOMERNAME']); ?></td>
        <td><?php echo h($customer['CUSTOMEREMAIL']); ?></td>
        <td><?php echo h($customer['CUSTOMERPHONE']); ?></td>
        <td><?php echo h($customer['TOTALORDERS']); ?></td>
        <td>RM <?php echo h(number_format((float)$customer['TOTALSPENT'], 2)); ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
</div>

<?php
} catch (Exception $e) {
    render_error($e->getMessage());
}

render_footer();
?>

