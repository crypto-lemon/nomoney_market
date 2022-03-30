<?php
include_once('./_common.php');
include_once('./_head.php');
?>

<div class="sub_title">
  <p class="title">본인인증</p>
  <div class="find_pro">
    <div class="find_pro_box on">
      <span>
        <b>STEP 1</b> <br>
        본인인증
      </span>
    </div>
    <div class="find_pro_box">
      <span>
        <b>STEP 2</b> <br>계정찾기
      </span>
    </div>
  </div>
</div>
<div class="find_layer">
  <ul>
    <li>
      <a href="">
        <img src="<?php echo G5_THEME_IMG_URL; ?>/find_hp.png" alt="">
        <p>휴대폰 인증</p>
        <p>본인 명의의 휴대폰으로 인증합니다.</p>
      </a>
    </li>
    <li>
      <a href="">
        <img src="<?php echo G5_THEME_IMG_URL; ?>/find_ip.png" alt="">
        <p>아이핀(I-PIN) 인증</p>
        <p>본인 명의의 아이핀(I-PIN) 계정으로 인증합니다.</p>
      </a>
    </li>
  </ul>
</div>


<?php
include_once('./_tail.php');
?>
