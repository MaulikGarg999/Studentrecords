<html> 
<head>
<title>Students Record</title>
<link rel="stylesheet" href="/esecforte/bootstrap-3.4.1-dist/css/bootstrap.css">
</head>
<?php

	if(!isset($_GET["oc"]))
	{ 
		$oc="desc";	
		//echo $oc." isset";
	}
	else
	{ 
		$oc=$_GET["oc"]; 
		//echo "while pgination ".$oc;	
	}	
	
	if(!isset($_GET["t1"]))
	{
		$TV="";
		$V="";
	}
	else
	{
		$TV="You searched for: ".$_GET["t1"];
		$V=$_GET["t1"];
	}

	if(!isset($_GET["Sort"]))
	{
		$sor="";
	}
	else 
	{
		$sor=$_GET["Sort"];
		$oc=$_GET["oc"];
		//echo $oc." in sort";
		if($oc=="desc")
		{
			$oc="asc"; //echo $oc." in if";
		}
		else
		{
			$oc="desc"; //echo $oc." in else";
		}
	}	
?>
<Body style="background-color: #dda;">	

<form  class="form-inline" method="get" action="Student1.php" style="text-align: right; margin-top:10px; margin-right:25px;">
<div class="form-group">
<input type="text" name="t1" placeholder="Enter name to search" class="form-control" value=<?php echo '"'.$V.'"' ?>>
<input type="submit" value="Go" class="btn btn-default">
</div>
</form>

<div class="panel panel-default" style="margin-right: 25px; margin-left:25px;">

<div class="panel-heading" style="background-color: #009B77;height: 50px;">
	<h2 style="text-align: center;color:white; margin-top: 0px;">Student's Data Sheet</h2>
</div>

<div class="panel-body">
	<h6 style="text-align: center;color:Green"><?php echo $TV ?></h6>
</div>

<table class="table table-hover" style="background-color: white; margin-right:25px;">
<tr style="font-weight: bold;">
	<td>ID</td>
	<td><a href="Student1.php?Sort=S&oc=<?php echo $oc ?>">Name</a></td>
	<td>DOB</td><td>Class</td><td>Fees</td><td>Email</td><td>Contact</td><td>Address</td>
</tr>

<?php
	
	$err=""; $res_per_page=5; $page=0; $no_of_page=0; $s=0;
	
	$conn=mysqli_connect("localhost","root","","student");

//===========Getting the GeT parameters to get the page values==============
	if(!isset($_GET["Inbox"]))
	{
		$in="";							//parameter for all records
	}
	else
	{
		$in=$_GET["Inbox"];
	} 		
	
	if(!isset($_GET["s"]))
 	{
 		$s=0;							//parameter for Flagging sort while in pagination
 	}
 	else
 	{
 		$s=$_GET["s"];
 	}	
	
	if (!isset ($_GET["page"]) ) 
	{  
        $page = 1;  					//Getting page numbers for applying pagination
    } 
    else 
    {  
        $page = $_GET["page"]; 
    }
 	
//===============================deletion of records ======================================   
	
	if(isset($_GET["delete"]))
	{	
		if(!empty($_GET["t2"]))
		{
			$res=mysqli_query($conn,"select Stu_id from student where Stu_id=".$_GET["t2"]);
			
			if(mysqli_num_rows($res)==1)
			{
				mysqli_query($conn,"delete from student where Stu_id=".$_GET["t2"]);
				$err="Record Deleted Succesfully:";
			}
			else
			{ 
				$err="No record found";
			}
		}
		else
		{
			$err="Please enter Id;";
		}
	}
//=============================insertion and validation logic:================================
	$flag=0;	$flag1=0;

