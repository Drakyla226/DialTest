<!DOCTYPE html>
<html lang="ru">

<head>
  <title>
    <?= $APPLICATION->ShowTitle() ?>
  </title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset="utf-8">
  <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/css/style.css">
  <link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/css/adaptive.css">
  <script src="https://unpkg.com/imask"></script>
  <script src="<?= SITE_TEMPLATE_PATH ?>/js/mask.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/easy-toggler@2.2.7"></script>
</head>

<body>
  <?php $APPLICATION->ShowHead(); ?>
  <div id="panel">
    <?= $APPLICATION->ShowPanel() ?>
  </div>

  <header class="header">
    <div class="logo">
      <a href="/"><img src="<?= SITE_TEMPLATE_PATH ?>/images/logo.png"></a>
    </div>

    <div class="contact">
      <ul>
        <li>+375 (12) - 345 - 67 - 89</li>
        <li>г. Минск</li>
      </ul>
    </div>

    <div class="modal-back">
      <button type="button" class="btn btn-modal" easy-toggle="#modal" easy-class="show" easy-rcoe>Заказать звонок</button>
    </div>

    <menu class="head-menu">
      <ul class="ul-menu_head">
        <li class="li-menu_head"><a href="#">Меню</a>
          <ul class="ul-hover_head">


          <? $APPLICATION->IncludeComponent(
            "bitrix:menu",
            "header",
            array(
              "ALLOW_MULTI_SELECT" => "N",  // Разрешить несколько активных пунктов одновременно
              "CHILD_MENU_TYPE" => "left",  // Тип меню для остальных уровней
              "DELAY" => "N",  // Откладывать выполнение шаблона меню
              "MAX_LEVEL" => "1",  // Уровень вложенности меню
              "MENU_CACHE_GET_VARS" => array(  // Значимые переменные запроса
                0 => "",
              ),
              "MENU_CACHE_TIME" => "3600",  // Время кеширования (сек.)
              "MENU_CACHE_TYPE" => "A",  // Тип кеширования
              "MENU_CACHE_USE_GROUPS" => "Y",  // Учитывать права доступа
              "ROOT_MENU_TYPE" => "top",  // Тип меню для первого уровня
              "USE_EXT" => "N",  // Подключать файлы с именами вида .тип_меню.menu_ext.php
            ),
            false
          ); ?>
          </ul>
        </li>
      </ul>
    </menu>

  </header>
  <div class="modal-form-back" id="modal">

    <? $APPLICATION->IncludeComponent(
      "bitrix:iblock.element.add.form",
      "feedback",
      array(
        "CUSTOM_TITLE_DATE_ACTIVE_FROM" => "",
        "CUSTOM_TITLE_DATE_ACTIVE_TO" => "",
        "CUSTOM_TITLE_DETAIL_PICTURE" => "",
        "CUSTOM_TITLE_DETAIL_TEXT" => "",
        "CUSTOM_TITLE_IBLOCK_SECTION" => "",
        "CUSTOM_TITLE_NAME" => "Ваше имя",
        "CUSTOM_TITLE_PREVIEW_PICTURE" => "",
        "CUSTOM_TITLE_PREVIEW_TEXT" => "",
        "CUSTOM_TITLE_TAGS" => "",
        "DEFAULT_INPUT_SIZE" => "30",
        "DETAIL_TEXT_USE_HTML_EDITOR" => "N",
        "ELEMENT_ASSOC" => "CREATED_BY",
        "GROUPS" => array(),
        "IBLOCK_ID" => "8",
        "IBLOCK_TYPE" => "form",
        "LEVEL_LAST" => "Y",
        "LIST_URL" => "",
        "MAX_FILE_SIZE" => "0",
        "MAX_LEVELS" => "100000",
        "MAX_USER_ENTRIES" => "100000",
        "PREVIEW_TEXT_USE_HTML_EDITOR" => "N",
        "PROPERTY_CODES" => array(
          0 => "17",
          1 => "NAME",
        ),
        "PROPERTY_CODES_REQUIRED" => array(
          0 => "17",
          1 => "NAME",
        ),
        "RESIZE_IMAGES" => "N",
        "SEF_MODE" => "N",
        "STATUS" => "ANY",
        "STATUS_NEW" => "N",
        "USER_MESSAGE_ADD" => "Ваша заявка успешно добавлена.",
        "USER_MESSAGE_EDIT" => "",
        "USE_CAPTCHA" => "N",
        "AJAX_MODE" => "Y",
        "COMPONENT_TEMPLATE" => "feedback"
      ),
      false
    ); ?>
    <div class="overlay" easy-toggle="#modal" easy-class="hidden" easy-rcoe></div>
  </div>