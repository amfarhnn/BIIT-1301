<?php
require_once __DIR__ . '/lib.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        execute_non_query(
            'UPDATE sales_order SET orderStatus = :orderStatus WHERE orderID = :orderID',
            array(
                'orderID' => $_POST['orderID'],
                'orderStatus' => $_POST['orderStatus']
            )
        );
        set_flash('success', 'Order status updated successfully.');
    } catch (Exception $e) {
        set_flash('error', $e->getMessage());
    }

    redirect_to('orders.php');
}

render_header('Orders');

try {
    $orders = execute_query(
        "SELECT so.orderID, c.customerName, a.adminName, so.orderDate, so.orderStatus,
                so.subtotal, so.deliveryFee, so.totalAmount, p.paymentStatus, s.shipmentStatus
         FROM sales_order so
         JOIN customer c ON so.customerID = c.customerID
         JOIN admin a ON so.adminID = a.adminID
         JOIN payment p ON so.orderID = p.orderID
         JOIN shipment s ON so.orderID = s.orderID
         ORDER BY so.orderID"
    );
?>

<div class="table-wrap">
  <table>
    <tr>
      <th>Order ID</th>
      <th>Customer</th>
      <th>Admin</th>
      <th>Date</th>
      <th>Payment</th>
      <th>Shipment</th>
      <th>Total</th>
      <th>Status</th>
    </tr>
    <?php foreach ($orders as $order): ?>
      <tr>
        <td><?php echo h($order['ORDERID']); ?></td>
        <td><?php echo h($order['CUSTOMERNAME']); ?></td>
        <td><?php echo h($order['ADMINNAME']); ?></td>
        <td><?php echo h($order['ORDERDATE']); ?></td>
        <td><?php echo h($order['PAYMENTSTATUS']); ?></td>
        <td><?php echo h($order['SHIPMENTSTATUS']); ?></td>
        <td>RM <?php echo h(number_format((float)$order['TOTALAMOUNT'], 2)); ?></td>
        <td>
          <form method="post">
            <input type="hidden" name="orderID" value="<?php echo h($order['ORDERID']); ?>">
            <select name="orderStatus">
              <?php foreach (array('PENDING', 'PROCESSING', 'SHIPPED', 'DELIVERED', 'CANCELLED') as $status): ?>
                <option <?php echo $status === $order['ORDERSTATUS'] ? 'selected' : ''; ?>><?php echo h($status); ?></option>
              <?php endforeach; ?>
            </select>
            <button type="submit">Save</button>
          </form>
        </td>
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

