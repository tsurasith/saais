<?php

/*
	include("../../include/class.mysqldb.php");
	include("../../include/config.inc.php");
	include("../../include/shareFunction.php");
	if(!isset($_SESSION['tp-logined'])) {
		echo "<meta http-equiv=\"refresh\" content=\"0;url=../index.php\">";
	} 
	*/
	
	if(isset($_POST['save']))
	{
		for($i =0 ;$i < $_POST['count'] ;$i ++)
		{
			$row_id = '';
			if($i < 10)
			{
				$row_id = $_POST['date'] . $_POST['room_id'] . '0' .$i;
			}
			else
			{
				$row_id = $_POST['date'] . $_POST['room_id'] .$i;
			}
			$sql_insert_student = 'INSERT INTO student_800 VALUES (\'' . $row_id . '\', \'' . $_POST['student_id'][$i]  . '\', \''. $_POST['room_id'] .'\', \'' . timecheck_id($_POST['check'][$i]) .'\', \''. $_POST['date'] . '\',\'' . date('Y-m-d') . '\', ' .$_POST['acadyear'] .', ' . $_POST['acadsemester'] . ', \''. $_SESSION['name']  . '\');'; 
			$a = mysql_query($sql_insert_student) or die ('Error - ' . mysql_error());  // บันทึกข้อมูลการเช็ค
			if($_POST['check'][$i] == "yellow" || $_POST['check'][$i] == "blue" || $_POST['check'][$i] == "red")
			{
				$sql = "insert into student_discipline values (null,'" . $_POST['student_id'][$i] . "','" . $_POST['date'] . "','08.00',' ',' ','". $_SESSION['name'] . "',curdate(),
									'ครู','" . $_SESSION['name'] . "','" . $_POST['date'] . "','เห็นควรมอบให้หัวหน้าระดับดำเนินการสอบสวน',
									'" . disDetail($_POST['check'][$i]) . "','" . $_SESSION['name'] . "')";
				$sql_status = "insert into student_disciplinestatus values('" . $_POST['student_id'][$i]  . "',null,'1','00','0','" . $acadyear . "','" . $acadsemester . "')";
				//mysql_query($sql);
				//mysql_query($sql_status);
			}
		}
		$sql_insert_teacher = 'insert into  teachers_800 VALUES (\'' . $_POST['date'] . '-' . $_POST['room_id'] .'\',\'' . $_POST['room_id'] .'\',\'' . $_POST['teacherSign'] .'\' , \'' . $_POST['date'] .'\', ' .$_POST['acadyear'] .', ' . $_POST['acadsemester'] . ') ';
		$b = mysql_query($sql_insert_teacher) or die ('Error - '. mysql_error()); // บันทึกการเข้าใช้งานของครู
		updateTask($_POST['date'],$_POST['room_id']); // อัพเดทสถานะงานเป็น "บันทึก" แล้ว  ?>
        
        
          <div id="content">
              <table width="100%"  align="center" border="0" cellspacing="10" cellpadding="0"  class="header">
            <tr> 
              <td width="6%" align="center"><a href="index.php?option=module_800/index"><img src="../images/refresh.png" alt="" width="48" height="48" border="0"/></a></td>
              <td width="45%"><strong><font color="#990000" size="4">8.00 O' Clock</font></strong><br />
                <span class="normal"><font color="#0066FF"><strong>ระบบบันทึกการเข้าร่วมกิจกรรมหน้าเสาธง</strong></font></span></td>
              <td >&nbsp;</td>
            </tr>
          </table>
          <br/>
        <table width="75%" border="0" cellspacing="1" cellpadding="3" align="center" bgcolor="#CC99FF">
          <tr bgcolor="#CCCCCC"> 
            <td colspan="2"><font size="2"  ><strong>ผลการดำเนินงาน</strong></font></td>
          </tr>
          <tr bgcolor="white"> 
            <td width="200px"><font size="2"  >ตรวจสอบรายชื่อห้อง</font></td>
            <td><font color="#009900" size="2"  ><strong>เรียบร้อย</strong></font></td>
          </tr>
          <tr bgcolor="white"> 
            <td><font size="2"  >บันทึกรายการนัดพบ</font></td>
            <td><font color="#009900" size="2"  ><strong>เรียบร้อย</strong></font></td>
          </tr>
          <tr bgcolor="white"> 
            <td><font size="2"  >บันทึกการเข้าแถว</font></td>
            <td><font color="#009900" size="2"  ><strong>เรียบร้อย</strong></font></td>
          </tr>
          <tr bgcolor="white"> 
            <td><font size="2"  >บันทึกการเข้าร่วมของครูที่ปรึกษา</font></td>
            <td><font color="#009900" size="2"  ><strong>เรียบร้อย</strong></font></td>
          </tr>
          <tr bgcolor="white">
            <td colspan="2" align="center">
                <br/>
                <form action="index.php?option=module_800/dateTaskList" method="post">
                    <input type="hidden" name="date" value="<?=$_POST['date']?>"/>
                    <input type="submit" value="ดำเนินการต่อไป" />
                </form>
            </td>
            <br/>
          </tr>
        </table>
        </div>
        
