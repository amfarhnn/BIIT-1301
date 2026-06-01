<?php
require_once __DIR__ . '/lib.php';

$output = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if ($_POST['procedure'] === 'add_product') {
            $output = execute_plsql_with_output(
                'BEGIN add_product(:productID, :categoryID, :adminID, :productName, :productBrand, :unitPrice, :stockQty, :productStatus); END;',
                array(
                    'productID' => $_POST['productID'],
                    'categoryID' => $_POST['categoryID'],
                    'adminID' => $_POST['adminID'],
                    'productName' => $_POST['productName'],
                    'productBrand' => $_POST['productBrand'],
                    'unitPrice' => $_POST['unitPrice'],
                    'stockQty' => $_POST['stockQty'],
                    'productStatus' => $_POST['productStatus']
                )
            );
        }

        if ($_POST['procedure'] === 'list_customer_orders') {
            $output = execute_plsql_with_output(
                'BEGIN list_customer_orders(:customerID); END;',
                array('customerID' => $_POST['customerID'])
            );
        }
    } catch (Exception $e) {
        $output = array($e->getMessage());
    }
}

render_header('Procedures');

try {
    $categories = execute_query('SELECT categoryID, categoryName FROM category ORDER BY categoryName');
    $admins = execute_query('SELECT adminID, adminName FROM admin ORDER BY adminID');
    $customers = execute_query('SELECT customerID, customerName FROM customer ORDER BY customerID');
?>

<section class="grid two-col">
  <div class="card">
    <h2>Add Product Procedure</h2>
    <form method="post">
      <input type="hidden" name="procedure" value="add_product">
      <div class="form-row">
        <label for="productID">Product ID</label>
        <input id="productID" name="productID" type="number" required>
      </div>
      <div class="form-row">
        <label for="categoryID">Category</label>
        <select id="categoryID" name="categoryID" required>
          <?php foreach ($categories as $category): ?>
            <option value="<?php echo h($category['CATEGORYID']); ?>"><?php echo h($category['CATEGORYNAME']); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-row">
        <label for="adminID">Admin</label>
        <select id="adminID" name="adminID" required>
          <?php foreach ($admins as $admin): ?>
            <option value="<?php echo h($admin['ADMINID']); ?>"><?php echo h($admin['ADMINID'] . ' - ' . $admin['ADMINNAME']); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-row">
        <label for="productName">Product Name</label>
        <input id="productName" name="productName" required>
      </div>
      <div class="form-row">
        <label for="productBrand">Brand</label>
        <input id="productBrand" name="productBrand">
      </div>
      <div class="form-row">
        <label for="unitPrice">Unit Price</label>
        <input id="unitPrice" name="unitPrice" type="number" step="0.01" min="0" required>
      </div>
      <div class="form-row">
        <label for="stockQty">Stock Quantity</label>
        <input id="stockQty" name="stockQty" type="number" min="0" required>
      </div>
      <div class="form-row">
        <label for="productStatus">Status</label>
        <select id="productStatus" name="productStatus" required>
          <option>AVAILABLE</option>
          <option>LOW STOCK</option>
          <option>OUT OF STOCK</option>
          <option>DISCONTINUED</option>
        </select>
      </div>
      <button type="submit">Run Procedure</button>
    </form>
  </div>

  <div class="card">
    <h2>Customer Orders Procedure</h2>
    <form method="post">
      <input type="hidden" name="procedure" value="list_customer_orders">
      <div class="form-row">
        <label for="customerID">Customer</label>
        <select id="customerID" name="customerID" required>
          <?php foreach ($customers as $customer): ?>
            <option value="<?php echo h($customer['CUSTOMERID']); ?>"><?php echo h($customer['CUSTOMERID'] . ' - ' . $customer['CUSTOMERNAME']); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <button type="submit">Run Procedure</button>
    </form>

    <h2 style="margin-top:18px">Output</h2>
    <div class="output"><?php echo h(implode(PHP_EOL, $output)); ?></div>
  </div>
</section>

<?php
} catch (Exception $e) {
    render_error($e->getMessage());
}

render_footer();
?>

