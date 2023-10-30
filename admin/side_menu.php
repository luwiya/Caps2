 <div class="sidebar">
    <div class="logo_details">
      <div class="logo_name">Admin</div>
      <i class="bx bx-menu" id="btn"></i>
    </div>
    <ul class="nav-list">
      <li>
        <a href="Dashboard.php">
          <i class="bx bx-grid-alt"></i>
          <span class="link_name">Dashboard</span>
        </a>
        <span class="tooltip">Dashboard</span>
      </li>
      <li>
         <a href="settings.php?id=<?php echo $_SESSION['user_data']['id']; ?>">
          <i class="bx bx-user-circle"></i>
          <span class="link_name">My Profile</span>
        </a>
        <span class="tooltip">My Profile</span>
      </li>
      <li>
          <a href="account.php">
            <i class="bx bx-group"></i>
            <span class="link_name">Accounts</span>
          </a>
          <span class="tooltip">Accounts</span>
        </li>
       <li>
          <a href="RegisteredUserAdmin.php">
            <i class="bx bxs-user-detail"></i>
            <span class="link_name">Registered Accounts</span>
          </a>
          <span class="tooltip">Registered Accounts</span>
      </li>
      <li>
        <a href="medicinerecords.php">
          <i class="bx bx-plus-medical"></i>
          <span class="link_name">Medicine Records</span>
        </a>
        <span class="tooltip">Medicine Records</span>
      </li>
     
      <li>
        <a href="records.php">
          <i class="bx bx-folder"></i>
          <span class="link_name">Resident Records</span>
        </a>
        <span class="tooltip">Records</span>
      </li>
     
      <li class="profile">
          <div class="profile_details">
          <img src = "../photo/<?php echo $_SESSION['user_data']['photo']?>"/>
          <div class="profile_content">
          <div class="name"><?php echo $_SESSION['user_data']['fname']; ?></div>
        </div>
          </div>
          <a href="../logout.php" id="log_out">
          <i class="bx bx-log-out" style="display: block; margin: 0 auto;"></i>
      </a>
      </li>
    </ul>
  </div>