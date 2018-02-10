# bx.event.handlers
Часто используемые обработчики событий

## 

/** * перед добавлением инфоблока * * даем права на инфоблоки на чтение по умолчанию */
iblock_OnBeforeIBlockAdd_FixIBlockPermissions

/** * перед отправкой письма * * корректировка сведения о доставке * */
main_OnBeforeEventSend_ChangeTrackingNumberFields

/** * при отправке письма о смене статуса заказа * * изменение сведений о доставке и пользователе */
sale_OnOrderStatusSendEmail_ChangeDeliveryNameAndOrderUser

## Использование

После установки подключаем файл класса в init.php
`require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/digital-spectr/ds-bitrix-event-handlers/EventHandlersLoader.php');
`

Далее используем следующий метод:
`EventHandlersLoader::includeEventHandler();` - подключение всех обработчиков
`EventHandlersLoader::includeEventHandler("iblock_OnBeforeIBlockAdd_FixIBlockPermissions");` - подключение обработчика iblock_OnBeforeIBlockAdd_FixIBlockPermissions

Иерархия папок и файлов с обработчиками внутри HelperEventHandlers следующая:
/HelperEventHandlers/[модуль]/[событие]/[название, которое можно было бы дать обработчику при классическом расположении, т.е. в init.php или handlers.php ].php

Пример: /HelperEventHandlers/iblock/OnBeforeIBlockAdd/FixIBlockPermissions.php

Название обработчика формируется по следующей схеме:
[модуль]_[событие]_[название, которое можно было бы дать обработчику при классическом расположении, т.е. в init.php или handlers.php]

Посмотреть список доступных обработчиков можно при помощи метода 
`EventHandlersLoader::getEventHandlersInfo();`
