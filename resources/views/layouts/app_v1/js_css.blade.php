<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
<style>
    #content-wrapper {
        overflow-y: hidden
    }

    .sidebar-submenu-box {
        border: 1px solid #007bff;
        border-radius: 15px !important;
        background: white;
    }

    .sidebar-sidemenu-item {
        border-bottom: 1px solid #a4a4a4;
        font-size: 20px;
        font-family: 'Roboto', sans-serif;
        color: #74757b !important
    }

    .sidebar-sidemenu-item:hover {
        color: white !important;
        background: #007bff !important;
    }

    .form-control {
        height: calc(1.6em + 0.75rem + -6px)
    }

    .no-padding-right {
        padding-right: 0px;
    }

    .no-padding-left {
        padding-left: 0px;
    }

    .tab-content>.tab-pane {
        padding: 10px 0px;
    }

    td.table-no-border-top {
        border-top: none;
    }

    .profile .table th,
    .table td {
        padding: 0.15rem 0.75rem;
    }

    .label-background {
        padding: 0px 7px;
        border: 1px solid rgb(0 0 0 / 25%);
        border-radius: 2px;
    }

    .card-header {
        background: rgb(132 132 132 / 8%);
        font-size: large;
        font-weight: 600;
    }

    .title-cyan {
        color: #44a0ff;
    }

    .field-bold {
        font-weight: bold;
    }

    .table-td-padding td {
        padding: 10px;
    }

    .icon-button {
        cursor: pointer;
    }

    .input-group-prepend,.input-group-append  {
        height: 29px;
    }

    .table td.fit,
    .table th.fit {
        white-space: nowrap;
        width: 14%;
    }

    .bg-theme {
        background-color: #00b0f0;
        background-image: unset;
    }

    .profile .IZ-select__input-wrap{
        height: 47%;
    }

    .profile .with-notes .IZ-select__input-wrap{
        height: 41%;
    }
    .nav-pills .nav-link.active, .nav-pills .show > .nav-link{
        background-color: #00b0f0;
    }
    .nav-item a{
        color:black ;
    }
    .profile td, .profile td a i {
        color:#00b0f0;
    }
    .text-primary{
        color:black !important;
    }
    .card-header a h5,.title-cyan, .vuetable th.sortable:hover{
        color:#00b0f0;
    }
    .btn-primary{
        background-color:#00b0f0;
    }

    .btn-outline-primary {
        color: #00b0f0;
        border-color:#00b0f0;
    }
    .btn-outline-primary:hover {
        color: #fff;
        background-color: #00b0f0;
        border-color: #00b0f0;
    }




</style>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>
<script>
    $(function() {
        $('body').on("click", function() {
            $('.sidebar-menu-collapse').removeClass('show');
        });
    });
</script>
