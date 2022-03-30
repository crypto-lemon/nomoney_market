<?php

if($send_gift=='1'){
  $g5['title'] ='선물하기 주문서';
}else{
  $g5['title'] ='주문서';
}


if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

require_once(G5_SHOP_PATH.'/settle_'.$default['de_pg_service'].'.inc.php');
require_once(G5_SHOP_PATH.'/settle_kakaopay.inc.php');

if( $default['de_inicis_lpay_use'] || $default['de_inicis_kakaopay_use'] ){   //이니시스 Lpay 또는 이니시스 카카오페이 사용시
    require_once(G5_SHOP_PATH.'/inicis/lpay_common.php');
}

if(function_exists('is_use_easypay') && is_use_easypay('global_nhnkcp')){  // 타 PG 사용시 NHN KCP 네이버페이 사용이 설정되어 있다면
    require_once(G5_SHOP_PATH.'/kcp/global_nhn_kcp.php');
}

// 결제대행사별 코드 include (스크립트 등)
require_once(G5_SHOP_PATH.'/'.$default['de_pg_service'].'/orderform.1.php');

if( $default['de_inicis_lpay_use'] || $default['de_inicis_kakaopay_use'] ){   //이니시스 L.pay 사용시
    require_once(G5_SHOP_PATH.'/inicis/lpay_form.1.php');
}

if(function_exists('is_use_easypay') && is_use_easypay('global_nhnkcp')){  // 타 PG 사용시 NHN KCP 네이버페이 사용이 설정되어 있다면
    require_once(G5_SHOP_PATH.'/kcp/global_nhn_kcp_form.1.php');
}

if($is_kakaopay_use) {
    require_once(G5_SHOP_PATH.'/kakaopay/orderform.1.php');
}

?>
<div class="sub_title">
  <button type="button" class="title_btn">
    <img src="<?php echo G5_THEME_IMG_URL ?>/btn_arrow_left.png" alt="">
  </button>
  <?php if($send_gift=='1'){?>
    <p class="title">선물하기 주문서</p>
  <?php }else{ ?>
    <p class="title">주문서</p>
  <?php } ?>

</div>

