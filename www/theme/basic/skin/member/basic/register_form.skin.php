<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
add_javascript('<script src="'.G5_JS_URL.'/jquery.register_form.js"></script>', 0);
if ($config['cf_cert_use'] && ($config['cf_cert_simple'] || $config['cf_cert_ipin'] || $config['cf_cert_hp']))
    add_javascript('<script src="'.G5_JS_URL.'/certify.js?v='.G5_JS_VER.'"></script>', 0);
?>

<!-- 회원정보 입력/수정 시작 { -->
<div class="sub_title">
  <button type="button" class="title_btn" onClick="history.back();">
    <img src="<?php echo G5_THEME_IMG_URL ?>/btn_arrow_left.png" alt="">
  </button>
  <p class="title">정보입력</p>
  <div class="find_pro">
    <div class="find_pro_box ">
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
<div class="register_layer2">
  <form id="fregisterform" name="fregisterform" action="<?php echo $register_action_url ?>" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">

    <input type="hidden" name="mb_name" value="<?php echo $_POST['mb_name']; ?>">
    <input type="hidden" name="mb_5" value="<?php echo $_POST['mb_resi']; ?>">
    <input type="hidden" name="w" value="<?php echo $w ?>">
  	<input type="hidden" name="url" value="<?php echo $urlencode ?>">
  	<input type="hidden" name="agree" value="<?php echo $agree ?>">
  	<input type="hidden" name="agree2" value="<?php echo $agree2 ?>">
  	<input type="hidden" name="cert_type" value="<?php echo $member['mb_certify']; ?>">
  	<input type="hidden" name="cert_no" value="">
  	<?php if (isset($member['mb_sex'])) {  ?><input type="hidden" name="mb_sex" value="<?php echo $member['mb_sex'] ?>"><?php }  ?>
    <div class="regi_box regi_box2">
      <div class="title"><span>*</span>계정 정보</div>
      <div class="input_style regi_input">
        <p>아이디 입력</p>
        <input type="text" name="mb_id" value="<?php echo $member['mb_id'] ?>" id="reg_mb_id" class=""  placeholder="아이디 입력">
      </div>
      <div class="input_style regi_input pass_box">
        <p>비밀번호 입력</p>
        <input type="password" name="mb_password" id="reg_mb_password" placeholder="비밀번호 입력">
        <span>숫자+영문+특수문자 조합 12자리 이상</span>
      </div>
      <div class="input_style regi_input pass_re_box">
        <p>비밀번호 입력</p>
        <input type="password" name="mb_password_re" id="reg_mb_password_re"  placeholder="비밀번호 입력">
        <span>숫자+영문+특수문자 조합 12자리 이상</span>
      </div>
    </div>
    <div class="regi_box regi_box2">
      <div class="title"><span>*</span>휴대폰 번호 인증</div>
      <div class="regi_hp_box">
        <input type="hidden" name="mb_hp" value="<?php echo get_text($member['mb_hp']) ?>" id="reg_mb_hp" >
        <div class="input_style regi_input">
          <p>휴대폰 번호 1</p>
          <input type="text" name="mb_hp1" id="mb_hp1"  placeholder="휴대폰 번호 1" maxlength="3">
        </div>
        <div class="input_style regi_input">
          <p>휴대폰 번호 2</p>
          <input type="text" name="mb_hp2" id="mb_hp2"  placeholder="휴대폰 번호 2"  maxlength="4">
        </div>
        <div class="input_style regi_input">
          <p>휴대폰 번호 3</p>
          <input type="text" name="mb_hp3" id="mb_hp3"  placeholder="휴대폰 번호 3"  maxlength="4">
        </div>
      </div>
      <div class="regi_hp_btn_box">
        <input type="hidden" name="go_random" value="" id="go_random">
        <div class="input_style  only_input">
          <span class="time"></span>
          <input type="text" name="hp_random_num" value="" id="hp_random_num" placeholder="메세지로 전송된 번호를 입력해주세요.">
        </div>
        <button type="button" id="hp_my_btn">본인인증</button>
        <button type="button" id="win_hp_cert" class="btn_frmline">휴대폰 본인확인</button>

      </div>
    </div>
    <div class="regi_box regi_box2">
      <div class="title">이메일 정보</div>
      <div class="regi_email_box">
        <input type="hidden" name="mb_email" value="<?php echo isset($member['mb_email'])?$member['mb_email']:''; ?>" id="reg_mb_email">
        <div class="input_style regi_input">
          <p>이메일 입력</p>
          <input type="text" name="mb_email1" id="mb_email1"  placeholder="이메일 입력">
        </div>
        <div class="input_style">
          <input type="text" name="mb_email2" id="mb_email2">
        </div>
      </div>
      <div class="alram_chd_box">
        <div class="tit">노머니마켓 알림 수신 동의</div>
        <p>할인, 쿠폰, 이벤트 혜택 및 주문 배송 상태를 알려드립니다.</p>
        <div class="chd_list">
          <label> <input type="checkbox" name="mb_1" value="<?php echo $member['mb_1']; ?>"><img src="<?php echo G5_THEME_IMG_URL; ?>/check.png" alt=""><span>문자 메세지</span></label>
          <label> <input type="checkbox" name="mb_2" value="<?php echo $member['mb_2']; ?>"><img src="<?php echo G5_THEME_IMG_URL; ?>/check.png" alt=""><span>카카오톡</span></label>
          <label> <input type="checkbox" name="mb_3" value="<?php echo $member['mb_3']; ?>"><img src="<?php echo G5_THEME_IMG_URL; ?>/check.png" alt=""><span>이메일</span></label>
        </div>
      </div>

    </div>
    <div class="regi_box regi_box2">
      <div class="title">주소 입력<b>상품 주문 시 배송지로 자동 설정됩니다.</b></div>
      <input type="hidden" name="mb_zip" value="<?php echo $member['mb_zip1'].$member['mb_zip2']; ?>" readonly id="reg_mb_zip" placeholder="주소 검색">

      <div class="input_style">
        <p>주소 검색</p>
        <input type="text" name="mb_addr1" value="<?php echo get_text($member['mb_addr1']) ?>" id="reg_mb_addr1" placeholder="주소 검색" readonly>
      </div>
      <button type="button" class="btn_frmline" onclick="win_zip('fregisterform', 'mb_zip', 'mb_addr1', 'mb_addr2', 'mb_addr3', 'mb_addr_jibeon');">주소 검색</button>
      <div class="input_style">
        <input type="text" name="mb_addr2" value="<?php echo get_text($member['mb_addr2']) ?>" id="reg_mb_addr2"   size="50" placeholder="상세주소">
      </div>
      <input type="hidden" name="mb_addr3" value="<?php echo get_text($member['mb_addr3']) ?>" id="reg_mb_addr3"  placeholder="참고항목">
      <input type="hidden" name="mb_addr_jibeon" value="<?php echo get_text($member['mb_addr_jibeon']); ?>">

    </div>
    <div class="regi_box regi_box2 last_regi_box">
      <div class="title">추천자 초대 링크<b class="warning_p">회원가입 후 등록할 수 없습니다.</b></div>
      <div class="invite_box">
        <div class="input_style">
          <input type="text" name="mb_4" value="" id="invite_fr" placeholder="추천자 초대 링크 입력하기">
        </div>
        <button type="button" id="code_copy">붙여넣기</button>

      </div>

    </div>
    <div class="terms_chd">
      <label>
        <input type="checkbox" name="term_chd" value="" id="term_chd" >
        <img src="<?php echo G5_THEME_IMG_URL; ?>/check.png" alt="">
        Nomoneymarket 가입 약관에 모두 동의합니다.
      </label>
      <button type="button" class="open_term_txt"><span>약관 내용 보기</span></button>
    </div>
    <div class="btns_style">
      <button type="button">이전</button>
      <button type="submit" name="submit_btn" id="resgi_submit">다음</button>
    </div>
  </form>
</div>
<script>
var regExpPw = /(?=.*\d{1,50})(?=.*[~`!@#$%\^&*()-+=]{1,50})(?=.*[a-zA-Z]{1,50}).{12,50}$/

/*패스워드 확인*/
$("#reg_mb_password").on("keyup", function() {
  var pass = $(this).val();
  if( regExpPw.test(pass) ) {
    $('.pass_box span').text('안전');
    $('.pass_box').addClass('safe');
    $('.pass_box').removeClass('discord');
  }else{
    $('.pass_box span').text('숫자+영문+특수문자 조합 12자리 이상');
    $('.pass_box').addClass('discord');
    $('.pass_box').removeClass('safe');

  }

});
$("#reg_mb_password_re").on("keyup", function() {
  var pass = $('#reg_mb_password').val();
  var pass_re = $(this).val();
  if( !regExpPw.test(pass) ) {
    alert('비밀번호를 다시 확인해주세요.');
    $('#reg_mb_password').focus();
    return false;
  }
  if( pass != pass_re){
    $('.pass_re_box span').text('다시 입력해주세요.');
    $('.pass_re_box').addClass('discord');
  }else{
    $('.pass_re_box span').text('일치합니다.');
    $('.pass_re_box').removeClass('discord');
    $('.pass_re_box').addClass('safe');

  }
});


$(".regi_hp_box input").on("keyup", function() {
    $(this).val($(this).val().replace(/[^0-9]/g,""));
 });

 $(".regi_input").on("keyup", function() {
  $(this).find('p').show();
  $(this).addClass('on');
});

$('#reg_mb_addr1').click(function(){
  $('.btn_frmline').trigger('click');
});

/*휴대폰 본인인증*/
var timer = null;
var isRunning = false;

$('#hp_my_btn').click(function(){
  var hp1 = $('#mb_hp1').val();
  var hp2 = $('#mb_hp2').val();
  var hp3 = $('#mb_hp3').val();
  if(hp1 ==''){
    alert('휴대폰 번호를 정확히 입력해주세요.');
    $('#mb_hp1').focus();
    return false();
  }
  if(hp2 ==''){
    alert('휴대폰 번호를 정확히 입력해주세요.');
    $('#mb_hp2').focus();
    return false();
  }
  if(hp3 ==''){
    alert('휴대폰 번호를 정확히 입력해주세요.');
    $('#mb_hp3').focus();
    return false();
  }
  if(hp1 != '' || hp2 != '' || hp3 != '' ){
    $('#reg_mb_hp').val(hp1 + hp2 + hp3);
    $("#go_random").val( Math.floor(Math.random() * 1000000) + 1 );
  }

  var display = $('.regi_box2  .input_style .time');
    	var leftSec = 30;
    	// 남은 시간
    	// 이미 타이머가 작동중이면 중지
    	if (isRunning){
        alert('이미 전송되었습니다.');
        return false();
    	}else{
    	startTimer(leftSec, display);
      $('.regi_hp_btn_box .input_style').addClass('safe');
    	}
});
function startTimer(count, display) {

    		var minutes, seconds;
            timer = setInterval(function () {
            minutes = parseInt(count / 60, 10);
            seconds = parseInt(count % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.html(minutes + ":" + seconds);

            // 타이머 끝
            if (--count < 0) {
    	     clearInterval(timer);
    	     display.hide();
    	     isRunning = false;

            }
        }, 1000);
             isRunning = true;
}

/*알림*/
var regType1 = /^[a-zA-Z0-9]*$/;
$('#mb_email1').on("keyup", function(){
  $(this).val($(this).val().replace( /[^a-z0-9]/gi,""));

});
$('.chd_list label').click(function(){
  if($(this).find('input').is(':checked')){
    $(this).addClass('on');
    $(this).find('img').attr('src','<?php echo G5_THEME_IMG_URL; ?>/check_on.png');
    $(this).find('input').val('1');
  }else{
    $(this).removeClass('on');
    $(this).find('img').attr('src','<?php echo G5_THEME_IMG_URL; ?>/check.png');
    $(this).find('input').val('');
  }

});
/*약관동의*/
$('.terms_chd label').click(function(){
  if($(this).find('input').is(':checked')){
    $(this).addClass('on');
    $(this).find('img').attr('src','<?php echo G5_THEME_IMG_URL; ?>/check_on.png');
  }else{
    $(this).removeClass('on');
    $(this).find('img').attr('src','<?php echo G5_THEME_IMG_URL; ?>/check.png');

  }

});

$('#resgi_submit').click(function(){
  var email1 = $('#mb_email1').val();
  var email2 = $('#mb_email2').val();
  $('#reg_mb_email').val(email1+'@'+email2 );

  var id = $('#reg_mb_id').val();
  var pass = $('#reg_mb_password').val();
  var pass2 = $('#reg_mb_password_re').val();
  var num = $('#hp_random_num').val();
  var email = $('#reg_mb_email').val();
  var addr1 = $('#reg_mb_addr1  ').val();
  var addr2 = $('#reg_mb_addr2').val();

  if(id == ''){
    alert('아이디를 입력해주세요.');
     $('#reg_mb_id').focus();
     return false;
  }
  if(pass == ''){
    alert('비밀번호를 입력해주세요.');
     $('#reg_mb_password').focus();
     return false;
  }
  if(pass2 == ''){
    alert('비밀번호 확인을 진행해주세요.');
     $('#reg_mb_password_re').focus();
     return false;
  }

  if(email == ''){
    alert('이메일을 입력해주세요.');
     $('#reg_mb_email').focus();
     return false;
  }
  if(addr1 == ''){
    alert('주소를 입력해주세요.');
     $('#reg_mb_addr1').focus();
     return false;
  }
  if(addr2 == ''){
    alert('상세 주소를 입력해주세요.');
     $('#reg_mb_addr2').focus();
     return false;
  }


});
$(function() {
    $("#reg_zip_find").css("display", "inline-block");
    var pageTypeParam = "pageType=register";

	<?php if($config['cf_cert_use'] && $config['cf_cert_simple']) { ?>
	// 이니시스 간편인증
	var url = "<?php echo G5_INICERT_URL; ?>/ini_request.php";
	var type = "";
    var params = "";
    var request_url = "";

	$(".win_sa_cert").click(function() {
		if(!cert_confirm()) return false;
		type = $(this).data("type");
		params = "?directAgency=" + type + "&" + pageTypeParam;
        request_url = url + params;
        call_sa(request_url);
	});
    <?php } ?>
    <?php if($config['cf_cert_use'] && $config['cf_cert_ipin']) { ?>
    // 아이핀인증
    var params = "";
    $("#win_ipin_cert").click(function() {
		if(!cert_confirm()) return false;
        params = "?" + pageTypeParam;
        var url = "<?php echo G5_OKNAME_URL; ?>/ipin1.php"+params;
        certify_win_open('kcb-ipin', url);
        return;
    });

    <?php } ?>
    <?php if($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
    // 휴대폰인증
    var params = "";
    $("#win_hp_cert").click(function() {
		if(!cert_confirm()) return false;
        params = "?" + pageTypeParam;
        <?php
        switch($config['cf_cert_hp']) {
            case 'kcb':
                $cert_url = G5_OKNAME_URL.'/hpcert1.php';
                $cert_type = 'kcb-hp';
                break;
            case 'kcp':
                $cert_url = G5_KCPCERT_URL.'/kcpcert_form.php';
                $cert_type = 'kcp-hp';
                break;
            case 'lg':
                $cert_url = G5_LGXPAY_URL.'/AuthOnlyReq.php';
                $cert_type = 'lg-hp';
                break;
            default:
                echo 'alert("기본환경설정에서 휴대폰 본인확인 설정을 해주십시오");';
                echo 'return false;';
                break;
        }
        ?>

        certify_win_open("<?php echo $cert_type; ?>", "<?php echo $cert_url; ?>"+params);
        return;
    });
    <?php } ?>
});

jQuery(function($){
	//tooltip
    $(document).on("click", ".tooltip_icon", function(e){
        $(this).next(".tooltip").fadeIn(400).css("display","inline-block");
    }).on("mouseout", ".tooltip_icon", function(e){
        $(this).next(".tooltip").fadeOut();
    });
});

</script>

<!-- } 회원정보 입력/수정 끝 -->
