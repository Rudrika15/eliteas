<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ErrorLog;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PDO;

class DatabaseBackupController extends Controller
{
    // Define the backup path
    protected $backupPath;

    public function __construct()
    {
        // Set the path to where backups are stored (e.g., storage/app/backups)
        $this->backupPath = storage_path('dbBackUps'); // Adjust the path as needed
    }

    public function index()
    {
        try {
            $backupFiles = Storage::files($this->backupPath); // List files in the backup directory
            return view('admin.dbBackup.index', compact('backupFiles'));
        } catch (\Throwable $th) {
            // Log the error
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }

    public function export()
    {
        try {
            // Database connection details
            $dbConfig = config('database.connections.mysql');

            // Connect to the database using PDO
            $pdo = new PDO(
                "mysql:host={$dbConfig['host']};dbname={$dbConfig['database']}",
                $dbConfig['username'],
                $dbConfig['password']
            );

            // Fetch all tables from the database
            $stmt = $pdo->prepare("SHOW TABLES");
            $stmt->execute();
            $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

            // Start generating the backup content
            $backupContent = '';

            // Loop through each table and export its structure and data
            foreach ($tables as $table) {
                // Export table structure (CREATE TABLE statement)
                $createStmt = $pdo->query("SHOW CREATE TABLE `$table`")->fetch(PDO::FETCH_ASSOC);
                $backupContent .= $createStmt['Create Table'] . ";\n\n";

                // Export table data (INSERT INTO statements)
                $rows = $pdo->query("SELECT * FROM `$table`")->fetchAll(PDO::FETCH_ASSOC);
                if (!empty($rows)) {
                    $backupContent .= "INSERT INTO `$table` VALUES ";
                    $values = [];

                    foreach ($rows as $row) {
                        $values[] = '(' . implode(',', array_map([$pdo, 'quote'], $row)) . ')';
                    }
                    $backupContent .= implode(",\n", $values) . ";\n\n";
                }
            }

            // Stream the file to the browser
            $fileName = 'backup_' . date('Y_m_d_H_i_s') . '.sql';

            return response($backupContent)
                ->header('Content-Type', 'application/sql')
                ->header('Content-Disposition', "attachment; filename={$fileName}");
        } catch (\Throwable $th) {
            // Log the error
            ErrorLogger::logError($th, request()->fullUrl());
            return back()->with('error', 'Failed to export database.');
        }
    }

    public function download($file)
    {
        try {
            if (Storage::exists($this->backupPath . '/' . $file)) {
                return Storage::download($this->backupPath . '/' . $file);
            }
            return back()->with('error', 'File not found.');
        } catch (\Throwable $th) {
            // Log the error
            ErrorLogger::logError($th, request()->fullUrl());
            return back()->with('error', 'Failed to download file.');
        }
    }

    public function delete($file)
    {
        try {
            if (Storage::exists($this->backupPath . '/' . $file)) {
                Storage::delete($this->backupPath . '/' . $file);
                return back()->with('success', 'Backup deleted successfully.');
            }
            return back()->with('error', 'File not found.');
        } catch (\Throwable $th) {
            // Log the error
            ErrorLogger::logError($th, request()->fullUrl());
            return back()->with('error', 'Failed to delete backup.');
        }
    }
}
