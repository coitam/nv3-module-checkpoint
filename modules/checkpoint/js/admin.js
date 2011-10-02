/**
 * @Author GaNguCay (gangucay@gmail.com)
 * @createdate 05/09/2010
 */

//  ---------------------------------------

function nv_chang_acgv( vid )
{
   var nv_timer = nv_settimeout_disable( 'change_acgv_' + vid, 5000 );
   var new_acgv = document.getElementById( 'change_acgv_' + vid ).options[document.getElementById( 'change_acgv_' + vid ).selectedIndex].value;
   nv_ajax( "post", script_name, nv_name_variable+'='+nv_module_name+'&'+nv_fc_variable + '=change_ac&lopid='+ vid +'&new_acgv='+ new_acgv);
   return;
}

function nv_chang_cn( vid )
{
   var nv_timer = nv_settimeout_disable( 'change_cn_' + vid, 5000 );
   nv_ajax( "post", script_name, nv_name_variable+'='+nv_module_name+'&'+nv_fc_variable + '=change_ac&cnid=' + vid + '&new_cn=1');
   return;
}

function nv_chang_kh( vid )
{
   var nv_timer = nv_settimeout_disable( 'change_kh_' + vid, 5000 );
   nv_ajax( "post", script_name, nv_name_variable+'='+nv_module_name+'&'+nv_fc_variable + '=change_ac&khid=' + vid + '&new_kh=1');
   return;
}
