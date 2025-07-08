<?php

namespace console\controllers;

use yii\console\Controller;
use yii\console\ExitCode;
use yii\db\Connection;
use PDO;
use PDOException;
use yii\helpers\Console;

/**
 * Perintah konsol untuk membuat database aplikasi.
 *
 * Untuk menjalankan:
 * php yii db/create
 *
 * Atau, jika Anda ingin menghapus database (HATI-HATI!):
 * php yii db/drop
 */
class DbController extends Controller
{
    /**
     * Membuat database yang dikonfigurasi di komponen 'db' aplikasi.
     *
     * @return int Exit code
     */
    public function actionCreate()
    {
        $this->stdout("Mencoba membuat database...\n");

        /** @var Connection $db */
        $db = \Yii::$app->db;

        // --- START PERBAIKAN EKSTRAKSI DSN ---
        $dsn = $db->dsn;
        $host = '';
        $dbName = '';

        // Hapus prefiks driver (misal: 'mysql:', 'pgsql:')
        $dsnWithoutDriver = preg_replace('/^[a-z]+:/', '', $dsn);
        $dsnParts = explode(';', $dsnWithoutDriver);

        foreach ($dsnParts as $part) {
            $part = trim($part); // Hapus spasi di awal/akhir
            if (strpos($part, 'host=') === 0) {
                $host = substr($part, 5); // Ambil nilai setelah 'host='
            } elseif (strpos($part, 'dbname=') === 0) {
                $dbName = substr($part, 7); // Ambil nilai setelah 'dbname='
            }
        }
        // --- END PERBAIKAN EKSTRAKSI DSN ---

        if (empty($host) || empty($dbName)) {
            $this->stderr("Error: Konfigurasi DSN di komponen 'db' tidak lengkap (host atau dbname tidak ditemukan).\n", Console::FG_RED);
            $this->stderr("DSN yang terdeteksi: '{$db->dsn}'\n", Console::FG_RED);
            $this->stderr("Host terdeteksi: '{$host}', Nama Database terdeteksi: '{$dbName}'\n", Console::FG_RED);
            return ExitCode::UNSPECIFIED_ERROR;
        }

        // DSN untuk koneksi ke server MySQL tanpa menentukan database
        $dsnWithoutDb = 'mysql:host=' . $host; // Pastikan format ini benar untuk PDO
        $username = $db->username;
        $password = $db->password;

        // --- START PERBAIKAN CHARACTER SET & COLLATION ---
        $charset = $db->charset ?? 'utf8mb4'; // Gunakan charset dari config, default ke utf8mb4
        $collation = 'utf8mb4_unicode_ci'; // Default collation untuk utf8mb4

        if ($charset === 'utf8') {
            $collation = 'utf8_general_ci'; // Jika charset adalah utf8, gunakan collation yang kompatibel
        }
        // --- END PERBAIKAN CHARACTER SET & COLLATION ---

        try {
            // Koneksi ke server MySQL (bukan ke database spesifik)
            $pdo = new PDO($dsnWithoutDb, $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Buat database
            $sql = "CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET {$charset} COLLATE {$collation}";
            $pdo->exec($sql);

            $this->stdout("Database '{$dbName}' berhasil dibuat atau sudah ada.\n", Console::FG_GREEN);
            return ExitCode::OK;

        } catch (PDOException $e) {
            $this->stderr("Gagal membuat database: " . $e->getMessage() . "\n", Console::FG_RED);
            $this->stderr("Pastikan Anda memiliki hak akses 'CREATE DATABASE' untuk user '{$username}' dan host '{$host}'.\n", Console::FG_RED);
            return ExitCode::UNSPECIFIED_ERROR;
        }
    }

    /**
     * Menghapus database yang dikonfigurasi di komponen 'db' aplikasi.
     * HATI-HATI! Operasi ini akan menghapus semua data.
     *
     * @return int Exit code
     */
    public function actionDrop()
    {
        $this->stdout("PERINGATAN: Anda akan menghapus database ini. Semua data akan hilang!\n", Console::FG_YELLOW);
        if (!$this->confirm("Apakah Anda yakin ingin menghapus database?")) {
            $this->stdout("Operasi penghapusan database dibatalkan.\n");
            return ExitCode::OK;
        }

        /** @var Connection $db */
        $db = \Yii::$app->db;

        // --- START PERBAIKAN EKSTRAKSI DSN ---
        $dsn = $db->dsn;
        $host = '';
        $dbName = '';

        // Hapus prefiks driver (misal: 'mysql:', 'pgsql:')
        $dsnWithoutDriver = preg_replace('/^[a-z]+:/', '', $dsn);
        $dsnParts = explode(';', $dsnWithoutDriver);

        foreach ($dsnParts as $part) {
            $part = trim($part); // Hapus spasi di awal/akhir
            if (strpos($part, 'host=') === 0) {
                $host = substr($part, 5); // Ambil nilai setelah 'host='
            } elseif (strpos($part, 'dbname=') === 0) {
                $dbName = substr($part, 7); // Ambil nilai setelah 'dbname='
            }
        }
        // --- END PERBAIKAN EKSTRAKSI DSN ---

        if (empty($host) || empty($dbName)) {
            $this->stderr("Error: Konfigurasi DSN di komponen 'db' tidak lengkap (host atau dbname tidak ditemukan).\n", Console::FG_RED);
            $this->stderr("DSN yang terdeteksi: '{$db->dsn}'\n", Console::FG_RED);
            $this->stderr("Host terdeteksi: '{$host}', Nama Database terdeteksi: '{$dbName}'\n", Console::FG_RED);
            return ExitCode::UNSPECIFIED_ERROR;
        }

        // DSN untuk koneksi ke server MySQL tanpa menentukan database
        $dsnWithoutDb = 'mysql:host=' . $host;
        $username = $db->username;
        $password = $db->password;

        try {
            // Koneksi ke server MySQL (bukan ke database spesifik)
            $pdo = new PDO($dsnWithoutDb, $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Hapus database
            $sql = "DROP DATABASE IF EXISTS `{$dbName}`";
            $pdo->exec($sql);

            $this->stdout("Database '{$dbName}' berhasil dihapus.\n", Console::FG_GREEN);
            return ExitCode::OK;

        } catch (PDOException $e) {
            $this->stderr("Gagal menghapus database: " . $e->getMessage() . "\n", Console::FG_RED);
            $this->stderr("Pastikan Anda memiliki hak akses 'DROP DATABASE' untuk user '{$username}' dan host '{$host}'.\n", Console::FG_RED);
            return ExitCode::UNSPECIFIED_ERROR;
        }
    }
}
