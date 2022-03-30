<?php
if (!defined('_GNUBOARD_')) exit;

class OCTET {

	protected $API_KEY;
	protected $API_HOST;

	public function __construct() {

		/*
		$api_vars['reqSysId'] = 'BPA1006'; // 인터페이스 아이디
		$api_vars['reqSysCode'] = 'MER'; // 요청시스템 코드
		$api_vars['reqDate'] = date('YmdHis'); // 요청일시
		$api_vars['vrId'] = $vrId; // 가맹점아이디
		$api_vars['txtBxaid'] = $pay_result['txtBxaid']; // 거래번호
		$api_vars['vrOrderId'] = $order_seq; // 가맹점주문번호
		$api_vars['hashKey'] = $hashKey;
		$plaintext = $api_vars['reqSysId'] . $api_vars['reqSysCode'] . $api_vars['reqDate'] . $api_vars['hashKey'];
		$signature = hash('sha256',$plaintext);
		$api_vars['signature'] = $signature; 

		$json_vars = json_encode($api_vars);

		*/

		//추후 DB로변경, 90일마다 갱신
		$this->API_KEY = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZHgiOjkzNCwiaXNfYWRtaW4iOmZhbHNlLCJpYXQiOjE2NDgwOTc3NTUsImV4cCI6MTY1NTg3Mzc1NSwiaXNzIjoibm9kZS5oZWxhbnQifQ.6Usa2XxQKf9J7AJFe1kU1uvG4IVtgrkA4M2G_W1flGU";

		//eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZHgiOjkzNCwiaXNfYWRtaW4iOmZhbHNlLCJpYXQiOjE2NDY5NjMzMjksImV4cCI6MTY1NDczOTMyOSwiaXNzIjoibm9kZS5oZWxhbnQifQ.HeteV2hoJQtU5rJTdmzn3lTBFGyI6NHM_j0L-1ujnMk/
		//추후 실서버 호스트로 변경
		$this->API_HOST = "https://dev.blockchainapi.pro";
	}

    public static function getInstance()
    {   //싱글톤
        static $instance = null;
        if (null === $instance) {
            $instance = new self();
        }

        return $instance;
    }

