﻿<?php
	if(isset($_POST['save']))
	{
				
		for($i =1 ;$i < $_POST['count'] ;$i ++)
		{
			$row_id = '';
			for($_period=1;$_period<=8;$_period++){
				if($i < 10) { $row_id = $_POST['date'] . '-' . $_POST['room_id'] . '-' . $_period . '-' . '0' .$i; }
				else { $row_id = $_POST['date'] . '-' . $_POST['room_id'] . '-' . $_period . '-' .$i; }
				$sql_insert_student = "INSERT INTO student_learn VALUES (
										'" . $row_id . "',
										'" . $_POST['student_id'][$i]  . "',
										'" . $_POST['room_id'] ."',
										'" . $_period . "' , 
										'" . timecheck_id($_POST['sCheck'][$i][$_period]) . "',
										'" . $_POST['date'] . "',
										'" . date('Y-m-d') . "',
										 " . $_POST['acadyear'] . ",
										 " . $_POST['acadsemester'] . ", 
										'" . $_SESSION['name']  . "')";
				//echo $sql_insert_student . '<br/>';
				$a = mysql_query($sql_insert_student) or die ('ผิดพลาดเนื่องจาก - ' . mysql_error());  // บันทึกข้อมูลการเช็ค
			}
		}
		
			for($_period=1;$_period<=8;$_period++)
			{
				$sql_insert_teacher = "insert into  teachers_learn VALUES (
											'" . $_POST['date'] . '-' . $_POST['room_id'] . '-' . '0' . $_period . "',
											'" . $_POST['room_id'] ."', 
											'" . $_period . "' , 
											'" . $_POST['tCheck'][$_period] . "' , 
											'" . $_POST['date'] . "',
											 " . $_POST['acadyear'] . ", 
											 " . $_POST['acadsemester'] . ")";
				 $b = mysql_query($sql_insert_teacher) or die ('Error - '. mysql_error()); // บันทึกการเข้าใช้งานของครู
				//echo $sql_insert_teacher . '<br/>';
				updateTask($_POST['date'],$_POST['room_id'],$_period); // อัพเดทสถานะงานเป็น "บันทึก" แล้ว
			}
		
		?>
		<div id="content">
		 <table width="100%"  align="center" border="0" cellspacing="10" cellpadding="0"  class="header">
			<tr> 
			  <td width="6%" align="center"><a href="index.php?option=module_learn/index"><img src="../images/history.png" alt="" width="48" height="48" border="0" /></a></td>
			  <td width="45%"><strong><font color="#990000" size="4">Room Tracking</font></strong><br />
				<span class="normal"><font color="#0066FF"><strong>ระบบบันทึกการเข้าเรียนของนักเรียน >> บันทึกข้อมูล</strong></font></span></td>
			  <td>ปีการศึกษา <?=$acadyear?> ภาคเรียนที่ <?=$acadsemester?> </td>
			</tr>
		  </table><br/>
			<div style="width:100%;" align="center">
				<table width="75%" border="0" cellspacing="1" cellpadding="3" align="center" bgcolor="#CC99FF">
				  <tr bgcolor="#CCCCCC"> 
					<td colspan="2"><font size="2"  ><strong>ผลการดำเนินงาน</strong></font></td>
				  </tr>
				  <tr bgcolor="white"> 
					<td width="150px"><font size="2"  >ตรวจสอบรายชื่อห้อง</font></td>
					<td><font color="#009900" size="2"  ><strong>เรียบร้อย</strong></font></td>
				  </tr>
				 
				  <tr bgcolor="white"> 
					<td><font size="2"  >บันทึกการเข้าห้องเรียน</font></td>
					<td><font color="#009900" size="2"  ><strong>เรียบร้อย</strong></font></td>
				  </tr>
				  <tr bgcolor="white"> 
					<td><font size="2"  >บันทึกการเข้าร่วมของครูที่ปรึกษา</font></td>
					<td><font color="#009900" size="2"  ><strong>เรียบร้อย</strong></font></td>
				  </tr>
				  <tr bgcolor="white">
					<td colspan="2" align="center">
						<br/>
						<form action="index.php?option=module_learn/dateTaskList2" method="post">
							<input type="hidden" name="date" value="<?=$_POST['date']?>"/>
							<input type="submit" name="Submit" value="ดำเนินการต่อไป" />
						</form>
						<br/>
					</td>
				  </tr>
				</table>
			</div>
		</div>
		<?php

	}
	else
	{	 
?>
<html>
<head>
	<title>หน้าต่างบันทึกข้อมูลการเข้าห้องเรียน</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" href="css/main.css">
    
    <style>
		.hover:hover{
			background-color:#C9F;
		}
	
		select option[value="white"] {
			background-color:#FFF;
		}
		select option[value="red"]{
			background-color: #F00;
		}
		select option[value="lightgreen"]{
			background-color: #0F0;
		}
		select option[value="yellow"]{
			background-color: #FF0;
		}
		select option[value="blue"]{
			background-color: #00F;
		}
	</style>
    
    
</head>
<body>
<script language="javascript" type="text/javascript">
	function check(name,value) 
	{ 
		if(value=="unsign")
		{
			document.getElementById(name).bgColor = "red"; 
		}
		else
		{
			document.getElementById(name).bgColor = "transparent"; 
		}
		
	}
	function check2(name,value) 
	{ 
		document.getElementById(name).bgColor=value; 
		document.getElementsByName(name).bgColor=value;
	}
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
<form method="post" action="">
<div  align="center">
	<table width="800px"  align="center" cellspacing="1" class="admintable">
		<tr>
			<td class="header" align="center">
				<img src="../images/school_logo.gif" width="120px"><br/>
				บันทึกการเข้าชั้นเรียน<br/>ประจำวันที่  
				<font color="red"><?=displayFullDate($_REQUEST['date'])?></font>
				ห้อง  <font color="red"><?=getFullRoomFormat($_REQUEST['room'])?> </font><br/>
				ภาคเรียนที่ <?=$_REQUEST['acadsemester']?>  ปีการศึกษา <?=$_REQUEST['acadyear']?><br/>
			</td>
		</tr>
		<tr>
			<td class="key">รายละเอียดเพิ่มเติม</td>
		</tr>
		<tr>
        	<td>
                    <table width="100%">
                        <tr class="hover">
                            <td>
                                การลงลายมือชื่อของครูผู้สอน
                            </td>
                            <? for($_i=1;$_i<=8;$_i++) { ?>
                                    <td align="center" id="tCheck[<?=$_i?>]">
                                       คาบที่ <?=$_i?><br/>
                                        <select name="tCheck[<?=$_i?>]" onChange="check(this.name,this.value)">
                                            <option value="sign">ลงชื่อ</option>
                                            <option value="unsign">ไม่ลงชื่อ</option>
                                        </select>
                                    </td>
                            <? } ?>
                        </tr>
                    </table>
              </td>
        </tr>
		<tr>
			<td align="center">
					  <input type="hidden" name="room_id" value="<?=$_REQUEST['room']; ?>"/>
					  <input type="hidden" name="date" value="<?=$_REQUEST['date']; ?>"/>
					  <input type="hidden" name="acadyear" value="<?=$_REQUEST['acadyear']?>"/>
					  <input type="hidden" name="acadsemester" value="<?=$_REQUEST['acadsemester']?>"/>					  
					  					
                                          <table border="0" cellspacing="1" cellpadding="1" align="center" bgcolor="#3366FF">
                                            <tr bgcolor="#CCCCFF"> 
                                              <td width="20px" rowspan="2"><div align="center"><font color="#990066"><strong>เลขที่</strong></font></div></td>
                                              <td width="80px" rowspan="2"><div align="center"><font color="#990066"><strong>เลขประจำตัว</strong></font></div></td>
                                              <td width="200px" rowspan="2"><div align="center"><font color="#990066"><strong>ชื่อ - สกุล</strong></font></div></td>
                                              <td colspan="8"><div align="center"><font color="#990066"><strong>การมาเข้าห้องเรียน</strong></font></div></td>
                                            </tr>
                                            <tr bgcolor="#CCCCFF"> 
                                              <? for($_i=1;$_i<=8;$_i++){ ?>
                                              		<td align="center"><font color="#990066">คาบที่ <?=$_i?></font></td>
                                              <? } ?>
                                            </tr>
                                            <?php

  	$sql = 'SELECT id, prefix , firstname , lastname FROM students WHERE xLevel =  \''. $xlevel . '\' AND xYearth = \'' . $xyear .'\' and room = \'' . $room_id  .  '\' and xedbe = \'' .$acadyear . '\'  and studstatus = \'1\' order by sex,id';
//	echo $sql;
  	$result = mysql_query($sql) or die ('Error  - ' .mysql_error());
	$j = 1;
	$rows = mysql_num_rows($result);
	while($data = mysql_fetch_array($result))
	{
		echo "<tr class=\"hover\" bgcolor=\"#FFFFFF\">";
		echo "<td align=\"center\"><font size=\"2\" face=\"Tahoma, sans-serif\">" . $j . "</font></td>";
		echo "<td align=\"center\"><input type=\"hidden\" name=\"student_id[$j]\" value=\"$data[0]\" /><font size=\"2\" face=\"Tahoma, sans-serif\">$data[0]</font></td>";
		echo "<td><font size=\"2\" face=\"Tahoma, sans-serif\">$data[1]$data[2]  $data[3]</font></td>";
		for($_i=1;$_i<=8;$_i++) {
			echo "<td id=\"sCheck[$j][$_i]\" align=\"center\">
						<select name=\"sCheck[$j][$_i]\" onChange='check2(this.name,this.value);'>
							<option value='white'>มา</option>
							<option value='lightgreen'>กก.</option>
							<option value='yellow'>สาย</option>
							<option value='blue'>ลา</option>
							<option value='red'>ขาด</option>
						</select>
				  </td>";
		}
		echo "</tr>";
		$j++;
	}
	
?>
                                            <tr bgcolor="#FFFFFF"> 
                                              <td colspan="11" align="center"> 
                                                <input type="hidden" name="count" value="<?=$j?>>"/>
                                                <input type="submit" name="save" value="บันทึก"/> 
                                                <input type="button" value="ยกเลิก" onClick="location.href='../administrator/index.php?option=module_learn/dateTaskList2&date=<?=$_REQUEST['date']?>'"/> 
                                              </td>
                                            </tr>
                                          </table>


					  </td>
					  </tr>
</table>

<? mysql_free_result($result); ?>		
</div>		
</form>	
</body>
</html>
<?
	} //end else
?>

<?

		
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
		
		function updateTask($date,$room_id,$period)
		{
			
			$sql = "update student_learn_task set task_status = '1' where task_date = '" . $date . "' and task_roomid = '" . $room_id . "' and period = '" . $period . "'" ;
			//echo $sql . "<br/>";
			mysql_query($sql) or die ('Error - ' . mysql_error());
		
		}

?>