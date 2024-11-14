<?php

namespace Sprint\Migration;

use Bitrix\Main\Loader;
use Bitrix\Sale\Delivery\DeliveryLocationTable;
use Bitrix\Sale\Delivery\Restrictions\ByPaySystem;
use \Bitrix\Sale\Delivery\Services\Table;
use \Bitrix\Sale\Delivery\Services\Manager;
use \Bitrix\Sale\Delivery\Restrictions\Manager as RestrictionManager;
use Bitrix\Sale\Internals\ServiceRestrictionTable;
use \Bitrix\Sale\Delivery\Services\Configurable;
use Bitrix\Sale\Internals\DeliveryPaySystemTable;
use Bitrix\Sale\Delivery\EO_DeliveryLocation;
use Bitrix\Sale\Services\Base\Restriction;
use Bitrix\Sale\Delivery\Restrictions\ByLocation;
use Bitrix\Sale\Location\Group;
use Bitrix\Sale\Location\LocationTable;
use CFile;
use CSaleDelivery2PaySystem;
use CSaleDelivery;

class Version20241114140509 extends Version
{
    protected $description = '116955 | Сайт / Добавление данных магазин Санкт-Петербурга | Служба доставки петроградск. и обновление основого самовывоза';

    protected $moduleVersion = '4.2.4';

    public function up()
    {
        Loader::includeModule('sale');

        $idDelivery = $this->addDeliveryPetro();
        $this->updateDeliveryPetro($idDelivery);

        $this->updateMoscowDelivery();
    }

    public function updateMoscowDelivery()
    {
        $rsDeliveries = Table::getList(array('filter' => ['XML_ID' => 'bx_61921d9830e1e'],))->fetch();
        CSaleDelivery::Update($rsDeliveries['ID'], [
            'LOGOTIP' => CFile::MakeFileArray('/include/images/migrations/moscow_delivery.jpg')
        ]);
    }

    /**
     * Добавление новой службы доставки петроградск. самовывоз
     *
     * @return void
     */
    public function addDeliveryPetro()
    {
        try {
            $rsAdd = Manager::add([
                'CODE' => 17,
                'SORT' => 200,
                'NAME' => 'Самовывоз',
                'ACTIVE' => 'Y',
                'DESCRIPTION' => 'Вы можете самостоятельно забрать заказ из наших магазинов.',
                'XML_ID' => 'samovyvoz_petrogradsk',
                'CONFIG' => array(
                    'MAIN' =>
                    array(
                        'CURRENCY' => 'RUB',
                        'PRICE' => '0',
                        'PERIOD' =>
                        array(
                            'FROM' => '1',
                            'TO' => '2',
                            'TYPE' => 'D',
                        ),
                    ),
                ),
                'CLASS_NAME' => '\Bitrix\Sale\Delivery\Services\Configurable',
                'CURRENCY' => 'RUB',
                'ALLOW_EDIT_SHIPMENT' => 'Y'
            ]);

            CSaleDelivery::Update($rsAdd->getId(), [
                'LOGOTIP' => CFile::MakeFileArray('/include/images/migrations/petro_delivery.jpg')
            ]);

            return $rsAdd->getId();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateDeliveryPetro($idDelivery)
    {
        try {
            /**
             * Коды Питера и области
             */
            $codeSanktPeterburg = LocationTable::getById(21)->fetch()['CODE'];
            $codeLeningradskayaOblast = LocationTable::getById(93)->fetch()['CODE'];

            /**
             * Лиды
             */
            CSaleDelivery::Update($idDelivery, ['LID' => ['s1', 'st']]);

            /**
             * Локации
             */
            DeliveryLocationTable::add([
                'DELIVERY_ID' => $idDelivery,
                'LOCATION_CODE' => $codeSanktPeterburg,
                'LOCATION_TYPE' => 'L'
            ]);
            DeliveryLocationTable::add([
                'DELIVERY_ID' => $idDelivery,
                'LOCATION_CODE' => $codeLeningradskayaOblast,
                'LOCATION_TYPE' => 'L'
            ]);
            /**
             * Платежные системы
             */
            DeliveryPaySystemTable::setLinks($idDelivery, DeliveryPaySystemTable::ENTITY_TYPE_DELIVERY, [3, 13, 8, 12, 2, 11]);
        } catch (\Throwable $th) {
        }
    }

    public function down()
    {
        //your code ...
    }
}
