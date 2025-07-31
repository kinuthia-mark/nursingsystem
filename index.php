<?php
// session.php
include 'session.php';
include 'dbconnect.php';

?>
<!DOCTYPE html>
<html lang="en">
  <?php include 'head.php';  ?>
  <body class="app sidebar-mini">
    <?php include 'sidenav.php';  ?>    
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Nursing Database Management System </h1>        
        </div>       
      </div>
      <div class="row">
        <div class="col-md-6 col-lg-3">
          <div class="widget-small primary coloured-icon"><i class="icon fa fa-list fa-3x"></i>
            <div class="info">
              <h6>Registered Children</h6>
              
              <a href="master_list.php">
              <p><b>                
                
              </b></p>
              </a>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small info coloured-icon"><i class="icon fa fa-thumbs-o-up fa-3x"></i>
            <div class="info">
              <h6>Active Children</h6>
              <a href="#">
              <p><b>
              
                     
              </b></p>
                  </a>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small warning coloured-icon"><i class="icon fa fa-users fa-3x"></i>
            <div class="info">
              <h6>Conducted tests</h6>
              <a href='all_users.php'>
              <p><b>
              
              </b></p>
              </a>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small info coloured-icon"><i class="icon fa fa-users fa-3x"></i>
            <div class="info">
              <h6>Registered Users</h6>
              <a href='companyReg.php'>
              <p><b>
             

              </b></p>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        
      
      </div>
    </main>
    <!-- Essential javascripts for application to work-->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="js/plugins/pace.min.js"></script>
    <!-- Page specific javascripts-->
    <script type="text/javascript" src="js/plugins/chart.js"></script>
    <script type="text/javascript"></script>
    
  </body>
</html>