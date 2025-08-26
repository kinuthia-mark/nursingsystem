<?php
//session start 
include 'session.php'; // Ensure user is logged in
include 'dbconnect.php'; // include your database connection
?>

<!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="index.php" style="background-color:rgb(41, 129, 216); color: white; font-family:veltica; font-size:130%">N-DBMS</a>
     <a class="app-sidebar__toggle" style="background-color:rgb(41, 129, 216);" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
      <!-- Navbar Right Menu-->
      <ul class="app-nav" style="background-color:rgb(41, 129, 216); color: white;">
        <li class="app-search">
          <input class="app-search__input" type="search" placeholder="Search">
          <button class="app-search__button"><i class="fa fa-search"></i></button>
        </li>
    
        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu">
          <i class="fa fa-user fa-lg"></i>
        </a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
           <li><a class="dropdown-item" href="page-user.php"><i class="fa fa-user fa-lg"></i> User Profile</a></li>
           <li><a class="dropdown-item" href="users.php"><i class="fa fa-cog fa-lg"></i> Manage Users</a></li>
            <li><a class="dropdown-item" href="logout.php"><i class="fa fa-sign-out fa-lg"></i> Logout</a></li>
          </ul>
        </li>
      </ul>
    </header>

    <!-- Sidebar menu-->
    <aside class="app-sidebar" style="background-color:rgb(14, 30, 117); color: white;">
      <div class="app-sidebar__user">
        <img class="app-sidebar__user-avatar" src="images/user.png" width="20%" height="20%" alt="User Image">
        <div>
          <p class="app-sidebar__user-name">User:<?php echo $_SESSION["username"]; ?>
          </p>
          <p class="app-sidebar__user-designation">

  
            </p>
        </div>
      </div>

      <ul class="app-menu">
        <li><a class="app-menu__item active" href="index.php"><i class="app-menu__icon fa fa-dashboard">
          
        </i><span class="app-menu__label">Dashboard</span></a></li>

        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-plus"></i><span class="app-menu__label">Register Management</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">

            <li  ><a class="treeview-item" href="admissionformtp.php"><i class="icon fa fa-circle-o"></i> Children Register</a></li>
            <li  ><a class="treeview-item" href="add_drug.php"><i class="icon fa fa-circle-o"></i> add drug</a></li>
            <li  ><a class="treeview-item" href="add_vaccine.php"><i class="icon fa fa-circle-o"></i> add vaccine</a></li>
            <li  ><a class="treeview-item" href="arv_therapy.php"><i class="icon fa fa-circle-o"></i> add allergy</a></li>
            <li  ><a class="treeview-item" href="discharge_abstract.php"><i class="icon fa fa-circle-o"></i> discharge abstract</a></li>
            <li  ><a class="treeview-item" href="HIV_+ve_siblings.php"><i class="icon fa fa-circle-o"></i> HIV +ve siblings</a></li>
            <li  ><a class="treeview-item" href="hiv_test.php"><i class="icon fa fa-circle-o"></i> HIV test</a></li>
            <li  ><a class="treeview-item" href="laboratory.php"><i class="icon fa fa-circle-o"></i> laboratory</a></li>
            
            
            
          </ul>
        </li>       

           <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-list" ></i>

            <span class="app-menu__label">Master List</span><i class="treeview-indicator fa fa-angle-right"></i></a>
              <ul class="treeview-menu">
                <li ><a class="treeview-item" href="#"><i class="icon fa fa-circle-o"></i>Registered Children</a></li>   
                <li ><a class="treeview-item" href="#"><i class="icon fa fa-circle-o"></i>ARTS</a></li>          
              </ul>
           </li>    

        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Reports</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="medical_progress_report.php"><i class="icon fa fa-users"></i>medical progress report</a></li>
            <li><a class="treeview-item" href=""><i class="icon fa fa-gear"></i>Report 2</a></li>           
          </ul>
        </li> 


        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-wrench"></i><span class="app-menu__label">Settings</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
              <li><a class="treeview-item" href="user_register.php"><i class="icon fa fa-circle-o"></i>Company Registration</a></li>
              <li><a class="treeview-item" href="#"><i class="icon fa fa-circle-o"></i>Client's Admin Register</a></li>        
            </ul>
        </li>
      </ul>
    </aside>