<form name="forderform" id="forderform" method="post" action="<?php echo $order_action_url; ?>" autocomplete="off">
<div id="sod_frm" class="sod_frm_pc">
    <!-- 주문상품 확인 시작 { -->
    <div class=" get_list_box">
        <table id="sod_list" class="get_list">
        <tbody>
        <?php
        $tot_point = 0;
        $tot_sell_price = 0;

        $goods = $goods_it_id = "";
        $goods_count = -1;

        // $s_cart_id 로 현재 장바구니 자료 쿼리
        $sql = " select a.ct_id,
                        a.it_id,
                        a.it_name,
                        a.ct_price,
                        a.ct_point,
                        a.ct_qty,
                        a.ct_status,
                        a.ct_send_cost,
                        a.it_sc_type,
                        b.ca_id,
                        b.ca_id2,
                        b.ca_id3,
                        b.it_notax
                   from {$g5['g5_shop_cart_table']} a left join {$g5['g5_shop_item_table']} b on ( a.it_id = b.it_id )
                  where a.od_id = '$s_cart_id'
                    and a.ct_select = '1' ";
        $sql .= " group by a.it_id ";
        $sql .= " order by a.ct_id ";
        $result = sql_query($sql);

        $good_info = '';
        $it_send_cost = 0;
        $it_cp_count = 0;

        $comm_tax_mny = 0; // 과세금액
        $comm_vat_mny = 0; // 부가세
        $comm_free_mny = 0; // 면세금액
        $tot_tax_mny = 0;

        for ($i=0; $row=sql_fetch_array($result); $i++)
        {
            // 합계금액 계산
            $sql = " select SUM(IF(io_type = 1, (io_price * ct_qty), ((ct_price + io_price) * ct_qty))) as price,
                            SUM(ct_point * ct_qty) as point,
                            SUM(ct_qty) as qty
                        from {$g5['g5_shop_cart_table']}
                        where it_id = '{$row['it_id']}'
                          and od_id = '$s_cart_id' ";
            $sum = sql_fetch($sql);

            if (!$goods)
            {
                //$goods = addslashes($row[it_name]);
                //$goods = get_text($row[it_name]);
                $goods = preg_replace("/\'|\"|\||\,|\&|\;/", "", $row['it_name']);
                $goods_it_id = $row['it_id'];
            }
            $goods_count++;

            // 에스크로 상품정보
            if($default['de_escrow_use']) {
                if ($i>0)
                    $good_info .= chr(30);
                $good_info .= "seq=".($i+1).chr(31);
                $good_info .= "ordr_numb={$od_id}_".sprintf("%04d", $i).chr(31);
                $good_info .= "good_name=".addslashes($row['it_name']).chr(31);
                $good_info .= "good_cntx=".$row['ct_qty'].chr(31);
                $good_info .= "good_amtx=".$row['ct_price'].chr(31);
            }

            $image = get_it_image($row['it_id'], 100, 100);

            $it_name =  stripslashes($row['it_name']) ;
            $it_options = print_item_options($row['it_id'], $s_cart_id);

            // 복합과세금액
            if($default['de_tax_flag_use']) {
                if($row['it_notax']) {
                    $comm_free_mny += $sum['price'];
                } else {
                    $tot_tax_mny += $sum['price'];
                }
            }

            $point      = $sum['point'];
            $sell_price = $sum['price'];

            // 쿠폰
            $cp_button = '';
            if($is_member) {
                $cp_count = 0;

                $sql = " select cp_id
                            from {$g5['g5_shop_coupon_table']}
                            where mb_id IN ( '{$member['mb_id']}', '전체회원' )
                              and cp_start <= '".G5_TIME_YMD."'
                              and cp_end >= '".G5_TIME_YMD."'
                              and cp_minimum <= '$sell_price'
                              and (
                                    ( cp_method = '0' and cp_target = '{$row['it_id']}' )
                                    OR
                                    ( cp_method = '1' and ( cp_target IN ( '{$row['ca_id']}', '{$row['ca_id2']}', '{$row['ca_id3']}' ) ) )
                                  ) ";
                $res = sql_query($sql);

                for($k=0; $cp=sql_fetch_array($res); $k++) {
                    if(is_used_coupon($member['mb_id'], $cp['cp_id']))
                        continue;

                    $cp_count++;
                }

                if($cp_count) {
                    $cp_button = '<button type="button" class="cp_btn">쿠폰적용</button>';
                    $it_cp_count++;
                }
            }

            // 배송비
            switch($row['ct_send_cost'])
            {
                case 1:
                    $ct_send_cost = '착불';
                    break;
                case 2:
                    $ct_send_cost = '무료';
                    break;
                default:
                    $ct_send_cost = '선불';
                    break;
            }

            // 조건부무료
            if($row['it_sc_type'] == 2) {
                $sendcost = get_item_sendcost($row['it_id'], $sum['price'], $sum['qty'], $s_cart_id);

                if($sendcost == 0)
                    $ct_send_cost = '무료';
            }

            $it= sql_fetch("select it_maker , it_basic from {$g5['g5_shop_item_table']} where  it_id = '{$row['it_id']}' ");
        ?>

        <tr>

            <td class="td_prd">
                <div class="sod_img"><?php echo $image; ?></div>
                <div class="sod_name">
                    <input type="hidden" name="it_id[<?php echo $i; ?>]"    value="<?php echo $row['it_id']; ?>">
                    <input type="hidden" name="it_name[<?php echo $i; ?>]"  value="<?php echo get_text($row['it_name']); ?>">
                    <input type="hidden" name="it_price[<?php echo $i; ?>]" value="<?php echo $sell_price; ?>">
                    <input type="hidden" name="cp_id[<?php echo $i; ?>]" value="">
                    <input type="hidden" name="cp_price[<?php echo $i; ?>]" value="0">
                    <?php if($default['de_tax_flag_use']) { ?>
                    <input type="hidden" name="it_notax[<?php echo $i; ?>]" value="<?php echo $row['it_notax']; ?>">
                    <?php } ?>
                    <p class="lt_name"><?php echo $it_name; ?></p>
                    <p class="lt_info"><?php echo $it['it_basic']; ?></p>

                 </div>
            </td>
            <td class="">
              <p class="td_tit">수량</p>
              <p><?php echo number_format($sum['qty']); ?>개</p>
            </td>
            <td class="">
              <p class="td_tit">금액</p>
              <p><?php echo number_format($row['ct_price']); ?>원</p>
            </td>
            <td class="total_td">
              <p class="td_tit">합계</p>
              <p><span class="total_price"><?php echo number_format($sell_price); ?>원</span></p>
            </td>
        </tr>

        <?php
            $tot_point      += $point;
            $tot_sell_price += $sell_price;
        } // for 끝

        if ($i == 0) {
            //echo '<tr><td colspan="7" class="empty_table">장바구니에 담긴 상품이 없습니다.</td></tr>';
            alert('장바구니가 비어 있습니다.', G5_SHOP_URL.'/cart.php');
        } else {
            // 배송비 계산
            $send_cost = get_sendcost($s_cart_id);
        }

        // 복합과세처리
        if($default['de_tax_flag_use']) {
            $comm_tax_mny = round(($tot_tax_mny + $send_cost) / 1.1);
            $comm_vat_mny = ($tot_tax_mny + $send_cost) - $comm_tax_mny;
        }
        ?>
        </tbody>
        </table>
    </div>

    <?php if ($goods_count) $goods .= ' 외 '.$goods_count.'건'; ?>
    <!-- } 주문상품 확인 끝 -->

    <div class="">
        <input type="hidden" name="od_price"    value="<?php echo $tot_sell_price; ?>">
        <input type="hidden" name="org_od_price"    value="<?php echo $tot_sell_price; ?>">
        <input type="hidden" name="od_send_cost" value="<?php echo $send_cost; ?>">
        <input type="hidden" name="od_send_cost2" value="0">
        <input type="hidden" name="item_coupon" value="0">
        <input type="hidden" name="od_coupon" value="0">
        <input type="hidden" name="od_send_coupon" value="0">
        <input type="hidden" name="od_goods_name" value="<?php echo $goods; ?>">

        <?php
        // 결제대행사별 코드 include (결제대행사 정보 필드)
        require_once(G5_SHOP_PATH.'/'.$default['de_pg_service'].'/orderform.2.php');

        if($is_kakaopay_use) {
            require_once(G5_SHOP_PATH.'/kakaopay/orderform.2.php');
        }
        ?>

        <!-- 주문하시는 분 입력 시작 { -->
        <div class="order_box order_sheet">
          <p>주문자 정보</p>
          <div class="order_table_wrap">
            <table class="order_table ">
              <tr>
                <th class="first_th">주문자</th>
                <th>연락처</th>
                <th>이메일</th>
              </tr>
              <tr>
                <td>
                  <input type="text" name="od_name" id="od_name" value="<?php echo isset($member['mb_name']) ? get_text($member['mb_name']) : ''; ?>">
                </td>
                <td>
                  <input type="text" name="od_tel" id="od_tel" value="<?php echo get_text($member['mb_hp']); ?>">
                  <?php echo get_text($member['mb_hp']); ?>
                </td>
                <td>
                  <input type="text" name="od_email" id="od_email" value="<?php echo $member['mb_email']; ?>">
                  <?php echo $member['mb_email']; ?>
                </td>
              </tr>
            </table>

          </div>
        </div>
        <!-- } 주문하시는 분 입력 끝 -->
        <!-- 받으시는 분 입력 시작 { -->
        <div class="order_box order_sheet">
          <p>받는 분 정보 <span>받는 분이 직접 입력하는 정보입니다. 직접 입력을 원할 시 수정하기를 눌러 입력해주세요.</span></p>
          <div class="order_table_wrap">
            <table class="order_table get_table">
              <tr>
                <th>받는 분</th>
                <th>연락처</th>
                <th>주소</th>
                <th>배송메세지</th>
                <td rowspan="2" class="correct_td">
                  <button type="button" class="correct_btn">수정하기</button>
                </td>
              </tr>
              <tr>
                <td>
                  <input type="text" name="od_b_name" id="od_b_name" value="">
                </td>
                <td>
                  <input type="text" name="od_b_tel" id="od_b_tel" value="">
                </td>
                <td>
                  <input type="text" name="od_b_zip" id="od_b_zip" value="">
                  <input type="text" name="od_b_addr1" id="od_b_addr1" value="">
                  <input type="text" name="od_b_addr2" id="od_b_addr2" value="">
                  <input type="text" name="od_b_addr3" id="od_b_addr3" value="">
                  <input type="text" name="od_b_addr_jibeon" id="od_b_addr_jibeon" value="">
                </td>
                <td>
                </td>
              </tr>
            </table>

          </div>
        </div>
        <div class="expect_box order_sheet">
          <p>결제예정금액</p>
          <div class="order_table_wrap">
            <table class="order_table order_pay_table">
              <tr>
                <th>상품금액</th>
                <th>배송비</th>
                <th>결제예정금액</th>
              </tr>
              <tr>
                <td>
                  <?php echo number_format($tot_sell_price); ?>원
                </td>
                <td>
                  <?php echo number_format($send_cost); ?>원
                </td>
                <td>
                  <?php $tot_price = $tot_sell_price + $send_cost;
                   echo number_format($tot_price);
                  ?>원
                </td>
              </tr>
            </table>

          </div>
        </div>
        <div class="order_sheet">
          <p>결제정보</p>
          <div class="order_table_wrap">
            <table class="order_table order_info_table">
              <tr>
                <td>
                  <label>
                    <input type="radio" id="od_settle_nhnkcp_payco" name="od_settle_case" data-pay="payco" value="간편결제">
                    <span></span>페이코(PAYCO)
                  </label>
                </td>
                <td>
                  <label>
                    <input type="radio" id="od_settle_nhnkcp_kakaopay" name="od_settle_case" data-pay="kakaopay" value="간편결제">
                    <span></span>카카오페이
                  </label>
                </td>
                <td>
                    <label>
                      <input type="radio" id="od_settle_nhnkcp_naverpay" name="od_settle_case" data-pay="naverpay" value="간편결제">
                      <span></span>네이버페이
                    </label>
                </td>
                <td>
                  <label>
                    <input type="radio" id="od_settle_card" name="od_settle_case"  value="신용카드">
                    <span></span>신용카드
                  </label>
                </td>
                <td>

                    <label>
                      <input type="radio" id="od_settle_iche" name="od_settle_case"  value="계좌이체">
                      <span></span>실시간 계좌이체
                    </label>
                </td>
                <!-- <td>
                  <label><input type="radio" name="pay_btn" value="escrow"><span></span>에스크로</label>
                </td> -->
                <td>

                    <label>
                      <input type="radio" id="od_settle_vbank" name="od_settle_case"  value="가상계좌">
                      <span></span>가상계좌
                    </label>
                </td>
              </tr>
            </table>

          </div>

        </div>
        <div class="order_sheet">
          <p>주문자 동의</p>
          <div class="order_table_wrap">
            <table class="order_table order_agree_table">
              <tr>
                <td>
                  <p>목적</p>
                  <ul>
                    <li><span>-</span>주문자 정보 확인, 주문 내역 안내, 주문 내역 조회</li>
                    <li><span>-</span>상품 배송(구매/환불/취소/교환)을 위한 수취인 정보</li>
                  </ul>
                </td>
                <td>
                  <p>항목</p>
                  <ul>
                    <li><span>-</span>주문자 정보(이름, 연락처, 이메일)</li>
                    <li><span>-</span>수취인 정보(이름, 연락처 1, 연락처 2, 주소)</li>
                  </ul>
                </td>
                <td>
                  <p>보유기간</p>
                  <p>주문일로부터 90일까지 보유하며, <br> 관계 법령에 의해 5년간 보관</p>
                </td>
              </tr>
            </table>

          </div>

        </div>
        <div class="order_agree_chd">
          <label>
            <input type="checkbox" name="order_gree" value="">
            <span></span>
            상기 결제정보를 확인하였으며, 구매진행에 동의합니다.
          </label>
        </div>
        <div class="order_sheet total_price_box">
          <div class="order_table_wrap">
            최종결제금액 <span><?php  echo number_format($tot_price);?></span>

          </div>
        </div>

        <div class="get_box_btns">
          <?php

        // 결제대행사별 코드 include (주문버튼)
        require_once(G5_SHOP_PATH.'/'.$default['de_pg_service'].'/orderform.3.php');

                if($is_kakaopay_use) {
                    require_once(G5_SHOP_PATH.'/kakaopay/orderform.3.php');
                }
           ?>

        </div>

        <!-- } 받으시는 분 입력 끝 -->
    </div>

