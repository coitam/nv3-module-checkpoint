<!-- BEGIN: main -->
	<div class = "tieude">BẢNG ĐIỂM - NĂM HỌC {NAMHOC} </div>
<table width="100%" border="1" style="border-collapse:collapse;border-color:#999999" cellpadding="2" cellspacing="2">
	<tr>
		<td colspan="4"><br>
		<table width="100%" border="0" style="border-collapse:collapse" cellpadding="2" cellspacing="2">
			<tr>
				<td width="38%"><b>Họ và tên:</b> <a class="huongdan">{HOTEN}</a></td>
				<td><b>Giới tính:</b>&nbsp; {GTINH}</td>
				<td><b>Nơi sinh:</b>&nbsp; {NOISINH}</td>
		  	</tr>
		  	<tr>
				<td><b>Mã Số:</b>&nbsp;{MAHS}</td>
				<td><b>Lớp:</b>&nbsp;{LOP}</td>
				<td><b>Ngày sinh:</b>&nbsp;{NGSINH}</td>
				</tr>
			</table><br>
		</td>
	</tr>
	<tr>
		<td width="100" class="stitle">Môn học</td>
		<td width="75" class="stitle">ĐTBmhkI</td>
		<td width="75" class="stitle">ĐTBmhkII</td>
		<td width="75" class="stitle">ĐTBmcn</td>
	</tr>
	<!-- BEGIN: loop_diem -->
	<tr>
		<td class="tdmonhoc">{MON}</td>
		<td align = "center">{HKI}</td>
		<td align = "center">{HKII}</td>
		<td align = "center">{HKIII}</td>	
	</tr>
	<!-- END: loop_diem -->
	<tr>
	  	<td colspan="4" height = "20">
	  	</td>
	<tr>
		<td width="100" class="stitle">Tổng kết</td>
		<td width="75" class="stitle">Học kỳ 1</td>
		<td width="75" class="stitle">Học kỳ 2</td>
		<td width="75" class="stitle">Cả năm</td>
	</tr>
		<td class="tdmonhoc">ĐTBcn</td>
		<td class="kqcn">{TBMKI}</td>
		<td class="kqcn">{TBMKII}</td>
		<td class="kqcn">{TBMKIII}</td>
	</tr>
	<tr>
	  	<td class="tdmonhoc">Học lực</td>
		<td class="kqcn">{HLI}</td>
		<td class="kqcn">{HLII}</td>
		<td class="kqcn">{HLIII}</td>
	</tr>
 	<tr>
	  	<td class="tdmonhoc">Hạnh kiểm</td>
		<td class="kqcn">{HAKI}</td>
		<td class="kqcn">{HAKII}</td>
		<td class="kqcn">{HAKIII}</td>
	</tr>
	<tr>
	  	<td class="tdmonhoc">Số này nghỉ</td>
		<td>CP:&nbsp;{SNNCP1}&nbsp;|&nbsp;KP:&nbsp;{SNNKP1}&nbsp;
		 |&nbsp;TC:&nbsp;{SNN1}</td>
		<td>CP:&nbsp;{SNNCP2}&nbsp;|&nbsp;KP:&nbsp;{SNNKP2}&nbsp;
		 |&nbsp;TC:&nbsp;{SNN2}</td>
 		<td>CP:&nbsp;{SNNCP3}&nbsp;|&nbsp;KP:&nbsp;{SNNKP3}&nbsp;
 		 |&nbsp;TC:&nbsp;{SNN3}</td>
	</tr>
	<tr>
		<td class="tdmonhoc">Danh hiệu</td>
		<td class="kqcn">{DHI}</td>
 		<td class="kqcn">{DHII}</td>
		<td class="kqcn">{DHIII}</td>
	 </tr>
	 <tr>
		<td class="tdmonhoc">Nhận xét của GVCN</td>
		<td colspan=3>{NXGVCN}</td>
	 </tr>
	 <tr>
		<td colspan="4"><div align="center"><strong>Nguồn từ : http://thpt-vinhloc-thuathienhue.edu.vn</strong></div></td>
	 </tr>
</table>

<!-- END: main -->
