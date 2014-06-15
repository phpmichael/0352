<!-- begin TOP NAVIGATION -->
<nav class="navbar-top" role="navigation">

<!-- begin BRAND HEADING -->
<div class="navbar-header">
    <button type="button" class="navbar-toggle pull-right" data-toggle="collapse" data-target=".sidebar-collapse">
        <i class="fa fa-bars"></i> Menu
    </button>
    <div class="navbar-brand">
        <a href="index.html">
            <img src="css_all/skins/flex/img/flex-admin-logo.png" class="img-responsive" alt="">
        </a>
    </div>
</div>
<!-- end BRAND HEADING -->

<div class="nav-top">

<!-- begin LEFT SIDE WIDGETS -->
<ul class="nav navbar-left">
    <li class="tooltip-sidebar-toggle">
        <a href="#" id="sidebar-toggle" data-toggle="tooltip" data-placement="right" title="Sidebar Toggle">
            <i class="fa fa-bars"></i>
        </a>
    </li>
    <!-- You may add more widgets here using <li> -->
</ul>
<!-- end LEFT SIDE WIDGETS -->

<!-- begin MESSAGES/ALERTS/TASKS/USER ACTIONS DROPDOWNS -->
<ul class="nav navbar-right">

<!-- begin MESSAGES DROPDOWN -->
<li class="dropdown">
    <a href="#" class="messages-link dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-envelope"></i>
        <span class="number">4</span> <i class="fa fa-caret-down"></i>
    </a>
    <ul class="dropdown-menu dropdown-scroll dropdown-messages">

        <!-- Messages Dropdown Heading -->
        <li class="dropdown-header">
            <i class="fa fa-envelope"></i> 4 New Messages
        </li>

        <!-- Messages Dropdown Body - This is contained within a SlimScroll fixed height box. You can change the height using the SlimScroll jQuery features. -->
        <li id="messageScroll">
            <ul class="list-unstyled">
                <li>
                    <a href="#">
                        <div class="row">
                            <div class="col-xs-2">
                                <img class="img-circle" src="css_all/skins/flex/img/user-profile-1.jpg" alt="">
                            </div>
                            <div class="col-xs-10">
                                <p>
                                    <strong>Jane Smith</strong>: Hi again! I wanted to let you know that the order...
                                </p>
                                <p class="small">
                                    <i class="fa fa-clock-o"></i> 12 minutes ago
                                </p>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="row">
                            <div class="col-xs-2">
                                <img class="img-circle" src="css_all/skins/flex/img/user-profile-2.jpg" alt="">
                            </div>
                            <div class="col-xs-10">
                                <p>
                                    <strong>Roddy Austin</strong>: Thanks for the info, if you need anything from...
                                </p>
                                <p class="small">
                                    <i class="fa fa-clock-o"></i> 3:39 PM
                                </p>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="row">
                            <div class="col-xs-2">
                                <img class="img-circle" src="css_all/skins/flex/img/user-profile-3.jpg" alt="">
                            </div>
                            <div class="col-xs-10">
                                <p>
                                    <strong>Stacy Gibson</strong>: Hey, what was the purchase order number for the...
                                </p>
                                <p class="small">
                                    <i class="fa fa-clock-o"></i> Yesterday at 10:23 AM
                                </p>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="row">
                            <div class="col-xs-2">
                                <img class="img-circle" src="css_all/skins/flex/img/user-profile-4.jpg" alt="">
                            </div>
                            <div class="col-xs-10">
                                <p>
                                    <strong>Jeffrey Cortez</strong>: Check out this video I found the other day, it's...
                                </p>
                                <p class="small">
                                    <i class="fa fa-clock-o"></i> Tuesday at 12:23 PM
                                </p>
                            </div>
                        </div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Messages Dropdown Footer -->
        <li class="dropdown-footer">
            <a href="mailbox.html">Read All Messages</a>
        </li>

    </ul>
    <!-- /.dropdown-menu -->
</li>
<!-- /.dropdown -->
<!-- end MESSAGES DROPDOWN -->

