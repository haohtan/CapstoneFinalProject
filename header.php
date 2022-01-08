<div class="header_bg">
        <div>
            <a class="logo" href="index.php">
                <img src="https://cgi.luddy.indiana.edu/~team41/team-41/imgs/logo.png" alt="logo" style="display:block; height:100px;">
            </a>
        </div>
        <div class="header_nav">

            <div class="header_nav_item" >

                <a href="favorite.php" >Favorite</a>

            </div>
            <div class="header_nav_item">

                <a href="plan.php">Plan</a>

            </div>
            <div class="header_nav_item">

                <a href="community.php">Community</a>

            </div>
        </div>
        <div class="header_user">
            <div class="header_user_item">

                <a class="" href="#" id="">
                    <!-- user attar-->
                    <img class="attar" src="<?php if (!isset($_SESSION["avatarUrl"])) echo "https://cgi.luddy.indiana.edu/~team41/team-41/imgs/default-avatar.png";
                                                    else echo $_SESSION["avatarUrl"]; ?>" ><?php if (!isset($_SESSION['user_first'])) echo "Name"; else echo $_SESSION['user_first']; ?>
                </a>

            </div>

            <div class = "header_dropdown">
                <div class="header_user_item">
                    <a href="profile.php">Profile</a>

                </div>
                <div class="header_user_item">
                    <a href="logout.php">Sign Out</a>
                </div>
            </div>
        </div>

    </div>