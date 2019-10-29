<?php

require_once('vendor/autoload.php');

if (file_exists(__DIR__ . '/.env')) {
    $dotenv = \Dotenv\Dotenv::create(__DIR__);
    $dotenv->load();
}

class RoboFile extends \Robo\Tasks
{
    use \Robo\Task\Development\loadTasks;
    use \Robo\Common\TaskIO;

    protected $config;

    public function __construct()
    {
        foreach ($_ENV as $option => $value) {
            if (substr($option, 0, 3) === 'OC_') {
                $option = strtolower(substr($option, 3));
                $this->config[$option] = $value;
            }
        }

        $required = ['db_username', 'password', 'email', 'http_server'];

        $missing = [];

        foreach ($required as $config) {
            if (empty($this->config[$config])) {
                $missing[] = 'OC_' . strtoupper($config);
            }
        }

        if (!empty($missing)) {
            $this->printTaskError("<error> Missing " . implode(', ', $missing));
            $this->printTaskError("<error> See .env.example ");
            die();
        }
    }

    public function setup()
    {
        $this->taskDeleteDir('www')->run();
        $this->taskFileSystemStack()
            ->mirror('vendor/opencart/opencart/upload', 'www')
            ->copy('www/config-dist.php','www/config.php')
            ->copy('www/admin/config-dist.php','www/admin/config.php')
            ->remove('www/config-dist.php')
            ->remove('www/admin/config-dist.php')
            ->chmod('www', 0777, 0000, true)
            ->run();

        try {
            $conn = new PDO("mysql:host=".$this->config['db_hostname'], $this->config['db_username'], $this->config['db_password']);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->exec("DROP DATABASE IF EXISTS `" . $this->config['db_database'] . "`");
            $conn->exec("CREATE DATABASE `" . $this->config['db_database'] . "`");
        }
        catch(PDOException $e)
        {
            $this->printTaskError("<error> Could not connect ot database...");
        }

        $cli_install = 'www/install/cli_install.php';

        $search = '$db->query("SET @@session.sql_mode = \'MYSQL40\'");';
        $add = '$db->query("SET @@session.sql_mode = \'\'");';

        $this->taskReplaceInFile($cli_install)
            ->from($search)
            ->to($add)
            ->run();

        $install = $this->taskExec('php')->arg($cli_install)->arg('install');

        foreach ($this->config as $option => $value) {
            $install->option($option, $value);
        }

        $install->run();

        $this->taskDeleteDir('www/install')->run();
    }

    public function watch()
    {
        $this->deploy();

        $this->taskWatch()
            ->monitor('composer.json', function () {
                $this->taskComposerUpdate()->run();
                $this->deploy();
            })->monitor('src/', function () {
                $this->deploy();
            }, \Lurker\Event\FilesystemEvent::ALL)->run();
    }

    public function deploy()
    {
        $this->taskFileSystemStack()->mirror('src/upload', 'www')->run();
    }
}