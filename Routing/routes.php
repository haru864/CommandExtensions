<?php

use Helpers\DatabaseHelper;
use Helpers\ValidationHelper;
use Response\HTTPRenderer;
use Response\Render\HTMLRenderer;
use Response\Render\JSONRenderer;

return [
    'random/part' => function (): HTTPRenderer {
        $part = DatabaseHelper::getRandomComputerPart();
        return new HTMLRenderer('component/random-part', ['part' => $part]);
    },
    'parts' => function (): HTTPRenderer {
        $id = ValidationHelper::integer($_GET['id'] ?? null);
        $part = DatabaseHelper::getComputerPartById($id);
        return new HTMLRenderer('component/part', ['part' => $part]);
    },
    'api/random/part' => function (): HTTPRenderer {
        $part = DatabaseHelper::getRandomComputerPart();
        return new JSONRenderer(['part' => $part]);
    },
    'api/parts' => function () {
        $id = ValidationHelper::integer($_GET['id'] ?? null);
        $part = DatabaseHelper::getComputerPartById($id);
        return new JSONRenderer(['part' => $part]);
    },
    'api/types' => function () {
        $type = ValidationHelper::string($_GET['type'] ?? null);
        $page = ValidationHelper::integer($_GET['page'] ?? null);
        $perpage = ValidationHelper::integer($_GET['perpage'] ?? null);
        $part = DatabaseHelper::getComputerPartByType($type);
        return new JSONRenderer(['parts' => $part]);
    },
];
