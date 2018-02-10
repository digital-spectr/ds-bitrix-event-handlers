<?

/**
 * перед добавлением инфоблока
 *
 * даем права на инфоблоки на чтение по умолчанию
 */


AddEventHandler("iblock", "OnBeforeIBlockAdd", "iblock_OnBeforeIBlockAdd_FixIBlockPermissions");
function iblock_OnBeforeIBlockAdd_FixIBlockPermissions(&$arFields) {
    $filter = array();
    $rsGroups = CGroup::GetList(($by = "c_sort"), ($order = "desc"), $filter);
    while ($arGroup = $rsGroups->Fetch()) {
        if ($arGroup['ANONYMOUS'] == 'Y') {
            $group_id = $arGroup['ID'];
            break;
        }
    }
    $arFields['GROUP_ID'][$group_id] = "R";
}