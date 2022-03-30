<?php
	/*
		ZOO@2022-03-17: 옥텟 API 관련 테스트 페이지
	*/

	include_once('./_common.php');
	include_once(G5_LIB_PATH.'/octet.lib.php');

	 $octet = new OCTET();

	

	//$res = $octet->createChildAddress();
 /*
		echo "<pre>";
		print_r($res);
		echo "출력";
*/
		$KeyInfo = $octet->getAPIKeyInfo();
		$reissueDate = $KeyInfo['formatUnixTimestampSecond'] - (86400 * 7); //7일 전

		$limit_day_m = floor( ($KeyInfo['formatUnixTimestampSecond'] - time()) / (60*60) );
		$limit_day_d = floor( $limit_day_m / 24 );

		$arrChildAddrList = $octet->getChildAddressList();
		//자식지갑 조회
		$arrChildAddr = array();
		foreach( $arrChildAddrList['addresses'] as $childAddr ) {
			$arrChildAddr[$childAddr['keyIndex']] = $octet->getChildAddressInfo($childAddr['address']);

		}

		print_r($arrChildAddr);

		$arrContracts = $octet->getContractsList();
		$arrNFTs = $octet->getNFTList();


		//$res = $octet->transferNFT('0xFbAAED72cFFbA2C5C250Fb1E000955c1ed026476',22345);
		//$res = $octet->transferNFT('0xF140fC4B23ba8593a6F87d8E3537CF79b3392D4c',32345);
		//print_r($res);

?>
<h1>옥텟 API 테스트</h1>

<div>
API Key 유효기간 : <?php echo date("Y-m-d h:i:s", $KeyInfo['formatUnixTimestampSecond']); ?><br>
(갱신 날짜: <?php echo date("Y-m-d h:i:s", $reissueDate); ?>)<br>
남은 기간 <?php echo $limit_day_d;  ?>

<?php
if( ($limit_date - 70) < 0 )  {
	//$res = $octet->createAPIKey();

	//print_r($res);

	//echo "<br><br>키 교체";
}
?>
</div>

<h2>회원 지갑리스트</h2>
<ul>
<?php
	foreach( $arrChildAddrList['addresses'] as $childAddr ) {
		echo "<li>";
		echo "회원 (index) : ".$childAddr['keyIndex']."<br>";
		echo "주소 : ".$childAddr['address']."<br>";
		echo "잔액 : ".$arrChildAddr[$childAddr['keyIndex']]['balance']."<br>";

		//echo "<button onclick='transferNFT('');'>토큰(NFT) 전송</button>"."<br>";

		echo "</li>";
	}
?>
</ul>

<h2>컨트렉트 리스트</h2>
<ul>
<?php
	foreach( $arrContracts as $contracts ) {
		echo "<li>";
		echo "name : ".$contracts['name']."<br>";
		echo "type : ".$contracts['type']."<br>";
		echo "status : ".$contracts['status']."<br>";
		echo "parentSymbol : ".$contracts['parentSymbol']."<br>";
		echo "symbol : ".$contracts['symbol']."<br>";
		echo "address : ".$contracts['contractAddress']."<br>";
		echo "createdDate : ".$contracts['createdDate']."<br>";
		echo "</li>";
	}
?>
</ul>

<h2>NFT(토큰) 리스트</h2>
<ul>
<?php
	foreach( $arrNFTs as $nft ) {
		echo "<li>";
		echo "tokenId : ".$nft['tokenId']."<br>";
		echo "ownerAddress : ".$nft['ownerAddress']."<br>";
		echo "metadata : ".$nft['metadata']."<br>";
		echo "amount : ".$nft['amount']."<br>";
		echo "createdDate : ".$nft['createdDate']."<br>";
		echo "</li>";
	}
?>
</ul>

<button onclick="createNFT();">토큰(NFT)발급</button>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
 

<script>

function createNFT() {
	var cntNFT = "<?=count($arrNFTs)?>";

	var data = JSON.stringify({
			"uri":"https://mblogthumb-phinf.pstatic.net/MjAxODAxMTRfMjc1/MDAxNTE1ODkzMjgxMTEy.VBwzXbDz2BI6-r1ispUIW0P3cSzujfx4NG6OdsLsf1Yg.vpuI5SfE4hpBtSM0QyCa1MvUeUQuG3sxUj0LH7R_4IYg.JPEG.hhyunk49/%EB%82%98%EB%AC%B4.jpg?type=w800",
			"tokenId":32345 + parseInt(cntNFT),
			"privateKey":"8024c09789d0790f4312e7859728a879f75752d05c20ecfff5adc1bba51304a8ae42417e3f17b5aca1eb76d37245d7db7e4b8165b8afb7b3851bf13a87a5464ecb6fcc511b03847cbaab66b805481e42f16d5723e3a8356b8c8cecf5a07b65aa33bc67f9a4dbcada54346382ce2233ce08c4a3b8b983b85fc5993b8e8dbdfd604a0784055f547a56c8be90f10a10a2355bbb5701d9ac515a4e4efe6cda9ee596ef7ad979fc35b772b1381bbb1f078bbccb52573b195cda914749762927b11f4bb251f4f8f80c8e12e2f48b09ef13100ed643fcf822fcff1d357e9e7f155175d0a0685528f53ccfa8aa0fd7790afc18bb1513df8db694a0ef6866a2d81c49fa0e81ffa82e4ccc3ac8cee58786e48129e526f",
			"passphrase":"Pentasquare123!@#"
		});

	var config = {
		  method: 'post',
		  url: 'https://dev.blockchainapi.pro/v1/KLAY/nft/contracts/0x348e91b1f21f2aA27598dEF413377A8a217C60a9/tokens',
		  headers: { 
			'Authorization': 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZHgiOjkzNCwiaXNfYWRtaW4iOmZhbHNlLCJpYXQiOjE2NDY5NjMzMjksImV4cCI6MTY1NDczOTMyOSwiaXNzIjoibm9kZS5oZWxhbnQifQ.HeteV2hoJQtU5rJTdmzn3lTBFGyI6NHM_j0L-1ujnMk', 
			'Content-Type': 'application/json'
		  },
			  data : data
		};

		axios(config)
		.then(function (response) {
		  console.log(JSON.stringify(response.data));
		})
		.catch(function (error) {
		  console.log(error);
		});
}

function transferNFT() {
}
</script>