<!-- begin ALERTS DROPDOWN -->
<li class="dropdown">
    <a href="#" class="alerts-link dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-bell"></i>
        <span class="number">9</span><i class="fa fa-caret-down"></i>
    </a>
    <ul class="dropdown-menu dropdown-scroll dropdown-alerts">

        <!-- Alerts Dropdown Heading -->
        <li class="dropdown-header">
            <i class="fa fa-bell"></i> 9 New Alerts
        </li>

        <!-- Alerts Dropdown Body - This is contained within a SlimScroll fixed height box. You can change the height using the SlimScroll jQuery features. -->
        <li id="alertScroll">
            <ul class="list-unstyled">
                <li>
                    <a href="#">
                        <div class="alert-icon green pull-left">
                            <i class="fa fa-money"></i>
                        </div>
                        Order #2931 Received
                                            <span class="small pull-right">
                                                <strong>
                                                    <em>3 minutes ago</em>
                                                </strong>
                                            </span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="alert-icon blue pull-left">
                            <i class="fa fa-comment"></i>
                        </div>
                        New Comments
                        <span class="badge blue pull-right">15</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="alert-icon orange pull-left">
                            <i class="fa fa-wrench"></i>
                        </div>
                        Crawl Errors Detected
                        <span class="badge orange pull-right">3</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="alert-icon yellow pull-left">
                            <i class="fa fa-question-circle"></i>
                        </div>
                        Server #2 Not Responding
                                            <span class="small pull-right">
                                                <strong>
                                                    <em>5:25 PM</em>
                                                </strong>
                                            </span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="alert-icon red pull-left">
                            <i class="fa fa-bolt"></i>
                        </div>
                        Server #4 Crashed
                                            <span class="small pull-right">
                                                <strong>
                                                    <em>3:34 PM</em>
                                                </strong>
                                            </span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="alert-icon green pull-left">
                            <i class="fa fa-plus-circle"></i>
                        </div>
                        New Users
                        <span class="badge green pull-right">5</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="alert-icon orange pull-left">
                            <i class="fa fa-download"></i>
                        </div>
                        Downloads
                        <span class="badge orange pull-right">16</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="alert-icon purple pull-left">
                            <i class="fa fa-cloud-upload"></i>
                        </div>
                        Server #8 Rebooted
                                            <span class="small pull-right">
                                                <strong>
                                                    <em>12 hours ago</em>
                                                </strong>
                                            </span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="alert-icon red pull-left">
                            <i class="fa fa-bolt"></i>
                        </div>
                        Server #8 Crashed
                                            <span class="small pull-right">
                                                <strong>
                                                    <em>12 hours ago</em>
                                                </strong>
                                            </span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Alerts Dropdown Footer -->
        <li class="dropdown-footer">
            <a href="#">View All Alerts</a>
        </li>

    </ul>
    <!-- /.dropdown-menu -->
</li>
<!-- /.dropdown -->
<!-- end ALERTS DROPDOWN -->

