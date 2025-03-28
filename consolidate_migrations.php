<?php

// List of migrations to keep (basic Laravel migrations and our consolidated ones)
$migrationsToKeep = [
    '0001_01_01_000000_create_users_table.php',
    '0001_01_01_000001_create_cache_table.php',
    '0001_01_01_000002_create_jobs_table.php',
    '2025_03_28_083032_create_consolidated_schema.php',
    '2025_03_28_083103_cleanup_migrations.php'
];

// Process migrations directory
$migrationDir = __DIR__ . '/database/migrations';
$migrationFiles = scandir($migrationDir);

$deletedCount = 0;
$keptCount = 0;

echo "Starting migration consolidation...\n";

foreach ($migrationFiles as $file) {
    // Skip directories and files to keep
    if ($file === '.' || $file === '..' || in_array($file, $migrationsToKeep)) {
        if ($file !== '.' && $file !== '..') {
            echo "Keeping: $file\n";
            $keptCount++;
        }
        continue;
    }

    // Delete the migration file
    $fullPath = $migrationDir . '/' . $file;

    echo "Deleting: $file\n";

    if (unlink($fullPath)) {
        $deletedCount++;
    } else {
        echo "Failed to delete: $file\n";
    }
}

echo "\nMigration consolidation complete!\n";
echo "Deleted $deletedCount migration files.\n";
echo "Kept $keptCount migration files.\n";

echo "\nNext steps:\n";
echo "1. Run 'php artisan migrate:fresh' to reset your database with the consolidated schema\n";
echo "2. Import any seed data if needed\n";
