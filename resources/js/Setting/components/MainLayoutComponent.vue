<template>
    <div>
        <nav class="navbar navbar-expand-lg bg-theme row">
            <button
                class="navbar-toggler"
                type="button"
                data-toggle="collapse"
                data-target="#navbarTogglerDemo03"
                aria-controls="navbarTogglerDemo03"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <router-link class="navbar-brand text-white " to="/"
                >Setting</router-link
            >

            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item nav-item-fix-width">
                        <router-link
                            class="nav-link nav-link-sm-padding btn btn-sm btn-light"
                            to="/services"
                            >Service</router-link
                        >
                    </li>
                </ul>
            </div>
        </nav>
        <div class="mt-2">
            <h4>{{ title }}</h4>
            <slot></slot>
            <div class="p-4"></div>
        </div>
    </div>
</template>

<style>
.bg-theme {
    background-color: #e74a3b;
    background-image: linear-gradient(90deg, #e74a3b 90%, #be2617 100%);
}
.nav-item-fix-width {
    min-width: 60px;
    margin-right: 10px;
}
.nav-link-sm-padding {
    padding: 3px 0px;
}
.page-item, .page-link i{
    color:#e74a3b
}

.page-link.disabled i{
    color:grey;

}
.page-link.disabled{
   cursor:not-allowed
}
.page-link.disabled:hover{
    background:white
}

.page-item.active{
    z-index: 1;
    color: #fff;
    background-color: #e74a3b;
    border-color: #e74a3b;
}
</style>

<script>
export default {
    props: ["title"]
};
</script>