if(isset($_POST["Insert"])||isset($_POST["Upd"]))
{	
	//Basic Validations==================================================================
	if(is_numeric($_POST["t3"])&&!empty($_POST["t4"])&&!empty($_POST["t5"])&&is_numeric($_POST["t6"])&&$_POST["t6"]>0&&$_POST["t6"]<=12&&is_numeric($_POST["t7"])&&$_POST["t7"]>0&&$_POST["t7"]<=1200&&!empty($_POST["t8"])&&strpos($_POST["t8"],"@")!=""&&strpos($_POST["t8"],".com")!=""&&is_numeric($_POST["t9"])&&strlen($_POST["t9"])==10&&!empty($_POST["t10"]))
	{
//==============================Date Validation==========================================		
	if(is_numeric(substr($_POST["t5"],0,4))&&is_numeric(substr($_POST["t5"],5,2))&&is_numeric(substr($_POST["t5"],8,2)))
	{	
		$yy=intval(substr($_POST["t5"],0,4));
		$mm=intval(substr($_POST["t5"],5,2));
		$dd=intval(substr($_POST["t5"],8,2));
		echo $yy."\n".$mm."\n".$dd;
		if(!(checkdate($mm,$dd,$yy)))
		{ 	
			//echo " date mismatched;";
			$flag1=1;
			//echo $flag1;
			$err="Please enter the date in the given format:";
		}
	//	else
	//		{echo "dates successful";}
	}
	else
	{
		$flag1=1;
		//echo "date numeric condition failed.";
		$err="Please enter the date in the given format:";
	}
//==========================Email and iD unique check validation=======================
	$flag=0;
	if(isset($_POST["Insert"]))	
	{	
		if($flag1==0)
		{
		$res=mysqli_query($conn,"select Stu_id, email from student");
		if(mysqli_num_rows($res)>0)
		{
			while($row=mysqli_fetch_assoc($res))
			{
				if($_POST["t3"]==$row["Stu_id"]||$_POST["t8"]==$row["email"])
				{	
					$flag=1; 
					if($_POST["t3"]==$row["Stu_id"])
					{
						$err="ID should be unique";
					}
					else
					{	
						$err="Email should be unique:";
					}
				}
			}
		}
		}
	}	
//Email uniqueness and correct id check for update operation===============================	
	if(isset($_POST["Upd"]))
	{
		
	if($flag1==0)
	{	
	$res=mysqli_query($conn,"select Stu_id from student where Stu_id in(".$_POST["t3"].")");
	if(mysqli_num_rows($res)==1)
	{
		$res=mysqli_query($conn,"select Stu_id from student where email='".$_POST["t8"]."'");
		if(mysqli_num_rows($res)==1)
		{	
			$row=mysqli_fetch_assoc($res);
			if(!($row["Stu_id"]==$_POST["t3"]))
			{
					$flag=1;
					$err="Email already exist!";
			}
		}
	}
	else
	{	
		$flag=1;
		$err="No record exist by this Id.";
	}
	}
		
	}
//========================================Insertion and Updation==============================
		if($flag!=1&&$flag1!=1)
		{
			if(isset($_POST["Insert"]))	
			{	
				mysqli_query($conn,"insert into student values(".$_POST["t3"].",'".$_POST["t4"]."','".$_POST["t5"]."',".$_POST["t6"].",".$_POST["t7"].",'".$_POST["t8"]."','".$_POST["t9"]."','".$_POST["t10"]."')");
				$err="record inserted";
			}
			if(isset($_POST["Upd"]))
			{	
				$sql="Update student set name='".$_POST["t4"]."', DoB='".$_POST["t5"]."', class=".$_POST["t6"].", fees=".$_POST["t7"].", email='".$_POST["t8"]."', contact='".$_POST["t9"]."', address='".$_POST["t10"]."' where Stu_id=".$_POST["t3"];
				
				if(mysqli_query($conn,$sql))
				{$err="Update Succesful";}
				else
				{$err="Update Unsuccessful";}	
			}
		
		}
	}
	else
	{	
		if(empty($_POST["t3"]))
		{$err="ID cannot be blank";}

		else if(!empty($_POST["t3"])&&!is_numeric($_POST["t3"]))
		{$err="ID Must be Numeric";}
		
		else if(empty($_POST["t4"]))
		{$err="Name cannot be blank";}
		
		else if(empty($_POST["t5"]))
		{$err="date cannot be blank";}
			
		else if(empty($_POST["t6"]))
		{$err="class cannot be blank";}

		else if(!empty($_POST["t6"])&&!is_numeric($_POST["t6"]))
		{$err="class must be numeric";}

	else if(!empty($_POST["t6"])&&is_numeric($_POST["t6"])&&$_POST["t6"]>12&&$_POST["t6"]<1) 
		{$err="Value of class in not in range";}

		else if(empty($_POST["t7"]))
		{$err="Fee cannot be blank";}

		else if(!empty($_POST["t7"])&&!is_numeric($_POST["t7"]))
		{$err="Vaule of fees must be numeric";}

	else if(!empty($_POST["t7"])&&is_numeric($_POST["t7"])&&$_POST["t7"]>1200&&$_POST["t7"]<100) 
		{$err="Value of Fee in not in range";}
		
		else if(empty($_POST["t8"]))							
		{$err="Email cannot be empty";}

		else if(!empty($_POST["t8"])&&strpos($_POST["t8"],"@")=="")
		{ $err="@ is missing in email. invalid email";}

		else if(!empty($_POST["t8"])&&strpos($_POST["t8"],".com")=="")
		{ $err=".com is missing. invalid email.";} 

		else if(empty($_POST["t9"]))							
		{$err="Mobile cannot be empty";}

		else if(!empty($_POST["t9"])&&!is_numeric($_POST["t9"]))
		{ $err="Mobile must be numeric";}

		else if(!empty($_POST["t9"])&&is_numeric($_POST["t9"])&&strlen($_POST["t9"])>10)
		{ $err="Mobile digits cannot be greter than 10";} 
		
		else
		//if(empty($_POST["t10"]))
		{$err="Address cannot be blank";}
	}
}

