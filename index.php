<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Задание");
?>
<form method="get">
	<label>Запланировать транспорт на время</label>
	<p>
		<label>Начало: </label>
		<input type="datetime-local" name="trip-start" value="<?= date('Y-m-d\TH:i'); ?>" />
	<p>
		<label>Конец: </label>
		<input type="datetime-local" name="trip-end" value="<?= date('Y-m-d\TH:i'); ?>" />
	<p>
		<input type="submit" value="Отправить">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['trip-start']) && isset($_GET['trip-end'])) {
	$APPLICATION->IncludeComponent(
		"demo:task",
		".default",
		array(
			"IBLOCK_ID" => "4",
			"IBLOCK_TYPE" => "company",
			"COMPONENT_TEMPLATE" => ".default"
		),
		false
	);
}
?>

<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>