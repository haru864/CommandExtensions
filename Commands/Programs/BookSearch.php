<?php

namespace Commands\Programs;

use Commands\Argument;
use Commands\AbstractCommand;
use Database\MySQLWrapper;

class BookSearch extends AbstractCommand
{
    protected static string $OPEN_LIBRARY_API_ENDPOINT = "https://openlibrary.org/search.json";
    protected static ?string $alias = 'book-search';

    public static function getArguments(): array
    {
        return [
            (new Argument('title'))->description('Title of the book you searched for.')->required(false)->allowAsShort(false),
            (new Argument('isbn'))->description('ISBN of the book you searched for.')->required(false)->allowAsShort(false),
        ];
    }

    public function execute(): int
    {
        $title = $this->getArgumentValue('title');
        $isbn = $this->getArgumentValue('isbn');

        if (is_null($title) && is_null($isbn)) {
            $this->log("Error: Missing argument");
            echo $this->getHelp();
            return 0;
        }
        if (!$title && !$isbn) {
            $this->log("Error: Too many arguments");
            echo $this->getHelp();
            return 0;
        }

        if ($this->isUpToDate($title, $isbn)) {
            $bookData  = null;
            $bookData = $this->getLatestData($title, $isbn);
            var_dump($bookData);
            return 0;
        }

        $url = null;
        if ($title) {
            $url  = BookSearch::$OPEN_LIBRARY_API_ENDPOINT . sprintf("?q=%s", urlencode($title));
        } else if ($isbn) {
            $url  = BookSearch::$OPEN_LIBRARY_API_ENDPOINT . sprintf("?isbn=%s", $isbn);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
            return 0;
        }
        curl_close($ch);
        $data = json_decode($response, true);
        // var_dump(($data));
        // echo $data["numFound"] . PHP_EOL;

        return 0;
    }

    private function isUpToDate(?string $title = null, ?string $isbn = null): bool
    {
        $mysqlWrapper = new MySQLWrapper();
        $updatedAt = null;
        if (isset($title) && $title != "") {
            $updatedAt = $mysqlWrapper->getUpdatedDate(title: $title);
        } else if (isset($isbn) && $isbn != "") {
            $updatedAt = $mysqlWrapper->getUpdatedDate(isbn: $isbn);
        }
        if (is_null($updatedAt)) {
            return false;
        }
        $date30DaysAgo = new \DateTime('-30 days');
        $updatedDate = \DateTime::createFromFormat('Y-m-d', $updatedAt);
        return $updatedDate > $date30DaysAgo;
    }

    private function getLatestData(?string $title = null, ?string $isbn = null): mixed
    {
        $mysqlWrapper = new MySQLWrapper();
        $data = null;
        if (isset($title) && $title != "") {
            $data = $mysqlWrapper->getBookData(title: $title);
        } else if (isset($isbn) && $isbn != "") {
            $data = $mysqlWrapper->getBookData(isbn: $isbn);
        }
        return json_decode($data);
    }

    private function updateCachedData(?string $title = null, ?string $isbn = null): void
    {
        return;
    }

    public static function getHelp(): string
    {
        $msg = "[Usage] book-search --[title|isbn] <string>" . PHP_EOL;
        return $msg;
    }
}