//================================insertion and validation logic completed. Queries started...

	$res=mysqli_query($conn,"select count(*) as total from student");
	
	$row=mysqli_fetch_assoc($res);
	
	$no_of_page=ceil($row["total"]/$res_per_page);

	if($page>0&&$page<=$no_of_page)
	{
		$limitclauseI=($page-1)*$res_per_page;
//=====================RESULT FETCHING fROM QUERIES=======================
		
	if($s==1||$sor=="S")
	{	
		//echo $oc."uut";	
	if($oc=="asc")
	{
	
	$res=mysqli_query($conn,"select * from student order by name limit ".$limitclauseI.",".$res_per_page);
	
	}
	else
	{
		//echo $s."===ch===";
$res=mysqli_query($conn,"select * from student order by name desc limit ".$limitclauseI.",".$res_per_page);
	
	}
		$s=1;
	}		
	else if(empty($_GET["t1"])||$in=="Al")
	{	
		$res=mysqli_query($conn,"select * from student limit ".$limitclauseI.",".$res_per_page);
		$s=0;
	}
	else
	{	
		$res=mysqli_query($conn,"select * from student where name like '%".$_GET["t1"]."%'");	
		$s=0;
	}	

//===============Printing the Results======================================	
	
	if(mysqli_num_rows($res)>0)
	{
		while($row = mysqli_fetch_assoc($res))
		{
?>
	<tr>
		<td><?php echo $row["Stu_id"]?></td>
		<td><?php echo $row["name"]?></td>
		<td><?php echo $row["DoB"]?></td>
		<td><?php echo $row["class"]?></td>
		<td><?php echo $row["fees"]?></td>
		<td><?php echo $row["email"]?></td>
		<td><?php echo $row["contact"]?></td>
		<td><?php echo $row["address"]?></td>
	</tr>	
<?php
		}
	}
	else
	{
		$err="No Student By Name ".$_GET["t1"];
	}
	
	}
	else
	{	
		$err="No Record Exist: Please Try Again!";
	}
?>
</table>
<div class="panel-footer">
<h6 style="color: red; text-align: center;"><?php echo $err ?></h6>
</div>
<!-- pagination navigation bar is implemented in the panel-->

<nav aria-label="Page navigation" style="height: 40px;">
<ul class="pagination" style="margin-top: 2px;">
<li>
<a href="Student1.php?page=<?php echo ($page-1)?>&s=<?php echo $s?>&oc=<?php echo $oc?>" aria-label="Previous">
<span aria-hidden="true">&laquo;</span>
</a>
</li>
<?php
//Printing the links for Pagination to occur:===============================
$page1=$page;
for($page=1;$page<=$no_of_page;$page++)
	{ 
		echo '<li><a href = "Student1.php?page='.$page.'&s='.$s.'&oc='.$oc.'">'.$page.'</a></li>';
	}
?>

<li>
<a href="Student1.php?page=<?php echo ($page1+1)?>&s=<?php echo $s?>&oc=<?php echo $oc?>" aria-label="Next">
<span aria-hidden="true">&raquo;</span>
</a>
</li>
</ul>
</nav>
</div><!--Closing of panel -->

<nav class="navbar navbar-default">
<div class="container-fluid">
	  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
      <li><a href="Student1.php?Inbox=Al">All Records</a></li>
      <li><a href="Student1.php?Add=add">Add Records</a></li>
<li>
<form  class="form-inline" method="get" action="Student1.php" style="margin-top: 5px; padding-top: 7px; margin-left: 75px;">
<div class="form-group">
<input type="text" name="t2" placeholder="Enter Id to delete:" class="form-control">
<input type="submit" value="Delete" name="delete" class="btn btn-default">
</div>
</form>
</li>
<li>		
<form  class="form-inline" method="get" action="Student1.php" style="margin-top: 5px; padding-top: 7px; margin-left:325px;">
<div class="form-group">
<input type="text" name="t11" placeholder="Enter Id to update" class="form-control">
<input type="submit" value="update" name="Update" class="btn btn-default">
</div>
</form>
</li>
      </ul>
   	  </div>
