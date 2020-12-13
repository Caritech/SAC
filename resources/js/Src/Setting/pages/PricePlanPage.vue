<template>
<div>
    <b-breadcrumb>
        <b-breadcrumb-item href="/setting">Setting</b-breadcrumb-item>
        <b-breadcrumb-item href="/setting/services">Service</b-breadcrumb-item>
        <b-breadcrumb-item :href="'/setting/services/' + serviceId">Service Detail [{{ service.code }}]</b-breadcrumb-item>
        <b-breadcrumb-item active>Price Plan Maintenance</b-breadcrumb-item>
    </b-breadcrumb>

    <div class="card card-primary">
        <div class="card-header card-header-sm">
            Price Plan Info
            <div class="float-right">
                <Button type="button" class="btn btn-sm btn-outline-danger" @click="deletePricePlan">Delete</Button>
                <Button type="button" class="btn btn-sm btn-outline-primary" @click="cloneExistingPopUp">Clone From Existing</Button>
                <Button type="button" class="btn btn-sm btn-outline-primary" @click="addNewGroupPopUp">Add New Group</Button>
                <Button type="button" class="btn btn-sm btn-success" @click="updatePricePlan">Update</Button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <label>Title</label>
                    <b-form-input size="sm" v-model="price_plan.title" placeholder="Price Title"></b-form-input>
                </div>
                <div class="col-md-3">
                    <label>Start Date</label>
                    <date-picker class="form-control-sm" :config="{
                                format: 'YYYY-MM-DD'
                            }" v-model="price_plan.start_date"></date-picker>
                </div>
                <div class="col-md-3">
                    <label>End Date</label>
                    <date-picker class="form-control-sm" :config="{
                                format: 'YYYY-MM-DD'
                            }" v-model="price_plan.end_date"></date-picker>
                </div>
                <div class="col-md-3">
                    <label>Remark</label>
                    <b-form-input size="sm" v-model="price_plan.remark" placeholder="Remark"></b-form-input>
                </div>
            </div>
        </div>
    </div>

    <template v-for="(g, k) in price_plan_group_by_id">
        <div :key="k" class="card mt-4">
            <div class="card-header card-header-sm">
                <template v-if="!g.edit_mode">{{ g.group_name }} [{{ g.id }}]</template>
                <template v-else>
                    <b-form-input size="sm" v-model="g.group_name" placeholder="Group Name"></b-form-input>
                </template>

                <span class="float-right">
                    <b-button size="sm" variant="outline-primary" @click="editGroup(g)">Edit Group</b-button>
                    <b-button size="sm" variant="outline-primary" @click="addGroupItemPopUp(g)">Add New Item</b-button>
                    <Button type="button" class="btn btn-sm btn-outline-danger" @click="deleteGroup(g)">Delete</Button>
                    <Button type="button" class="btn btn-sm btn-success" @click="updateGroup(g)">Update</Button>
                </span>
            </div>
            <div class="card-body col-12">
                <div class="row">
                    <table class="table table-bordered table-hover table-sm">
                        <thead>
                            <tr>
                                <th class="fit text-center">Option</th>
                                <th>Item Name</th>
                                <th style="width:12%">Inc. / Exp.</th>
                                <th style="width:12%">Input Type</th>
                                <th class="fit">Level 1</th>
                                <th class="fit">Level 2</th>
                                <th class="fit">Level 3</th>
                                <th class="fit">Level 4</th>
                                <th style="width:20%">More</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, item_key) in g.item" :key="item_key">
                                <td class="text-center">
                                    <Button type="button" class="btn btn-sm btn-danger" @click="deleteGroupItem(item.id)">
                                        <i class="fa fa-trash"></i>
                                    </Button>
                                </td>
                                <td>
                                    <b-form-input size="sm" v-model="item.title" placeholder="Item Name"></b-form-input>
                                </td>
                                <td>
                                    <my-select size="sm" single-line :items="['income', 'expense']" v-model="item.type"></my-select>
                                </td>
                                <td>
                                    <my-select size="sm" :items="lists_item_input_type" v-model="item.input_type"></my-select>
                                </td>
                                <template v-for="(lv, lv_key) in [1, 2, 3, 4]">
                                    <td :key="lv_key">
                                        <div class="input-group">
                                            <b-form-input size="sm" v-model="item['level' + lv]" placeholder="value"></b-form-input>
                                        </div>
                                    </td>
                                </template>
                                <td>
                                    <template v-if="
                                                item.input_type == 'percentage'
                                            " a>
                                        Refer to Group
                                        <my-select v-model="item.refer_group_id" :items="[]" single-line></my-select>
                                    </template>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </template>

    <div class="card mt-4">
        <div class="card-header with-border">
            Service Item Price
            <span class="float-right">
                <Button type="button" class="btn btn-sm btn-success" @click="savePricePlanBreakdown">Update Service Item Price</Button>
            </span>
        </div>
        <div class="card-body">
            <div class="row p-2 m-2">
                <label class="col-6">Formula For Half Price</label>
                <div class="col-6">
                    <my-select :items="lists_formula_for_half_price" v-model="formula_half_price" itemText="label" itemValue="key"></my-select>
                </div>
            </div>
            <p>
                UOM explain:
                <br />- hours can have special price when
                <= 0.5 <br />- amount can have modifier which to increase the final amount such as 1.05 will turn 100 to 105 (0 => no modifier)
            </p>
            <table class="table table-bordered table-hover table-sm">
                <thead>
                    <tr>
                        <th>Service</th>
                        <th style="width:8%" v-for="(day, day_key) in lists_day_type" :key="day_key">{{ day.text }}</th>
                    </tr>
                </thead>
                <tbody>
                    <template v-for="(breakdown,
                            breakdown_key) in calculated_breakdown">
                        <tr :key="'breakdown' + breakdown_key">
                            <td>[{{ breakdown.breakdown_code }}] {{ breakdown.breakdown_name }} ({{ breakdown.breakdown_uom }})</td>
                            <td v-for="(day, day_key) in lists_day_type" :key="day_key">
                                <input type="text" class="form-control form-control-sm number" v-model="breakdown[day.key]" />
                            </td>
                        </tr>
                        <tr v-if="breakdown.breakdown_uom == 'hours'" :key="'breakdown2' + breakdown_key">
                            <td align="right">Half</td>
                            <td v-for="(day, day_key) in lists_day_type" :key="day_key">
                                <input class="form-control form-control-sm number" v-model="breakdown[day.key + '_half']" :disabled="
                                            formula_half_price != 'custom' &&
                                                formula_half_price != ''
                                        " type="text" />
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <span class="float-right">
                <Button type="button" class="btn btn-sm btn-success" @click="savePricePlanBreakdown">Update Service Item Price</Button>
            </span>
        </div>
    </div>

    <b-modal :title="
                'Add New Item For Group [' + new_group_info.group_name + ' ]'
            " ref="modal-add-new-group-item" hide-footer>
        <p v-if="new_group_error.length">
            <b-alert v-for="(error, error_k) in new_group_error" :key="error_k" variant="danger" show>{{ error }}</b-alert>
        </p>
        <b-form-input type="text" placeholder="New Item Name" v-model="new_group_item.title"></b-form-input>
        <my-select :items="[
                    { text: 'Income', value: 'income' },
                    { text: 'Expense', value: 'expense' }
                ]" placeholder="Income / Expense" v-model="new_group_item.type" itemText="text" itemValue="value"></my-select>
        <my-select :items="[
                    { text: 'Checkbox', value: 'checkbox' },
                    { text: 'User Enter', value: 'user_enter' },
                    { text: 'Percentage', value: 'percentage' },
                    { text: 'Fixed', value: 'fixed' }
                ]" placeholder="Input Type" v-model="new_group_item.input_type" itemText="text" itemValue="value"></my-select>
        <b-button class="mt-3" variant="success" block @click="addNewGroupItem">Add Item</b-button>
        <b-button class="mt-2" variant="outline-danger" block @click="closeModalAddNewGroupItem">Close</b-button>
    </b-modal>
    <b-modal :title="'Add New Group'" ref="modal-add-new-group" hide-footer>
        <b-form-input type="text" placeholder="New Group Name" v-model="new_group.group_name"></b-form-input>

        <b-button class="mt-3" variant="success" block @click="addNewGroup">Add Group</b-button>
        <b-button class="mt-2" variant="outline-danger" block @click="closeModalNewGroup">Close</b-button>
    </b-modal>
    <b-modal :title="'Clone From Existing'" ref="modal-clone-existing" hide-footer>
        <my-select placeholder="Select an existing price plan" :items="lists_price_plan" v-model="price_plan_id_to_clone" itemText="title" itemValue="id"></my-select>

        <b-button class="mt-3" variant="success" block @click="cloneExisting">Clone</b-button>
        <b-button class="mt-2" variant="outline-danger" block @click="closeModalCloneExisting">Close</b-button>
    </b-modal>
