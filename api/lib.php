<?php
/**
 * ������ ��������� �������� ����
 * ������ ��� ��������-��������� (��)
 * 
 * @version 1.0
 * @since 21.06.2012
 * @link http://www.edostavka.ru/integrator/
 * @see 3197
 * @author Tatyana Shurmeleva, live long and prosper
 */
class CalculatePriceDeliverySdek {
	private $version = "1.0";//������ ������
    private $jsonUrl = 'http://api.cdek.ru/calculator/calculate_price_by_json_request.php';
    private $customUrl = false;

	private $authLogin;
	private $authPassword;

	private $senderCityId;
	private $receiverCityId;
	private $tariffId;
	private $modeId;
	public  $goodsList;
	public  $tariffList;
	private $result;
    private $error;
	public  $dateExecute;
	private $timeOut;
	private $services;

	public function __construct(){
	     $this->dateExecute = date('Y-m-d');
	     $this->tariffList  = array();
	}

	public function setDateExecute($date){
		$this->dateExecute = date($date);
	}

	public function setAuth($authLogin,$authPassword){
		$this->authLogin    = $authLogin;
		$this->authPassword = $authPassword;
	}

	private function _getSecureAuthPassword(){
		return md5($this->dateExecute.'&'.$this->authPassword);
	}

	public function setSenderCityId($id){
		$id = (int) $id;
		$this->senderCityId = $id;
	}

	public function setReceiverCityId($id) {
		$id = (int) $id;
		$this->receiverCityId = $id;
	}

	public function setTariffId($id) {
		$id = (int) $id;
		$this->tariffId = $id;
	}

	public function setModeDeliveryId($id) {
		$id = (int) $id;
		$this->modeId = $id;
	}

	public function setServices($arServices) {
		$this->services = $arServices;
	}

	public function addGoodsItemBySize($weight, $length, $width, $height) {
		$this->goodsList[] = array( 'weight' 	=> $weight, 
									'length' 	=> $length,
									'width' 	=> $width,
									'height' 	=> $height);
	}

	public function addGoodsItemByVolume($weight, $volume) {
		$this->goodsList[] = array( 'weight' 	=> $weight, 
									'volume'	=> $volume );
	}

	public function getGoodslist() {
		if(!isset($this->goodsList))
			return NULL;
		return $this->goodsList;
	}

	public function addTariffPriority($id,$priority = 0){
		$id = (int) $id;
		if($priority <= 0){
            $priority = (is_array($this->tariffList)) ? count($this->tariffList)+1 : 1;
        }
		$this->tariffList[] = array( 'priority' => $priority,
									 'id' 		=> $id);
	}

	private function _getTariffList(){
		if(empty($this->tariffList))
			return NULL;
		return $this->tariffList;
	}

	private function _getRemoteData($data){
        $bodyData = array (
          'json' => json_encode($data)
        );
        $data_string = http_build_query($bodyData);

		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, ($this->customUrl) ? $this->customUrl : $this->jsonUrl);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_HTTPHEADER,array(
		    'Content-Type: application/x-www-form-urlencoded',
            'Content-Length: '.strlen($data_string)
            ) 
		);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,$this->timeOut);
		curl_setopt($ch, CURLOPT_TIMEOUT,$this->timeOut);

		curl_setopt($ch,CURLOPT_POST,1);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$data_string);

		$result = curl_exec($ch); 
		$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		//\Ipolh\SDEK\Bitrix\Admin\Logger::calculation(array('Request' => $data,'Response' => json_decode($result, true)));

		if($code == 200)
			return json_decode($result, true);
		elseif($code == 0)
			return array('noanswer'=>true);
		else 
			return "Wrong answer ".$code;
	}

	public function calculate() {
		$data = array();
		$data['dateExecute'] = $this->dateExecute;
		isset($this->version)        ? $data['version']        = $this->version                  : '';		
		isset($this->authLogin)      ? $data['authLogin']      = $this->authLogin                : '';
		isset($this->authPassword)   ? $data['secure']         = $this->_getSecureAuthPassword() : '';
		isset($this->senderCityId)   ? $data['senderCityId']   = $this->senderCityId             : '';
		isset($this->receiverCityId) ? $data['receiverCityId'] = $this->receiverCityId           : '';
		isset($this->tariffId)       ? $data['tariffId']       = $this->tariffId                 : '';
		isset($this->tariffList)     ? $data['tariffList']     = $this->tariffList               : '';
		isset($this->modeId)         ? $data['modeId']         = $this->modeId                   : '';
		isset($this->services)		 ? $data['services']	   = $this->services				 : '';

		isset($this->timeOut) ? '' : $this->timeOut = 6;

		if(isset($this->goodsList)){
			foreach ($this->goodsList as $idGoods => $goods) {
				$data['goods'][$idGoods] = array();
				(isset($goods['weight']) && $goods['weight'] <> '' && $goods['weight']>0) ? $data['goods'][$idGoods]['weight'] = $goods['weight'] : '';
				(isset($goods['length']) && $goods['length'] <> '' && $goods['length']>0) ? $data['goods'][$idGoods]['length'] = $goods['length'] : '';
				(isset($goods['width'])  && $goods['width']  <> '' && $goods['width']>0)  ? $data['goods'][$idGoods]['width']  = $goods['width']  : '';
				(isset($goods['height']) && $goods['height'] <> '' && $goods['height']>0) ? $data['goods'][$idGoods]['height'] = $goods['height'] : '';
				(isset($goods['volume']) && $goods['volume'] <> '' && $goods['volume']>0) ? $data['goods'][$idGoods]['volume'] = $goods['volume'] : '';

			}
		}
		//�������� �� ���������� ���������� curl
		if(!extension_loaded('curl'))
			throw new Exception(GetMessage("IPOLSDEK_CALCEXC_NOCURL"));
		$response = $this->_getRemoteData($data);
        if(isset($response['result']) && !empty($response['result'])){
            $this->result = $response;
            return true;
        }elseif(isset($response['noanswer']) && !empty($response['noanswer'])){
			$this->result = 'noanswer';
			return false;
		}elseif(empty($response)){
			$this->result = 'badanswer';
			return false;
		}else{
            $this->error = $response;
            return false;
        }
	}

	public function getResult(){
		return $this->result;
	}

	public function getError() {
		return $this->error;
	}
	
	public function setTimeout($val){
		$val = floatval($val);
		$this->timeOut = ($val <= 0) ? 6 : $val;
	}

    /**
     * @param bool $customUrl
     * @return $this
     */
    public function setCustomUrl($customUrl)
    {
        $this->customUrl = $customUrl;

        return $this;
    }
}


$result['test'] = 1;

$sdek_calc = new CalculatePriceDeliverySdek();

$sdek_calc->setAuth('XOlAxGCIfVdenTUIIjS4rHfjup5tviyx', 'ATttW2E6ACWWyXd75R1L6nL52eKP2UIV');
$sdek_calc->setSenderCityId(137);
$sdek_calc->setReceiverCityId(44);
$sdek_calc->setTariffId(136);
$sdek_calc->addGoodsItemBySize(1, 20, 30, 40);
$sdek_calc->setServices([['id' => '2', 'param' => '1000']]);
//$sdek_calc->goodsList[] = array('weight' => 1, 'lenght' => 20, 'width' => 30, 'height' => 40);

$result['sdek'] = $sdek_calc->calculate();
$result['error'] = $sdek_calc->getError();
$result['result'] = $sdek_calc->getResult();

echo '<pre>';
print_r($result);
echo '</pre>';


?>


