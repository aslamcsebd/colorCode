
<?php 
   session_start();
   $conn =mysqli_connect('localhost','root','','color');   

   // Login
   if (isset($_POST['loginNow'])) {

      $email      = $_POST['email'];
      $password   = $_POST['password'];
      $sql="select * from admin where email='$email' AND password='$password'";

      $result2=mysqli_query($conn,$sql);

      $rowcount=mysqli_num_rows($result2);

      if ($rowcount==1) {
         $_SESSION['adminLogin']=true;
      }
   }

   // Add color
   if (isset($_POST['colorAdd'])) {
      $colorName = $_POST['colorName'];      
      $sql="select * from color where colorName='$colorName'";
      $result3=mysqli_query($conn,$sql);
      $rowcount=mysqli_num_rows($result3);

      if ($rowcount) {
         $_SESSION['Color Status']='Sorry! This already insert...';

      }else{

         $sql="insert into color values(null, '$colorName')";
         $result3=mysqli_query($conn,$sql);

         if ($result3) {
            $_SESSION['Color Status']='Color code insert successfully';
         }
      }
   }

   // Logout
   if (isset($_POST['logout'])) {
      unset($_SESSION['adminLogin']);
   }

   // All Color Display
   $sql = "select * from color order by id desc";
   $allColor = mysqli_query($conn, $sql);

?>


<!DOCTYPE html>
<html>
   <head>
   	<title>Favorite Color</title>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- <meta http-equiv="refresh" content="5" /> -->
      <link rel="stylesheet" href="assets/css/dataTables.min.css">
      <link rel="stylesheet" href="assets/css/bootstrap.css">
      <link rel="stylesheet" href="assets/css/style.css">
   </head>

   <body>
     
      <nav class="navbar navbar-expand-lg">
         <div class="container">

            <a class="navbar-brand" href="index.php">My Color</a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
               <ul class="navbar-nav ml-auto">

                  <?php if (!isset($_SESSION['adminLogin']) && !isset($_POST['login'])) { ?>
                     <form action="" method="post">
                        <li class="nav-item active">
                           <button class="btn btn-sm btn-success" name="login">Login</button>
                        </li>
                     </form>
                  <?php } ?>

                  <?php if (isset($_SESSION['adminLogin'])) { ?>
                     <form action="" method="post">
                        <li class="nav-item active">
                           <button class="px-5 btn btn-sm btn-danger" name="logout">Logout</button>
                        </li>
                     </form>
                  <?php } ?>

               </ul>
            </div>

         </div>
      </nav>

   	<div class="container">
         
         <div class="row justify-content-center mt-2">
            <div class="col-12 col-lg-6 col-md-4 col-sm-6 col-sm-12 mt-2 mb-2">
               <?php if (isset($_POST['login'])) { ?>
                  <form action=" " method="post" >                          
                     <div class="row justify-content-center" class="border">
                        <div class="col-4">
                           <input type="email" name="email" class="form-control" placeholder="Email">
                        </div>  
                        <div class="col-4">
                           <input type="password" name="password" class="form-control" placeholder="Password">
                        </div>                    
                        <div class="col-4">
                           <button class="btn btn-sm btn-primary px-4" name="loginNow">Submit</button>
                        </div> 
                     </div>
                  </form>
               <?php } ?>
            </div>
         </div>

         <div class="row justify-content-center mt-4">
            <div class="col-12 col-lg-6 col-md-4 col-sm-6 col-sm-12 mt-2 mb-2">
               <?php if (isset($_SESSION['adminLogin'])) { ?>

                  <form action=" " method="post" >                          
                     <div class="row justify-content-center" class="border">
                        <div class="col-6">
                           <input type="text" name="colorName" class="form-control" placeholder="Color Name or Code">
                        </div>  
                        <div class="col-4">
                           <button class="btn btn-sm btn-primary px-4" name="colorAdd">Add</button>
                        </div> 
                     </div>
                  </form>

               <?php } ?>
            </div>
         </div>

         <div class="row justify-content-center">
      		<div class="col-12 col-lg-8 col-md-4 col-sm-6 col-sm-12 mt-2 mb-2">

               <?php if(isset($_SESSION['Color Status'])) { ?>
                  <div class="alert alert-success">
                     <!-- <strong>Success!</strong> Added successfully. -->
                     <strong><?= $_SESSION['Color Status']; ?></strong>
                  </div>
               <?php } ?>

               <table id="table" class="table table-bordered text-center">
                  <thead class="thead-dark">
                     <tr>
                        <th>ID</th>
                        <th>Color : Name</th>
                        <?php if (isset($_SESSION['adminLogin'])) { ?>
                            <th>Action</th>
                        <?php } ?>
                     </tr>
                  </thead>
                  <tbody>                 
            			<?php while ($colorCode = mysqli_fetch_assoc($allColor)) { ?>
            				<tr>
                           <td><?= $colorCode['id']; ?></td>
                           <td width="90%">
                              <div class="center-block" style="background-color: <?= $colorCode['colorName']; ?>;">
                                 <button class="btn btn-sm btn-warning copyNow mt-2 mr-2" data-clipboard-target="#copy<?= $colorCode['id']; ?>" onclick="copy(this); copy2(this);">Copy</button>
               						<h4 class="colorName" id="copy<?= $colorCode['id']; ?>"><?= $colorCode['colorName']; ?></h4>
               					</div>
                           </td>

                           <?php if (isset($_SESSION['adminLogin'])) { ?>
                              <td width="10%">
                                 <a class="btn btn-sm btn-info" href="delete.php?id=<?php echo $colorCode['id']; ?>">Delete</a>
                            </td>
                           <?php } ?>
                        </tr>   
            			<?php } ?>                  
                 </tbody>
               </table>
      		</div>
         </div>
   	</div>

      <!-- All js -->
      <script type="text/javascript" src="assets/js/jquery-3.4.1.min.js"></script>
      <script type="text/javascript" src="assets/js/dataTables.min.js"></script>
      <script type="text/javascript" src="assets/js/clipboard.min.js"></script> 
      <script type="text/javascript" src="assets/js/bootstrap.js"></script>

      <script type="text/javascript">
         $(document).ready( function () {
            $('.table').DataTable();
         } );

         $('.table').DataTable({
            "lengthMenu": [ [6, 10, 25, 50, -1], [6, 10, 25, 50, "All"] ]
         });  

         var table = $('.table').DataTable();
         table
             .order( [ 0, 'desc' ] ) 
             .draw();       
      </script>

      <script type="text/javascript">
         var clipboard = new ClipboardJS('.copyNow');
         clipboard.on('success', function(e) {
             console.info('Action:', e.action);
             console.info('Text:', e.text);
             console.info('Trigger:', e.trigger);
             e.clearSelection();
         });
         clipboard.on('error', function(e) {
             console.error('Action:', e.action);
             console.error('Trigger:', e.trigger);
         });
      </script>

      <script>
         function copy2(obj) {
            obj.style.backgroundColor = "blue";
            obj.style.color = "#fff";
            obj.innerHTML = "Copied";
            // Manual table row background change
            // document.getElementById("copy").style.backgroundColor = "blue";
         }
         $('.table tr').click(function () {
            // Dynamic table row background change            
            // $(this).css('background-color', "#D6D5C3");
         });
         let copy = function(){
            // document.getElementById("audio").play()
         }
      </script>
      
   </body>
</html>


<!-- All php code -->
<?php unset($_SESSION['Color Status']); ?>

