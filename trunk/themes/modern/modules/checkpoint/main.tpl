<!-- BEGIN: main -->
	<div class="tieude">{CAUHINH.0}</div>
<!-- BEGIN: block_table-->
	<form id="search_diem" name="frm_search" method="post" align="center">
	<div class="huongdan" align="center"><a>{CAUHINH.1}</a></div>
	<table border = "0" class = "tracuutb" id = "tracuutb">
		<tr>
			<td height = "25px"><b>Từ khóa: </b></td>
			<td><span class="tracuu_input">
			<input name="keywords" id="keyword" type="text" style="width:220px"></td></span>			
		</tr>
		<tr>
			<td height = "25px">Tìm theo:</td>
			<td>
				<span class="tracuu_input">
				<input value="1" name="findtype" id="ho" type="radio"> Họ Và Tên &nbsp;&nbsp;&nbsp;
				<input value="2" id="mahs" name="findtype" checked="checked" type="radio"> 
				MHS hoặc Mã Lớp</span></td>
		</tr>
		<tr>
			<td height = "25px">Học kì:</td>
			<td><span class="tracuu_input">
				<select name="hkid" id="hkid" style="width:224px">
					<option value="0">Chọn học kì</option>
					<!-- BEGIN: loop_hk-->
					<option value={MAHK}>{TENHK}</option>
					<!-- END: loop_hk -->
				</select></span>
			</td>
		</tr>
		<tr>
			<td height = "25px">Năm học:</td>
			<td><span class="tracuu_input">
				<select name="namid" id="namid" style="width:224px">
					<option value="0">Chọn năm học</option>
					<!-- BEGIN: loop_nh-->
					<option value={MANAMHOC}>{TENNAMHOC}</option>
					<!-- END: loop_nh -->
				</select></span>
			</td>
		</tr>
	</table>
		<div align = "center"><button id="button_submit" value="click" type="submit">Tra cứu</button></div>
	</form>
	<div style="clear:both"></div>
	<div id="result"></div>
	{SCRIPT}
<!-- END: block_table -->
<!-- BEGIN: block_tablekq -->
	<div class="kqseach">Tìm thấy <font color = red>{COUNT}</font> hồ sơ với từ khoá <font color = red>{KEY}</font></div>
	<table class="tieude" style="border-collapse:collapse;border-color:#999999" cellpadding="2" cellspacing="2" width="100%" border="1">
	<tr class = "stitle">
		<td width = 10%>Mã số </td>
		<td>Họ tên</td>
		<td width = 15%>Ngày sinh</td>
		<td>Nơi sinh</td>
		<td width = 10%>Chi tiết</td>
	</tr>
	<!-- BEGIN:loop_kq -->
	<tr class = "tiet">
		<td><a href ={LINKS}={MAHS}&hkid={HKID}&namid={NAMID}&findtype={FINDTYPE}>{MAHS}</a></td>
		<td align = "left">&nbsp;{HOTEN}</td>
		<td>{NGSINH}</td>
		<td align = "left">{NOISINH}</td>
		<td><a href ={LINKS}={MAHS}&hkid={HKID}&namid={NAMID}&findtype={FINDTYPE}>Xem</a></td>
	</tr>
	<!-- END:loop_kq -->
	</table>
<!-- END: block_tablekq -->
<!-- END: main -->
