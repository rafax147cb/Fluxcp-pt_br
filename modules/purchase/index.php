<?php
if (!defined('FLUX_ROOT')) exit;

$title = 'Loja de Itens';

require_once 'Flux/ItemShop.php';

$category      = $params->get('category');
$categories    = Flux::config("ShopCategories")->toArray();
$categoryName  = Flux::config("ShopCategories.$category");
$categoryCount = array();
$shop          = new Flux_ItemShop($server);
$items         = $shop->getItems($category);
$sql           = sprintf("SELECT COUNT(id) AS total FROM %s.%s WHERE category = ?", $server->charMapDatabase, Flux::config('FluxTables.ItemShopTable'));
$sql2          = sprintf("SELECT COUNT(id) AS total FROM %s.%s", $server->charMapDatabase, Flux::config('FluxTables.ItemShopTable'));
$sth           = $server->connection->getStatement($sql);
$sth2          = $server->connection->getStatement($sql2);
$sth2->execute();
$total         = $sth2->fetch()->total;

foreach ($categories as $catID => $catName) {
	$sth->execute(array($catID));
	$categoryCount[$catID] = $sth->fetch()->total;
}
?>