</form>
</div>
<div class="get_correct_bg"></div>
<div class="get_correct_box">
  <form class="get_correct_form" name="get_correct_form" action=""  method="post">
    <div class="title">받는 분 정보 수정하기</div>
    <ul>
      <li>
        <p>받는 분</p>
        <input type="text" name="get_name" value="" id="get_name" placeholder="이름 입력">
        <div class="get_hp_box">
          <input type="text" name="get_hp1" value="" id="get_hp1" placeholder="휴대폰 번호1" maxlength="3">
          <span></span>
          <input type="text" name="get_hp2" value="" id="get_hp2" placeholder="휴대폰 번호2" maxlength="4">
          <span></span>
          <input type="text" name="get_hp3" value="" id="get_hp3" placeholder="휴대폰 번호3" maxlength="4">
        </div>
      </li>
      <li>
        <p>주소</p>
        <input type="text" name="get_zip" value="" id="get_zip" size="5" maxlength="6"  placeholder="주소검색" readonly>
        <button type="button" class="btn_frmline" onclick="win_zip('forderform', 'get_zip', 'get_addr1', 'get_addr2', 'get_addr3', 'get_addr_jibeon');" id="add_btn">주소 검색</button><br>
        <input type="hidden" name="get_addr1" value="" id="get_addr1" size="50"  placeholder="기본주소">
        <input type="text" name="get_addr2" value="" id="get_addr2" class="frm_input frm_address full_input" size="50" placeholder="상세주소">
        <br>
        <input type="hidden" name="get_addr3" value="" id="get_addr3" class="frm_input frm_address full_input" size="50" readonly="readonly" placeholder="참고항목">
        <input type="hidden" name="get_addr_jibeon" value="">

      </li>
      <li>
        <p>배송메세지</p>
        <input type="text" name="get_message" value="" id="get_message" placeholder="배송메세지">

      </li>
    </ul>
    <div class="get_correct_btns">
      <button type="button" class="close_btn">취소</button>
      <button type="submit" class="get_submit">수정완료</button>
    </div>
  </form>
</div>


<?php
if( $default['de_inicis_lpay_use'] || $default['de_inicis_kakaopay_use'] ){   //이니시스 L.pay 또는 이니시스 카카오페이 사용시
    require_once(G5_SHOP_PATH.'/inicis/lpay_order.script.php');
}
if(function_exists('is_use_easypay') && is_use_easypay('global_nhnkcp')){  // 타 PG 사용시 NHN KCP 네이버페이 사용이 설정되어 있다면
    require_once(G5_SHOP_PATH.'/kcp/global_nhn_kcp_order.script.php');
}
?>
<script>
$('.order_agree_chd label').click(function(){
  if($('.order_agree_chd input').is(":checked")){
    $(this).addClass('on');
  }else{
    $(this).removeClass('on');
  }
});
$('.correct_btn').click(function(){
  $('.get_correct_bg').fadeIn();
  $('.get_correct_box').show();
});
$('.get_correct_bg, .get_correct_btns .close_btn').click(function(){
  $('.get_correct_bg').fadeOut();
  $('.get_correct_box').hide();
});

