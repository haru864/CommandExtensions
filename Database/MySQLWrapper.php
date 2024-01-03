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

    public function getUpdatedDate(?string $title = null, ?string $isbn = null): ?string
    {
        $query = null;
        if ($title != null) {
            $query = sprintf("SELECT updated_at FROM open_library_cache WHERE type = 'title' AND name = '%s'", $title);
        } else {
            $query = sprintf("SELECT updated_at FROM open_library_cache WHERE type = 'isbn' AND name = '%s'", $isbn);
        }
        $updatedAt = $this->query($query)->fetch_row()[0];
        return $updatedAt;
    }

    public function getBookData(?string $title = null, ?string $isbn = null): ?string
    {
        $query = null;
        if ($title != null) {
            $query = sprintf("SELECT data FROM open_library_cache WHERE type = 'title' AND name = '%s'", $title);
        } else {
            $query = sprintf("SELECT data FROM open_library_cache WHERE type = 'isbn' AND name = '%s'", $isbn);
        }
        $data = $this->query($query)->fetch_row()[0];
        var_dump($data);
        return $data;
    }
}
