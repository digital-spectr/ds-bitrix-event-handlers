<?
/**
 * Created by PhpStorm.
 * User: GSU
 * Date: 06.02.2018
 * Time: 0:39
 */


/**
 * при отправке письма о смене статуса заказа
 *
 * изменение сведений о доставке и пользователе
 */
AddEventHandler("sale", "OnOrderStatusSendEmail", "sale_OnOrderStatusSendEmail_ChangeDeliveryNameAndOrderUser");
function sale_OnOrderStatusSendEmail_ChangeDeliveryNameAndOrderUser($ID, &$eventName, &$arFields, $val)
{
    CModule::IncludeModule("sale");
    $arOrder = CSaleOrder::GetByID($ID);
    $arFields["DELIVERY_INFO"] = $arOrder["COMMENTS"];
    $arFields["PRICE"] = $arOrder["PRICE"];
    if (intval($arOrder['DELIVERY_ID'])) {
        $dbDelivery = CSaleDelivery::GetList(
            array("SORT" => "ASC"),
            array("ID" => $arOrder['DELIVERY_ID']),
            false,
            false,
            array("ID", "NAME")
        );
        if ($dbDelivery->SelectedRowsCount()) {
            if ($arDelivery = $dbDelivery->GetNext()) {
                $arFields['DELIVERY_NAME'] = $arDelivery['NAME'];
            }
        }
    }
    if (strlen($arFields['ORDER_USER']) <= 0 && intval($arOrder['USER_ID'])) {
        $by = "ID";
        $dbUser = CUser::GetList($by, $order, array("ID" => $arOrder['USER_ID']));
        if ($dbUser->SelectedRowsCount()) {
            if ($arUser = $dbUser->GetNext()) {
                if (strlen($arUser['NAME'])) {
                    $arFields['ORDER_USER'] .= $arUser['NAME'];
                }
                if (strlen($arUser['LAST_NAME'])) {
                    $arFields['ORDER_USER'] .= " ".$arUser['LAST_NAME'];
                }
            }
        }
    }
}

