<template>
    <div>
        <form class="row align-items-start">
            <div class="col-md-2">
                <v-select :options="column"></v-select>
            </div>
            <div class="col-md-2">
                <v-select
                    :options="filter_type"
                    v-model="selected_type"
                ></v-select>
            </div>

            <template v-if="selected_type != null">
                <div
                    v-if="
                        [
                            'equal',
                            'not_equal',
                            'like',
                            'not_like',
                            'more_than',
                            'less_than'
                        ].includes(selected_type.value)
                    "
                    class="col-md-3"
                >
                    <input
                        class="form-control mr-sm-2"
                        type="search"
                        placeholder="Search"
                        aria-label="Search"
                    />
                </div>

                <div
                    v-if="['in', 'not_in'].includes(selected_type.value)"
                    class="col-md-3"
                >
                    <vue-tags-input
                        v-model="tag"
                        :tags="tags"
                        @tags-changed="newTags => (tags = newTags)"
                    />
                </div>

                <div
                    v-if="
                        ['between', 'not_between'].includes(selected_type.value)
                    "
                    class="col-md-3 row"
                >
                    <div class="col-md-6">
                        <input
                            type="text"
                            class="form-control"
                            placeholder="from"
                        />
                    </div>
                    <div class="col-md-6">
                        <input
                            type="text"
                            class="form-control"
                            placeholder="to"
                        />
                    </div>
                </div>
            </template>

            <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">
                Search
            </button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            column: ["FirstName", "LastName", "Active"],
            filter_type: [
                { label: "Equal to", value: "equal" },
                { label: "Not Equal to", value: "not_equal" },
                { label: "Like %...%", value: "like" },
                { label: "Not Like %...%", value: "not_like" },
                { label: "In (...)", value: "in" },
                { label: "Not In (...)", value: "not_in" },
                { label: "Between", value: "between" },
                { label: "Not Between", value: "not_between" },
                { label: "More Than", value: "more_than" },
                { label: "Less Than", value: "less_than" },
                { label: "Null Or Empty", value: "null_or_empty" },
                { label: "Not Null", value: "not_null" }
            ],
            selected_type: null,
            tag: "",
            tags: []
        };
    }
};
</script>

<style lang="css">
/* style the background and the text color of the input ... */
.vue-tags-input {
    background: #324652;
}

.vue-tags-input .ti-new-tag-input {
    background: transparent;
    color: rgb(88, 88, 88);
}

.vue-tags-input .ti-input {
    padding: 4px 10px;
    transition: border-bottom 200ms ease;
    border-radius: 4px;
}

/* default styles for all the tags */
.vue-tags-input .ti-tag {
    position: relative;
    background: #dad8d8;
    color: #283944;
}

/* if a tag or the user input is a duplicate, it should be crossed out */
.vue-tags-input .ti-duplicate span,
.vue-tags-input .ti-new-tag-input.ti-duplicate {
    text-decoration: line-through;
}

/* if the user presses backspace, the complete tag should be crossed out, to mark it for deletion */
.vue-tags-input .ti-tag:after {
    transition: transform 0.2s;
    position: absolute;
    content: "";
    height: 2px;
    width: 108%;
    left: -4%;
    top: calc(50% - 1px);
    background-color: #000;
    transform: scaleX(0);
}

.vue-tags-input .ti-deletion-mark:after {
    transform: scaleX(1);
}
</style>
