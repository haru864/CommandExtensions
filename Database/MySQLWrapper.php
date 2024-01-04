<?php

namespace Database;

use mysqli;
use Helpers\Settings;

class MySQLWrapper extends mysqli
{
    public function __construct(?string $hostname = 'localhost', ?string $username = null, ?string $password = null, ?string $database = null, ?int $port = null, ?string $socket = null)
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $username = $username ?? Settings::env('DATABASE_USER');
        $password = $password ?? Settings::env('DATABASE_USER_PASSWORD');
        $database = $database ?? Settings::env('DATABASE_NAME');
        parent::__construct($hostname, $username, $password, $database, $port, $socket);
    }

    public function isRegistered(?string $title = null, ?string $isbn = null): bool
    {
        $sql = null;
        if ($title != null) {
            $sql = sprintf("SELECT count(*) FROM open_library_cache WHERE type = 'title' AND name = '%s'", $title);
        } else {
            $sql = sprintf("SELECT count(*) FROM open_library_cache WHERE type = 'isbn' AND name = '%s'", $isbn);
        }
        $count = $this->query($sql)->fetch_row()[0];
        return $count > 0;
    }

    public function getUpdatedDate(?string $title = null, ?string $isbn = null): ?string
    {
        $sql = null;
        if ($title != null) {
            $sql = sprintf("SELECT updated_at FROM open_library_cache WHERE type = 'title' AND name = '%s'", $title);
        } else {
            $sql = sprintf("SELECT updated_at FROM open_library_cache WHERE type = 'isbn' AND name = '%s'", $isbn);
        }
        $updatedAt = $this->query($sql)->fetch_row()[0];
        return $updatedAt;
    }

    public function getBookData(?string $title = null, ?string $isbn = null): ?string
    {
        $sql = null;
        if ($title != null) {
            $sql = sprintf("SELECT data FROM open_library_cache WHERE type = 'title' AND name = '%s'", $title);
        } else {
            $sql = sprintf("SELECT data FROM open_library_cache WHERE type = 'isbn' AND name = '%s'", $isbn);
        }
        $data = $this->query($sql)->fetch_row()[0];
        return $data;
    }

    public function insertData(?string $title = null, ?string $isbn = null, string $data): void
    {
        $currDateStr = date("Y-m-d");
        $sql = null;
        if ($title != null) {
            $sql = sprintf("INSERT INTO open_library_cache VALUES ('title', '%s', '%s', '%s', '%s')", $title, $currDateStr, $currDateStr, $data);
        } else {
            $sql = sprintf("INSERT INTO open_library_cache VALUES ('isbn', '%s', '%s', '%s', '%s')", $isbn, $currDateStr, $currDateStr, $data);
        }
        $this->query($sql);
    }

    public function updateData(?string $title = null, ?string $isbn = null, string $data): void
    {
        $sql = null;
        if ($title != null) {
            $sql = sprintf("UPDATE open_library_cache set data = '%s' WHERE type = 'title' AND name = '%s'", $data, $title);
        } else {
            $sql = sprintf("UPDATE open_library_cache set data = '%s' WHERE type = 'isbn' AND name = '%s'", $data, $isbn);
        }
        $this->query($sql);
    }
}
