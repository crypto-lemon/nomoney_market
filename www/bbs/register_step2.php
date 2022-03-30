<?php
include_once('./_common.php');
include_once('./_head.php');
?>
<div class="sub_title">
  <button type="button" class="title_btn" onClick="history.back();">
    <img src="<?php echo G5_THEME_IMG_URL ?>/btn_arrow_left.png" alt="">
  </button>
  <p class="title">정보입력</p>
  <div class="find_pro">
    <div class="find_pro_box">
      <span>
        <b>STEP 1</b> <br>
        본인인증
      </span>
    </div>
    <div class="find_pro_box on">
      <span>
        <b>STEP 2</b> <br>정보입력
      </span>
    </div>
    <div class="find_pro_box">
      <span>
        <b>STEP 3</b> <br>지갑생성
      </span>
    </div>
    <div class="find_pro_box">
      <span>
        <b>STEP 4</b> <br>완료
      </span>
    </div>
  </div>
</div>
<div class="register_layer find_layer ">
  <form class="regi_box find_box"  action="#n" method="post">
    <p class="title"><span>*</span>사용자 기본 정보</p>
    <div class="input_style login_input">
      <p>이름입력</p>
      <input type="text" name="" class="" placeholder=" 이름입력">
    </div>
    <div class="regi_input_wrap">
      <div class="input_style login_input">
        <p>주민등록번호 앞자리 입력</p>
        <input type="text" name="" class="" placeholder="주민등록번호 앞자리 입력">
      </div>
      <div class="input_style login_input">
        <p>주민등록번호 앞자리 입력</p>
        <input type="text" name="" class="" placeholder="주민등록번호 앞자리 입력">
      </div>
    </div>
    <button type="button" name="submit" class="result_btn">다음</button>

  </form>
</div>
<script type="text/javascript">
$('.login_input').click(function(){
  $(this).find('p').show();
  $(this).addClass('on');
});

</script>
<?php
include_once('./_tail.php');
?>
