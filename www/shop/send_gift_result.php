<?php
include_once('./_common.php');
  $g5['title'] ='선물하기';

if(G5_IS_MOBILE)
    include_once(G5_MSHOP_PATH.'/_head.php');
else
    include_once(G5_SHOP_PATH.'/_head.php');

?>
<div class="sub_title">
  <button type="button" class="title_btn">
    <img src="<?php echo G5_THEME_IMG_URL ?>/btn_arrow_left.png" alt="">
  </button>
  <p class="title">선물하기</p>
  <p class="info">NOMONEYmarket 회원에게만 선물할 수 있습니다.</p>
</div>

<div class="gift_result_layer">
  <img src="<?php echo G5_THEME_IMG_URL ;?>/gift_result.png" alt="">
  <p class="result_p"><span>경민서</span>님께 <br> 선물이 정상적으로 전달되었습니다.</p>
  <a href="<?php echo G5_URL; ?>">메인으로</a>
</div>
<?php

if(G5_IS_MOBILE)
    include_once(G5_MSHOP_PATH.'/_tail.php');
else
    include_once(G5_SHOP_PATH.'/_tail.php');

 ?>
