<?php

include("php/dbconnect.php");
include("php/verify.php");


$paper = '';
$id = '';
$errormsg = '';
$question = '';
$type = '';
$obj1 = '';
$obj2 = '';
$obj3 = '';
$obj4 = '';
$turefalse = '';

$oneword='';
$answer = '';



if(isset($_POST['save1']))
{
$question = mysqli_real_escape_string($conn,$_POST['question']);
$type = mysqli_real_escape_string($conn,$_POST['type']);
$paper = mysqli_real_escape_string($conn,$_POST['paper']);



if($_POST['action']=="add")
{

if($type=='True/False')
{

$answer = $turefalse = mysqli_real_escape_string($conn,$_POST['turefalse']);
$sql = $conn->query("INSERT INTO  questions (paper,question,type,turefalse,answer) VALUES ('$paper','$question','$type','$turefalse','$answer')") ;

}else
if($type=='One Word')
{
$answer = $oneword = mysqli_real_escape_string($conn,$_POST['oneword']);
$sql = $conn->query("INSERT INTO  questions (paper,question,type,oneword,answer) VALUES ('$paper','$question','$type','$oneword','$answer')") ;

}else
if($type=='Multiple Choice')
{
$obj1 = mysqli_real_escape_string($conn,$_POST['obj1']);
$obj2 = mysqli_real_escape_string($conn,$_POST['obj2']);
$obj3 = mysqli_real_escape_string($conn,$_POST['obj3']);
$obj4 = mysqli_real_escape_string($conn,$_POST['obj4']);
$answer1 = 'obj'.mysqli_real_escape_string($conn,$_POST['answer']);
$answer = $_POST[$answer1];

$sql = $conn->query("INSERT INTO  questions (paper,question,type,obj1,obj2,obj3,obj4,answer) VALUES ('$paper','$question','$type','$obj1','$obj2','$obj3','$obj4','$answer')") ;

}

  echo '<script type="text/javascript">window.location="questions.php?act=1";</script>';
}else
if($_POST['action']=="update")
{

$id = mysqli_real_escape_string($conn,$_POST['id']);
$qtype = mysqli_real_escape_string($conn,$_POST['qtype']);

if($qtype=='True/False')
{

$answer = $turefalse = mysqli_real_escape_string($conn,$_POST['turefalse']);
$sql = $conn->query("update questions set turefalse= '$turefalse' ,answer= '$answer' ,question= '$question' ,paper= '$paper'   where id = '$id'") ;


}else
if($qtype=='One Word')
{
$answer = $oneword = mysqli_real_escape_string($conn,$_POST['oneword']);
$sql = $conn->query("update questions set oneword= '$oneword' ,answer= '$answer' ,question= '$question' ,paper= '$paper'   where id = '$id'") ;



}else
if($qtype=='Multiple Choice')
{
$obj1 = mysqli_real_escape_string($conn,$_POST['obj1']);
$obj2 = mysqli_real_escape_string($conn,$_POST['obj2']);
$obj3 = mysqli_real_escape_string($conn,$_POST['obj3']);
$obj4 = mysqli_real_escape_string($conn,$_POST['obj4']);
$answer1 = 'obj'.mysqli_real_escape_string($conn,$_POST['answer']);
$answer = $_POST[$answer1];

$sql = $conn->query("update questions set obj1= '$obj1' ,obj2= '$obj2' ,obj3= '$obj3' ,obj4= '$obj4' ,answer= '$answer' ,question= '$question' ,paper= '$paper'   where id = '$id'") ;


}




  echo '<script type="text/javascript">window.location="questions.php?act=2";</script>';


}

}




$action = "add";
if(isset($_GET['action']) && $_GET['action']=="edit" ){
$id = isset($_GET['id'])?mysqli_real_escape_string($conn,$_GET['id']):'';

$sqlEdit = $conn->query("SELECT * FROM questions WHERE id='".$id."'");
if($sqlEdit->num_rows)
{
$rowsEdit = $sqlEdit->fetch_assoc();
extract($rowsEdit);
$action = "update";
}else
{
$_GET['action']="";
}

}


if(isset($_GET['action']) && $_GET['action']=="delete"){

$conn->query("Delete from questions  WHERE id='".$_GET['id']."'");	
header("location: questions.php?act=3");

}


if(isset($_REQUEST['act']) && @$_REQUEST['act']=="1")
{
$errormsg = "<div class='alert alert-success alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><strong>Success!</strong> Exam Add successfully</div>";
}else if(isset($_REQUEST['act']) && @$_REQUEST['act']=="2")
{
$errormsg = "<div class='alert alert-success alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><strong>Success!</strong> Exam Edit successfully</div>";
}
else if(isset($_REQUEST['act']) && @$_REQUEST['act']=="3")
{
$errormsg = "<div class='alert alert-success alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><strong>Success!</strong> Exam Delete successfully</div>";
}

