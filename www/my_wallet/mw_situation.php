<?php
include_once('./_common.php');
include_once('./_head.php');
?>
<div class="mw_layer mw_situ_layer">
  <div class="mw_title left">내 지갑 <span>자산 현황</span></div>
  <div class="mw_code_box">
    <div class="mw_code">0xc1fb467dc5d9613b17ec1dbeccd5d48974b9e17c</div>
    <button type="button" >복사하기</button>
  </div>
  <div class="mw_nft_box">
    <div class="nft_left">
      <p class="tit">NFT</p>
      <div class="ntf_slide_wrap">
        <p class="ntf_page_box">( <span class="ntf_page"></span> )</p>
        <ul class="swiper-wrapper">
          <li class="swiper-slide">
            <div class="img"><img src="<?php echo G5_THEME_IMG_URL; ?>/NFT1.png" alt=""></div>
            <div class="img"><img src="<?php echo G5_THEME_IMG_URL; ?>/NFT2.png" alt=""></div>
            <div class="img"><img src="<?php echo G5_THEME_IMG_URL; ?>/NFT3.png" alt=""></div>
            <div class="img"><img src="<?php echo G5_THEME_IMG_URL; ?>/NFT1.png" alt=""></div>
            <div class="img"><img src="<?php echo G5_THEME_IMG_URL; ?>/NFT2.png" alt=""></div>
            <div class="img"><img src="<?php echo G5_THEME_IMG_URL; ?>/NFT3.png" alt=""></div>
          </li>
          <li class="swiper-slide">
            <div class="img"><img src="<?php echo G5_THEME_IMG_URL; ?>/NFT1.png" alt=""></div>
            <div class="img"><img src="<?php echo G5_THEME_IMG_URL; ?>/NFT2.png" alt=""></div>
            <div class="img"><img src="<?php echo G5_THEME_IMG_URL; ?>/NFT3.png" alt=""></div>
            <div class="img"><img src="<?php echo G5_THEME_IMG_URL; ?>/NFT1.png" alt=""></div>
            <div class="img"><img src="<?php echo G5_THEME_IMG_URL; ?>/NFT2.png" alt=""></div>
            <div class="img"><img src="<?php echo G5_THEME_IMG_URL; ?>/NFT3.png" alt=""></div>
          </li>
          <li class="swiper-slide">
            <div class="img"><img src="<?php echo G5_THEME_IMG_URL; ?>/NFT1.png" alt=""></div>
            <div class="img"><img src="<?php echo G5_THEME_IMG_URL; ?>/NFT2.png" alt=""></div>
            <div class="img"><img src="<?php echo G5_THEME_IMG_URL; ?>/NFT3.png" alt=""></div>
            <div class="img"><img src="<?php echo G5_THEME_IMG_URL; ?>/NFT1.png" alt=""></div>
            <div class="img"><img src="<?php echo G5_THEME_IMG_URL; ?>/NFT2.png" alt=""></div>
            <div class="img"><img src="<?php echo G5_THEME_IMG_URL; ?>/NFT3.png" alt=""></div>
          </li>
        </ul>
        <div class="nft_prev ntf_arrow"><img src="<?php echo G5_THEME_IMG_URL; ?>/btn_arrow_left.png" alt=""></div>
        <div class="nft_next ntf_arrow"><img src="<?php echo G5_THEME_IMG_URL; ?>/btn_arrow_right.png" alt=""></div>
      </div>
    </div>
    <div class="nft_right">
      <p class="tit">COIN</p>
      <ul class="nft_coin_ul">
        <li>
          <span>LEMN</span>
          <p><b>0.000%</b><br>평가금액 ₩1,000,000</p>
        </li>
        <li>
          <span>LEMN</span>
          <p><b>0.000%</b><br>평가금액 ₩1,000,000</p>
        </li>
        <li>
          <span>LEMN</span>
          <p><b>0.000%</b><br>평가금액 ₩1,000,000</p>
        </li>
      </ul>
    </div>
  </div>
  <div class="mw_link_box">
    <a href="<?php echo G5_URL; ?>/my_wallet/mw_box.php">박스 보관함</a>
    <a href="<?php echo G5_URL; ?>/my_wallet/mw_dw.php">입출금관리</a>
    <a href="<?php echo G5_URL; ?>/my_wallet/mw_coin.php">코인 전환하기</a>
  </div>
</div>

<script>
     var swiper = new Swiper(".ntf_slide_wrap", {
       loop:true,
       pagination: {
         el: ".ntf_page",
         type: "fraction",
       },
       navigation: {
         nextEl: ".nft_prev",
         prevEl: ".nft_next",
       },
     });
</script>
<?php
include_once('./_tail.php');
?>