</div>
</nav>
<?php 
$err1="";
if(isset($_GET["Add"])||isset($_POST["Insert"])||isset($_GET["Update"])||isset($_POST["Upd"]))
{	
	if(isset($_GET["Add"])||isset($_POST["Insert"])||isset($_POST["Upd"]))
	{
		if(!isset($_POST["t3"]))
		{	$id=""; }
		else
		{	$id=$_POST["t3"]; }
	
		if(!isset($_POST["t4"]))
		{	$name=""; }
		else
		{	$name=$_POST["t4"]; }
	
		if(!isset($_POST["t5"]))
		{	$dob=""; }
		else
		{	$dob=$_POST["t5"]; }
	
		if(!isset($_POST["t6"]))
		{	$class=""; }
		else
		{	$class=$_POST["t6"]; }

		if(!isset($_POST["t7"]))
		{	$fees=""; }
		else
		{	$fees=$_POST["t7"]; }

		if(!isset($_POST["t8"]))
		{	$email=""; }
		else
		{	$email=$_POST["t8"]; }
	
		if(!isset($_POST["t9"]))
		{	$contact=""; }
		else
		{	$contact=$_POST["t9"]; }

		if(!isset($_POST["t10"]))
		{	$address=""; }
		else
		{	$address=$_POST["t10"]; }
	}


if(isset($_GET["Update"]))
{	
	if(!empty($_GET["t11"]))
	{
		$res=mysqli_query($conn,"select * from student where Stu_id=".$_GET["t11"]);
		if(mysqli_num_rows($res)==1)
		{	
			$row=mysqli_fetch_assoc($res);
			$id=$row["Stu_id"];
			$name=$row["name"];
			$dob=$row["DoB"];
			$class=$row["class"];
			$fees=$row["fees"];
			$email=$row["email"];
			$contact=$row["contact"];
			$address=$row["address"];
		}
		else
		{
			$err1="No record found for this id";
			$id="";
			$name="";
			$dob="";
			$class="";
			$fees="";
			$email="";
			$contact="";
			$address="";
		}	
	}
	else
	{
		$err1="Enter ID to Update"; 
		$id="";
		$name="";
		$dob="";
		$class="";
		$fees="";
		$email="";
		$contact="";
		$address="";
	}
}

?>
<form method="post" action="Student1.php" style="margin-top: 5px; padding-top: 7px;">
<table class="table table-hover" style="background-color:white; text-align: center;width:500px; margin-left: 25px;">
<tr style="font-weight: bold;"><td>Attribute</td><td>Value</td></tr>
<tr>
<td><label>ID</label></td>
<td><input type="text" name="t3" placeholder="Enter ID" class="form-control" value="<?php echo $id ?>"></td>
</tr>
<tr>
<td><label>Name</label></td>
<td><input type="text" name="t4" placeholder="Name" class="form-control" value="<?php echo $name ?>"> </td>
</tr>
<tr>
<td><label>Date Of Birth:</label></td>
<td><input type="text" name="t5" placeholder="YYYY-MM-DD" class="form-control" value="<?php echo $dob ?>"></td>
</tr>
<tr>
<td><label>Class</label></td>
<td><input type="text" name="t6" placeholder="12" class="form-control" value="<?php echo $class ?>"></td>
</tr>
<tr>
<td><label>Fee</label></td>
<td><input type="text" name="t7" placeholder="1000" class="form-control" value="<?php echo $fees ?>"></td>
</tr>
<tr>
<td><label>Email</label></td>
<td><input type="text" name="t8" placeholder="abc@gmail.com" class="form-control" value="<?php echo $email ?>"></td>
</tr>
<tr>
<td><label>Mobile No</label></td>
<td><input type="text" name="t9" placeholder="9012334455" class="form-control" value="<?php echo $contact ?>"></td>
</tr>
<tr>
<td><label>Address</label></td>
<td><input type="text" name="t10" placeholder="Address" class="form-control" value="<?php echo $address ?>"></td>
</tr>
<tr>
<td><input type="submit" name="Upd" value="Update" class="btn btn-default"></td>
<td><input type="submit" name="Insert" value="Add" class="btn btn-default"></td>
</tr>
</table>
</form>
<?php
}
?>
<h6><?php echo $err1; ?></h6>
</body>
<html>