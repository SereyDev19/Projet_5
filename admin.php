<?php
require('controller/backend.php');
try {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        adminVerification();
    } elseif (isset($_GET['action'])) {
        if ($_GET['action'] == 'reportAccount') {
            adminReportAccount($_GET['account_id']);
        } elseif ($_GET['action'] == 'logout') {
            adminLogout();
        } elseif ($_GET['action'] == 'detailedReport') {
            admindetailedReport($_GET['account_id']);
        } elseif ($_GET['action'] == 'updateData') {
//            APIdetailedReport($_GET['account_id']);
            admindetailedReport($_GET['account_id']);
        } elseif ($_GET['action'] == 'globalreport') {
//            APIGlobalReport();
            adminGlobalReport();
        }elseif($_GET['action'] == 'updateAccountData'){
            APIGlobalReport();
        }
    } else {
        adminGlobalReport();
    }

} catch
(Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}