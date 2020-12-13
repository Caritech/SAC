<!--
    column: [
        //FOR Select dropdown
        {
          name: "active",
          title: "Active",
          search_type: "drop_down",
          search_lists: [0, 1],
        },
        //FOR Text based input
        {
          name: "perfer_name",
          title: "Perfer Name",
          search_type: "text",
        },
      ],

-->
<template>
    <div class="col-md-12 card card-body">
        <div>
            <h5>Search</h5>
            <b-button
                size="sm"
                variant="outline-info"
                @click="addSearch"
            >
                <i class="fa fa-plus"></i> Add
            </b-button>
            <button
                type="button"
                class="btn btn-sm btn-outline-danger my-2 my-sm-0"
                @click="performSearch"
            >Search</button>
        </div>

        <div class="col-md-12">
            <div
                class="row align-items-start"
                v-for="(s,s_key) in search_data"
            >
                <div class="">
                    <button
                        type="button"
                        @click="deleteSearch(s_key)"
                        class="btn btn-sm btn-danger"
                    ><i class="fa fa-trash"></i></button>
                </div>
                <div class="col-md-2">
                    <my-select
                        size="sm"
                        :items="searchColumns"
                        v-model="s.column"
                        itemText="title"
                        itemValue="name"
                        placeholder="Select a Field"
                        @input="columnSelected(s,$event)"
                    ></my-select>
                </div>
                <div class="col-md-2">
                    <my-select
                        size="sm"
                        :items="generateFilterTypeLists( columnInfo(s.column))"
                        v-model="s.filter_type"
                        itemText="label"
                        itemValue="value"
                        @input="filterTypeSelected(s,$event)"
                    ></my-select>
                </div>

                <template v-if="s.filter_type != null">

                    <template v-if="columnInfo(s.column) != null && columnInfo(s.column).search_type == 'drop_down'">
                        <div class="col-md-2">
                            <my-select
                                size="sm"
                                :items="columnInfo(s.column).search_lists"
                                v-model="s.value"
                                itemText="label"
                                itemValue="value"
                                @input="filterTypeSelected"
                                :placeholder="columnInfo(s.column).search_lists_placeholder"
                            ></my-select>
                        </div>
                    </template>
                    <template v-else>
                        <div
                            v-if="
                        [
                            'equal',
                            'not_equal',
                            'like',
                            'not_like',
                            'more_than',
                            'less_than'
                        ].includes(s.filter_type)
                    "
                            class="col-md-3"
                        >
                            <input
                                class="form-control form-control-sm mr-sm-2"
                                type="search"
                                placeholder="Search"
                                aria-label="Search"
                                v-model="s.value"
                            />
                        </div>

                        <div
                            v-if="['in', 'not_in'].includes(s.filter_type)"
                            class="col-md-3"
                        >
                            <vue-tags-input
                                v-model="s.tag"
                                :tags="s.tags"
                                @tags-changed="newTags => (s.tags = newTags)"
                            />
                        </div>

                        <div
                            v-if="
                        ['between', 'not_between'].includes(s.filter_type)
                    "
                            class="col-md-3 row"
                        >
                            <div class="col-md-6">
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="from"
                                    v-model="s.value"
                                />
                            </div>
                            <div class="col-md-6">
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="to"
                                    v-model="s.value2"
                                />
                            </div>
                        </div>
                    </template>

                </template>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    props: ["searchFields", "searchColumns"],
    data() {
        return {
            search_data: null,
            //
            filter_type_lists: [
                {
                    label: "Equal to",
                    value: "equal",
                },
                {
                    label: "Not Equal to",
                    value: "not_equal",
                },
                {
                    label: "Like %...%",
                    value: "like",
                },
                {
                    label: "Not Like %...%",
                    value: "not_like",
                },
                {
                    label: "In (...)",
                    value: "in",
                },
                {
                    label: "Not In (...)",
                    value: "not_in",
                },
                {
                    label: "Between",
                    value: "between",
                },
                {
                    label: "Not Between",
                    value: "not_between",
                },
                {
                    label: "More Than",
                    value: "more_than",
                },
                {
                    label: "Less Than",
                    value: "less_than",
                },
                {
                    label: "Null Or Empty",
                    value: "null_or_empty",
                },
                {
                    label: "Not Null",
                    value: "not_null",
                },
            ],
        }
    },
    methods: {
        /*
            array_of_object: [ { label:'Hello World', name:'hello_world' }, { label:'This is Mars', name:'mars' } ]
            key_to_search: 'name'
            value_to_compare: 'hello_word'
        */
        filterObjInArray(array_of_object, key_to_search, value_to_compare) {
            var index = array_of_object.indexOf(
                array_of_object.filter(function (obj) {
                    if (key_to_search in obj) {
                        return obj[key_to_search] === value_to_compare
                    }
                })[0]
            )
            return array_of_object[index] ?? null
        },

        generateFilterTypeLists(column_info) {
            var filter_lists = []
            if (column_info == null) {
                return []
            }

            var search_type = column_info.search_type
            if (search_type == "text") {
                var lists = [
                    {
                        label: "Equal to",
                        value: "equal",
                    },
                    {
                        label: "Not Equal to",
                        value: "not_equal",
                    },
                    {
                        label: "Like %...%",
                        value: "like",
                    },
                    {
                        label: "Not Like %...%",
                        value: "not_like",
                    },
                    {
                        label: "Null Or Empty",
                        value: "null_or_empty",
                    },
                    {
                        label: "Not Null",
                        value: "not_null",
                    },
                ]
                filter_lists = [...filter_lists, ...lists]
            } else if (search_type == "drop_down") {
                var lists = [
                    {
                        label: "Equal to",
                        value: "equal",
                    },
                    {
                        label: "Not Equal to",
                        value: "not_equal",
                    },
                ]
                filter_lists = [...filter_lists, ...lists]
            }
            return filter_lists
        },

        columnInfo(value) {
            var $em = this
            var objects = this.searchColumns
            var obj = this.filterObjInArray(objects, "name", value)
            return obj
        },
        performSearch() {
            var search_arr = this.search
            this.$emit("search")
        },
        addSearch() {
            this.search_data.push({
                column: null,
                filter_type: "equal",
            })
        },
        openSearchModal() {
            this.$refs["search-modal"].show()
        },
        columnSelected(ele, $event) {
            var columnInfo = this.columnInfo(ele.column)
            if (columnInfo != null) {
                var select_type = columnInfo.search_type
                //ele.filter_type = 'equal'
            }

            this.$emit("input", this.search_data)
        },
        filterTypeSelected(ele, $event) {
            console.log($event)
            ele.filter_type = $event
            this.$emit("input", this.search_data)
        },
        deleteSearch(search_index) {
            this.$delete(this.search_data, search_index)
        },
    },

    created() {
        this.search_data = this.searchFields
    },
}
</script>
