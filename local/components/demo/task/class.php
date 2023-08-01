<?

use Bitrix\Main\Application;

class MyComponentTask extends CBitrixComponent
{
    public const I_BLOCK_TYPE = 'company';
    public const IBLOCK_ID_DRIVERS = '5';
    public const IBLOCK_ID_COMFORT = '6';
    public const IBLOCK_ID_POSITIONS = '3';
    public const IBLOCK_ID_WORKER = '7';
    public const IBLOCK_ID_CARS = '2';
    public const IBLOCK_ID_TRIPS = '4';

    public function MyComponent()
    {

        $user = \Bitrix\Main\Engine\CurrentUser::get()->getId();
        $userComfort = static::getUserByName($user);

        $comfortPosition = static::getComfortByPosition($userComfort);
        $comfortCategori = static::getComfortByCar();
        $userTrips = static::getUserIdForTrips($user);
        $userTime = static::getTime($userTrips);
    }

    public function getIdUser()
    {
        $arResult = CIBlockElement::GetList(
            array(),
            array(
                "IBLOCK_TYPE" => static::I_BLOCK_TYPE,
                "IBLOCK_ID" => static::IBLOCK_ID_TRIPS,
            ),
            false,
            false,
            array()
        );

        if ($arResult->SelectedRowsCount() > 0) {
            while ($ob = $arResult->GetNextElement()) {
                $arProperties  = $ob->GetProperties();
                $userId = $arProperties['TRIPS_USER']['VALUE'];
            }
        }
        return $userId;
    }


    public function getUserByName($user)
    {
        $arResult = CIBlockElement::GetList(
            array(),
            array(
                "IBLOCK_TYPE" => static::I_BLOCK_TYPE,
                "IBLOCK_ID" => static::IBLOCK_ID_TRIPS,
            ),
            false,
            false,
            array()
        );

        $users = 0;
        if ($arResult->SelectedRowsCount() > 0) {
            while ($ob = $arResult->GetNextElement()) {
                $arProperties  = $ob->GetProperties();
                $userId = $arProperties['TRIPS_USER']['VALUE'];

                $rsElement = CIBlockElement::GetList(array(), array('ID' => $userId), false, false, array());
                if ($arElement = $rsElement->GetNextElement()) {
                    $workerName = $arElement->GetProperties();
                    $userNameId = $workerName['WORKER_NAME']['VALUE'];
                    $userComfort = $workerName['WORKER_WORK']['VALUE'];
                    if ($userNameId == $user) {
                        $users++;
                    }
                }
            }
        }
        if ($users == 0) {
            echo "Пользователь не найден";
        }

        return $userComfort;
    }

    //Функция вывода всех записей авторизованного user'a
    public function getUserIdForTrips($user)
    {
        $arResult = CIBlockElement::GetList(
            array(),
            array(
                "IBLOCK_TYPE" => static::I_BLOCK_TYPE,
                "IBLOCK_ID" => static::IBLOCK_ID_TRIPS,
            ),
            false,
            false,
            array()
        );
        while ($arElement = $arResult->GetNext()) {
            //ID записи
            $tripsID = $arElement['ID'];
            $rsElement = CIBlockElement::GetList(array(), array('ID' => $tripsID), false, false, array());
            if ($arElementUser = $rsElement->GetNextElement()) {
                $workerName = $arElementUser->GetProperties();
                //ID пользователя
                $userNameId = $workerName['TRIPS_USER']['VALUE'];
                $rsElementPos = CIBlockElement::GetList(array(), array('ID' => $userNameId), false, false, array());
                if ($arElementPos = $rsElementPos->GetNextElement()) {
                    $workerNamePos = $arElementPos->GetProperties();
                    $userID = $workerNamePos['WORKER_NAME']['VALUE'];
                    //Авторизованный пользователь
                    if ($user == $userID) {
                        $arResultTripsID[] = $tripsID;
                    }
                }
            }
        }
        return $arResultTripsID;
    }


    //Функция вывода ID категории комфорта для должности авторизованного user'a
    public function getComfortByPosition($userComfort): array
    {
        $arResultElements = array();
        $rsElement = CIBlockElement::GetList(array(), array('ID' => $userComfort), false, false, array());
        $arElement = $rsElement->GetNextElement();
        $comportProperties = $arElement->GetProperties();
        $usercomfort = $comportProperties['WORK_COMFORT']['VALUE'];
        foreach ($usercomfort as $user) {
            $arResultElements[] = $user;
        }
        return $arResultElements;
    }

