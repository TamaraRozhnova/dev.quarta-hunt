<?php

namespace Sprint\Migration;


class Version20240724123556 extends Version
{
    protected $description = "111971 | Сайт / Программа лояльности / Анализ файла скидок | Агент";

    protected $moduleVersion = "4.2.4";

    /**
     * @throws Exceptions\HelperException
     * @return bool|void
     */
    public function up()
    {
        $helper = $this->getHelperManager();
        $helper->Agent()->saveAgent(array (
  'MODULE_ID' => '',
  'USER_ID' => NULL,
  'SORT' => '0',
  'NAME' => 'getUsersFrom1cXmlAgent();',
  'ACTIVE' => 'Y',
  'NEXT_EXEC' => '24.07.2024 21:00:00',
  'AGENT_INTERVAL' => '86400',
  'IS_PERIOD' => 'N',
  'RETRY_COUNT' => '0',
));
    }

    public function down()
    {
        //your code ...
    }
}
