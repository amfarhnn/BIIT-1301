<?php

if (PHP_SAPI !== 'cli') {
    exit("This script can only be run from the command line.\n");
}

$connection = oci_connect(
    getenv('DB_USERNAME'),
    getenv('DB_PASSWORD'),
    getenv('DB_CONNECTION_STRING')
);

if (!$connection) {
    $error = oci_error();
    exit($error['message'] . "\n");
}

$files = array(
    '/database/scripts/ecommerce_table.sql',
    '/database/scripts/ecommerce_data.sql',
    '/database/scripts/ecommerce_procedures.sql',
    '/database/scripts/ecommerce_functions.sql'
);

function execute_statement($connection, $sql, $source) {
    $statement = oci_parse($connection, $sql);

    if (!oci_execute($statement, OCI_NO_AUTO_COMMIT)) {
        $error = oci_error($statement);
        $isMissingDrop = stripos($sql, 'DROP TABLE') === 0
            && strpos($error['message'], 'ORA-00942') !== false;

        oci_free_statement($statement);

        if ($isMissingDrop) {
            return;
        }

        throw new Exception($source . ': ' . $error['message']);
    }

    oci_free_statement($statement);
}

function run_sql_file($connection, $path) {
    $lines = file($path, FILE_IGNORE_NEW_LINES);
    $buffer = '';
    $isPlSql = false;

    foreach ($lines as $lineNumber => $line) {
        $trimmed = trim($line);

        if ($trimmed === '' || strpos($trimmed, '--') === 0) {
            continue;
        }

        if (preg_match('/^(SET|PROMPT|WHENEVER|SPOOL|SHOW)\b/i', $trimmed)) {
            continue;
        }

        if ($buffer === '') {
            $isPlSql = preg_match(
                '/^(CREATE\s+OR\s+REPLACE\s+(PROCEDURE|FUNCTION|TRIGGER)|BEGIN\b|DECLARE\b)/i',
                $trimmed
            ) === 1;
        }

        if ($isPlSql && $trimmed === '/') {
            execute_statement($connection, trim($buffer), basename($path));
            $buffer = '';
            $isPlSql = false;
            continue;
        }

        $buffer .= $line . "\n";

        if (!$isPlSql && substr($trimmed, -1) === ';') {
            $sql = preg_replace('/;\s*$/', '', trim($buffer));
            execute_statement($connection, $sql, basename($path));
            $buffer = '';
        }
    }

    if (trim($buffer) !== '') {
        throw new Exception(basename($path) . ': unterminated SQL statement');
    }
}

try {
    foreach ($files as $file) {
        echo 'Running ' . basename($file) . "...\n";
        run_sql_file($connection, $file);
    }

    oci_commit($connection);
    echo "Database initialization completed.\n";
} catch (Exception $exception) {
    oci_rollback($connection);
    fwrite(STDERR, $exception->getMessage() . "\n");
    oci_close($connection);
    exit(1);
}

oci_close($connection);

