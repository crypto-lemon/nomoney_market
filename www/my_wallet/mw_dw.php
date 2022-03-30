<?php
include_once('./_common.php');
include_once('./_head.php');
?>
<div class="sub_title">
  <button type="button" class="title_btn" onClick="history.back();">
    <img src="<?php echo G5_THEME_IMG_URL ?>/btn_arrow_left.png" alt="">
  </button>
  <p class="title">입출금관리</p>
</div>
<div class="mw_layer mw_dw_layer">
  <div class="dw_box_wrap">
    <div class="dw_box_left dw_box">
      <div class="tit">총 보유 자산 </div>
      <div class="dw_left_top dw_in_box">
        <p class="tit">NFT</p>
        <a href="<?php echo G5_URL?>/my_wallet/mw_coin.php" class="dw_more">자세히 보기 ></a>
        <div class="ntf_slide_wrap">
          <p class="ntf_page_box">( <span class="ntf_page"></span> )</p>
          <ul class="swiper-wrapper">
            <li class="swiper-slide">
              <div class="img"><img src="<?php echo G5_THEME_IMG_URL; ?>/NFT1.png" alt=""></div>
              <div class="img"><img src="<?php echo G5_THEME_IMG_URL; ?>/NFT2.png" alt=""></div>
              <div class="img"><img src="<?php echo G5_THEME_IMG_URL; ?>/NFT3.png" alt=""></div>
              <div class="img"><img src="<?php echo G5_THEME_IMG_URL; ?>/NFT1.png" alt=""></div>
              <div class="img"><img src="<?php echo G5_THEME_IMG_URL; ?>/NFT2.png" alt=""></div>
              <div class="img"><img src="<?php echo G5_THEME_IMG_URL; ?>/NFT3.png" alt=""></div>
            </li>
            <li class="swiper-slide">
              <div class="img"><img src="<?php echo G5_THEME_IMG_URL; ?>/NFT1.png" alt=""></div>
              <div class="img"><img src="<?php echo G5_THEME_IMG_URL; ?>/NFT2.png" alt=""></div>
              <div class="img"><img src="<?php echo G5_THEME_IMG_URL; ?>/NFT3.png" alt=""></div>
              <div class="img"><img src="<?php echo G5_THEME_IMG_URL; ?>/NFT1.png" alt=""></div>
              <div class="img"><img src="<?php echo G5_THEME_IMG_URL; ?>/NFT2.png" alt=""></div>
              <div class="img"><img src="<?php echo G5_THEME_IMG_URL; ?>/NFT3.png" alt=""></div>
            </li>
            <li class="swiper-slide">
              <div class="img"><img src="<?php echo G5_THEME_IMG_URL; ?>/NFT1.png" alt=""></div>
              <div class="img"><img src="<?php echo G5_THEME_IMG_URL; ?>/NFT2.png" alt=""></div>
              <div class="img"><img src="<?php echo G5_THEME_IMG_URL; ?>/NFT3.png" alt=""></div>
              <div class="img"><img src="<?php echo G5_THEME_IMG_URL; ?>/NFT1.png" alt=""></div>
              <div class="img"><img src="<?php echo G5_THEME_IMG_URL; ?>/NFT2.png" alt=""></div>
              <div class="img"><img src="<?php echo G5_THEME_IMG_URL; ?>/NFT3.png" alt=""></div>
            </li>
          </ul>
          <div class="nft_prev ntf_arrow"><img src="<?php echo G5_THEME_IMG_URL; ?>/btn_arrow_left.png" alt=""></div>
          <div class="nft_next ntf_arrow"><img src="<?php echo G5_THEME_IMG_URL; ?>/btn_arrow_right.png" alt=""></div>
        </div>
      </div>
      <div class="dw_left_bottom dw_in_box">
        <p class="tit">COIN</p>
        <a href="<?php echo G5_URL?>/my_wallet/mw_coin.php" class="dw_more">자세히 보기 ></a>
        <ul class="nft_coin_ul">
          <li>
            <span>LEMN</span>
            <p><b>0.000%</b><br>평가금액 ₩1,000,000</p>
          </li>
          <li>
            <span>LEMN</span>
            <p><b>0.000%</b><br>평가금액 ₩1,000,000</p>
          </li>
          <li>
            <span>LEMN</span>
            <p><b>0.000%</b><br>평가금액 ₩1,000,000</p>
          </li>
        </ul>

      </div>
    </div>
    <div class="dw_box_right dw_box">
      <div class="tit">입출금</div>
      <form class="dw_pay_form" action="#n" method="post">
        <div class="dw_right_top dw_in_box">
          <span class="in_tit">입금주소</span>
          <button type="button" class="pay_add_copy">복사하기</button>
        </div>
        <div class="dw_right_mid dw_in_box">
          <p class="in_tit">출금 신청</p>
          <ul class="pay_method">
            <li>
              <p>출금 방식</p>
              <label> <input type="radio" name="pay_method_btn" value=""><img src="<?php echo G5_THEME_IMG_URL; ?>/check.png" alt="">일반 출금</label>
              <label> <input type="radio" name="pay_method_btn" value=""><img src="<?php echo G5_THEME_IMG_URL; ?>/check.png" alt="">바로 출금</label>

            </li>
            <li>
              <p>출금 가능</p>
              <span class="pay_money">0.00000000 <b>ETH</b></span>
            </li>
            <li>
              <p>출금 한도</p>
              <span class="pay_money">500,000,000 <b>KRW</b></span>
            </li>
            <li>
              <p>출금 주소</p>
              <select class="pay_out_select" name="">
                <option value="0xc1fb467dc5d9613b17ec1dbeccd5d48974b9e17c">0xc1fb467dc5d9613b17ec1dbeccd5d48974b9e17c</option>
              </select>
            </li>
            <li>
              <p>출금 수량</p>
              <div class="pay_out_count">
                0.00000000<span>ETH</span>
              </div>
              <div class="pay_out_btns">
                <button type="button" name="button">10%</button>
                <button type="button" name="button">25%</button>
                <button type="button" name="button">50%</button>
                <button type="button" name="button">최대</button>
              </div>
            </li>
          </ul>

        </div>
        <div class="dw_right_bottom dw_in_box">
          <ul class="pay_method">
            <li>
              <p>예상출금금액</p>
              <span class="pay_money">500,000,000 <b>KRW</b></span>
            </li>
            <li>
              <p>출금 수수료 <span>(부가세 포함)</span></p>
              <span class="pay_money">0.00000000 <b>ETH</b></span>
            </li>
            <li>
              <p>총 출금 <span>(수수료 포함)</span></p>
              <span class="pay_money">0.00000000 <b>ETH</b></span>
            </li>
          </ul>
        </div>
        <button type="submit" class="pay_submit">출금하기</button>
      </form>
    </div>
  </div>
  <div class="dw_table_box">
    <p>입출금 내역<span>(총 167건)</span></p>
    <div class="dw_table_wrap">
      <table>
        <tr>
          <th>입금/출금</th>
          <th>날짜</th>
          <th>거래 ID</th>
          <th>거래 내역</th>
          <th>잔액</th>
        </tr>
        <tr>
          <td class="withdrawal">출금</td>
          <td>2022.02.15.</td>
          <td>0xc1fb467dc5d9613b17ec1dbeccd5d48974b9e17c</td>
          <td>
            500,000,000 <span>KRW</span>
          </td>
          <td>
            1,500,000,000 <span>KRW</span>
          </td>
        </tr>
        <tr>
          <td class="depoit">입금</td>
          <td>2022.02.15.</td>
          <td>0xc1fb467dc5d9613b17ec1dbeccd5d48974b9e17c</td>
          <td>
            500,000,000 <span>KRW</span>
          </td>
          <td>
            1,500,000,000 <span>KRW</span>
          </td>
        </tr>
        <tr>
          <td class="withdrawal">출금</td>
          <td>2022.02.15.</td>
          <td>0xc1fb467dc5d9613b17ec1dbeccd5d48974b9e17c</td>
          <td>
            500,000,000 <span>KRW</span>
          </td>
          <td>
            1,500,000,000 <span>KRW</span>
          </td>
        </tr>
        <tr>
          <td class="depoit">입금</td>
          <td>2022.02.15.</td>
          <td>0xc1fb467dc5d9613b17ec1dbeccd5d48974b9e17c</td>
          <td>
            500,000,000 <span>KRW</span>
          </td>
          <td>
            1,500,000,000 <span>KRW</span>
          </td>
        </tr>
        <tr>
          <td class="withdrawal">출금</td>
          <td>2022.02.15.</td>
          <td>0xc1fb467dc5d9613b17ec1dbeccd5d48974b9e17c</td>
          <td>
            500,000,000 <span>KRW</span>
          </td>
          <td>
            1,500,000,000 <span>KRW</span>
          </td>
        </tr>
        <tr>
          <td class="depoit">입금</td>
          <td>2022.02.15.</td>
          <td>0xc1fb467dc5d9613b17ec1dbeccd5d48974b9e17c</td>
          <td>
            500,000,000 <span>KRW</span>
          </td>
          <td>
            1,500,000,000 <span>KRW</span>
          </td>
        </tr>
        <tr>
          <td class="withdrawal">출금</td>
          <td>2022.02.15.</td>
          <td>0xc1fb467dc5d9613b17ec1dbeccd5d48974b9e17c</td>
          <td>
            500,000,000 <span>KRW</span>
          </td>
          <td>
            1,500,000,000 <span>KRW</span>
          </td>
        </tr>
        <tr>
          <td class="depoit">입금</td>
          <td>2022.02.15.</td>
          <td>0xc1fb467dc5d9613b17ec1dbeccd5d48974b9e17c</td>
          <td>
            500,000,000 <span>KRW</span>
          </td>
          <td>
            1,500,000,000 <span>KRW</span>
          </td>
        </tr>
        <tr>
          <td class="withdrawal">출금</td>
          <td>2022.02.15.</td>
          <td>0xc1fb467dc5d9613b17ec1dbeccd5d48974b9e17c</td>
          <td>
            500,000,000 <span>KRW</span>
          </td>
          <td>
            1,500,000,000 <span>KRW</span>
          </td>
        </tr>
        <tr>
          <td class="depoit">입금</td>
          <td>2022.02.15.</td>
          <td>0xc1fb467dc5d9613b17ec1dbeccd5d48974b9e17c</td>
          <td>
            500,000,000 <span>KRW</span>
          </td>
          <td>
            1,500,000,000 <span>KRW</span>
          </td>
        </tr>
        <tr>
          <td class="withdrawal">출금</td>
          <td>2022.02.15.</td>
          <td>0xc1fb467dc5d9613b17ec1dbeccd5d48974b9e17c</td>
          <td>
            500,000,000 <span>KRW</span>
          </td>
          <td>
            1,500,000,000 <span>KRW</span>
          </td>
        </tr>
        <tr>
          <td class="depoit">입금</td>
          <td>2022.02.15.</td>
          <td>0xc1fb467dc5d9613b17ec1dbeccd5d48974b9e17c</td>
          <td>
            500,000,000 <span>KRW</span>
          </td>
          <td>
            1,500,000,000 <span>KRW</span>
          </td>
        </tr>
      </table>

    </div>
    <a href="#n" class="more_transaction">거래내역 전체보기></a>
  </div>
</div>
<script>
  $('.pay_method label').click(function(){
    if($(this).find('input').is(':checked')){
      $('.pay_method label').removeClass('on');
      $('.pay_method label img').attr('src','<?php echo G5_THEME_IMG_URL;?>/check.png');
      $(this).addClass('on');
      $(this).find('img').attr('src','<?php echo G5_THEME_IMG_URL;?>/check_on.png');
    }else{
      $(this).removeClass('on');
      $(this).find('img').attr('src','<?php echo G5_THEME_IMG_URL;?>/check.png');

    }
  });
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
</script>

<?php
include_once('./_tail.php');
?>
