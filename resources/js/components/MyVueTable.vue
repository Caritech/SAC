<script>
import VueTable from "vuetable-2"
import VuetablePaginationInfo from "vuetable-2/src/components/VuetablePaginationInfo"
import VuetablePagination from "vuetable-2/src/components/VuetablePagination"
import VuetableFilter from "./VueTableFilter"

export default {
    components: {
        vuetable: VueTable,
        "vuetable-pagination": VuetablePagination,
        "vuetable-pagination-info": VuetablePaginationInfo,
        "vuetable-filter": VuetableFilter,
    },
    data() {
        return {
            appendParamsWithSearch: null,
        }
    },
    props: {
        apiUrl: {
            type: String,
            required: true,
        },
        fields: {
            type: Array,
            required: true,
        },
        perPage: {
            type: Number,
        },
        appendParams: {
            type: Object,
            default: () => {
                return {}
            },
        },
        searchColumns: {
            type: Array,
            default: null,
        },
        filter: {
            type: String,
            default: "true",
        },
        transform: {},
    },
    render(h) {
        return h("div", [
            //filter bar only appear when search Columns is declared in props
            this.searchColumns != null || this.filter == "true"
                ? this.renderFilter(h)
                : null,
            <br />,
            this.renderVuetable(h),
            this.renderPagination(h),
        ])
    },
    methods: {
        handleLoadError(err) {
            let error_status = err.response.status
            let error_message = err.response.data.message
            Vue.swal("Error " + error_status, error_message, "error")
        },
        renderVuetable(h) {
            return h("vuetable", {
                ref: "vuetable",
                props: {
                    apiUrl: this.apiUrl,
                    fields: this.fields,
                    paginationPath: "",
                    perPage: this.perPage ?? 20,
                    multiSort: true,
                    sortOrder: this.sortOrder,
                    appendParams: this.appendParamsWithSearch,
                    detailRowComponent: this.detailRowComponent,

                    transform: this.transform,

                    css: {
                        tableClass: "ui selectable unstackable celled table",
                        ascendingIcon: "fa fa-sort-up",
                        descendingIcon: "fa fa-sort-down",
                        sortableIcon: "fa fa-sort",
                    },
                },

                on: {
                    //"vuetable:cell-clicked": this.onCellClicked,
                    "vuetable:pagination-data": this.onPaginationData,
                    "vuetable:load-error": this.handleLoadError,
                },
                scopedSlots: this.$vnode.data.scopedSlots,
            })
        },
        renderPagination(h) {
            return h(
                "div",
                {
                    class: {
                        "vuetable-pagination": true,
                        basic: true,
                        segment: true,
                        grid: true,
                    },
                },
                [
                    h("vuetable-pagination-info", {
                        ref: "paginationInfo",
                    }),
                    h("vuetable-pagination", {
                        ref: "pagination",
                        props: {
                            css: {
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
                                    last: "fa fa-angle-double-right",
                                },
                            },
                        },
                        on: {
                            "vuetable-pagination:change-page": this
                                .onChangePage,
                        },
                    }),
                ]
            )
        },
        renderFilter(h) {
            return h("vuetable-filter", {
                ref: "vuetableFilter",
                props: {
                    searchColumns: this.searchColumns,
                },
                on: {
                    "update-search": this.setSearchData,
                    "reset-search": this.resetSearchData,
                },
            })
        },
        onPaginationData(paginationData) {
            this.$refs.pagination.setPaginationData(paginationData)
            this.$refs.paginationInfo.setPaginationData(paginationData)
        },
        onChangePage(page) {
            this.$refs.vuetable.changePage(page)
        },
        setSearchData(search) {
            this.appendParamsWithSearch.search = search
            var $vm = this
            Vue.nextTick(() => $vm.$refs.vuetable.refresh())
        },
        resetSearchData() {
            this.appendParamsWithSearch = {}
            var $vm = this
            Vue.nextTick(() => $vm.$refs.vuetable.refresh())
        },
    },
    created() {
        if (this.appendParams == null) {
            this.appendParamsWithSearch = {}
        } else {
            this.appendParamsWithSearch = this.appendParams
        }
    },
}
</script>