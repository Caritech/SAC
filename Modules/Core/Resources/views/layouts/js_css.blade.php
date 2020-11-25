<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
<style>
    .sidebar-submenu-box{
        border:1px solid #ff6969;
        border-radius:15px !important;
        background:white;
    }
    .sidebar-sidemenu-item{
        border-bottom:1px solid #a4a4a4;
        font-size:20px;
        font-family: 'Roboto', sans-serif;
        color:#74757b !important
    }
    .sidebar-sidemenu-item:hover{
        color:white !important;
        background:#cd3324 !important;
    }
</style>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>
<script>
    $(function(){
        $('body').on("click", function () {
            $('.sidebar-menu-collapse').removeClass('show');
        });
    });
</script>
