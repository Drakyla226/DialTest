<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Авторизация");
?>
<? $APPLICATION->IncludeComponent(
	"bitrix:system.auth.form",
	"",
	array(
		"FORGOT_PASSWORD_URL" => "/auth/forger.php",
		"PROFILE_URL" => "/auth/personal.php",
		"REGISTER_URL" => "/auth/registration.php",
		"SHOW_ERRORS" => "N"
	)
); ?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>