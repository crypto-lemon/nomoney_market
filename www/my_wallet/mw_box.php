<?php
include_once('./_common.php');
include_once('./_head.php');
?>
<div class="sub_title">
  <button type="button" class="title_btn" onClick="history.back();">
    <img src="<?php echo G5_THEME_IMG_URL ?>/btn_arrow_left.png" alt="">
  </button>
  <p class="title">박스 보관함</p>
</div>
<div class="mw_layer mw_box_layer">
  <div class="mw_box_wrap">
    <div class="mw_box">
      <img src="<?php echo G5_THEME_IMG_URL; ?>/check_on.png" alt="" class="click_img">
      <img src="<?php echo G5_THEME_IMG_URL; ?>/normal_close.png" alt="" class="box_img">
    </div>
    <div class="mw_box">
      <img src="<?php echo G5_THEME_IMG_URL; ?>/check_on.png" alt="" class="click_img">
      <img src="<?php echo G5_THEME_IMG_URL; ?>/normal_close.png" alt="" class="box_img">
    </div>
    <div class="mw_box">
      <img src="<?php echo G5_THEME_IMG_URL; ?>/check_on.png" alt="" class="click_img">
      <img src="<?php echo G5_THEME_IMG_URL; ?>/rare_close.png" alt="" class="box_img">
    </div>
    <div class="mw_box">
      <img src="<?php echo G5_THEME_IMG_URL; ?>/check_on.png" alt="" class="click_img">
      <img src="<?php echo G5_THEME_IMG_URL; ?>/regend_close.png" alt="" class="box_img">
    </div>
    <div class="mw_box">
      <img src="<?php echo G5_THEME_IMG_URL; ?>/check_on.png" alt="" class="click_img">
      <img src="<?php echo G5_THEME_IMG_URL; ?>/normal_close.png" alt="" class="box_img">
    </div>
    <div class="mw_box">
      <img src="<?php echo G5_THEME_IMG_URL; ?>/check_on.png" alt="" class="click_img">
      <img src="<?php echo G5_THEME_IMG_URL; ?>/rare_close.png" alt="" class="box_img">
    </div>
    <div class="mw_box">
      <img src="<?php echo G5_THEME_IMG_URL; ?>/check_on.png" alt="" class="click_img">
      <img src="<?php echo G5_THEME_IMG_URL; ?>/regend_close.png" alt="" class="box_img">
    </div>

  </div>
  <p>< 레어2, 레전드1 선택 ></p>
  <div class="btns_style box_btns_layer" >
    <button type="button" name="button" class="open_box">열기</button>
    <button type="button" name="button" class="all_open_box">모두열기</button>
  </div>
</div>
<div class="box_pg"></div>
<div class="box_result">
  <ul class="open_box_wrap">
    <li>
      <div class="box">
        <img src="<?php echo G5_THEME_IMG_URL; ?>/rare_open.png" alt="" class="box_img">
      </div>
      <img src="<?php echo G5_THEME_IMG_URL; ?>/NFT3.png" alt="" class="nft_img">
    </li>
    <li>
      <div class="box">
        <img src="<?php echo G5_THEME_IMG_URL; ?>/rare_open.png" alt="" class="box_img">
      </div>
      <img src="<?php echo G5_THEME_IMG_URL; ?>/NFT3.png" alt="" class="nft_img">
    </li>
    <li>
      <div class="box">
        <img src="<?php echo G5_THEME_IMG_URL; ?>/regend_open.png" alt="" class="box_img">
      </div>
      <img src="<?php echo G5_THEME_IMG_URL; ?>/NFT1.png" alt="" class="nft_img">
    </li>
  </ul>
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

     $('.mw_box').click(function(){
       if($(this).hasClass('on')){
         $(this).removeClass('on');

       }else{
         $(this).addClass('on');
         var img = $(this).find('.box_img').attr('src');
         $('body').append('<img src="'+img+'" alt="" class="big_box_img"/>');
         $('.box_pg').fadeIn();


       }

     });

     $('.box_pg').click(function(){
       $('.box_pg').fadeOut();
       $('.big_box_img').detach();
       


     });

   </script>
<?php
include_once('./_tail.php');
?>
