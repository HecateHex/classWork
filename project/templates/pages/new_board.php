<?php
$this->layout('main', ['title' => 'SYSTEM | Board']);

if (!empty($_SESSION['loginMember'] ?? '')) {
    // 這裡讀資料庫
    $login_query = $db->prepare('SELECT * FROM `memberdata` WHERE `m_username` = :username');
    $login_query->execute([':username' => $_SESSION['loginMember']]);
    $member = $login_query->fetch(PDO::FETCH_ASSOC);
    $user_display_name = $member['m_username'];
}

if (isset($_GET["logout"]) && ($_GET["logout"] == "true")) {
    unset($_SESSION["loginMember"]);
    unset($_SESSION["memberLevel"]);
    header("Location: index-coming-soon.php");
}
$this->push('footer');

?>
    <script>
        $(function () {
            $("#example1").DataTable();
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
        });
    </script>
<?php
$this->end();
