<?php include "session.php"; ?>	
<?php include "header.php"; ?>
<?php include "navbar.php"; ?>	
<?php include "scripts.php"; ?>
<h1 align="center">Welcome to Answers Kart</h1>
<div class="container">
<?php
 
 if ($useradmin==1){
 	?>
 	<div class="row">
 	<br>
 	</div>
 	<div class="row">
 	  <div class="col-md-2">
  <form action="main_home.php" method="post">
    <button type="submit" class="btn btn-danger">Top Questions</button>
  </form>
  </div>
<div class="col-md-2">
 <form action="questions_panel.php" method="post">
 <button type="submit" class="btn btn-success">Questions Panel</button>
 </form>
 </div>
 <div class="col-md-2">
  <form action="users_page.php?page=1" method="post">
  <button type="submit" class="btn btn-info">Users Panel</button>
  </form>
  </div>

 
</div>



 	<?php


 }
?>
	<div class="row">
		<div class="col-md-12">
			<h2>Unanswered Questions</h2><hr/>
			<?php 
				$query = "SELECT title,admin,questions_table.created_at,questions_table.question_id from questions_table LEFT JOIN answers_table ON questions_table.question_id=answers_table.question_id JOIN login_details ON login_details.user_id=questions_table.user_id WHERE questions_table.question_id NOT IN (SELECT question_id from answers_table)";
				$result = mysqli_query($connection,$query) or die("Failed to query database".mysql_error());
				$count=$result->num_rows;
				$totalpages=ceil($count/5);	
				// echo $totalpages;
					if ($totalpages==0){
						$totalpages=1;
					}
					if (!isset($_GET['page'])){
						$_GET['page']=0;
					}
					else{
						$_GET['page']=(int)$_GET['page'];
					}

					if($_GET['page']<1){
						$_GET['page']=1;
					}
					elseif ($_GET['page'] > $totalpages) {
						$_GET['page']=$totalpages;
					}

				$startArticle = ($_GET['page'] - 1) * 5;
				$pagination="SELECT questions_table.user_id as quser,title,tags,admin,emailid,checkgit,questions_table.created_at,questions_table.question_id from questions_table LEFT JOIN answers_table ON questions_table.question_id=answers_table.question_id JOIN login_details ON login_details.user_id=questions_table.user_id WHERE questions_table.question_id NOT IN (SELECT question_id from answers_table) limit ".$startArticle.','.'5';
				$page_result = mysqli_query($connection,$pagination) or die ("Failed to query database".mysql_error());







				while ($row = mysqli_fetch_array($page_result,MYSQLI_ASSOC)) { 
					$question_id=htmlentities($row['question_id']);
			?>
			<div class="row">
				<div class="col-md-8">
					<h3><p><a href='single_question.php?ques_id=<?php echo $question_id;?>&page=1'><?php echo htmlentities($row['title']);?></a></p></h3>
					<h4>Tags:
				 <?php
					$onetag=explode(" ",$row['tags']);
					foreach ($onetag as $value) {?>
						<a href="tagspage.php?name=<?php echo $value;?>">
						<?php
					 echo "$value";?> </a><?php
					}
						///echo $row['tags']."<br />";
				?>


				</h4>
				</div>
				<div class="col-md-4">
							<p>
								<a href="ProfilePage.php?name=<?php echo trim($row['admin']);?>&page=1">
									<?php
              
              if($row["checkgit"]==1)
              { 
                echo "<img width='25' height='25' alt='abc' src='https://github.com/".$row['admin'].".png' />";
                
              }
              else
              {
                $grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $row['emailid'] ) ) ) . "?d=" . urlencode( 'https://s24.postimg.org/a4bwqzpgl/default.png' );
              $source = "./images/".$row['admin'];
              $source = trim($source);
              if(file_exists($source))
              { 
                 ?>
                  <img width='25' height='25' alt='abc' src='./images/<?php echo $row['admin']; ?>' />
                <?php
              }
              else
              {
                 ?>
                  <img width='25' height='25' alt='abc' src='<?php echo $grav_url; ?>' / >
                <?php
              }
              }
              ?>
								</a>
								<b><?php echo "Asked by ";?><a href="ProfilePage.php?name=<?php echo trim($row['admin']);?>&page=1"> <?php echo htmlentities($row['admin']) ?></a>
									<?php 
										echo '(',scores($row['quser']),')'," on ".htmlentities($row['created_at'])."<br />"?> 
								</b>
							</p>
				</div>
				<div class="col-md-12">
				<div class="row"><hr/></div>
				</div>
			</div>
				<?php }

					?> 
					<center><ul class="pagination">
					<?php
					foreach (range(1,$totalpages) as $page){
						// echo $page;
						// echo "hi";
						if($page == $_GET['page']){
        					echo '<li><a class="active"><span class="currentpage">' . $page . '</span></a></li>';
        					// echo  "current";
    					}else if($page ==1 || $page ==$totalpages ||($page >= $_GET['page'] -2 && $page <= $_GET['page']+2)){
							 echo '<li><a href="?page=' . $page . '">' . $page . '</a></li>'; 
						}
					}
				?>
<?php include "footer.php"; ?>
		</div>
	</div>
</div>