include("php/header.php");
?>

        <div id="page-wrapper">

            <div class="container-fluid">

     

				
				<?php
			if(isset($_GET['action']) && @$_GET['action']=="add" || @$_GET['action']=="edit")
			  {
				?>
				
				
	<script type="text/javascript">
$(document).ready(function(){

$("#qtype").change(function(){


 $(".questiontype").each(function(){
        $(this).hide();
    });
	
	
if($(this).val()=="Multiple Choice")
{
$("#multiplechoice").show();
}
else
if($(this).val()=="True/False")
{
$("#trueflase").show();
}
else
if($(this).val()=="One Word")
{
$("#oneword").show();
}

});

});

   </script>	
				
				
                      <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                          Exam  Paper Mangament <small class="pull-right"> <?php echo (($action=="update")?"Edit":"Add"); ?> Questions</small>
                        </h1>
                       
                    </div>
                </div>
                <!-- /.row -->
                       
						
						 <div class="alert alert-info alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="fa fa-info-circle"></i>  <strong>Set Questions </strong> <?php echo (($action=="update")?"Edit":"Add"); ?> Question to exam for Paper Generating!
                        </div>
						
                
                <!-- /.row -->
 <form role="form" method="post" action="questions.php" >
                <div class="row">
                    <div class=" col-md-6">
					
					 <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title"> Primary Info</h3>
                            </div>
                            <div class="panel-body">
                        

						 
						 <div class="form-group">
                                <label>Exam</label>
                                <select class="form-control"   name="paper" required>
									<option value="">Select Exam</option>
								<?php
								$sql = "select * from  paper";
								$q = $conn->query($sql);
								
							  
								while($r = $q->fetch_assoc())
								{
								 echo ' <option value="'.$r['id'].'"  '.(($r['id']==$paper)?'selected="selected"':'').'>'.$r['papername'].'</option>';
								}
								?>
                                    
                                </select>
								
								 <p class="help-block">Select Exam name where this question will show</p>
                            </div>
							
							
							
							
						<div class="form-group">
                                <label>Type</label>
                                <select class="form-control"  name="type"   id="qtype"  <?php echo ($action=="update")?'disabled="disabled"':'';?>>
								
								<option  value="Multiple Choice" <?php echo ($type=="Multiple Choice")?'selected="selected"':''; ?> >Multiple Choice</option>
								<option  value="True/False" <?php echo ($type=="True/False")?'selected="selected"':''; ?> >True/False</option>
								<option  value="One Word" <?php echo ($type=="One Word")?'selected="selected"':''; ?> >One Word</option>
								
                                </select>
								
								 <p class="help-block">Select Question Type</p>
                            </div>
                            
                         

                        
						</div>
                        </div>
						
						<input type="hidden" name="action" value="<?php echo $action;?>">
						<input type="hidden" name="qtype" value="<?php echo $type;?>">
                            <input type="hidden" name="id" value="<?php echo $id;?>">

                            <a href="questions.php" class="btn btn-danger">Cancel</a>
                            <button type="submit" name="save1" class="btn btn-primary">Save </button>

                    </div>
					
					
					
					 <div class=" col-md-6">
					      <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title"> Question Info</h3>
                            </div>
                            <div class="panel-body">
                        

						 
						 <div class="form-group">
                                <label>Question</label>
                                 <textarea class="form-control" rows="2" name="question" required><?php echo $question;?></textarea>		
								
                            </div>
					
					
					 <?php
					 
					 if($action =="add")
					 {
					 ?>
					
						 <div class="form-group">
                               <div id="multiplechoice"  class="questiontype">
							    <label>Multiple</label>
                                <div class="checkbox">
                                    <label>
                                        <input type="radio" value="1"    name="answer" > <input type="text" name="obj1" value="" >
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="radio" value="2"  name="answer" > <input type="text" name="obj2" value=""  >
                                    </label>
                                </div>
                                 <div class="checkbox">
                                    <label>
                                        <input type="radio" value="3"  name="answer" > <input type="text" name="obj3" value="" >
                                    </label>
                                </div>
								
								 <div class="checkbox">
                                    <label>
                                        <input type="radio" value="4"  name="answer" > <input type="text" name="obj4" value="" >
                                    </label>
                                </div>	


                              <p class="help-block">Select wright answer</p>								
								</div>
								
								
								<div id="trueflase"  class="questiontype" style="display:none;">
																
                                <label>True/False</label>
                                <select class="form-control"  name="turefalse" id="qtype">
								
								<option  value="True"  >True</option>
								<option  value="False" >False</option>
								
								
                                </select>
								
								 <p class="help-block">Select Wright Answer Either True or False</p>
								
								</div>
								
								
								<div id="oneword"  class="questiontype"  style="display:none;">
								<label>One Word</label>
								 <input type="text" name="oneword" value=""  >
								  <p class="help-block">Select wright word for answer</p>			
								</div>
								
								
                            </div>
							
					<?php
					}else
					{ // this code will use when edit action is perform
					?>
					       
					    <div class="form-group">
						 <?php
					 
					 if($type =="Multiple Choice")
					 {
					 ?>
                               <div id="multiplechoice"  class="questiontype">
							    <label>Multiple</label>
                                <div class="checkbox">
                                    <label>
                                        <input type="radio" value="1"    name="answer" <?php echo ($obj1==$answer)?'checked="checked"':'';?>> <input type="text" name="obj1" value="<?php echo $obj1; ?>">
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="radio" value="2" name="answer" <?php echo ($obj2==$answer)?'checked="checked"':'';?>> <input type="text" name="obj2" value="<?php echo $obj2; ?>"  >
                                    </label>
                                </div>
                                 <div class="checkbox">
                                    <label>
                                        <input type="radio" value="3" name="answer" <?php echo ($obj3==$answer)?'checked="checked"':'';?>> <input type="text" name="obj3" value="<?php echo $obj3; ?>">
                                    </label>
                                </div>
								
								 <div class="checkbox">
                                    <label>
                                        <input type="radio" value="4" name="answer" <?php echo ($obj4==$answer)?'checked="checked"':'';?>> <input type="text" name="obj4" value="<?php echo $obj4; ?>">
                                    </label>
                                </div>	

                                <p class="help-block">Select wright answer</p>											
								</div>
								<?php
								}else if($type =="True/False")
					                 {
								?>
								
								<div id="trueflase"  class="questiontype" >
																
                                <label>True/False</label>
                                <select class="form-control"  name="turefalse" id="qtype">
								
								<option  value="True" <?php echo ($turefalse=="True")?'selected="selected"':''; ?> >True </option>
								<option  value="False" <?php echo ($turefalse=="False")?'selected="selected"':''; ?> >False</option>
								
								
                                </select>
								
								 <p class="help-block">Select Wright Answer Either True or False</p>
								
								</div>
								
								<?php
								}else if($type =="One Word")
					                 {
								?>
								<div id="oneword"  class="questiontype" >
								<label>One Word</label>
								 <input type="text" name="obj2" value="<?php echo $oneword; ?>"  >
								  <p class="help-block">Select wright answer</p>			
								</div>
								<?php
								}
								?>
								
                            </div>
					<?php
					
					}
					
					?>
						
                            
                         

                        
						</div>
                        </div>
					
					</div>
                   
                </div>
				
				
				
				
				</form>
                <!-- /.row -->
              <?php
			  }else			  
			  {
			  ?>
			  
			   <link href="plugin/datatable/dataTables.bootstrap.css" rel="stylesheet" />
			  
			          <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                          Exam  Paper Mangament<small>  Questions</small>
						   <div class="pull-right">
                <a href="questions.php?action=add" class="btn btn-primary">Add</a>
				
              </div>
                        </h1>
                       
                    </div>
                </div>
                <!-- /.row -->
					
             <div class="row">
                 <div class="col-md-12">
			   
			  </div>
			  
			  </div>
			  <br/>
			  
			  <?php
						
				echo $errormsg;
				?>
			  
			   <div class="panel panel-primary">
                        <div class="panel-heading">
                            Exams             
                        </div>
                        <div class="panel-body">
                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Exam Name </th>
											<th>Question  </th>
											<th>Question Type </th>
											<th>Answer  </th>
                                            <th width="15%">Action</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
									
									<?php 
								
								$sql = $conn->query("select q.id as qid,papername,question,type,answer from questions as q ,paper as p where q.paper = p.id group by q.id");
								while($row = $sql->fetch_assoc())
								{
								
								
                                    echo '<tr>
                                       
                                        <td>'.$row['papername'].'</td>
										<td>'.$row['question'].'</td>
										<td>'.$row['type'].'</td>
										<td>'.$row['answer'].'</td>
										
										<td><a href="questions.php?action=edit&id='.$row['qid'].'" class="btn btn-primary btn-xs">Edit</a>  &nbsp; <a  onclick="return confirm(\'Are you sure you want to delete this record\');"  href="questions.php?action=delete&id='.$row['qid'].'" class="btn btn-danger btn-xs"  >Delete</a></td>
                                        
                                        </tr>';
								}
								?>
                                       
                                    </tbody>
                                </table>
                            
                           
                        </div>
                    </div>
			  
			     <script type='text/javascript' src='plugin/datatable/jquery.dataTables.js'></script>
	<script type='text/javascript' src='plugin/datatable/dataTables.bootstrap.js'></script>
	
	<script>
         $(document).ready(function () {
             $('#dataTables-example').dataTable();
         });
    </script>
			 
			  <?php
			  
			  }
			  
			  ?>
               

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
 </div>
   


</body>

</html>
 