$('#get_zip').click(function(){
  $('#add_btn').trigger('click');
});

$(".get_hp_box input").on("keyup", function() {
    $(this).val($(this).val().replace(/[^0-9]/g,""));
 });

var zipcode = "";
var form_action_url = "<?php echo $order_action_url; ?>";

$(function() {
    var $cp_btn_el;
    var $cp_row_el;

    $(".cp_btn").click(function() {
        $cp_btn_el = $(this);
        $cp_row_el = $(this).closest("tr");
        $("#cp_frm").remove();
        var it_id = $cp_btn_el.closest("tr").find("input[name^=it_id]").val();

        $.post(
            "./orderitemcoupon.php",
            { it_id: it_id,  sw_direct: "<?php echo $sw_direct; ?>" },
            function(data) {
                $cp_btn_el.after(data);
            }
        );
    });

    $(document).on("click", ".cp_apply", function() {
        var $el = $(this).closest("tr");
        var cp_id = $el.find("input[name='f_cp_id[]']").val();
        var price = $el.find("input[name='f_cp_prc[]']").val();
        var subj = $el.find("input[name='f_cp_subj[]']").val();
        var sell_price;

        if(parseInt(price) == 0) {
            if(!confirm(subj+"쿠폰의 할인 금액은 "+price+"원입니다.\n쿠폰을 적용하시겠습니까?")) {
                return false;
            }
        }

        // 이미 사용한 쿠폰이 있는지
        var cp_dup = false;
        var cp_dup_idx;
        var $cp_dup_el;
        $("input[name^=cp_id]").each(function(index) {
            var id = $(this).val();

            if(id == cp_id) {
                cp_dup_idx = index;
                cp_dup = true;
                $cp_dup_el = $(this).closest("tr");;

                return false;
            }
        });

        if(cp_dup) {
            var it_name = $("input[name='it_name["+cp_dup_idx+"]']").val();
            if(!confirm(subj+ "쿠폰은 "+it_name+"에 사용되었습니다.\n"+it_name+"의 쿠폰을 취소한 후 적용하시겠습니까?")) {
                return false;
            } else {
                coupon_cancel($cp_dup_el);
                $("#cp_frm").remove();
                $cp_dup_el.find(".cp_btn").text("적용").focus();
                $cp_dup_el.find(".cp_cancel").remove();
            }
        }

        var $s_el = $cp_row_el.find(".total_price");;
        sell_price = parseInt($cp_row_el.find("input[name^=it_price]").val());
        sell_price = sell_price - parseInt(price);
        if(sell_price < 0) {
            alert("쿠폰할인금액이 상품 주문금액보다 크므로 쿠폰을 적용할 수 없습니다.");
            return false;
        }
        $s_el.text(number_format(String(sell_price)));
        $cp_row_el.find("input[name^=cp_id]").val(cp_id);
        $cp_row_el.find("input[name^=cp_price]").val(price);

        calculate_total_price();
        $("#cp_frm").remove();
        $cp_btn_el.text("변경").focus();
        if(!$cp_row_el.find(".cp_cancel").length)
            $cp_btn_el.after("<button type=\"button\" class=\"cp_cancel\">취소</button>");
    });

    $(document).on("click", "#cp_close", function() {
        $("#cp_frm").remove();
        $cp_btn_el.focus();
    });

    $(document).on("click", ".cp_cancel", function() {
        coupon_cancel($(this).closest("tr"));
        calculate_total_price();
        $("#cp_frm").remove();
        $(this).closest("tr").find(".cp_btn").text("적용").focus();
        $(this).remove();
    });

    $("#od_coupon_btn").click(function() {
        if( $("#od_coupon_frm").parent(".od_coupon_wrap").length ){
            $("#od_coupon_frm").parent(".od_coupon_wrap").remove();
        }
        $("#od_coupon_frm").remove();
        var $this = $(this);
        var price = parseInt($("input[name=org_od_price]").val()) - parseInt($("input[name=item_coupon]").val());
        if(price <= 0) {
            alert('상품금액이 0원이므로 쿠폰을 사용할 수 없습니다.');
            return false;
        }
        $.post(
            "./ordercoupon.php",
            { price: price },
            function(data) {
                $this.after(data);
            }
        );
    });

    $(document).on("click", ".od_cp_apply", function() {
        var $el = $(this).closest("tr");
        var cp_id = $el.find("input[name='o_cp_id[]']").val();
        var price = parseInt($el.find("input[name='o_cp_prc[]']").val());
        var subj = $el.find("input[name='o_cp_subj[]']").val();
        var send_cost = $("input[name=od_send_cost]").val();
        var item_coupon = parseInt($("input[name=item_coupon]").val());
        var od_price = parseInt($("input[name=org_od_price]").val()) - item_coupon;

        if(price == 0) {
            if(!confirm(subj+"쿠폰의 할인 금액은 "+price+"원입니다.\n쿠폰을 적용하시겠습니까?")) {
                return false;
            }
        }

        if(od_price - price <= 0) {
            alert("쿠폰할인금액이 주문금액보다 크므로 쿠폰을 적용할 수 없습니다.");
            return false;
        }

        $("input[name=sc_cp_id]").val("");
        $("#sc_coupon_btn").text("쿠폰적용");
        $("#sc_coupon_cancel").remove();

        $("input[name=od_price]").val(od_price - price);
        $("input[name=od_cp_id]").val(cp_id);
        $("input[name=od_coupon]").val(price);
        $("input[name=od_send_coupon]").val(0);
        $("#od_cp_price").text(number_format(String(price)));
        $("#sc_cp_price").text(0);
        calculate_order_price();
        if( $("#od_coupon_frm").parent(".od_coupon_wrap").length ){
            $("#od_coupon_frm").parent(".od_coupon_wrap").remove();
        }
        $("#od_coupon_frm").remove();
        $("#od_coupon_btn").text("변경").focus();
        if(!$("#od_coupon_cancel").length)
            $("#od_coupon_btn").after("<button type=\"button\" id=\"od_coupon_cancel\" class=\"cp_cancel\">취소</button>");
    });

    $(document).on("click", "#od_coupon_close", function() {
        if( $("#od_coupon_frm").parent(".od_coupon_wrap").length ){
            $("#od_coupon_frm").parent(".od_coupon_wrap").remove();
        }
        $("#od_coupon_frm").remove();
        $("#od_coupon_btn").focus();
    });

    $(document).on("click", "#od_coupon_cancel", function() {
        var org_price = $("input[name=org_od_price]").val();
        var item_coupon = parseInt($("input[name=item_coupon]").val());
        $("input[name=od_price]").val(org_price - item_coupon);
        $("input[name=sc_cp_id]").val("");
        $("input[name=od_coupon]").val(0);
        $("input[name=od_send_coupon]").val(0);
        $("#od_cp_price").text(0);
        $("#sc_cp_price").text(0);
        calculate_order_price();
        if( $("#od_coupon_frm").parent(".od_coupon_wrap").length ){
            $("#od_coupon_frm").parent(".od_coupon_wrap").remove();
        }
        $("#od_coupon_frm").remove();
        $("#od_coupon_btn").text("쿠폰적용").focus();
        $(this).remove();
        $("#sc_coupon_btn").text("쿠폰적용");
        $("#sc_coupon_cancel").remove();
    });

    $("#sc_coupon_btn").click(function() {
        $("#sc_coupon_frm").remove();
        var $this = $(this);
        var price = parseInt($("input[name=od_price]").val());
        var send_cost = parseInt($("input[name=od_send_cost]").val());
        $.post(
            "./ordersendcostcoupon.php",
            { price: price, send_cost: send_cost },
            function(data) {
                $this.after(data);
            }
        );
    });

    $(document).on("click", ".sc_cp_apply", function() {
        var $el = $(this).closest("tr");
        var cp_id = $el.find("input[name='s_cp_id[]']").val();
        var price = parseInt($el.find("input[name='s_cp_prc[]']").val());
        var subj = $el.find("input[name='s_cp_subj[]']").val();
        var send_cost = parseInt($("input[name=od_send_cost]").val());

        if(parseInt(price) == 0) {
            if(!confirm(subj+"쿠폰의 할인 금액은 "+price+"원입니다.\n쿠폰을 적용하시겠습니까?")) {
                return false;
            }
        }

        $("input[name=sc_cp_id]").val(cp_id);
        $("input[name=od_send_coupon]").val(price);
        $("#sc_cp_price").text(number_format(String(price)));
        calculate_order_price();
        $("#sc_coupon_frm").remove();
        $("#sc_coupon_btn").text("변경").focus();
        if(!$("#sc_coupon_cancel").length)
            $("#sc_coupon_btn").after("<button type=\"button\" id=\"sc_coupon_cancel\" class=\"cp_cancel\">취소</button>");
    });

    $(document).on("click", "#sc_coupon_close", function() {
        $("#sc_coupon_frm").remove();
        $("#sc_coupon_btn").focus();
    });

    $(document).on("click", "#sc_coupon_cancel", function() {
        $("input[name=od_send_coupon]").val(0);
        $("#sc_cp_price").text(0);
        calculate_order_price();
        $("#sc_coupon_frm").remove();
        $("#sc_coupon_btn").text("쿠폰적용").focus();
        $(this).remove();
    });

    $("#od_b_addr2").focus(function() {
        var zip = $("#od_b_zip").val().replace(/[^0-9]/g, "");
        if(zip == "")
            return false;

        var code = String(zip);

        if(zipcode == code)
            return false;

        zipcode = code;
        calculate_sendcost(code);
    });

    $("#od_settle_bank").on("click", function() {
        $("[name=od_deposit_name]").val( $("[name=od_name]").val() );
        $("#settle_bank").show();
    });

    $("#od_settle_iche,#od_settle_card,#od_settle_vbank,#od_settle_hp,#od_settle_easy_pay,#od_settle_kakaopay,#od_settle_nhnkcp_payco,#od_settle_nhnkcp_naverpay,#od_settle_nhnkcp_kakaopay,#od_settle_inicislpay,#od_settle_inicis_kakaopay").bind("click", function() {
        $("#settle_bank").hide();
    });

    // 배송지선택
    $("input[name=ad_sel_addr]").on("click", function() {
        var addr = $(this).val().split(String.fromCharCode(30));

        if (addr[0] == "same") {
            gumae2baesong();
        } else {
            if(addr[0] == "new") {
                for(i=0; i<10; i++) {
                    addr[i] = "";
                }
            }

            var f = document.forderform;
            f.od_b_name.value        = addr[0];
            f.od_b_hp.value         = addr[1];
            f.od_b_zip.value         = addr[3] + addr[4];
            f.od_b_addr1.value       = addr[5];
            f.od_b_addr2.value       = addr[6];
            f.od_b_addr3.value       = addr[7];
            f.od_b_addr_jibeon.value = addr[8];
            f.ad_subject.value       = addr[9];

            var zip1 = addr[3].replace(/[^0-9]/g, "");
            var zip2 = addr[4].replace(/[^0-9]/g, "");

            var code = String(zip1) + String(zip2);

            if(zipcode != code) {
                calculate_sendcost(code);
            }
        }
    });

    // 배송지목록
    $("#order_address").on("click", function() {
        var url = this.href;
        window.open(url, "win_address", "left=100,top=100,width=800,height=600,scrollbars=1");
        return false;
    });
});

