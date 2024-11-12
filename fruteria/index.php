<?php
session_start();

if (isset($_GET['cliente'])) {
    $_SESSION['cliente'] = $_GET["cliente"];
    $_SESSION['pedidos'] = [];
}

if (!isset($_SESSION['cliente'])) {
    include_once('bienvenida.php');
    exit();
}

if (isset($_POST['accion'])) {
    if ($_POST['accion'] == 'Anotar') {
        $fruta = $_POST['fruta'];
        $cantidad = $_POST['cantidad'];

        if (isset($_SESSION['pedidos'][$fruta])) {
            $_SESSION['pedidos'][$fruta] += $cantidad;
        } else {
            $_SESSION['pedidos'][$fruta] = $cantidad;
        }
    } elseif ($_POST['accion'] == 'Terminar') {
        $compraRealizada = htmlTablaPedidos();
        session_destroy();
        include_once('despedida.php');
        exit;
    }
}


$compraRealizada = htmlTablaPedidos();
require_once('compra.php');

function htmlTablaPedidos(): string
{   
    $msg = "";
    if (isset($_SESSION['pedidos']) && count($_SESSION['pedidos']) > 0) {
        $msg .= "Este es su pedido :";
        $msg .= "<table style='border: 1px solid black;'>";
        foreach ($_SESSION['pedidos'] as $fruta => $cantidad) {
            $msg .= "<tr><td><b>" . $fruta . "</b></td><td>" . $cantidad . "</td></tr>";
        }
        $msg .= "</table>";
    }
    return $msg;
}
?>
