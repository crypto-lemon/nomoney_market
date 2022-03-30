<?php
include_once('./_common.php');
include_once('./_head.php');
?>
<div class="sub_title">
  <button type="button" class="title_btn" onClick="history.back();">
    <img src="<?php echo G5_THEME_IMG_URL ?>/btn_arrow_left.png" alt="">
  </button>
  <p class="title">계정찾기</p>
  <div class="find_pro">
    <div class="find_pro_box">
      <span>
        <b>STEP 1</b> <br>
        본인인증
      </span>
    </div>
    <div class="find_pro_box  on">
      <span>
        <b>STEP 2</b> <br>계정찾기
      </span>
    </div>
  </div>
</div>
<div class="find_layer">
  <div class="find_result_box">
    <img src="<?php echo G5_THEME_IMG_URL ?>/gift_result.png" alt="">
    <p>비밀번호 변경이 완료되었습니다.</p>
    <a href="<?php echo G5_BBS_URL ?>/login.php" class="result_btn">로그인하러가기</a>
  </div>
</div>

<?php
include_once('./_tail.php');
?>
