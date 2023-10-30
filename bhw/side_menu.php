
  <div class="sidebar">
    <div class="logo_details">
      <div class="logo_name">Barangay Health Worker</div>
      <i class="bx bx-menu" id="btn"></i>
    </div>
    <ul class="nav-list">
      <li>
        <a href="homemedd.php">
          <i class="bx bx-grid-alt"></i>
          <span class="link_name">Dashboard</span>
        </a>
        <span class="tooltip">Dashboard</span>
      </li>
      <li>
      <a href="settings.php?id=<?php echo $_SESSION['user_data']['id']; ?>">
          <i class="bx bx-user"></i>
          <span class="link_name">My Profile</span>
        </a>
        <span class="tooltip">My Profile</span>
      </li>
      <li>
        <a href="announcement.php">
          <i class="bx bx-chat"></i>
          <span class="link_name">Anouncements</span>
        </a>
        <span class="tooltip">Anouncements</span>
      </li>
    
      <li>
        <a href="userRecMed.php">
          <i class="bx bx-folder"></i>
          <span class="link_name">Records</span>
        </a>
        <span class="tooltip">Records</span>
      </li>
      <li>
        <a href="medicinee.php">
          <i class="bx bx-plus-medical"></i>
          <span class="link_name">Medicine</span>
        </a>
        <span class="tooltip">Medicine</span>
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
    