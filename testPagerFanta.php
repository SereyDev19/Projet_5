<?php
require __DIR__ . '/vendor/autoload.php';

use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Pagerfanta\View\DefaultView;
use App\Config\Config;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Pagerfanta\Adapter;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dbquery = new Config($_ENV);

$queryBuilder = $dbquery->getAll('SELECT * from access', []);

$maxPerPage = 10;
$adapter = new DoctrineORMAdapter($queryBuilder);
$pagerfanta = new Pagerfanta($adapter);

$pagerfanta->setMaxPerPage($maxPerPage); // 10 by default
$maxPerPage = $pagerfanta->getMaxPerPage();

$currentPage = 1;
$pagerfanta->setCurrentPage($currentPage); // 1 by default
$currentPage = $pagerfanta->getCurrentPage();

$nbResults = $pagerfanta->getNbResults();
$currentPageResults = $pagerfanta->getCurrentPageResults();

$view = new DefaultView();
$options = array('proximity' => 3);
$html = $view->render($pagerfanta, __DIR__, $options);