<?php        
		

		
		
	}
	else
	{
	
?>
<html>
	<head>
		<title>หน้าต่างบันทึกข้อมูลการเข้าร่วมกิจกรรมหน้าเสาธง</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <style>
			body,table{
				font-family:Tahoma;
			}
			th{
				font-size:18px;
				font-family:Tahoma;
			}
			
			.hover:hover{
				color:#00F;
				font-weight:bold;
				cursor:pointer;
			}
			input,label{
				cursor:pointer;
			}
			input:hover{
				border:1px solid #F00;
			}
		</style>
	</head>
<body>
<script type="text/javascript" language="javascript">
	function check(name,value){ document.getElementById(name).bgColor=value; }
</script>
<?php
			$room_id = getRoom($_REQUEST['room']);
			$xyear = getXyearth($_REQUEST['room']);
			$xlevel  = getXLevel($_REQUEST['room']);

/*
	$date = ????-??-??
	$room_id = ?
	$room = ?0?
	$xlevel = 3|4
	$xyear = 1-6
*/
?>
<table width="800" align="center">
                      <tr>
                        <th > 
								<img src="../images/school_logo.gif" width="120px"><br/>
								บันทึกการมาเข้าร่วมกิจกรรมหน้าเสาธง<br />
								ภาคเรียนที่ <?=$_REQUEST['acadsemester']?>  ปีการศึกษา <?=$_REQUEST['acadyear']?><br />
								ประจำวันที่  
							<font color="red"><?=displayFullDate($_REQUEST['date']); ?></font>
							 ห้อง  <font color="red"><?=getFullRoomFormat($_REQUEST['room']); ?> </font>
							 
						</th>
                      </tr>
					  <tr>
					  <td align="center">
					  <!-- old action="index.php?option=module_800/insertStudentCheck" -->
					  <form method="post" name="save_check" action="">
					  <input type="hidden" name="room_id" value="<?php echo $_REQUEST['room']; ?>" />
					  <input type="hidden" name="acadyear" value="<?=$_REQUEST['acadyear']?>"/>
					  <input type="hidden" name="acadsemester" value="<?=$_REQUEST['acadsemester']?>"/>
					  <input type="hidden" name="date" value="<?php echo $_REQUEST['date']; ?>"/>
					  
					  					<table width="638" cellspacing="1" cellpadding="1">
											<tr>
												<td>
													<input type="radio" name="teacherSign" checked value="sign" id="teacherSign">
              										<label for="teacherSign"><strong><font color="#009900" face="Tahoma" size="2"> มี</font></strong><font face="Tahoma" size="2">ลายเซ็นต์อาจารย์ที่ปรึกษา </font> </label><br/>
													<input type="radio" name="teacherSign" value="unsign" id="teacherUnsign">
													<label for="teacherUnsign"><strong><font color="#FF0000" face="Tahoma" size="2">ไม่มี</font></strong><font face="Tahoma" size="2">ลายเซ็นต์อาจารย์ที่ปรึกษา  </font></label><br/>
													<font face="Tahoma" size="2">ผู้บันทึกข้อมูล :</font><font color="blue" face="Tahoma" size="2"> <?= $_SESSION['name'] ?></font>
												</td>
											</tr>
										</table>
                                          <table width="638" border="0" cellspacing="1" cellpadding="1" align="center" bgcolor="#3366FF">
                                            <tr bgcolor="#CCCCFF"> 
                                              <td width="6%" rowspan="2"><div align="center"><font color="#990066"><strong>เลขที่</strong></font></div></td>
                                              <td width="14%" rowspan="2"><div align="center"><font color="#990066"><strong>เลขประจำตัว</strong></font></div></td>
                                              <td width="36%" rowspan="2"><div align="center"><font color="#990066"><strong>ชื่อ - สกุล</strong></font></div></td>
                                              <td colspan="5"><div align="center"><font color="#990066"><strong>การมาเข้าแถว</strong></font></div></td>
                                            </tr>
                                            <tr> 
                                              <td width="8%" bgcolor="#CCCCFF"><div align="center"><font color="#990066"><strong>มา</strong></font></div></td>
                                              <td width="8%" bgcolor="#CCCCFF"><div align="center"><font color="#990066"><strong>กิจกรรม</strong></font></div></td>
											  <td width="8%" bgcolor="#CCCCFF"><div align="center"><font color="#990066"><strong>สาย</strong></font></div></td>
                                              <td width="8%" bgcolor="#CCCCFF"><div align="center"><font color="#990066"><strong>ลา</strong></font></div></td>
                                              <td width="8%" bgcolor="#CCCCFF"><div align="center"><font color="#990066"><strong>ขาด</strong></font></div></td>
                                            </tr>
 <?php

  	$sql = 'SELECT id, prefix , firstname , lastname FROM students WHERE xLevel =  \''. $xlevel . '\' AND xYearth = \'' . $xyear .'\' and room = \'' . $room_id  .  '\' and studstatus = \'1\' and xedbe = \'' .$acadyear . '\' order by sex,id';
	//echo $sql;
  	$result = mysql_query($sql) or die ('ผิดพลาดเนื่องจาก  - ' .mysql_error());
	$i = 1;
	$j = 0;
	$rows = mysql_num_rows($result);
	while($data = mysql_fetch_array($result))
	{
		echo "<tr class=\"hover\"   id=\"check[$j]\"  bgcolor='#FFFFFF' >";
		echo "<td align=\"center\"><font size=\"2\" face=\"Tahoma\">" . $i . "</font></td>";
		echo "<td align=\"center\"><input type=\"hidden\" name=\"student_id[$j]\" value=\"$data[0]\" /><font size=\"2\" face=\"Tahoma\">$data[0]</font></td>";
		echo "<td><font size=\"2\" face=\"Tahoma\">$data[1]$data[2]  $data[3]</font></td>";
		echo "<td align=\"center\"><input type='radio' name=\"check[$j]\" value='white'  checked    onclick=\"check(this.name,this.value)\" /></td>";
		echo "<td align=\"center\"><input type='radio' name=\"check[$j]\" value='lightgreen'  onclick=\"check(this.name,this.value)\" /></td>";
		echo "<td align=\"center\"><input type='radio' name=\"check[$j]\" value='yellow'   onclick=\"check(this.name,this.value)\" ></td>";
		echo "<td align=\"center\"><input type='radio' name=\"check[$j]\" value='blue'   onclick=\"check(this.name,this.value)\" ></td>";
		echo "<td align=\"center\"><input type='radio' name=\"check[$j]\" value='red'  onclick=\"check(this.name,this.value)\" ></td>";	
		echo "</tr>";
		$j++;
		$i++;	
	}
	
?>
                                            <tr bgcolor="#FFFFFF"> 
                                              <td colspan="8" align="center"> <input type="hidden" name="count" value="<?php  echo $j; ?>"/>
                                                <input type="submit" name="save" value="บันทึก"/> 
                                                <input type="button" value="ยกเลิก" onClick="history.go(-1)" /> 
                                              </td>
                                            </tr>
                                          </table>

</form>
					  </td>
					  </tr>
</table>

<? mysql_free_result($result);  ?>					
</body>
</html>

<? } //end else ?>

<?php

//-------------------------------
function timecheck_id($value)
{
	if($value == 'white') return '00';
	if($value == 'lightgreen') return '01';
	if($value == 'yellow') return '02';
	if($value == 'blue') return '03';
	if($value == 'red') return '04';
	else return 9;
}

function disDetail($value)
{
	if($value == 'yellow') return 'สายการเข้าร่วมกิจกรรมหน้าเสาธง';
	if($value == 'blue') return 'ลาการเข้าร่วมกิจกรรมหน้าเสาธง';
	if($value == 'red') return 'ขาดการเข้าร่วมกิจกรรมหน้าเสาธง';
	else return "ผิดพลาด";
}

function updateTask($date,$room_id)
{
	
	$sql = "update student_800_task set task_status = '1' where task_date = '" . $date . "' and task_roomid = '" . $room_id . "'" ;
	//echo $sql . "<br/>";
	mysql_query($sql) or die ('Error - ' . mysql_error());

}

?>