    //Функция вывода ID комфота связанного с машинами
    public function getComfortByCar(): array
    {
        $arComfort = array();
        $rsElement = CIBlockElement::GetList(array(), array("IBLOCK_ID" => static::IBLOCK_ID_CARS), false, false, array());
        while ($arElement = $rsElement->GetNextElement()) {
            $arProperties = $arElement->GetProperties();
            $arComfort[] = $arProperties['AVTO_COMFORT']['VALUE'];
        }
        return $arComfort;
    }

    public function getTime($userTrips): array
    {
        $result = false;
        $request = Application::getInstance()->getContext()->getRequest();
        $dateStart = $request->get('trip-start'); // Получение значения начала
        $dateStart = str_replace("T", "", $dateStart); //Удаляем T
        $dateStartAdd = DateTime::createFromFormat('Y-m-dH:i', $dateStart); //Преобразуем в DateTime
        $dateStart = DateTime::createFromFormat('Y-m-dH:i', $dateStart); //Преобразуем в DateTime
        $dateStart = $dateStart->format('Y.m.d H:i:s'); // Делаем нужный формат

        $dateEnd = $request->get('trip-end'); // Получение значения окончания
        $dateEnd = str_replace("T", "", $dateEnd);
        $dateEndAdd = DateTime::createFromFormat('Y-m-dH:i', $dateEnd);
        $dateEnd = DateTime::createFromFormat('Y-m-dH:i', $dateEnd);
        $dateEnd = $dateEnd->format('Y.m.d H:i:s');

        foreach ($userTrips as $trip) {
            $rsElement = CIBlockElement::GetList(array(), array("ID" => $trip), false, false, array());
            while ($arElement = $rsElement->GetNextElement()) {
                $arProperties = $arElement->GetProperties();
                $arTimes[] = array(
                    'start_time' => $arProperties['TRIPS_FIRST']['VALUE'],
                    'end_time' => $arProperties['TRIPS_LAST']['VALUE']
                );
                $arFirst = $arProperties['TRIPS_FIRST']['VALUE'];
                $arLast = $arProperties['TRIPS_LAST']['VALUE'];
                $arFirst = DateTime::createFromFormat('d.m.Y H:i:s', $arFirst); //Преобразуем в DateTime
                $arFirst = $arFirst->format('Y.m.d H:i:s'); // Делаем нужный формат
                $arLast = DateTime::createFromFormat('d.m.Y H:i:s', $arLast); //Преобразуем в DateTime
                $arLast = $arLast->format('Y.m.d H:i:s'); // Делаем нужный формат

                if (
                    $dateStart < $arFirst && $dateEnd > $arLast ||
                    $dateStart > $arFirst && $dateEnd < $arLast ||
                    $dateEnd > $arFirst && $dateStart < $arFirst ||
                    $dateEnd > $arFirst && $dateStart < $arLast
                ) {
                    $result = true;
                    break;
                }
            }
        }
        if ($result) {
            echo "Машины на заданное время заняты";
        } else {
            static::addNewTrips($dateStartAdd, $dateEndAdd);
            echo "Машина успешно заланировна";
        }
        return [$arFirst, $arLast];
    }

    public function addNewTrips($dateStartAdd, $dateEndAdd)
    {
        $comfortCategori = static::getComfortByCar();
        $userId = static::getIdUser();
        $dateStart = $dateStartAdd->format('d.m.Y H:i:s'); // Делаем нужный формат
        $dateEnd = $dateEndAdd->format('d.m.Y H:i:s');
        $iBlockElement = new CIBlockElement;
        $arFields = array(
            "IBLOCK_TYPE" => static::I_BLOCK_TYPE,
            "IBLOCK_ID" => static::IBLOCK_ID_TRIPS,
            "ACTIVE"            => "Y",
            "NAME"              => "Название поездки",
            "PROPERTY_VALUES"   => array(
                "TRIPS_FIRST" => $dateStart,
                "TRIPS_LAST" => $dateEnd,
                "TRIPS_CAR" => $comfortCategori[0],
                "TRIPS_USER" => $userId
                //propertys array ...
            )
        );
        if (!$id = $iBlockElement->Add($arFields)) {
            echo "Error:" . $iBlockElement->LAST_ERROR;
        }
    }
}