function coupon_cancel($el)
{
    var $dup_sell_el = $el.find(".total_price");
    var $dup_price_el = $el.find("input[name^=cp_price]");
    var org_sell_price = $el.find("input[name^=it_price]").val();

    $dup_sell_el.text(number_format(String(org_sell_price)));
    $dup_price_el.val(0);
    $el.find("input[name^=cp_id]").val("");
}

function calculate_total_price()
{
    var $it_prc = $("input[name^=it_price]");
    var $cp_prc = $("input[name^=cp_price]");
    var tot_sell_price = sell_price = tot_cp_price = 0;
    var it_price, cp_price, it_notax;
    var tot_mny = comm_tax_mny = comm_vat_mny = comm_free_mny = tax_mny = vat_mny = 0;
    var send_cost = parseInt($("input[name=od_send_cost]").val());

    $it_prc.each(function(index) {
        it_price = parseInt($(this).val());
        cp_price = parseInt($cp_prc.eq(index).val());
        sell_price += it_price;
        tot_cp_price += cp_price;
    });

    tot_sell_price = sell_price - tot_cp_price + send_cost;

    $("#ct_tot_coupon").text(number_format(String(tot_cp_price)));
    $("#ct_tot_price").text(number_format(String(tot_sell_price)));

    $("input[name=good_mny]").val(tot_sell_price);
    $("input[name=od_price]").val(sell_price - tot_cp_price);
    $("input[name=item_coupon]").val(tot_cp_price);
    $("input[name=od_coupon]").val(0);
    $("input[name=od_send_coupon]").val(0);
    <?php if($oc_cnt > 0) { ?>
    $("input[name=od_cp_id]").val("");
    $("#od_cp_price").text(0);
    if($("#od_coupon_cancel").length) {
        $("#od_coupon_btn").text("쿠폰적용");
        $("#od_coupon_cancel").remove();
    }
    <?php } ?>
    <?php if($sc_cnt > 0) { ?>
    $("input[name=sc_cp_id]").val("");
    $("#sc_cp_price").text(0);
    if($("#sc_coupon_cancel").length) {
        $("#sc_coupon_btn").text("쿠폰적용");
        $("#sc_coupon_cancel").remove();
    }
    <?php } ?>
    $("input[name=od_temp_point]").val(0);
    <?php if($temp_point > 0 && $is_member) { ?>
    calculate_temp_point();
    <?php } ?>
    calculate_order_price();
}

