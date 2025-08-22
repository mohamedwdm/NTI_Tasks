<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar w/ text</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Pricing</a>
                </li>
            </ul>
            <?php if (!isset($_SESSION['auth_user'])) { ?>
                <div class="actions">
                    <a class="link-primary mx-3" href="login.php">Login</a>
                </div>
            <?php } else { ?>
                <div class="user-info">
                    <span class="navbar-text mx-3">
                        Hi, <strong><?= $_SESSION['auth_user']['name'] ?></strong>
                    </span>
                    <!-- <a class="btn btn-danger mx-3" href="logout.php">Logout</a> --> 
                    <form class="d-inline" action="logout.php" method="post">
                        <button class="btn btn-danger me-3" type="submit">Logout</button>
                    </form>
                </div>
                
            <?php } ?>
        </div>
    </div>
</nav>