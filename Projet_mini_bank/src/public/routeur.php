<?php
ob_start();
require_once __DIR__ . '/../controllers/ClientController.php';

$page = $_GET['page'] ?? 'liste';

switch ($page) {

    /* =======================
       CLIENTS
    ======================= */

    case 'create':
        $controller = new ClientController();
        $controller->create();
        break;

    case 'edit':
        $controller = new ClientController();
        $controller->edit();
        break;

    case 'delete':
        $controller = new ClientController();
        $controller->delete();
        break;

    case 'liste':
        $controller = new ClientController();
        $controller->read();
        break;


    /* =======================
       COMPTES
    ======================= */

    case 'comptes':
        require_once __DIR__ . '/../controllers/CompteController.php';
        $controller = new CompteController();
        $controller->read();
        break;

    case 'create_compte':
        require_once __DIR__ . '/../controllers/CompteController.php';
        $controller = new CompteController();
        $controller->create();
        break;

    case 'delete_compte':
        require_once __DIR__ . '/../controllers/CompteController.php';
        $controller = new CompteController();
        $controller->delete();
        break;


    /* =======================
       Transactions
    ======================= */

    case 'transactions':
        require_once __DIR__ . '/../controllers/TransactionController.php';
        $controller = new TransactionController();
        $controller->list(); // 👈 ton nom de méthode
        break;

    case 'create_transaction':
        require_once __DIR__ . '/../controllers/TransactionController.php';
        $controller = new TransactionController();
        $controller->create();
        break;    

    /* =======================
       DEFAULT
    ======================= */

    default:
        $controller = new ClientController();
        $controller->read();
        break;
}