function calculate_order_price()
{
    var sell_price = parseInt($("input[name=od_price]").val());
    var send_cost = parseInt($("input[name=od_send_cost]").val());
    var send_cost2 = parseInt($("input[name=od_send_cost2]").val());
    var send_coupon = parseInt($("input[name=od_send_coupon]").val());
    var tot_price = sell_price + send_cost + send_cost2 - send_coupon;

    $("input[name=good_mny]").val(tot_price);
    $("#od_tot_price .print_price").text(number_format(String(tot_price)));
    <?php if($temp_point > 0 && $is_member) { ?>
    calculate_temp_point();
    <?php } ?>
}

function calculate_temp_point()
{
    var sell_price = parseInt($("input[name=od_price]").val());
    var mb_point = parseInt(<?php echo $member['mb_point']; ?>);
    var max_point = parseInt(<?php echo $default['de_settle_max_point']; ?>);
    var point_unit = parseInt(<?php echo $default['de_settle_point_unit']; ?>);
    var temp_point = max_point;

    if(temp_point > sell_price)
        temp_point = sell_price;

    if(temp_point > mb_point)
        temp_point = mb_point;

    temp_point = parseInt(temp_point / point_unit) * point_unit;

    $("#use_max_point").text(number_format(String(temp_point))+"점");
    $("input[name=max_temp_point]").val(temp_point);
}

function calculate_sendcost(code)
{
    $.post(
        "./ordersendcost.php",
        { zipcode: code },
        function(data) {
            $("input[name=od_send_cost2]").val(data);
            $("#od_send_cost2").text(number_format(String(data)));

            zipcode = code;

            calculate_order_price();
        }
    );
}

function calculate_tax()
{
    var $it_prc = $("input[name^=it_price]");
    var $cp_prc = $("input[name^=cp_price]");
    var sell_price = tot_cp_price = 0;
    var it_price, cp_price, it_notax;
    var tot_mny = comm_free_mny = tax_mny = vat_mny = 0;
    var send_cost = parseInt($("input[name=od_send_cost]").val());
    var send_cost2 = parseInt($("input[name=od_send_cost2]").val());
    var od_coupon = parseInt($("input[name=od_coupon]").val());
    var send_coupon = parseInt($("input[name=od_send_coupon]").val());
    var temp_point = 0;

    $it_prc.each(function(index) {
        it_price = parseInt($(this).val());
        cp_price = parseInt($cp_prc.eq(index).val());
        sell_price += it_price;
        tot_cp_price += cp_price;
        it_notax = $("input[name^=it_notax]").eq(index).val();
        if(it_notax == "1") {
            comm_free_mny += (it_price - cp_price);
        } else {
            tot_mny += (it_price - cp_price);
        }
    });

    if($("input[name=od_temp_point]").length)
        temp_point = parseInt($("input[name=od_temp_point]").val());

    tot_mny += (send_cost + send_cost2 - od_coupon - send_coupon - temp_point);
    if(tot_mny < 0) {
        comm_free_mny = comm_free_mny + tot_mny;
        tot_mny = 0;
    }

    tax_mny = Math.round(tot_mny / 1.1);
    vat_mny = tot_mny - tax_mny;
    $("input[name=comm_tax_mny]").val(tax_mny);
    $("input[name=comm_vat_mny]").val(vat_mny);
    $("input[name=comm_free_mny]").val(comm_free_mny);
}

