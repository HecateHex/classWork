<?php
    $id="";
    $name = "";
    $isAdmin = SessionHelper :: getCurrentSession()->isAdmin;
    $isBlock = flase;
    $title = $title ?? "未命名標題";
    $this -> layout('template',['title'=>$title,'class'=>'hold-transition skin-fgu sidebar-mini layout-boxed']);
    $this->push("footer");
?>
<script src="../AdminLTE-cn-master/dist/js/app.min.js"></script>
<script src="../AdminLTE-cn-master/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<?php
    $this->end();
?>
<div class = "wrapper">
    <header class = "main-header">
        <a href="." class ="logo">
            <span class = "logo-mini"><b>F</b>Final</span>
            <span class = "logo-lg"><b>FGU</b>Final</span>
        </a>

        <nav class="navbar navbar-static-top">
            <a href="javascript:" class ="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class ="sr-only">顯示/隱藏選單</span>
            </a>
            <div class = "navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu"
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="glyphicon glyphicon-user"></i>
                            <span class="hidden-xs"><?= $this->e($name) ?></span>
                        </a>
                    <form class="dropdown-menu no-padding" action="logout.php" method="POST">
                        <table class="table table-striped no-margin">
                            <tbody>
                            <tr>
                                <th>登入帳號</th>
                                <td><?=$this->e($id) ?></td>
                            </tr>
                            <tr>
                                <th>顯示名稱</th>
                                <td><?=$this->e($name)?></td>
                            </tr>
                                <th>帳號身分</th>
                                <td>
                                    <i class="fa fa-fw "></i>
                                </td>
                            </tbody>
                        </table>
                    </form>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
</div>>