	public function call_api($api, $post=1, $api_vars=array()) {
		$ch = curl_init();
		//echo $this->API_HOST.$api;

		curl_setopt($ch, CURLOPT_URL, $this->API_HOST.$api);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// curl_setopt($ch, CURLOPT_HEADER, 1); // 쿠키를 가져오려면 써줘야.
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json','Authorization:'.$this->API_KEY.''));

		if($post) {
			curl_setopt($ch, CURLOPT_POST, 1);
			$json_vars = json_encode($api_vars);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $json_vars);
		} else { //get방식 파라미터가 있을 경우
			if( count($api_vars) > 0 ) {
				$json_vars = json_encode($api_vars);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $json_vars);
			}
		}

		$resp = curl_exec($ch);
		//echo $resp;
		//$body=mb_substr($resp, curl_getinfo($ch,CURLINFO_HEADER_SIZE));
		curl_close ($ch);

		$res = json_decode($resp, true);

		return $res;
	}

	//API Key 정보(유효기간 확인)
	function getAPIKeyInfo() {
		return $this->call_api('/v1/user/tokeninfo',0);
	}

	//API Key 발급
	function createAPIKey() {
		return $this->call_api('/v1/user/issue-token',1);
	}

	//KLAY 코인 정보
	function getCoinInfo() {
		return $this->call_api('/v1/KLAY/info',0);
	}

	//자식 주소(회원지갑) 생성
	function createChildAddress() {
		return $this->call_api('/v1/KLAY/address',1);
	}

	//자식 주소(회원지갑) 목록
	function getChildAddressList() {
		return $this->call_api('/v1/KLAY/scheduler/list',0);
	}

	//자식 주소(회원지갑) 정보 조회
	function getChildAddressInfo($addr) {
		return $this->call_api('/v1/KLAY/scheduler/'.$addr,0);
	}

	//자식 주소(회원지갑) 잔액 조회
	function getChildAddressBalance($addr) {
		return $this->call_api('/v1/KLAY/address/'.$addr,0);
	}

	//컨트랙트 생성
	function createContracts() {
		$api_vars['contractSpec'] = "KIP17";
		$api_vars['tokenSymbol'] = "ZKIP17";
		$api_vars['contractName'] = "Z TEST Contract";
		//API 경우 (key/2)사용, 콘솔은 (KEY/1) 사용
		$api_vars['privateKey'] = "8024c09789d0790f4312e7859728a879f75752d05c20ecfff5adc1bba51304a8ae42417e3f17b5aca1eb76d37245d7db7e4b8165b8afb7b3851bf13a87a5464ecb6fcc511b03847cbaab66b805481e42f16d5723e3a8356b8c8cecf5a07b65aa33bc67f9a4dbcada54346382ce2233ce08c4a3b8b983b85fc5993b8e8dbdfd604a0784055f547a56c8be90f10a10a2355bbb5701d9ac515a4e4efe6cda9ee596ef7ad979fc35b772b1381bbb1f078bbccb52573b195cda914749762927b11f4bb251f4f8f80c8e12e2f48b09ef13100ed643fcf822fcff1d357e9e7f155175d0a0685528f53ccfa8aa0fd7790afc18bb1513df8db694a0ef6866a2d81c49fa0e81ffa82e4ccc3ac8cee58786e48129e526f";
		$api_vars['passphrase'] = "Pentasquare123!@#";

		return $this->call_api('/v1/KLAY/nft/contracts/',1,$api_vars);
	}

	//컨트랙트 목록 조회
	function getContractsList() {
		return $this->call_api('/v1/KLAY/nft/contracts/',0);
	}

	//NFT 발행
	function createNFT() {
		$api_vars['uri'] = "https://blog.kakaocdn.net/dn/GWiBY/btq4jt5fWeK/2Gf6N9saPdzovJKkFggon0/img.jpg";
		$api_vars['tokenId'] = 12345; //임의 숫자 유일하게 적용할것
		//API 경우 (key/2)사용, 콘솔은 (KEY/1) 사용
		$api_vars['privateKey'] = "8024c09789d0790f4312e7859728a879f75752d05c20ecfff5adc1bba51304a8ae42417e3f17b5aca1eb76d37245d7db7e4b8165b8afb7b3851bf13a87a5464ecb6fcc511b03847cbaab66b805481e42f16d5723e3a8356b8c8cecf5a07b65aa33bc67f9a4dbcada54346382ce2233ce08c4a3b8b983b85fc5993b8e8dbdfd604a0784055f547a56c8be90f10a10a2355bbb5701d9ac515a4e4efe6cda9ee596ef7ad979fc35b772b1381bbb1f078bbccb52573b195cda914749762927b11f4bb251f4f8f80c8e12e2f48b09ef13100ed643fcf822fcff1d357e9e7f155175d0a0685528f53ccfa8aa0fd7790afc18bb1513df8db694a0ef6866a2d81c49fa0e81ffa82e4ccc3ac8cee58786e48129e526f";
		$api_vars['passphrase'] = "Pentasquare123!@#";

		return $this->call_api('/v1/KLAY/nft/contracts/0x348e91b1f21f2aA27598dEF413377A8a217C60a9/tokens',1,$api_vars);
	}

	//보유 NFT
	function getNFTList() {
		$api_vars['limit'] = 100;
		$api_vars['offset'] = 0;
		$api_vars['ownerAddress'] = "0x5Ba180dAbfDdcC8B0BD50D0c6968333560f762C3";

		//return $this->call_api('/v1/KLAY/nft/contracts/0x348e91b1f21f2aA27598dEF413377A8a217C60a9/tokens',1,$api_vars);
		return $this->call_api('/v1/KLAY/nft/contracts/0x348e91b1f21f2aA27598dEF413377A8a217C60a9/tokens/?limit=10&offset=0&ownerAddress=0xFbAAED72cFFbA2C5C250Fb1E000955c1ed026476',0);
	}

	//NFT 전송
	function transferNFT($childAddr,$tokenId) {
		$api_vars['from'] = "0x5Ba180dAbfDdcC8B0BD50D0c6968333560f762C3";
		$api_vars['to'] = $childAddr;
		$api_vars['tokenId'] = $tokenId;

		//API 경우 (key/2)사용, 콘솔은 (KEY/1) 사용
		$api_vars['privateKey'] = "8024c09789d0790f4312e7859728a879f75752d05c20ecfff5adc1bba51304a8ae42417e3f17b5aca1eb76d37245d7db7e4b8165b8afb7b3851bf13a87a5464ecb6fcc511b03847cbaab66b805481e42f16d5723e3a8356b8c8cecf5a07b65aa33bc67f9a4dbcada54346382ce2233ce08c4a3b8b983b85fc5993b8e8dbdfd604a0784055f547a56c8be90f10a10a2355bbb5701d9ac515a4e4efe6cda9ee596ef7ad979fc35b772b1381bbb1f078bbccb52573b195cda914749762927b11f4bb251f4f8f80c8e12e2f48b09ef13100ed643fcf822fcff1d357e9e7f155175d0a0685528f53ccfa8aa0fd7790afc18bb1513df8db694a0ef6866a2d81c49fa0e81ffa82e4ccc3ac8cee58786e48129e526f";
		$api_vars['passphrase'] = "Pentasquare123!@#";

		return $this->call_api('/v1/KLAY/nft/contracts/0x348e91b1f21f2aA27598dEF413377A8a217C60a9/transfer',1,$api_vars);
	}
}