function forderform_check(f)
{
    // 재고체크
    var stock_msg = order_stock_check();
    if(stock_msg != "") {
        alert(stock_msg);
        return false;
    }

    errmsg = "";
    errfld = "";
    var deffld = "";

    check_field(f.od_name, "주문하시는 분 이름을 입력하십시오.");
    if (typeof(f.od_pwd) != 'undefined')
    {
        clear_field(f.od_pwd);
        if( (f.od_pwd.value.length<3) || (f.od_pwd.value.search(/([^A-Za-z0-9]+)/)!=-1) )
            error_field(f.od_pwd, "회원이 아니신 경우 주문서 조회시 필요한 비밀번호를 3자리 이상 입력해 주십시오.");
    }
    check_field(f.od_tel, "주문하시는 분 전화번호를 입력하십시오.");
    //check_field(f.od_addr1, "주소검색을 이용하여 주문하시는 분 주소를 입력하십시오.");
    //check_field(f.od_addr2, " 주문하시는 분의 상세주소를 입력하십시오.");
    //check_field(f.od_zip, "");

    clear_field(f.od_email);
    if(f.od_email.value=='' || f.od_email.value.search(/(\S+)@(\S+)\.(\S+)/) == -1)
        error_field(f.od_email, "E-mail을 바르게 입력해 주십시오.");

    if (typeof(f.od_hope_date) != "undefined")
    {
        clear_field(f.od_hope_date);
        if (!f.od_hope_date.value)
            error_field(f.od_hope_date, "희망배송일을 선택하여 주십시오.");
    }

    check_field(f.od_b_name, "받으시는 분 이름을 입력하십시오.");
    check_field(f.od_b_tel, "받으시는 분 전화번호를 입력하십시오.");
    check_field(f.od_b_addr1, "주소검색을 이용하여 받으시는 분 주소를 입력하십시오.");
    //check_field(f.od_b_addr2, "받으시는 분의 상세주소를 입력하십시오.");
    check_field(f.od_b_zip, "");

    var od_settle_bank = document.getElementById("od_settle_bank");
    if (od_settle_bank) {
        if (od_settle_bank.checked) {
            check_field(f.od_bank_account, "계좌번호를 선택하세요.");
            check_field(f.od_deposit_name, "입금자명을 입력하세요.");
        }
    }

    // 배송비를 받지 않거나 더 받는 경우 아래식에 + 또는 - 로 대입
    f.od_send_cost.value = parseInt(f.od_send_cost.value);

    if (errmsg)
    {
        alert(errmsg);
        errfld.focus();
        return false;
    }

    var settle_case = document.getElementsByName("od_settle_case");
    var settle_check = false;
    var settle_method = "";

    for (i=0; i<settle_case.length; i++)
    {
        if (settle_case[i].checked)
        {
            settle_check = true;
            settle_method = settle_case[i].value;
            break;
        }
    }
    if (!settle_check)
    {
        alert("결제방식을 선택하십시오.");
        return false;
    }

    var od_price = parseInt(f.od_price.value);
    var send_cost = parseInt(f.od_send_cost.value);
    var send_cost2 = parseInt(f.od_send_cost2.value);
    var send_coupon = parseInt(f.od_send_coupon.value);

    var max_point = 0;
    if (typeof(f.max_temp_point) != "undefined")
        max_point  = parseInt(f.max_temp_point.value);

    var temp_point = 0;
    if (typeof(f.od_temp_point) != "undefined") {
        var point_unit = parseInt(<?php echo $default['de_settle_point_unit']; ?>);
        temp_point = parseInt(f.od_temp_point.value) || 0;

        if (f.od_temp_point.value)
        {
            if (temp_point > od_price) {
                alert("상품 주문금액(배송비 제외) 보다 많이 포인트결제할 수 없습니다.");
                f.od_temp_point.select();
                return false;
            }

            if (temp_point > <?php echo (int)$member['mb_point']; ?>) {
                alert("회원님의 포인트보다 많이 결제할 수 없습니다.");
                f.od_temp_point.select();
                return false;
            }

            if (temp_point > max_point) {
                alert(max_point + "점 이상 결제할 수 없습니다.");
                f.od_temp_point.select();
                return false;
            }

            if (parseInt(parseInt(temp_point / point_unit) * point_unit) != temp_point) {
                alert("포인트를 "+String(point_unit)+"점 단위로 입력하세요.");
                f.od_temp_point.select();
                return false;
            }
        }

        // pg 결제 금액에서 포인트 금액 차감
        if(settle_method != "무통장") {
            f.good_mny.value = od_price + send_cost + send_cost2 - send_coupon - temp_point;
        }
    }

    var tot_price = od_price + send_cost + send_cost2 - send_coupon - temp_point;

    if (document.getElementById("od_settle_iche")) {
        if (document.getElementById("od_settle_iche").checked) {
            if (tot_price < 150) {
                alert("계좌이체는 150원 이상 결제가 가능합니다.");
                return false;
            }
        }
    }

    if (document.getElementById("od_settle_card")) {
        if (document.getElementById("od_settle_card").checked) {
            if (tot_price < 1000) {
                alert("신용카드는 1000원 이상 결제가 가능합니다.");
                return false;
            }
        }
    }

    if (document.getElementById("od_settle_hp")) {
        if (document.getElementById("od_settle_hp").checked) {
            if (tot_price < 350) {
                alert("휴대폰은 350원 이상 결제가 가능합니다.");
                return false;
            }
        }
    }

    <?php if($default['de_tax_flag_use']) { ?>
    calculate_tax();
    <?php } ?>

    <?php if($default['de_pg_service'] == 'inicis') { ?>
    if( f.action != form_action_url ){
        f.action = form_action_url;
        f.removeAttribute("target");
        f.removeAttribute("accept-charset");
    }
    <?php } ?>

    // 카카오페이 지불
    if(settle_method == "KAKAOPAY") {
        <?php if($default['de_tax_flag_use']) { ?>
        f.SupplyAmt.value = parseInt(f.comm_tax_mny.value) + parseInt(f.comm_free_mny.value);
        f.GoodsVat.value  = parseInt(f.comm_vat_mny.value);
        <?php } ?>
        getTxnId(f);
        return false;
    }

    var form_order_method = '';

    if( settle_method == "lpay" || settle_method == "inicis_kakaopay" ){      //이니시스 L.pay 또는 이니시스 카카오페이 이면 ( 이니시스의 삼성페이는 모바일에서만 단독실행 가능함 )
        form_order_method = 'samsungpay';
    } else if(settle_method == "간편결제") {
        if(jQuery("input[name='od_settle_case']:checked" ).attr("data-pay") === "naverpay"){
            form_order_method = 'nhnkcp_naverpay';
        }
    }

    if( jQuery(f).triggerHandler("form_sumbit_order_"+form_order_method) !== false ) {

        // pay_method 설정
        <?php if($default['de_pg_service'] == 'kcp') { ?>
        f.site_cd.value = f.def_site_cd.value;
        if(typeof f.payco_direct !== "undefined") f.payco_direct.value = "";
        if(typeof f.naverpay_direct !== "undefined") f.naverpay_direct.value = "A";
        if(typeof f.kakaopay_direct !== "undefined") f.kakaopay_direct.value = "A";
        switch(settle_method)
        {
            case "계좌이체":
                f.pay_method.value   = "010000000000";
                break;
            case "가상계좌":
                f.pay_method.value   = "001000000000";
                break;
            case "휴대폰":
                f.pay_method.value   = "000010000000";
                break;
            case "신용카드":
                f.pay_method.value   = "100000000000";
                break;
            case "간편결제":
                f.pay_method.value   = "100000000000";

                var nhnkcp_easy_pay = jQuery("input[name='od_settle_case']:checked" ).attr("data-pay");

                if(nhnkcp_easy_pay === "naverpay"){
                    if(typeof f.naverpay_direct !== "undefined") f.naverpay_direct.value = "Y";
                } else if(nhnkcp_easy_pay === "kakaopay"){
                    if(typeof f.kakaopay_direct !== "undefined") f.kakaopay_direct.value = "Y";
                } else {
                    if(typeof f.payco_direct !== "undefined") f.payco_direct.value = "Y";
                    <?php if($default['de_card_test']) { ?>
                    f.site_cd.value      = "S6729";
                    <?php } ?>
                }

                break;
            default:
                f.pay_method.value   = "무통장";
                break;
        }
        <?php } else if($default['de_pg_service'] == 'lg') { ?>
        f.LGD_EASYPAY_ONLY.value = "";
        if(typeof f.LGD_CUSTOM_USABLEPAY === "undefined") {
            var input = document.createElement("input");
            input.setAttribute("type", "hidden");
            input.setAttribute("name", "LGD_CUSTOM_USABLEPAY");
            input.setAttribute("value", "");
            f.LGD_EASYPAY_ONLY.parentNode.insertBefore(input, f.LGD_EASYPAY_ONLY);
        }

        switch(settle_method)
        {
            case "계좌이체":
                f.LGD_CUSTOM_FIRSTPAY.value = "SC0030";
                f.LGD_CUSTOM_USABLEPAY.value = "SC0030";
                break;
            case "가상계좌":
                f.LGD_CUSTOM_FIRSTPAY.value = "SC0040";
                f.LGD_CUSTOM_USABLEPAY.value = "SC0040";
                break;
            case "휴대폰":
                f.LGD_CUSTOM_FIRSTPAY.value = "SC0060";
                f.LGD_CUSTOM_USABLEPAY.value = "SC0060";
                break;
            case "신용카드":
                f.LGD_CUSTOM_FIRSTPAY.value = "SC0010";
                f.LGD_CUSTOM_USABLEPAY.value = "SC0010";
                break;
            case "간편결제":
                var elm = f.LGD_CUSTOM_USABLEPAY;
                if(elm.parentNode)
                    elm.parentNode.removeChild(elm);
                f.LGD_EASYPAY_ONLY.value = "PAYNOW";
                break;
            default:
                f.LGD_CUSTOM_FIRSTPAY.value = "무통장";
                break;
        }
        <?php }  else if($default['de_pg_service'] == 'inicis') { ?>
        switch(settle_method)
        {
            case "계좌이체":
                f.gopaymethod.value = "DirectBank";
                break;
            case "가상계좌":
                f.gopaymethod.value = "VBank";
                break;
            case "휴대폰":
                f.gopaymethod.value = "HPP";
                break;
            case "신용카드":
                f.gopaymethod.value = "Card";
                f.acceptmethod.value = f.acceptmethod.value.replace(":useescrow", "");
                break;
            case "간편결제":
                f.gopaymethod.value = "Kpay";
                break;
            case "lpay":
                f.gopaymethod.value = "onlylpay";
                f.acceptmethod.value = f.acceptmethod.value+":cardonly";
                break;
            case "inicis_kakaopay":
                f.gopaymethod.value = "onlykakaopay";
                f.acceptmethod.value = f.acceptmethod.value+":cardonly";
                break;
            default:
                f.gopaymethod.value = "무통장";
                break;
        }
        <?php } ?>

        // 결제정보설정
        <?php if($default['de_pg_service'] == 'kcp') { ?>
        f.buyr_name.value = f.od_name.value;
        f.buyr_mail.value = f.od_email.value;
        f.buyr_tel1.value = f.od_tel.value;
        //f.buyr_tel2.value = f.od_hp.value;
        f.rcvr_name.value = f.od_b_name.value;
        f.rcvr_tel1.value = f.od_b_tel.value;
        //f.rcvr_tel2.value = f.od_b_hp.value;
        f.rcvr_mail.value = f.od_email.value;
        f.rcvr_zipx.value = f.od_b_zip.value;
        f.rcvr_add1.value = f.od_b_addr1.value;
        f.rcvr_add2.value = f.od_b_addr2.value;

        if(f.pay_method.value != "무통장") {
            jsf__pay( f );
        } else {
            f.submit();
        }
        <?php } ?>
        <?php if($default['de_pg_service'] == 'lg') { ?>
        f.LGD_BUYER.value = f.od_name.value;
        f.LGD_BUYEREMAIL.value = f.od_email.value;
        f.LGD_BUYERPHONE.value = f.od_hp.value;
        f.LGD_AMOUNT.value = f.good_mny.value;
        f.LGD_RECEIVER.value = f.od_b_name.value;
        f.LGD_RECEIVERPHONE.value = f.od_b_hp.value;
        <?php if($default['de_escrow_use']) { ?>
        f.LGD_ESCROW_ZIPCODE.value = f.od_b_zip.value;
        f.LGD_ESCROW_ADDRESS1.value = f.od_b_addr1.value;
        f.LGD_ESCROW_ADDRESS2.value = f.od_b_addr2.value;
        f.LGD_ESCROW_BUYERPHONE.value = f.od_hp.value;
        <?php } ?>
        <?php if($default['de_tax_flag_use']) { ?>
        f.LGD_TAXFREEAMOUNT.value = f.comm_free_mny.value;
        <?php } ?>

        if(f.LGD_CUSTOM_FIRSTPAY.value != "무통장") {
            launchCrossPlatform(f);
        } else {
            f.submit();
        }
        <?php } ?>
        <?php if($default['de_pg_service'] == 'inicis') { ?>
        f.price.value       = f.good_mny.value;
        <?php if($default['de_tax_flag_use']) { ?>
        f.tax.value         = f.comm_vat_mny.value;
        f.taxfree.value     = f.comm_free_mny.value;
        <?php } ?>
        f.buyername.value   = f.od_name.value;
        f.buyeremail.value  = f.od_email.value;
        f.buyertel.value    = f.od_hp.value ? f.od_hp.value : f.od_tel.value;
        f.recvname.value    = f.od_b_name.value;
        f.recvtel.value     = f.od_b_hp.value ? f.od_b_hp.value : f.od_b_tel.value;
        f.recvpostnum.value = f.od_b_zip.value;
        f.recvaddr.value    = f.od_b_addr1.value + " " +f.od_b_addr2.value;

        if(f.gopaymethod.value != "무통장") {
            // 주문정보 임시저장
            var order_data = $(f).serialize();
            var save_result = "";
            $.ajax({
                type: "POST",
                data: order_data,
                url: g5_url+"/shop/ajax.orderdatasave.php",
                cache: false,
                async: false,
                success: function(data) {
                    save_result = data;
                }
            });

            if(save_result) {
                alert(save_result);
                return false;
            }

            if(!make_signature(f))
                return false;

            paybtn(f);
        } else {
            f.submit();
        }
        <?php } ?>
    }

}

// 구매자 정보와 동일합니다.
function gumae2baesong() {
    var f = document.forderform;

    f.od_b_name.value = f.od_name.value;
    f.od_b_tel.value  = f.od_tel.value;
    f.od_b_hp.value   = f.od_hp.value;
    f.od_b_zip.value  = f.od_zip.value;
    f.od_b_addr1.value = f.od_addr1.value;
    f.od_b_addr2.value = f.od_addr2.value;
    f.od_b_addr3.value = f.od_addr3.value;
    f.od_b_addr_jibeon.value = f.od_addr_jibeon.value;

    calculate_sendcost(String(f.od_b_zip.value));
}

<?php if ($default['de_hope_date_use']) { ?>
$(function(){
    $("#od_hope_date").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99", minDate: "+<?php echo (int)$default['de_hope_date_after']; ?>d;", maxDate: "+<?php echo (int)$default['de_hope_date_after'] + 6; ?>d;" });
});
<?php } ?>
</script>
