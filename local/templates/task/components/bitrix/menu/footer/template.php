<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<? if (!empty($arResult)) : ?>

		<?
		foreach ($arResult as $arItem) :
			if ($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1)
				continue;
		?>
			<? if ($arItem["SELECTED"]) : ?>
				<div class="menu_footer">
					<a href="<?= $arItem["LINK"] ?>" class="selected"><?= $arItem["TEXT"] ?></a>
				</div>
			<? else : ?>
				<div class="menu_footer">
					<a href="<?= $arItem["LINK"] ?>"><?= $arItem["TEXT"] ?></a>
				</div>
			<? endif ?>

		<? endforeach ?>

<? endif ?>