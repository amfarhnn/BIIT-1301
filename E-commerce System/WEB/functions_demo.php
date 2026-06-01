<?php
require_once __DIR__ . '/lib.php';

$result = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if ($_POST['function'] === 'customer_discount') {
            $discount = scalar_query(
                'SELECT customer_discount(:customerID) AS discountRate FROM dual',
                array('customerID' => $_POST['customerID'])
            );
            $result = 'Discount Rate: ' . number_format(((float)$discount * 100), 2) . '%';
        }

        if ($_POST['function'] === 'order_total') {
            $total = scalar_query(
                'SELECT order_total(:orderID) AS calculatedTotal FROM dual',
                array('orderID' => $_POST['orderID'])
            );
            $result = 'Calculated Order Total: RM ' . number_format((float)$total, 2);
        }
    } catch (Exception $e) {
        $result = $e->getMessage();
    }
}

render_header('Functions');

try {
    $customers = execute_query('SELECT customerID, customerName FROM customer ORDER BY customerID');
    $orders = execute_query('SELECT orderID, totalAmount FROM sales_order ORDER BY orderID');
?>

<section class="grid two-col">
  <div class="card">
    <h2>Customer Discount Function</h2>
    <form method="post">
      <input type="hidden" name="function" value="customer_discount">
      <div class="form-row">
        <label for="customerID">Customer</label>
        <select id="customerID" name="customerID" required>
          <?php foreach ($customers as $customer): ?>
            <option value="<?php echo h($customer['CUSTOMERID']); ?>"><?php echo h($customer['CUSTOMERID'] . ' - ' . $customer['CUSTOMERNAME']); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <button type="submit">Calculate</button>
    </form>
  </div>

  <div class="card">
    <h2>Order Total Function</h2>
    <form method="post">
      <input type="hidden" name="function" value="order_total">
      <div class="form-row">
        <label for="orderID">Order</label>
        <select id="orderID" name="orderID" required>
          <?php foreach ($orders as $order): ?>
            <option value="<?php echo h($order['ORDERID']); ?>"><?php echo h($order['ORDERID'] . ' - RM ' . number_format((float)$order['TOTALAMOUNT'], 2)); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <button type="submit">Calculate</button>
    </form>

    <h2 style="margin-top:18px">Result</h2>
    <div class="output"><?php echo h($result); ?></div>
  </div>
</section>

<?php
} catch (Exception $e) {
    render_error($e->getMessage());
}

render_footer();
?>

