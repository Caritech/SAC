<template>
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
            >Contact Information</router-link
        >

        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item nav-item-fix-width active">
                    <router-link
                        class="nav-link nav-link-sm-padding btn btn-sm btn-light"
                        to="/all_contact"
                        >All <span class="sr-only">(current)</span></router-link
                    >
                </li>
                <li class="nav-item nav-item-fix-width">
                    <router-link
                        class="nav-link nav-link-sm-padding btn btn-sm btn-light"
                        to="/worker"
                        >Worker</router-link
                    >
                </li>
                <li class="nav-item nav-item-fix-width">
                    <router-link
                        class="nav-link nav-link-sm-padding btn btn-sm btn-light"
                        to="/client"
                        >Client</router-link
                    >
                </li>
            </ul>
        </div>
    </nav>
</template>
