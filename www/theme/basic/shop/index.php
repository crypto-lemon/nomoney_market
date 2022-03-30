<?php
include_once('./_common.php');

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MSHOP_PATH.'/index.php');
    return;
}

if(! defined('_INDEX_')) define('_INDEX_', TRUE);

include_once(G5_THEME_SHOP_PATH.'/shop.head.php');
?>
<div id="main" class="main">
  <div class="con main_con">
    <img src="<?php echo G5_THEME_IMG_URL; ?>/main_img.png" alt="" class="main_img">
    <div class="main_txt">
      <p>쇼핑에 <span>NFT</span>를 더하다!</p>
      <p>노머니마켓은 고객의 구성상품과 NFT를  <br> 더욱 가치있게 만들어줍니다.</p>
    </div>
  </div>
</div>
<div id="main2" class="main">
  <img src="<?php echo G5_THEME_IMG_URL; ?>/no_login_box.png" alt="">

  <div class="tit">제품 구매하고 <span>NFT</span>를 <span>획득</span>하세요!</div>
  <a href="<?php echo G5_BBS_URL ?>/login.php" class="go_login">로그인하기</a>
</div>
<div id="main3" class="main">
  <div class="con">
    <div class="tit"><span>노머니마켓</span> 이용방법</div>
    <div class="use_box">
      <div class="use_num">이용방법 01.</div>
      <p class="use_tit">회원가입 후 지갑 확인</p>
      <a href="<?php echo G5_BBS_URL ?>/register.php" class="go_regi">
        회원가입하기
        <img src="<?php echo G5_THEME_IMG_URL; ?>/go_resgster.png" alt="">
      </a>
      <p class="use_info">
        <b>회원가입 시 자동으로 지갑이 생성됩니다.</b> <br>
        상품을 비회원으로 구매하실 경우 NFT가 지급되지 않습니다.
      </p>
    </div>
    <div class="use_box">
      <div class="use_num">이용방법 02.</div>
      <p class="use_tit">랜덤 NFT 박스 획득</p>
      <ul>
        <li>
          <div class="nft_box nft_box1">
            <img src="<?php echo G5_THEME_IMG_URL; ?>/normal_close.png" alt="">
          </div>
          <p>Rare</p>
          <p>레어</p>

        </li>
        <li>
          <div class="nft_box nft_box2">
            <img src="<?php echo G5_THEME_IMG_URL; ?>/rare_close.png" alt="">
          </div>
          <p>Epic</p>
          <p>에픽</p>

        </li>
        <li>
          <div class="nft_box nft_box3">
            <img src="<?php echo G5_THEME_IMG_URL; ?>/regend_close.png" alt="">
          </div>
          <p>Regend</p>
          <p>레전드</p>

        </li>
      </ul>
      <p class="use_info">
        <b>
          NFT를 제공하는 상품을 구매하시고 구매 확정을 하시면 <br>
          [<span class="color1">레어</span>, <span class="color2">에픽</span>, <span class="color3">레전드</span>] 3가지 등급 중 하나의 랜덤 box가 제공됩니다.
        </b>
      </p>

    </div>
    <div class="use_box">
      <div class="use_num">이용방법 03.</div>
      <p class="use_tit">NFT BOX 오픈</p>
      <p class="use_info">획득하신 NFT는 송금, 환전, 제품 구매 등으로 다양하게 사용 가능합니다.</p>
      <img src="<?php echo G5_THEME_IMG_URL; ?>/coins.png" alt="" class="coins">

    </div>
  </div>
</div>
<!-- 메인이미지 시작 { -->
<?php
include_once(G5_THEME_SHOP_PATH.'/shop.tail.php');
