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
  <div class="find_box">
    <p class="title left">보유중인 아이디</p>
    <div class="find_id">nomoneymarket01 </div>
    <form class="re_pass_form" action="#n" method="post" >
      <p class="title left">비밀번호 변경</p>
      <div class="input_style find_input">
        <p>새 비밀번호 입력</p>
        <input type="password" name="re_pw" value="" class="re_pw">
        <span>안전함</span>
      </div>
      <div class="input_style find_input">
        <p>새 비밀번호 확인</p>
        <input type="password" name="re_pw2" value="" class="re_pw2">
        <span>확인</span>
      </div>
      <div class="btns_style">
        <a href="javascript:history.back();">이전</a>
        <a href="<?php echo G5_BBS_URL; ?>/find_pw.php">비밀번호 변경</a>
      </div>

    </form>
  </div>
</div>

<?php
include_once('./_tail.php');
?>
