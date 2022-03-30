<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$q = isset($_GET['q']) ? clean_xss_tags($_GET['q'], 1, 1) : '';

if(G5_IS_MOBILE) {
    include_once(G5_THEME_MSHOP_PATH.'/shop.head.php');
    return;
}

include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
include_once(G5_LIB_PATH.'/latest.lib.php');

add_javascript('<script src="'.G5_JS_URL.'/owlcarousel/owl.carousel.min.js"></script>', 10);
add_stylesheet('<link rel="stylesheet" href="'.G5_JS_URL.'/owlcarousel/owl.carousel.css">', 0);
?>

 <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
 <link rel="stylesheet"  href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
<!-- 상단 시작 { -->
<div id="hd">
  <div class="hd_wrap">
    <a href="<?php echo G5_URL; ?>" id="logo">
      <img src="<?php echo G5_THEME_IMG_URL; ?>/logo.png" alt="">
    </a>
    <ul>
      <li><a href="<?php echo G5_URL; ?>/shop/list.php?ca_id=10">NOMONEY 마켓</a></li>
      <li><a href="<?php echo G5_URL; ?>/bbs/nft_collection.php">OUR NFT COLLECTION</a></li>
      <li><a href="#n">DROP</a></li>
      <li><a href="#n">EVENT</a></li>
      <li><a href="#n">내 지갑</a></li>
      <li>
        <?php if ($is_admin) {  ?>
          <a href="<?php echo correct_goto_url(G5_ADMIN_URL); ?>">관리자</a>
        <?php }else {?>
        <a href="#n">마이페이지</a>
        <?php } ?>
      </li>
    </ul>
    <?php if ($is_member) {  ?>
    <a href="<?php echo G5_BBS_URL ?>/logout.php" class="login_a" id="logout">LOGOUT</a>
    <?php } else {  ?>
    <a href="<?php echo G5_BBS_URL ?>/login.php" id="login" class="login_a">LOGIN</a>
    <?php }  ?>
  </div>
</div>

<script>
jQuery(function ($){
	$(".btn_member_mn").on("click", function() {
        $(".member_mn").toggle();
        $(".btn_member_mn").toggleClass("btn_member_mn_on");
    });

    var active_class = "btn_sm_on",
        side_btn_el = "#quick .btn_sm",
        quick_container = ".qk_con";

    $(document).on("click", side_btn_el, function(e){
        e.preventDefault();

        var $this = $(this);

        if (!$this.hasClass(active_class)) {
            $(side_btn_el).removeClass(active_class);
            $this.addClass(active_class);
        }

        if( $this.hasClass("btn_sm_cl1") ){
            $(".side_mn_wr1").show();
        } else if( $this.hasClass("btn_sm_cl2") ){
            $(".side_mn_wr2").show();
        } else if( $this.hasClass("btn_sm_cl3") ){
            $(".side_mn_wr3").show();
        } else if( $this.hasClass("btn_sm_cl4") ){
            $(".side_mn_wr4").show();
        }
    }).on("click", ".con_close", function(e){
        $(quick_container).hide();
        $(side_btn_el).removeClass(active_class);
    });

    $(document).mouseup(function (e){
        var container = $(quick_container),
            mn_container = $(".shop_login");
        if( container.has(e.target).length === 0){
            container.hide();
            $(side_btn_el).removeClass(active_class);
        }
        if( mn_container.has(e.target).length === 0){
            $(".member_mn").hide();
            $(".btn_member_mn").removeClass("btn_member_mn_on");
        }
    });

    $("#top_btn").on("click", function() {
        $("html, body").animate({scrollTop:0}, '500');
        return false;
    });
});
</script>
<?php
    $wrapper_class = array();
    if( defined('G5_IS_COMMUNITY_PAGE') && G5_IS_COMMUNITY_PAGE ){
        $wrapper_class[] = 'is_community';
    }
?>
<!-- 전체 콘텐츠 시작 { -->
<div id="wrapper" >
    <!-- #container 시작 { -->
    <?php if(!defined('_INDEX_')) { ?>
      <div id="container">


        <?php
            $content_class = array('shop-content');
            if( isset($it_id) && isset($it) && isset($it['it_id']) && $it_id === $it['it_id']){
                $content_class[] = 'is_item';
            }
            if( defined('IS_SHOP_SEARCH') && IS_SHOP_SEARCH ){
                $content_class[] = 'is_search';
            }
            if( defined('_INDEX_') && _INDEX_ ){
                $content_class[] = 'is_index';
            }
        ?>
        <!-- .shop-content 시작 { -->
        <div class="<?php echo implode(' ', $content_class); ?>">
            <?php if ((!$bo_table || $w == 's' ) && !defined('_INDEX_')) {
              if(!$g5['no_title'] == 'nft_collect'){
               ?>
            <?php
            }
          } ?>
            <!-- 글자크기 조정 display:none 되어 있음 시작 { -->
            <!-- } 글자크기 조정 display:none 되어 있음 끝 -->
          <?php } ?>
