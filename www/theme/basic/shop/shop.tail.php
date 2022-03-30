<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MSHOP_PATH.'/shop.tail.php');
    return;
}

$admin = get_admin("super");

// 사용자 화면 우측과 하단을 담당하는 페이지입니다.
// 우측, 하단 화면을 꾸미려면 이 파일을 수정합니다.
?>
<?php if(!defined('_INDEX_')) { ?>

        </div>  <!-- } .shop-content 끝 -->
	</div>      <!-- } #container 끝 -->
<?php }?>
</div>
<!-- } 전체 콘텐츠 끝 -->

<!-- 하단 시작 { -->
<div id="ft">
  <div class="ft_wrap">
    <div class="ft_left">
      <ul>
        <li><a href="#n">개인정보처리방침</a></li>
        <li><a href="#n">서비스이용약관</a></li>
        <li><a href="#n">위치기반서비스 이용약관</a></li>
      </ul>
      <div class="ft_txt_box">
        <img src="<?php echo G5_THEME_IMG_URL; ?>/ft_logo.png" alt="">
        <p>
          회사명 : 경남제약스퀘어(주)    대표자 : 박성재   주소 : 서울특별시 강남구 언주로 702(경남제약타워) 10층
        </p>
        <p>전화 : 070-4652-0186 고객센터 : 1688-1688 개인정보보호책임자 : 박성재 (seleso@naver.com)</p>
        <p>사업자등록번호 : 708-87-02535 [사업자정보확인]   통신판매업신고번호 : 제 2022-서울강남-00900 호</p>
        <p>COPYRIGHT (c) 경남제약스퀘어|주| ALL RIGHTS RESERVED.</p>
      </div>
    </div>
    <div class="ft_right">
      <select class="family_site" name="family_site">
        <option value="">FAMILY SITE</option>
      </select>
      <ul>
        <li><a href="#n">상담센터 바로가기</a></li>
        <li><a href="#n">문의하기 1688-1688</a></li>
        <li><a href="#n">협력업체 문의</a></li>
        <li><a href="#n">제휴/마케팅 문의</a></li>
      </ul>
    </div>
  </div>
</div>
<?php
$sec = get_microtime() - $begin_time;
$file = $_SERVER['SCRIPT_NAME'];

if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}
?>

<script src="<?php echo G5_JS_URL; ?>/sns.js"></script>
<!-- } 하단 끝 -->

<?php
include_once(G5_THEME_PATH.'/tail.sub.php');
