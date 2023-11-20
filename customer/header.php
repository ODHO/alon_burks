<?php
// session_start();
include 'connection.php';
?>

<header class="navigation fixed-top">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="index.php"><img src="images/logo.png" alt="Egen"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
                aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse text-center" id="navigation">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home</a>
                </li>

                <?php
                //echo $_SESSION["user_id"].'_2';
                if (isset($_SESSION['user_id'])) {
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="notifications.php">Notifications</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="myhirings.php">My Hirings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="myoffers.php">My Offers</a>
                </li>
                <?php
                   if (isset($_SESSION['user_id']) && $_SESSION['user_type'] == 'customer') {
                    $userId = $_SESSION['user_id'];
                    $userDataQuery = "SELECT fullname, city, phone, email, profile_picture, zipcode, address, country, region FROM provider_registration WHERE id = $userId";
                    $result = $conn->query($userDataQuery);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $fullname = $row['fullname'];
                        $_SESSION['customerFullName'] = $row['fullname'];
                        $email = $row['email'];
                        $city = $row['city'];
                        $zipcode = $row['zipcode'];
                        $region = $row['region'];
                        $phone = $row['phone'];
                        $address = $row['address'];
                        $country = $row['country'];
                        $profileImage = $row['profile_picture'];
                            ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="./<?php echo $profileImage; ?>" alt="User Profile Picture" class="profile-picture">
                                </a>
                                <div class="dropdown-menu" aria-labelledby="profileDropdown">
                                <a class="dropdown-item" href="profilesetting.php">Profile</a>
                                    <a class="dropdown-item" href="dashboard.php">Dashboard</a>
                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                       data-target="#logoutModal">Logout</a>
                                </div>
                            </li>
                            <?php
                        } else {
                            echo "User Not Found";
                        }
                    }
                ?>
                <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog"
                     aria-labelledby="logoutModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to log out?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <a href="../logout.php" class="btn btn-primary">Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                } else {
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="services.php">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="notifications.php">Notifications</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="myhirings.php">My Hirings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="provider.php">Provider</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../signin.php">Sign In</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Signup.php" target="_blank">Sign Up</a>
                </li>
                <?php
                }
                ?>
            </ul>
        </div>
    </nav>
</header>
