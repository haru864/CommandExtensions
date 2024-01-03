<?php

namespace Commands\Programs;

use Commands\Argument;
use Commands\AbstractCommand;

class DatabaseWipe extends AbstractCommand
{
    protected static ?string $alias = 'db-wipe';

    public static function getArguments(): array
    {
        return [
            (new Argument('database'))->description('Database to be deleted.')->required(true)->allowAsShort(true),
            (new Argument('user'))->description('User name for logging into the database.')->required(true)->allowAsShort(true),
            (new Argument('backup'))->description('Option to backup the database before deleting it.')->required(false)->allowAsShort(false),
            (new Argument('restore'))->description('Option to restore a previously deleted database.')->required(false)->allowAsShort(false),
        ];
    }

    public function execute(): int
    {
        $this->log("Start wipe");
        $db = $this->getArgumentValue('database');
        $user = $this->getArgumentValue('user');
        $doBackup = $this->getArgumentValue('backup');
        $doRestore = $this->getArgumentValue('restore');
        $cmd = sprintf('mysql -u %s -p -e "DROP DATABASE %s;"', $user, $db);
        if ($doBackup) {
            $cmd = sprintf('mysqldump -u %s -p %s > backup.sql', $user, $db);
        } else if ($doRestore) {
            $cmd = sprintf('mysql -u %s -p %s < backup.sql', $user, $db);
        }
        shell_exec($cmd);
        $this->log("Finish wipe");
        return 0;
    }

    public static function getHelp(): string
    {
        $msg = "[Usage] db-wipe [-d|--database] <database> [-u|--user] <username> [-p|--password] <password> [--backup]" . PHP_EOL;
        return $msg;
    }
}
