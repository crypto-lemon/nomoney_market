<?php
include_once('./_common.php');


$sw_direct = $_POST['sw_direct'];
$od_b_name = $_POST['od_b_name'];
$od_w_add = $_POST['od_w_add'];
$send_gift = 1;
if ($is_member)
{
  goto_url(G5_SHOP_URL."/orderform.php?sw_direct=$sw_direct&od_b_name=$od_b_name&od_w_add=$od_w_add&send_gift=1");
}
else
{
  goto_url(G5_BBS_URL."/login.php?url=".urlencode(G5_SHOP_URL."/orderform.php?sw_direct=$sw_direct&od_b_name=$od_b_name&od_w_add=$od_w_add&send_gift=1"));
}
 ?>
