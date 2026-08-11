<?php

// Script for converting pesonaas_db_bigdata.sql to SQLite database

$sqlFile = __DIR__ . '/pesonaas_db_bigdata.sql';
$sqliteFile = __DIR__ . '/database.sqlite';

if (!file_exists($sqlFile)) {
    die("Error: File SQL $sqlFile tidak ditemukan!\n");
}

echo "=== MENGKONVERSI PESONAAS_DB_BIGDATA.SQL KE SQLITE ===\n";

// Load Laravel Bootstrap to use Eloquent DB
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Ensure database.sqlite exists
if (!file_exists($sqliteFile)) {
    touch($sqliteFile);
    echo "Dibuat file SQLite baru: $sqliteFile\n";
}

// Read SQL content
$sql = file_get_contents($sqlFile);

// Parse INSERT statements from MySQL dump
preg_match_all('/INSERT INTO `([^`]+)` \(([^)]+)\) VALUES\s*([\s\S]+?);/i', $sql, $matches, PREG_SET_ORDER);

echo "Ditemukan " . count($matches) . " grup INSERT statement dalam dump SQL.\n";

DB::statement('PRAGMA foreign_keys = OFF;');

foreach ($matches as $match) {
    $table = $match[1];
    $columnsRaw = $match[2];
    $valuesRaw = $match[3];

    // Clean column names
    $columns = array_map(function ($col) {
        return trim($col, ' `');
    }, explode(',', $columnsRaw));

    echo "Processing table: $table ...\n";

    // Split multi-row values
    // Using a regex to extract tuple rows: (val1, val2, ...)
    $pattern = '/\((?>[^()]+|(?R))*\)/s';
    preg_match_all($pattern, $valuesRaw, $rowMatches);

    $insertedCount = 0;
    foreach ($rowMatches[0] as $rowStr) {
        $rowStr = trim($rowStr);
        if (str_starts_with($rowStr, '(') && str_ends_with($rowStr, ')')) {
            $inner = substr($rowStr, 1, -1);
            
            // Parse CSV-like SQL values
            $values = str_getcsv($inner, ',', "'", "\\");

            if (count($values) === count($columns)) {
                $data = [];
                for ($i = 0; $i < count($columns); $i++) {
                    $val = $values[$i];
                    if ($val === 'NULL' || $val === null) {
                        $data[$columns[$i]] = null;
                    } else {
                        // Unescape JSON string if escaped like [\"item\"]
                        if ($columns[$i] === 'highlights' && is_string($val)) {
                            $cleanJson = stripslashes($val);
                            if (json_decode($cleanJson) !== null) {
                                $val = $cleanJson;
                            }
                        }
                        $data[$columns[$i]] = $val;
                    }
                }

                try {
                    DB::table($table)->updateOrInsert(
                        [$columns[0] => $data[$columns[0]]],
                        $data
                    );
                    $insertedCount++;
                } catch (\Throwable $e) {
                    echo "Warn: " . $e->getMessage() . "\n";
                }
            }
        }
    }
    echo "  -> Impoted $insertedCount baris ke tabel '$table'.\n";
}

DB::statement('PRAGMA foreign_keys = ON;');

echo "\n=== KONVERSI SQLITE SELESAI DENGAN SUKSES! ===\n";
