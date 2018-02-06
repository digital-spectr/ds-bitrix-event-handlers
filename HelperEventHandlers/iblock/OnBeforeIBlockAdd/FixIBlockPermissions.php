<?
/**
 * Created by PhpStorm.
 * User: GSU
 * Date: 06.02.2018
 * Time: 0:51
 */


/**
 * перед добавлением инфоблока
 *
 * даем права на инфоблоки на чтение по умолчанию
 */

AddEventHandler("iblock", "OnBeforeIBlockAdd", "iblock_OnBeforeIBlockAdd_FixIBlockPermissions");
function FixIBlockPermissions(&$arFields) {
    $rsGroups = CGroup::GetList(($by = "c_sort"), ($order = "desc"), $filter);
    while ($arGroup = $rsGroups->Fetch()) {
        if ($arGroup['ANONYMOUS'] == 'Y') {
            $group_id = $arGroup['ID'];
            break;
        }
    }
    $arFields['GROUP_ID'][$group_id] = "R";
}