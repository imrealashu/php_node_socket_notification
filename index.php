<?php
include_once( dirname( __FILE__ ) . '/class/Database.class.php' );
include_once( dirname( __FILE__ ) . '/class/HelperClass.php' );

$pdo = Database::getInstance()->getPdoObject();
$helper = new HelperClass();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>VegFru | Notification</title>

    <!-- Bootstrap core CSS -->

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">
    <link href="css/pnotify.custom.min.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="css/custom.css" rel="stylesheet">
    <script src="js/jquery.min.js"></script>

</head>


<body class="nav-md">

    <div class="container body">


        <div class="main_container">

            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">

                    <div class="navbar nav_title" style="border: 0;">
                        <a href="index.php" class="site_title"><i class="fa fa-paw"></i> <span>VegFru</span></a>
                    </div>
                    <div class="clearfix"></div>

                    <!-- menu prile quick info -->
                    <div class="profile">
                        <div class="profile_pic">
                            <img src="images/img.jpg" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2>Ashish Singh</h2>
                        </div>
                    </div>
                    <!-- /menu prile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                        <div class="menu_section">
                            <ul class="nav side-menu">
                                <li><a href="#">Push Notification <i class="fa fa-dashboard pull-right"></i></a></li>
                                <li>
                                    <form action="ajax/insertNewMessage.php" id="notification">
                                        <div class="form-group" style="margin-left: 16px; width: 83%">
                                            <input type="checkbox" onclick="client.gerateRandomNotification(this)"/>
                                            <label class="control-label" for="notification-input">Generate Random</label>
                                        </div>
                                        <div class="form-group" style="margin-left: 16px; width: 83%">
                                            <label class="control-label" for="notification-input">Notification Message</label>
                                            <input type="text" id="notification-input" class="form-control" placeholder="Notification Message"><br/>
                                        </div>
                                        <button type="submit" class="btn btn-success" style="margin-left: 16px;">Send Push Notification</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- /sidebar menu -->
                </div>
            </div>
            <!-- top navigation -->
            <div class="top_nav">

                <div class="nav_menu">
                    <nav class="" role="navigation">
<!--                         <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>
 -->
                        <ul class="nav navbar-nav navbar-right">
                            <li class="">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <img src="images/img.jpg" alt="">Ashish Singh
                                </a>
                            </li>
                            <li role="presentation" class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-envelope-o"></i>
                                    <span class="badge bg-green"></span>
                                </a>
                            </li>
                            <li role="presentation" class="dropdown">
                                <?php
                                $query = $pdo->prepare( 'SELECT * FROM notification WHERE status = 0 ORDER BY id DESC' );
                                $query->execute();

                                $notifications = $query->fetchAll( PDO::FETCH_OBJ );
                                ?>
                                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-bell-o"></i>
                                    <span class="badge bg-green"><?= count($notifications) > 0 ? count($notifications): '' ?></span>
                                </a>
                                <ul class="dropdown-menu list-unstyled msg_list animated fadeInDown" style="right: -120px !important; border-top-left-radius: 7px; border-top-right-radius: 7px; margin-top: 10px;" role="menu">
                                    <li style="background-color: white">
                                        <div class="text-center">
                                            <a>
                                                <strong><a href="inbox.html">Notification (<?= count($notifications) ?>)</strong>

                                            </a>
                                        </div>
                                    </li>
                                    <div id="notifications-container">
                                        <?php foreach( $notifications as $notification):?>
                                            <li data-id="<?= $notification->id ?>" onclick="client.openNotification(this)">
                                                <a>
                                            <span class="image">
                                        <img src="images/img.jpg" alt="Profile Image" />
                                    </span>
                                            <span>
                                        <span>Ashish Singh</span>
                                            <span class="time"><?php echo $helper->time_elapsed_string($notification->created_at) ?></span>
                                            </span>
                                            <span class="message">
                                         <?php echo $notification->notification ?>
                                    </span>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>

                                    </div>
                                    <li>
                                        <div class="text-center">
                                            <a>
                                                <strong><a href="inbox.html">See All Alerts</strong>
                                                <i class="fa fa-angle-right"></i>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                    </nav>
                </div>

            </div>
            <!-- /top navigation -->
        </div>
    </div>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/pnotify.custom.min.js"></script>
    <script src="js/node_modules/socket.io/node_modules/socket.io-client/dist/socket.io.js"></script>
    <script src="js/nodeClient.js"></script>
</body>

</html>