</div>
</template>

<script>
export default {
    data() {
        return {
            serviceId: null,

            service: {},
            price_plan: {},
            price_plan_breakdown: {},
            price_plan_group_by_id: {},
            lists_price_plan: [],

            //new group
            new_group: {},
            //new group item data
            new_group_info: {}, //get info from selected group
            new_group_error: [], //form for new group item
            new_group_item: {}, //form for new group item
            //to clone
            price_plan_id_to_clone: null,

            //
            lists_item_input_type: ["checkbox", "user_enter", "percentage", "fixed"],
            lists_day_type: [{
                    key: "wk",
                    text: "Week"
                },
                {
                    key: "wk_ot",
                    text: "Week OT"
                },
                {
                    key: "sat",
                    text: "Sat"
                },
                {
                    key: "sat_ot",
                    text: "Sat OT"
                },
                {
                    key: "sun",
                    text: "Sun"
                },
                {
                    key: "sun_ot",
                    text: "Sun OT"
                },
                {
                    key: "pb",
                    text: "Pub"
                },
                {
                    key: "pb_ot",
                    text: "Pub OT"
                },
            ],
            lists_formula_for_half_price: [{
                    label: "1/2",
                    key: "1/2"
                },
                {
                    label: "3/4",
                    key: "3/4"
                },
                {
                    label: "Custom",
                    key: "custom"
                },
            ],
            formula_half_price: null,
        };
    },
    computed: {
        //FOR Half Price Auto Calculation use
        calculated_breakdown() {
            let $vm = this;
            var breakdown_items = $vm.price_plan_breakdown;
            var calculate_type = $vm.formula_half_price ?? "custom";

            var new_breakdown = [];
            breakdown_items.forEach(function (b) {
                $vm.lists_day_type.forEach(function (d) {
                    let full = b[d.key];
                    let half = b[d.key + "_half"];
                    if (calculate_type == "1/2") {
                        half = full / 2; // do nothing
                    } else if (calculate_type == "3/4") {
                        half = (full * 3) / 4; // do nothing
                    } else {
                        //default do nothing
                        half = b[d.key + "_half"]; // do nothing
                    }
                    b[d.key + "_half"] = half;
                });

                new_breakdown.push(b);
            });

            return new_breakdown;
        },
    },
    methods: {
        async getPricePlanDetail() {
            axios
                .get("/setting/r/get_price_plan_detail", {
                    params: {
                        price_plan_id: this.pricePlanId,
                    },
                })
                .then((res) => {
                    let data = res.data;

                    this.service = data.service;
                    this.serviceId = this.service.id;
                    this.price_plan = data.price_plan;
                    this.price_plan_breakdown = data.price_plan_breakdown;
                    this.price_plan_group_by_id = data.price_plan_group_by_id;
                    this.lists_price_plan = data.lists_price_plan;
                });
        },
        editPricePlan(priceId) {
            this.$router.push({
                path: `/price_plan/${priceId}`
            });
        },
        addGroupItemPopUp(group) {
            this.new_group_info = group;
            this.new_group_item.group_id = group.id;
            this.$refs["modal-add-new-group-item"].show();
        },
        addNewGroupItem() {
            let group_name = this.new_group_info.group_name;
            this.$swal({
                title: "Confirmation",
                text: "Confirm to add new item for group [" + group_name + "] ?",
                showCancelButton: true,
            }).then((result) => {
                if (result.value) {
                    axios
                        .post("/setting/r/price_plan/add_new_group_item", {
                            item: this.new_group_item,
                        })
                        .then((res) => {
                            location.reload();
                        });
                }
            });
        },
        deleteGroupItem(group_item_id) {
            this.$swal({
                title: "Confirmation",
                text: "Confirm to delete this item ?",
                showCancelButton: true,
            }).then((result) => {
                if (result.value) {
                    axios
                        .post("/setting/r/price_plan/delete_group_item", {
                            group_item_id: group_item_id,
                        })
                        .then((res) => {
                            location.reload();
                        });
                }
            });
        },
        updateGroup(group) {
            this.$swal({
                title: "Confirmation",
                text: "Confirm to update this group ?",
                showCancelButton: true,
            }).then((result) => {
                if (result.value) {
                    axios
                        .post("/setting/r/price_plan/update_group", {
                            group: group,
                        })
                        .then((res) => {
                            location.reload();
                        });
                }
            });
        },
        editGroup(group) {
            let v = !group.edit_mode;
            Vue.set(group, "edit_mode", v);
        },
        deleteGroup(group) {
            let group_name = group.group_name;
            this.$swal({
                title: "Confirmation",
                text: "Confirm to delete this group [" + group_name + "] ?",
                showCancelButton: true,
            }).then((result) => {
                if (result.value) {
                    axios
                        .post("/setting/r/price_plan/delete_group", {
                            group_id: group.id,
                        })
                        .then((res) => {
                            location.reload();
                        });
                }
            });
        },
        addNewGroupPopUp() {
            this.$refs["modal-add-new-group"].show();
        },
        addNewGroup() {
            let price_plan = this.price_plan;
            let new_group = this.new_group;
            this.$swal({
                title: "Confirmation",
                text: "Confirm to add group ?",
                showCancelButton: true,
            }).then((result) => {
                if (result.value) {
                    axios
                        .post("/setting/r/price_plan/add_new_group", {
                            price_plan_id: price_plan.id,
                            group: new_group,
                        })
                        .then((res) => {
                            location.reload();
                        });
                }
            });
        },
        closeModalAddNewGroupItem() {
            this.$refs["modal-add-new-group-item"].hide();
        },
        closeModalNewGroup() {
            this.$refs["modal-add-new-group"].hide();
        },
        updatePricePlan() {
            this.$swal({
                title: "Confirmation",
                text: "Confirm to update price plan info ?",
                showCancelButton: true,
            }).then((result) => {
                if (result.value) {
                    axios
                        .post("/setting/r/price_plan/update_price_plan", {
                            price_plan: this.price_plan,
                        })
                        .then((res) => {
                            location.reload();
                        });
                }
            });
        },
        cloneExistingPopUp() {
            this.$refs["modal-clone-existing"].show();
        },
        cloneExisting() {
            if (this.price_plan_id_to_clone == null) {
                alert("Cannot empty");
                return;
            }
            this.$swal({
                title: "Confirmation",
                text: "Confirm to clone selected price plan (All information in current plan will be overrided) ?",
                showCancelButton: true,
            }).then((result) => {
                if (result.value) {
                    axios
                        .post("/setting/r/price_plan/clone_existing", {
                            price_plan_id: this.price_plan.id,
                            clone_plan_id: this.price_plan_id_to_clone,
                        })
                        .then((res) => {
                            location.reload();
                        });
                }
            });
        },
        closeModalCloneExisting() {
            this.$refs["modal-clone-existing"].hide();
        },
        savePricePlanBreakdown() {
            this.$swal({
                title: "Confirmation",
                text: "Confirm to save price plan service pricing ?",
                showCancelButton: true,
            }).then((result) => {
                if (result.value) {
                    axios
                        .post("/setting/r/price_plan/save_price_plan_breakdown", {
                            price_plan_id: this.price_plan.id,
                            price_plan_breakdown: this.price_plan_breakdown,
                        })
                        .then((res) => {
                            location.reload();
                        });
                }
            });
        },
        deletePricePlan() {
            this.$swal({
                title: "Confirmation",
                text: "Confirm to delete this price plan ? (This action cannot be reversed)",
                showCancelButton: true,
            }).then((result) => {
                if (result.value) {
                    axios
                        .post("/setting/r/price_plan/delete_price_plan", {
                            price_plan_id: this.price_plan.id,
                        })
                        .then((res) => {
                            this.$router.go(-1);
                        });
                }
            });
        },
    },
    created() {
        let params = this.$route.params;
        this.pricePlanId = params.pricePlanId;
        this.getPricePlanDetail();
    },
};
</script>
