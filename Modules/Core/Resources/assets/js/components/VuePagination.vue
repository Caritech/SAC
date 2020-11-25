<template>
    <vuetable-pagination
        ref="pagination"
        :css="pagination"
        @vuetable-pagination:change-page="onChangePage"
    ></vuetable-pagination>
</template>

<script>
import Vue from 'vue'
import {
    VuetablePagination
} from "vuetable-2";
Vue.component('vuetable-pagination', VuetablePagination)

export default {
    prop: ["onChangePage", "ref"],
    data() {
        return {
            pagination: {
                wrapperClass: "pagination float-right",
                activeClass: "active",
                disabledClass: "disabled",
                pageClass: "page-item page-link",
                linkClass: "page-link",
                paginationClass: "pagination",
                paginationInfoClass: "float-left",
                dropdownClass: "form-control",
                icons: {
                    first: "fa fa-angle-double-left",
                    prev: "fa fa-angle-left",
                    next: "fa fa-angle-right",
                    last: "fa fa-angle-double-right"
                }
            }
        };
    }
};
</script>
