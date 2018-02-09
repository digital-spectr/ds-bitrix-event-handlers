<?
/**
 * перед отправкой письма
 *
 * корректировка сведения о доставке
 *
 */
AddEventHandler('main', 'OnBeforeEventSend', 'main_OnBeforeEventSend_ChangeTrackingNumberFields');
function main_OnBeforeEventSend_ChangeTrackingNumberFields(&$arFields, &$arTemplate)
{
    Bitrix\Main\Diag\Debug::writeToFile("main_OnBeforeEventSend_ChangeTrackingNumberFields", "", "main_OnBeforeEventSend_ChangeTrackingNumberFields.txt");

    if ((int)$arFields['ORDER_ID'] && (string)$arFields['ORDER_TRACKING_NUMBER'] !== '') {
        Bitrix\Main\Loader::includeModule('sale');
        $arOrder = CSaleOrder::GetByID($arFields['ORDER_ID']);
        if (0 !== count($arOrder)) {
            $arFields['DELIVERY_INFO'] = $arOrder['COMMENTS'];
            if ((int)$arOrder['DELIVERY_ID']) {
                $dbDelivery = CSaleDelivery::GetList(
                    array('SORT' => 'ASC'),
                    array('ID' => $arOrder['DELIVERY_ID']),
                    false,
                    false,
                    array('ID', 'NAME')
                );
                if ($dbDelivery->SelectedRowsCount()) {
                    if ($arDelivery = $dbDelivery->Fetch()) {
                        $arFields['DELIVERY_NAME'] = $arDelivery['NAME'];
                    }
                }
            }
        }
    }
}
