<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 로그인 시작 { -->
<div class="login_layer">
  <div class="login_box">
    <form name="flogin" action="<?php echo $login_action_url ?>" onsubmit="return flogin_submit(this);" method="post">
      <input type="hidden" name="url" value="<?php echo $login_url ?>">
      <div class="title">로그인</div>
      <div class="input_style id_box login_input">
        <p>아이디 입력</p>
        <input type="text" name="mb_id" id="login_id"  maxLength="20" placeholder="아이디 입력">
      </div>
      <div class="input_style login_input" >
        <p>비밀번호 입력</p>
        <input type="password" name="mb_password" id="login_pw" size="20" maxLength="20" placeholder="비밀번호 입력">
      </div>
      <a href="<?php echo G5_BBS_URL ?>/find_idpw.php" class="find_id">아이디/비밀번호를 잊어버리셨나요?</a>
      <div class="btns_style">
        <a href="<?php echo G5_BBS_URL ?>/register.php" class="resgi_btn">계정생성</a>
        <button type="submit" name="submit_btn" class="submit_btn">로그인</button>
      </div>

    </form>
  </div>

</div>

<script>

$('.login_input').click(function(){
  $(this).find('p').show();
  $(this).addClass('on');
});
jQuery(function($){
    $("#login_auto_login").click(function(){
        if (this.checked) {
            this.checked = confirm("자동로그인을 사용하시면 다음부터 회원아이디와 비밀번호를 입력하실 필요가 없습니다.\n\n공공장소에서는 개인정보가 유출될 수 있으니 사용을 자제하여 주십시오.\n\n자동로그인을 사용하시겠습니까?");
        }
    });
});

function flogin_submit(f)
{
    if( $( document.body ).triggerHandler( 'login_sumit', [f, 'flogin'] ) !== false ){
        return true;
    }
    return false;
}
</script>
<!-- } 로그인 끝 -->
