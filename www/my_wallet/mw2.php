<?php
include_once('./_common.php');
include_once('./_head.php');
?>
<div class="mw_layer mw_layer2">
  <div class="mw_con2">
    <div class="mw_title"><span>내 지갑</span> 만들기</div>
    <div class="mw2_txt">
      <p>NOMONEYmarket 지갑 개선에 참여</p>
      <p>
        NOMONEYmarket 지갑은 사용자가 확장 프로그램과 상호작용하는 방식을 <br> 자세히 이해하기 위해 사용 데이터를 수집하려 합니다. 이 데이터는 당사의 제품과 <br> 클레이튼 에코시스템의 사용 편의성 및 사용자 경험을 지속적으로 개선하는 데 사용됩니다.
      </p>
    </div>
    <div class="ul_box">
      <ul>
        <li><img src="<?php echo G5_THEME_IMG_URL; ?>/o.png" alt="">언제든 설정을 통해 옵트아웃(opt-out) 할 수 있습니다.</li>
        <li><img src="<?php echo G5_THEME_IMG_URL; ?>/o.png" alt="">익명화된 클릭 및 페이지뷰 이벤트 보내기</li>
      </ul>
      <ul>
        <li><img src="<?php echo G5_THEME_IMG_URL; ?>/x.png" alt="">키, 주소, 거래, 잔액, 해시 또는 개인 정보를 절대 수집하지 않습니다.</li>
        <li><img src="<?php echo G5_THEME_IMG_URL; ?>/x.png" alt="">전체 IP 주소를 절대 수집하지 않습니다.</li>
        <li><img src="<?php echo G5_THEME_IMG_URL; ?>/x.png" alt="">수익을 위해 데이터를 절대 판매하지 않습니다.</li>
      </ul>

    </div>
    <div class="mw2_info">
      이 데이터는 집계되며 일반 데이터 보호 규칙(EO) 2018/6/9의 방식에 따라 익명으로 관리됩니다. <br> 당사의 개인정보보호 관행에 관한 자세한 내용은 <a href="#n">개인정보보호정책</a>을 참고하세요.
    </div>
    <div class="btns_style mw_btns_style">
      <a href="<?php echo G5_URL;?>">다음에 하기</a>
      <button type="button" name="button" class="ok_mak_wallet">동의 후 지갑 생성하기</button>
    </div>

  </div>
</div>
<div class="wallet_pop_bg"></div>
<div class="wallet_pop">
  <img src="<?php echo G5_THEME_IMG_URL; ?>/gift_result.png" alt="">
  <p>지갑 생성이 완료되었습니다.</p>
</div>

<script type="text/javascript">
  $('.ok_mak_wallet').click(function(){
    $('.wallet_pop_bg').fadeIn();
    $('.wallet_pop').show();

    setTimeout(function() {
      $('.wallet_pop_bg').hide();
      $('.wallet_pop').hide();
      location.href = '<?php echo G5_URL?>/my_wallet/mw_situation.php';
    }, 1000);
  });
  $('.wallet_pop_bg').click(function(){
    $('.wallet_pop_bg').hide();
    $('.wallet_pop').hide();
  });
</script>
<?php
include_once('./_tail.php');
?>