<!-- begin TASKS DROPDOWN -->
<li class="dropdown">
    <a href="#" class="tasks-link dropdown-toggle" data-toggle=dropdown>
        <i class="fa fa-tasks"></i>
        <span class=number>10</span><i class="fa fa-caret-down"></i>
    </a>
    <ul class="dropdown-menu dropdown-scroll dropdown-tasks">

        <!-- Tasks Dropdown Header -->
        <li class="dropdown-header">
            <i class="fa fa-tasks"></i> 10 Pending Tasks
        </li>

        <!-- Tasks Dropdown Body - This is contained within a SlimScroll fixed height box. You can change the height using the SlimScroll jQuery features. -->
        <li id="taskScroll">
            <ul class="list-unstyled">
                <li>
                    <a href="#">
                        <p>
                            Software Update 2.1
                                                <span class="pull-right">
                                                    <strong>60%</strong>
                                                </span>
                        </p>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <p>
                            Server #2 Hardware Upgrade
                                                <span class="pull-right">
                                                    <strong>90%</strong>
                                                </span>
                        </p>
                        <div class="progress progress-striped">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 90%;"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <p>
                            Call Ticket #2032
                                                <span class="pull-right">
                                                    <strong>72%</strong>
                                                </span>
                        </p>
                        <div class="progress progress-striped active">
                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100" style="width: 72%;"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <p>
                            Emergency Maintenance
                                                <span class="pull-right">
                                                    <strong>36%</strong>
                                                </span>
                        </p>
                        <div class="progress progress-striped">
                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="36" aria-valuemin="0" aria-valuemax="100" style="width: 36%;"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <p>
                            Purchase Order #439
                                                <span class="pull-right">
                                                    <strong>52%</strong>
                                                </span>
                        </p>
                        <div class="progress progress-striped">
                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="52" aria-valuemin="0" aria-valuemax="100" style="width: 52%;"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <p>
                            March Content Update
                                                <span class="pull-right">
                                                    <strong>14%</strong>
                                                </span>
                        </p>
                        <div class="progress">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="14" aria-valuemin="0" aria-valuemax="100" style="width: 14%;"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <p>
                            Client #42 Data Scrubbing
                                                <span class="pull-right">
                                                    <strong>68%</strong>
                                                </span>
                        </p>
                        <div class="progress progress-striped">
                            <div class="progress-bar" role="progressbar" aria-valuenow="68" aria-valuemin="0" aria-valuemax="100" style="width: 68%;"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <p>
                            PHP Upgrade Server #6
                                                <span class="pull-right">
                                                    <strong>85%</strong>
                                                </span>
                        </p>
                        <div class="progress">
                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 85%;"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <p>
                            Malware Scan
                                                <span class="pull-right">
                                                    <strong>66%</strong>
                                                </span>
                        </p>
                        <div class="progress progress-striped active">
                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100" style="width: 66%;"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <p>
                            New Employee Intake
                                                <span class="pull-right">
                                                    <strong>98%</strong>
                                                </span>
                        </p>
                        <div class="progress progress-striped active">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="14" aria-valuemin="0" aria-valuemax="100" style="width: 98%;"></div>
                        </div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Tasks Dropdown Footer -->
        <li class="dropdown-footer">
            <a href="#">View All Tasks</a>
        </li>

    </ul>
    <!-- /.dropdown-menu -->
</li>
<!-- /.dropdown -->
<!-- end TASKS DROPDOWN -->

<!-- begin USER ACTIONS DROPDOWN -->
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-user"></i>  <i class="fa fa-caret-down"></i>
    </a>
    <ul class="dropdown-menu dropdown-user">
        <li>
            <a href="profile.html">
                <i class="fa fa-user"></i> My Profile
            </a>
        </li>
        <li>
            <a href="mailbox.html">
                <i class="fa fa-envelope"></i> My Messages
                <span class="badge green pull-right">4</span>
            </a>
        </li>
        <li>
            <a href="#">
                <i class="fa fa-bell"></i> My Alerts
                <span class="badge orange pull-right">9</span>
            </a>
        </li>
        <li>
            <a href="#">
                <i class="fa fa-tasks"></i> My Tasks
                <span class="badge blue pull-right">10</span>
            </a>
        </li>
        <li>
            <a href="calendar.html">
                <i class="fa fa-calendar"></i> My Calendar
            </a>
        </li>
        <li class="divider"></li>
        <li>
            <a href="#">
                <i class="fa fa-gear"></i> Settings
            </a>
        </li>
        <li>
            <a class="logout_open" href="#logout">
                <i class="fa fa-sign-out"></i> Logout
                <strong>John Smith</strong>
            </a>
        </li>
    </ul>
    <!-- /.dropdown-menu -->
</li>
<!-- /.dropdown -->
<!-- end USER ACTIONS DROPDOWN -->

</ul>
<!-- /.nav -->
<!-- end MESSAGES/ALERTS/TASKS/USER ACTIONS DROPDOWNS -->

</div>
<!-- /.nav-top -->
</nav>
<!-- /.navbar-top -->
<!-- end TOP NAVIGATION -->