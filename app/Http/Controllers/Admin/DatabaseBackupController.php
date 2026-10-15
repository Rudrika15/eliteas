<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Utils\ErrorLogger;
use Illuminate\Support\Facades\Log;
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
            $dbConfig = config('database.connections.mysql');

            // ✅ Add charset (IMPORTANT FIX)
            $pdo = new \PDO(
                "mysql:host={$dbConfig['host']};dbname={$dbConfig['database']};charset=utf8mb4",
                $dbConfig['username'],
                $dbConfig['password'],
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => false, // ✅ prevents memory crash
                ]
            );

            // ✅ Increase limits (IMPORTANT for large DB)
            ini_set('memory_limit', '512M');
            set_time_limit(0);

            $tables = $pdo->query('SHOW TABLES')->fetchAll(\PDO::FETCH_COLUMN);

            $backupContent = "";

            foreach ($tables as $table) {

                // ✅ Table structure
                $createStmt = $pdo->query("SHOW CREATE TABLE `$table`")->fetch(\PDO::FETCH_ASSOC);
                $backupContent .= "\n\n" . $createStmt['Create Table'] . ";\n\n";

                // ✅ Table data
                $stmt = $pdo->query("SELECT * FROM `$table`");

                while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {

                    $columns = array_keys($row);

                    $values = array_map(function ($value) use ($pdo) {
                        if (is_null($value)) {
                            return "NULL"; // ✅ FIX NULL issue
                        }
                        return $pdo->quote($value);
                    }, array_values($row));

                    $backupContent .= "INSERT INTO `$table` (`" . implode('`,`', $columns) . "`) VALUES (" . implode(',', $values) . ");\n";
                }
            }

            $fileName = 'backup_' . date('Y_m_d_H_i_s') . '.sql';

            return response($backupContent)
                ->header('Content-Type', 'application/sql')
                ->header('Content-Disposition', "attachment; filename={$fileName}");

        } catch (\Throwable $th) {

            \Log::error($th); // ✅ log real error

            return response()->json([
                'error' => $th->getMessage()
            ], 500);
        }
    }
    public function download($file)
    {
        try {
            if (Storage::exists($this->backupPath.'/'.$file)) {
                return Storage::download($this->backupPath.'/'.$file);
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
            if (Storage::exists($this->backupPath.'/'.$file)) {
                Storage::delete($this->backupPath.'/'.$file);

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
