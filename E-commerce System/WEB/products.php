<?php
require_once __DIR__ . '/lib.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    try {
        if ($action === 'create') {
            execute_non_query(
                "INSERT INTO product
                 (productID, categoryID, adminID, productName, productBrand, unitPrice, stockQty, productStatus, createdDate)
                 VALUES (:productID, :categoryID, :adminID, :productName, :productBrand, :unitPrice, :stockQty, :productStatus, SYSDATE)",
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
            set_flash('success', 'Product added successfully.');
        }

        if ($action === 'update') {
            execute_non_query(
                "UPDATE product
                 SET unitPrice = :unitPrice,
                     stockQty = :stockQty,
                     productStatus = :productStatus
                 WHERE productID = :productID",
                array(
                    'productID' => $_POST['productID'],
                    'unitPrice' => $_POST['unitPrice'],
                    'stockQty' => $_POST['stockQty'],
                    'productStatus' => $_POST['productStatus']
                )
            );
            set_flash('success', 'Product updated successfully.');
        }

        if ($action === 'delete') {
            execute_non_query(
                'DELETE FROM product WHERE productID = :productID',
                array('productID' => $_POST['productID'])
            );
            set_flash('success', 'Product deleted successfully.');
        }
    } catch (Exception $e) {
        set_flash('error', $e->getMessage());
    }

    redirect_to('products.php');
}

render_header('Products');

try {
    $categories = execute_query('SELECT categoryID, categoryName FROM category ORDER BY categoryName');
    $admins = execute_query('SELECT adminID, adminName FROM admin ORDER BY adminID');
    $products = execute_query(
        "SELECT p.productID, p.productName, p.productBrand, c.categoryName, a.adminName,
                p.unitPrice, p.stockQty, p.productStatus
         FROM product p
         JOIN category c ON p.categoryID = c.categoryID
         JOIN admin a ON p.adminID = a.adminID
         ORDER BY p.productID"
    );
?>

<section class="grid two-col">
  <div class="card">
    <h2>Add Product</h2>
    <form method="post">
      <input type="hidden" name="action" value="create">
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
      <button type="submit">Save Product</button>
    </form>
  </div>

  <div class="table-wrap">
    <table>
      <tr>
        <th>ID</th>
        <th>Product</th>
        <th>Category</th>
        <th>Price</th>
        <th>Stock</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
      <?php foreach ($products as $product): ?>
        <tr>
          <td><?php echo h($product['PRODUCTID']); ?></td>
          <td><?php echo h($product['PRODUCTNAME'] . ' (' . $product['PRODUCTBRAND'] . ')'); ?></td>
          <td><?php echo h($product['CATEGORYNAME']); ?></td>
          <td>RM <?php echo h(number_format((float)$product['UNITPRICE'], 2)); ?></td>
          <td><?php echo h($product['STOCKQTY']); ?></td>
          <td><span class="badge"><?php echo h($product['PRODUCTSTATUS']); ?></span></td>
          <td>
            <div class="actions">
              <form class="inline-form" method="post">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="productID" value="<?php echo h($product['PRODUCTID']); ?>">
                <input name="unitPrice" type="number" step="0.01" min="0" value="<?php echo h($product['UNITPRICE']); ?>" required>
                <input name="stockQty" type="number" min="0" value="<?php echo h($product['STOCKQTY']); ?>" required>
                <select name="productStatus" required>
                  <?php foreach (array('AVAILABLE', 'LOW STOCK', 'OUT OF STOCK', 'DISCONTINUED') as $status): ?>
                    <option <?php echo $status === $product['PRODUCTSTATUS'] ? 'selected' : ''; ?>><?php echo h($status); ?></option>
                  <?php endforeach; ?>
                </select>
                <button type="submit">Update</button>
              </form>
              <form class="inline-form" method="post" onsubmit="return confirm('Delete this product?');">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="productID" value="<?php echo h($product['PRODUCTID']); ?>">
                <button class="danger" type="submit">Delete</button>
              </form>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
</section>

<?php
} catch (Exception $e) {
    render_error($e->getMessage());
}

render_footer();
?>

