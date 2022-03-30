<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<div class="sub_title">
  <button type="button" class="title_btn" onClick="history.back();">
    <img src="<?php echo G5_THEME_IMG_URL ?>/btn_arrow_left.png" alt="">
  </button>
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
  <form class="regi_box find_box"  action="<?php echo G5_BBS_URL ?>/register_form.php" method="post">
    <p class="title"><span>*</span>사용자 기본 정보</p>
    <div class="input_style login_input">
      <p>이름입력</p>
      <input type="text" name="mb_name" class="" placeholder=" 이름입력" id="mb_name">
    </div>
    <input type="hidden" name="mb_resi" value="" id="mb_resi">

    <div class="regi_input_wrap">
      <div class="input_style login_input">
        <p>주민등록번호 앞자리 입력</p>
        <input type="text" name="mb_resi_num1" id="mb_resi_num1" maxlength="6" placeholder="주민등록번호 앞자리 입력">
      </div>
      <div class="input_style login_input">
        <p>주민등록번호 뒷자리 입력</p>
        <input type="password" name="mb_resi_num2" id="mb_resi_num2" placeholder="주민등록번호 뒷자리 입력" maxlength="7">
      </div>
    </div>
    <button type="submit" name="submit" class="result_btn" id="step1_submit">다음</button>

  </form>
</div>
<script type="text/javascript">
$(".regi_input_wrap .login_input input").on("keyup", function() {
    $(this).val($(this).val().replace(/[^0-9]/g,""));
 });

$('.login_input').click(function(){
  $(this).find('p').show();
  $(this).addClass('on');
});

$("#mb_resi_num2").on("keyup", function() {
  var resi_num1 = $('#mb_resi_num1').val();
  var resi_num2 = $('#mb_resi_num2').val();
  $('#mb_resi').val(resi_num1+'-'+resi_num2);


});
$('#step1_submit').click(function(){
  var name = $('#mb_name').val();
  var resi = $('#mb_resi').val();
  var resi_num1 = $('#mb_resi_num1').val();
  var resi_num2 = $('#mb_resi_num2').val();


  if(name ==''){
    alert('이름을 입력하세요.');
    $('#mb_name').focus();
    return false;
  }


  if(resi ==''){
    alert('주민번호를 입력해주세요.');
    $('#mb_resi').focus();
    return false;
  }
});
</script>

<!-- 회원가입약관 동의 시작 { -->
<!-- } 회원가입 약관 동의 끝 -->
