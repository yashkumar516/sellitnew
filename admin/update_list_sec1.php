<!-- header and slider start -->
<?php include 'includes/header.php' ?>
 <?php include 'includes/sidebar.php' ?>
<!-- header and slider end  -->  
		  <?php
				$vid = $_REQUEST['id'];
				// update start
				if(isset($_POST['product']))
				{
					$category = $_POST['category'];
					$subcategory = $_POST['subcategory'];
					$childcategory = $_POST['childcategory'];
					$productid = $_POST['product'];
					$description = $_POST['Description'];
					$video = str_replace(" ","_",$_FILES['productvideo']['name']);

					if($video == null)
					{
						move_uploaded_file($_FILES['productvideo']['tmp_name'], "video/".str_replace(" ","_",$_FILES['productvideo']['name']));
						$query = mysqli_query($con,"UPDATE `product_detail1` SET `categoryid`='$category',`subcategoryid`='$subcategory',`childcatid`='$childcategory',
						`product_id`='$productid',`desc`='$description' WHERE `id` = '$vid' ");
						if($query)
						{
							echo "<script> alert('insert successfully');
							window.location.href  = 'list_sec1.php';
							</script>";
						}
						else
						{
							echo "<script> alert('insert not successfully');
							window.location.href  = 'list_sec1.php';
							
							</script>";	
						}
					}
                    else{
					move_uploaded_file($_FILES['productvideo']['tmp_name'], "video/".str_replace(" ","_",$_FILES['productvideo']['name']));
				    $query = mysqli_query($con,"UPDATE `product_detail1` SET `categoryid`='$category',`subcategoryid`='$subcategory',`childcatid`='$childcategory',
					`product_id`='$productid',`desc`='$description',`video`='$video' WHERE `id` = '$vid' ");
					if($query)
					{
						echo "<script> alert('insert successfully');
						window.location.href  = 'list_sec1.php';
						</script>";
					}
					else
					{
						echo "<script> alert('insert not successfully');
						window.location.href  = 'list_sec1.php';
						
						</script>";	
					}
				}
				
				}
		  ?>
				<section role="main" class="content-body content-body-modern mt-0">
					<header class="page-header page-header-left-inline-breadcrumb">
						<h2 class="font-weight-bold text-6">Product Details</h2>
						<div class="right-wrapper">
							<ol class="breadcrumbs">
								<li><span>Home</span></li>
								<li><span>eCommerce</span></li>
								<li><span>Categories</span></li>
							</ol>
                             <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fas fa-chevron-left"></i></a>
						</div>
					</header>

					<!-- start: page -->
					<form  action="" method="post" enctype="multipart/form-data">
					<?php
	                    $videodetail = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM `product_detail1` WHERE `id` = '$vid'"));
						$cid = $videodetail['categoryid'];
						$catname = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM `category` WHERE `id` = '$cid' "));
						$sid = $videodetail['subcategoryid'];
						$subcatname = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM `subcategory` WHERE `id` = '$sid' "));
						$chid = $videodetail['childcatid'];
						$childcatname = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM `childcategory` WHERE `id` = '$chid' "));
						$pid = $videodetail['product_id'];
						$productname = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM `product` WHERE `id` = '$chid' "));
					?>
						<div class="row">
							<div class="col">
								<section class="card card-modern card-big-info">
									<div class="card-body">
										<div class="row">
										
											<div class="col-lg-2-5 col-xl-1-5">
												<i class="card-big-info-icon bx bx-camera"></i>
												<h2 class="card-big-info-title">Product Detail Video</h2>
												<p class="card-big-info-desc">Upload your Product video</p>
											</div>
											<div class="col-lg-3-5 col-xl-4-5">
												<div class="form-group row align-items-center">
													<div class="col">

													<div class="form-group row align-items-center">
													<label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Select Category</label>
													<div class="col-lg-7 col-xl-6">
										
														<select name="category" id="category" class="form-control form-control-modern" onchange="callsubcat()"  required>
															<option value="<?php echo $cid ?>" selected><?php echo $catname['category_name'] ?></option>
															 <!-- fetch category start -->
															 <?php
                                                              $category = mysqli_query($con,"SELECT * FROM `category` WHERE `status` = 'active' ");
                                                               while($array = mysqli_fetch_assoc($category))
                                                               {   
                                                                 ?>
                                                                 <option value="<?php echo $array['id'] ?>"><?php echo $array['category_name'] ?></option>
                                                                 <?php
                                                               }
                                                           ?>
                                                           <!-- fetch category end -->
														</select>
													</div>
												</div>

												<div class="form-group row align-items-center">
													<label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Select Subcategory</label>
													<div class="col-lg-7 col-xl-6">
														<select name="subcategory" id="subcategory" class="form-control form-control-modern"  onchange="callchildcat()" >
															<option value="<?php echo $sid ?>" selected><?php echo $subcatname['subcategory_name'] ?></option>
															<?php
															  $subquery = mysqli_query($con,"SELECT * FROM `subcategory` WHERE `status` = 'active' ");
															  while($arrsub = mysqli_fetch_assoc($subquery))
															  {
																  ?>
                                                                   <option value="<?php echo $arrsub['id'] ?>"><?php echo $arrsub['subcategory_name'] ?></option>
 																  <?php
															  }
															?>
														</select>
													</div>
												</div>

												<div class="form-group row align-items-center">
													<label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Select Child category</label>
													<div class="col-lg-7 col-xl-6">
														<select name="childcategory" id="childcategory" class="form-control form-control-modern">
															<option value="<?php echo $chid ?>" selected><?php echo $childcatname['childcategory'] ?></option>
															<?php
															  $childquery = mysqli_query($con,"SELECT * FROM `childcategory` WHERE `status` = 'active' ");
															  while($arrchild = mysqli_fetch_assoc($childquery))
															  {
																  ?>
                                                                   <option value="<?php echo $arrchild['id'] ?>"><?php echo $arrchild['childcategory'] ?></option>
 																  <?php
															  }
															?>
														</select>
													</div>
												</div>

												<div class="form-group row align-items-center">
													<label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0">Select Product</label>
													<div class="col-lg-7 col-xl-6">
														<select name="product" id="product" class="form-control form-control-modern" required>
														<option value="<?php echo $pid ?>" selected><?php echo $productname['product_name'] ?></option>
															<?php
															  $selectproduct = mysqli_query($con,"SELECT * FROM `product` WHERE `status` = 'active' ");
															  while($arrproduct = mysqli_fetch_assoc($selectproduct))
															  {
																  ?>
                                                                   <option value="<?php echo $arrproduct['id'] ?>"><?php echo $arrproduct['product_name'] ?></option>
 																  <?php
															  }
															?>
														</select>
													</div>
												</div>

												<div class="form-group row align-items-center">
												    
													<label class="col-lg-5 col-xl-3 control-label text-lg-right mb-0"> video(1722*739 px)</label>
													<div class="col-lg-7 col-xl-6">
													<video width="150" height="100">
                                                        <source src="video/<?php echo $videodetail['video'] ?>" type="video/mp4">
                                                        <source src="video/<?php echo $videodetail['video'] ?>" type="video/ogg">
                                                      </video>
														<input type="file" class="form-control form-control-modern" name="productvideo" value="" />
													</div>
												</div>
 
													</div>
												</div>
											</div>
										</div>
									</div>
								</section>
							</div>
						</div>
						 <div class="row">
							<div class="col">
								<section class="card card-modern card-big-info">
									<div class="card-body">
										<div class="row">
											<div class="col-lg-2-5 col-xl-1-5">
												<i class="card-big-info-icon bx bx-slider"></i>
												<h2 class="card-big-info-title">Product Details</h2>
												<p class="card-big-info-desc">Add here the category description with all details and necessary information.</p>
											</div>
											<div class="col-lg-3-5 col-xl-4-5">
								
												<div class="form-group row">
													<label class="col-lg-5 col-xl-3 control-label text-lg-right pt-2 mt-1 mb-0">Description</label>
													<div class="col-lg-7 col-xl-6">
														<textarea class="form-control form-control-modern" name="Description" rows="6"><?php echo $videodetail['desc'] ?></textarea>
													</div>
												</div>
											</div>
										</div>
									</div>
								</section>
							</div>
						</div>
						<div class="row action-buttons">
							<div class="col-12 col-md-auto">
								<button type="submit" name="submit" class="submit-button btn btn-primary btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1" data-loading-text="Loading...">
									<i class="bx bx-save text-4 mr-2"></i> Save Product Detail
								</button>
							</div>
							<div class="col-12 col-md-auto px-md-0 mt-3 mt-md-0">
								<a href="#" class="cancel-button btn btn-light btn-px-4 py-3 border font-weight-semibold text-color-dark text-3">Cancel</a>
							</div>
							<!-- <div class="col-12 col-md-auto ml-md-auto mt-3 mt-md-0">
								<a href="#" class="delete-button btn btn-danger btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1">
									<i class="bx bx-trash text-4 mr-2"></i> Delete Product Detail
								</a>
							</div> -->
						</div>
					</form>
					<!-- end: page -->
				</section>
			</div>

			<aside id="sidebar-right" class="sidebar-right">
				<div class="nano">
					<div class="nano-content">
						<a href="#" class="mobile-close d-md-none">
							Collapse <i class="fas fa-chevron-right"></i>
						</a>
			
						<div class="sidebar-right-wrapper">
			
							<div class="sidebar-widget widget-calendar">
								<h6>Upcoming Tasks</h6>
								<div data-plugin-datepicker data-plugin-skin="dark"></div>
			
								<ul>
									<li>
										<time datetime="2017-04-19T00:00+00:00">04/19/2017</time>
										<span>Company Meeting</span>
									</li>
								</ul>
							</div>
			
							<div class="sidebar-widget widget-friends">
								<h6>Friends</h6>
								<ul>
									<li class="status-online">
										<figure class="profile-picture">
											<img src="img/%21sample-user.jpg" alt="Joseph Doe" class="rounded-circle">
										</figure>
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
									<li class="status-online">
										<figure class="profile-picture">
											<img src="img/%21sample-user.jpg" alt="Joseph Doe" class="rounded-circle">
										</figure>
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
									<li class="status-offline">
										<figure class="profile-picture">
											<img src="img/%21sample-user.jpg" alt="Joseph Doe" class="rounded-circle">
										</figure>
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
									<li class="status-offline">
										<figure class="profile-picture">
											<img src="img/%21sample-user.jpg" alt="Joseph Doe" class="rounded-circle">
										</figure>
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
								</ul>
							</div>
			
						</div>
					</div>
				</div>
			</aside>

		</section>

		<!-- Vendor -->
		<script src="vendor/jquery/jquery.js"></script>		<script src="vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>		<script src="vendor/jquery-cookie/jquery.cookie.js"></script>		<script src="master/style-switcher/style.switcher.js"></script>		<script src="vendor/popper/umd/popper.min.js"></script>		<script src="vendor/bootstrap/js/bootstrap.js"></script>		<script src="vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>		<script src="vendor/common/common.js"></script>		<script src="vendor/nanoscroller/nanoscroller.js"></script>		<script src="vendor/magnific-popup/jquery.magnific-popup.js"></script>		<script src="vendor/jquery-placeholder/jquery.placeholder.js"></script>
		
		<!-- Specific Page Vendor -->		<script src="vendor/jquery-validation/jquery.validate.js"></script>		<script src="vendor/dropzone/dropzone.js"></script>		<script src="vendor/pnotify/pnotify.custom.js"></script>


		<!--(remove-empty-lines-end)-->
		
		<!-- Theme Base, Components and Settings -->
		<script src="js/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="js/custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="js/theme.init.js"></script>
		<!-- Analytics to Track Preview Website -->		<script>		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)		  })(window,document,'script','../../../www.google-analytics.com/analytics.js','ga');		  ga('create', 'UA-42715764-8', 'auto');		  ga('send', 'pageview');		</script>
		<!-- Examples -->
		<script src="js/examples/examples.header.menu.js"></script>
		<script src="js/examples/examples.ecommerce.form.js"></script>

	</body>
</html>

<script>
 CKEDITOR.replace('Description');
</script>

<!-- js start here -->
<script>
 function	callsubcat(){
		 var id = $('#category').val();
		if(id != null)
		{
			$.ajax({
				  method: "post",
				  url : "subdajax.php",
				  data:{cid:id},
				  dataType: "html",
				  success:function(result)
				  {
					  $('#subcategory').html(result);
				  }
			});
		}
	}
</script>

<script>
 function	callchildcat(){
		 var id = $('#subcategory').val();
		if(id != null)
		{
			$.ajax({
				  method: "post",
				  url : "childajax.php",
				  data:{sid:id},
				  dataType: "html",
				  success:function(result)
				  {
					  $('#childcategory').html(result);
				  }
			});
		}
	}
</script>
<script>
 $(document).ready(function(){
 $('#childcategory').on('change',function(){
   var cid=$(this).val();
   $.ajax({
       method:"POST",
       url:"ajaxproduct.php",
       data:{id:cid},
       dataType:"html",
       success:function(data){
         $('#product').html(data);
       }
   });
 });
 });
 </script>
<!-- js end here -->