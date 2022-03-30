<?php
include_once('./_common.php');


$sw_direct = isset($_REQUEST['sw_direct']) ? preg_replace('/[^a-z0-9_]/i', '', $_REQUEST['sw_direct']) : '';


set_session("ss_direct", $sw_direct);
// 장바구니가 비어있는가?
if ($sw_direct) {
    $tmp_cart_id = get_session('ss_cart_direct');
}
else {
    $tmp_cart_id = get_session('ss_cart_id');
}

if (get_cart_count($tmp_cart_id) == 0)
    alert('장바구니가 비어 있습니다.', G5_SHOP_URL.'/cart.php');

if (function_exists('before_check_cart_price')) {
    if(! before_check_cart_price($tmp_cart_id) ) alert('장바구니 금액에 변동사항이 있습니다.\n장바구니를 다시 확인해 주세요.', G5_SHOP_URL.'/cart.php');
}

$s_cart_id = $tmp_cart_id;

  $g5['title'] ='선물하기';


  if(G5_IS_MOBILE)
      include_once(G5_MSHOP_PATH.'/_head.php');
  else
      include_once(G5_SHOP_PATH.'/_head.php');


$g5['info'] =='NOMONEYmarket 회원에게만 선물할 수 있습니다.';

if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$order_action_url = G5_HTTPS_SHOP_URL.'/orderformupdate.php';
?>

<div class="sub_title">
  <button type="button" class="title_btn">
    <img src="<?php echo G5_THEME_IMG_URL ?>/btn_arrow_left.png" alt="">
  </button>
  <p class="title">선물하기</p>
  <p class="info">NOMONEYmarket 회원에게만 선물할 수 있습니다.</p>
</div>

<form name="fgiftform" id="fgiftform" method="post" action="<?php echo G5_HTTPS_SHOP_URL."/order_gift_formupdate.php"; ?>" autocomplete="off">
  <input type="hidden" name="send_gift" value="1">
  <input type="hidden" name="sw_direct" value="<?php echo $sw_direct;?>">

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

    <div class="get_box">
      <p>받는 분</p>
      <ul class="get_input_box">
        <li> <input type="text" name="od_b_name" id="gt_b_name" class="" maxlength="20"  placeholder="이름"> </li>
        <li> <input type="text" name="od_w_add" id="gt_w_add" class="" maxlength="20" placeholder="지갑주소"><button type="button" class="copy_btn">붙여넣기</button></li>
      </ul>
    </div>
  <div class="get_box_btns">
    <button type="button" class="cancle_btn">취소</button>
    <button type="submit" class="next_btn">다음</button>

  </div>
</div>
</form>

<script>

$(function() {

});

</script>

<?php

if(G5_IS_MOBILE)
    include_once(G5_MSHOP_PATH.'/_tail.php');
else
    include_once(G5_SHOP_PATH.'/_tail.php');

 ?>
