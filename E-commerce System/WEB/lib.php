<?php
require_once __DIR__ . '/config.php';

function h($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function db_connect() {
    if (!function_exists('oci_connect')) {
        throw new Exception('The OCI8 extension is not enabled in PHP.');
    }

    $conn = @oci_connect(DB_USERNAME, DB_PASSWORD, DB_CONNECTION_STRING);
    if (!$conn) {
        $error = oci_error();
        throw new Exception($error['message']);
    }

    return $conn;
}

function execute_query($sql, $binds = array()) {
    $conn = db_connect();
    $stmt = oci_parse($conn, $sql);
    $bindVars = array();

    foreach ($binds as $key => $value) {
        $name = ':' . ltrim($key, ':');
        $bindVars[$name] = $value;
        oci_bind_by_name($stmt, $name, $bindVars[$name]);
    }

    if (!oci_execute($stmt)) {
        $error = oci_error($stmt);
        oci_free_statement($stmt);
        oci_close($conn);
        throw new Exception($error['message']);
    }

    $rows = array();
    while (($row = oci_fetch_assoc($stmt)) !== false) {
        $rows[] = $row;
    }

    oci_free_statement($stmt);
    oci_close($conn);
    return $rows;
}

function execute_non_query($sql, $binds = array()) {
    $conn = db_connect();
    $stmt = oci_parse($conn, $sql);
    $bindVars = array();

    foreach ($binds as $key => $value) {
        $name = ':' . ltrim($key, ':');
        $bindVars[$name] = $value;
        oci_bind_by_name($stmt, $name, $bindVars[$name]);
    }

    if (!oci_execute($stmt, OCI_NO_AUTO_COMMIT)) {
        $error = oci_error($stmt);
        oci_rollback($conn);
        oci_free_statement($stmt);
        oci_close($conn);
        throw new Exception($error['message']);
    }

    oci_commit($conn);
    oci_free_statement($stmt);
    oci_close($conn);
}

function execute_plsql_with_output($plsql, $binds = array()) {
    $conn = db_connect();

    $enable = oci_parse($conn, 'BEGIN DBMS_OUTPUT.ENABLE(NULL); END;');
    oci_execute($enable);
    oci_free_statement($enable);

    $stmt = oci_parse($conn, $plsql);
    $bindVars = array();

    foreach ($binds as $key => $value) {
        $name = ':' . ltrim($key, ':');
        $bindVars[$name] = $value;
        oci_bind_by_name($stmt, $name, $bindVars[$name]);
    }

    if (!oci_execute($stmt, OCI_NO_AUTO_COMMIT)) {
        $error = oci_error($stmt);
        oci_rollback($conn);
        oci_free_statement($stmt);
        oci_close($conn);
        throw new Exception($error['message']);
    }

    oci_commit($conn);
    oci_free_statement($stmt);

    $output = array();
    $line = '';
    $status = 0;
    $getLine = oci_parse($conn, 'BEGIN DBMS_OUTPUT.GET_LINE(:line, :status); END;');
    oci_bind_by_name($getLine, ':line', $line, 32767);
    oci_bind_by_name($getLine, ':status', $status);

    do {
        oci_execute($getLine);
        if ((int)$status === 0) {
            $output[] = $line;
        }
    } while ((int)$status === 0);

    oci_free_statement($getLine);
    oci_close($conn);

    return $output;
}

function scalar_query($sql, $binds = array()) {
    $rows = execute_query($sql, $binds);
    if (count($rows) === 0) {
        return null;
    }

    $first = $rows[0];
    return reset($first);
}

function flash_message() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!empty($_SESSION['flash'])) {
        $message = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $message;
    }

    return null;
}

function set_flash($type, $message) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $_SESSION['flash'] = array('type' => $type, 'message' => $message);
}

function redirect_to($path) {
    header('Location: ' . $path);
    exit;
}

function render_header($title) {
    $flash = flash_message();

    $nav = array(
        'index.php' => 'Dashboard',
        'products.php' => 'Products',
        'orders.php' => 'Orders',
        'customers.php' => 'Customers',
        'procedures.php' => 'Procedures',
        'functions_demo.php' => 'Functions'
    );

    $current = basename($_SERVER['SCRIPT_NAME']);
    echo '<!doctype html>';
    echo '<html lang="en">';
    echo '<head>';
    echo '<meta charset="utf-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
    echo '<title>' . h($title) . ' - ' . h(APP_NAME) . '</title>';
    echo '<link rel="stylesheet" href="assets/style.css">';
    echo '</head>';
    echo '<body>';
    echo '<header class="topbar">';
    echo '<div class="brand">' . h(APP_NAME) . '</div>';
    echo '<nav>';
    foreach ($nav as $href => $label) {
        $class = $current === $href ? 'active' : '';
        echo '<a class="' . $class . '" href="' . h($href) . '">' . h($label) . '</a>';
    }
    echo '</nav>';
    echo '</header>';
    echo '<main class="page">';
    echo '<div class="page-title"><h1>' . h($title) . '</h1></div>';

    if ($flash) {
        echo '<div class="alert ' . h($flash['type']) . '">' . h($flash['message']) . '</div>';
    }
}

function render_footer() {
    echo '</main>';
    echo '</body>';
    echo '</html>';
}

function render_error($message) {
    echo '<div class="alert error">' . h($message) . '</div>';
}
?>
