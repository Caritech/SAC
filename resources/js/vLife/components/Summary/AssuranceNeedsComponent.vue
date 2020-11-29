<template>
    <div class="">
        <h1 class="title-cyan">Assurance Needs</h1>

        <div class="row mb-5">
            <div
                class="col-8"
                style="height:70vh;overflow-y:auto"
            >
                <div
                    class="card mb-4"
                    v-for="(asn,asn_key) in computedAssurance.items"
                >
                    <div class="card-header">
                        <h3 class="title-cyan">
                            {{asn.title}}
                            <b-btn
                                variant="outline-primary"
                                class="float-right"
                                v-b-toggle="'collapse-asn'+asn_key"
                            >
                                <i class="fa fa-chevron-down"></i>
                            </b-btn>
                        </h3>
                    </div>

                    <b-collapse :id="'collapse-asn'+asn_key">
                        <div class="card-body">

                            <template v-for="(type,type_key) in ['need','have']">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h4>{{type.toUpperCase()}}</h4>
                                            </div>
                                            <div class="col">
                                                <h4 class="text-right">{{moneyFormat(asn[type].total)}}</h4>
                                            </div>
                                        </div>

                                        <!-- Sub Category like Personal Medical -->
                                        <div
                                            class="card mb-2"
                                            v-for="(ele,ele_key) in (asn[type].items)"
                                        >
                                            <div class="card-header">

                                                <div class="row h5">
                                                    <div class="col-1">
                                                        <b-btn
                                                            size="sm"
                                                            variant="outline-primary"
                                                            v-b-toggle="'collapse-item'+type_key+ele_key"
                                                        >
                                                            <i class="fa fa-chevron-down"></i>
                                                        </b-btn>

                                                    </div>
                                                    <div class="col-8 text-left">{{ele.title}}</div>
                                                    <div class="col-3 text-right">{{moneyFormat(ele.total)}}</div>
                                                </div>
                                            </div>

                                            <b-collapse :id="'collapse-item'+type_key+ele_key">
                                                <div class="card-body">
                                                    <!-- Detail Item breakdown -->
                                                    <div
                                                        class="row h5"
                                                        v-for="item in ele.items"
                                                    >
                                                        <div class="col-1">
                                                            <b-form-checkbox
                                                                size="lg"
                                                                value="1"
                                                                v-model="item.incl"
                                                            />
                                                        </div>
                                                        <div
                                                            class="row col-11 
                                                        asn-item-box
                                                        "
                                                            :class="{
                                                            not_include:item.incl!=1}"
                                                        >
                                                            <div class="col-9 text-left">
                                                                {{item.description}}
                                                                <my-range-input
                                                                    v-model="item.percentage"
                                                                    min="0"
                                                                    max="200"
                                                                ></my-range-input>
                                                            </div>
                                                            <div class="col-3 text-right">{{moneyFormat(item.amount * item.percentage / 100)}}</div>

                                                        </div>

                                                    </div>
                                                </div>
                                            </b-collapse>
                                        </div>
                                    </div>
                                </div>
                            </template>

                        </div>
                    </b-collapse>
                    <div class="card-footer">
                        <div class="row h6">
                            <div class="col-8">Total Need</div>
                            <div class="col-4 text-right">{{ moneyFormat(asn['need']['total'])}}</div>
                        </div>
                        <div class="row h6">
                            <div class="col-8">Total Have</div>
                            <div class="col-4 text-right">{{moneyFormat(asn['have']['total'])}}</div>
                        </div>
                        <div class="row font-weight-bold h5">
                            <div class="col-8">
                                Total
                                <span>{{getAssuranceText(asn)}}</span>
                            </div>
                            <div class="col-4 text-right">{{moneyFormat(calAssuranceTotal(asn))}}</div>
                        </div>
                    </div>
                </div>
                <!-- End of loop assuranced-->

                <div class="card h4">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-8">Overall</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-8">Total Need</div>
                            <div class="col-4 text-right">{{ moneyFormat(computedAssurance.need)}}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-8">Total Have</div>
                            <div class="col-4 text-right">{{ moneyFormat(computedAssurance.have)}}</div>
                        </div>
                        <div class="row mb-3 font-weight-bold">
                            <div class="col-8">
                                Total <span>{{getAssuranceText(computedAssurance)}}</span>
                            </div>
                            <div class="col-4 text-right">{{moneyFormat(calAssuranceTotal(computedAssurance))}}</div>
                        </div>
                    </div>

                </div>

            </div>
            <div
                class="col-4"
                style="height:70vh;overflow-y:auto"
            >
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>App</th>
                            <th>Recommendation
                            <th><a
                                    class="btn btn-primary"
                                    @click="addInsurance('recommendation',contact_id,true)"
                                >Add</a></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="rec in recommendation">
                            <td>
                                <b-form-checkbox
                                    size="lg"
                                    value="1"
                                    v-model="rec.incl"
                                    @change="onInclRecommendationChange($event,rec)"
                                />
                            </td>
                            <td>
                                <b>{{rec.recommendation_no}}</b><br>
                                {{rec.plan_name}}
                            </td>
                            <td>
                                <b-dropdown
                                    id="dropdown-1"
                                    class="m-md-2"
                                    no-caret
                                    variant="outline"
                                >
                                    <template #button-content>
                                        <i class="fa fa-ellipsis-v"></i>
                                    </template>
                                    <b-dropdown-item>
                                        <b-btn
                                            variant="primary "
                                            block
                                            @click="editInsurance(rec)"
                                        >
                                            Edit
                                        </b-btn>
                                    </b-dropdown-item>
                                    <b-dropdown-item>
                                        <b-btn
                                            variant="danger"
                                            block
                                            @click="deleteInsurance(rec)"
                                        >Delete</b-btn>
                                    </b-dropdown-item>

                                </b-dropdown>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</template>

<script>
import mixinInsurance from "../../../mixins/MyContact/insurance"
export default {
    mixins: [mixinInsurance],
    data() {
        return {
            contact_id: null,
            recommendation: [],
            assurance_needs: {},
            assurance_needs2: [],
        }
    },
    computed: {
        computedAssurance() {
            let vm = this
            let data = vm.assurance_needs2
            let output = {
                need: 0,
                have: 0,
                items: {},
            }
            //restructure data
            let result = {}
            data.forEach(function (v, k) {
                if (v.percentage == null) {
                    vm.$set(v, "percentage", 100)
                }
                if (v.incl == null) {
                    vm.$set(v, "incl", 1)
                }

                //no space allow for item type, because will use in key
                let item_type = v.type.replace(" ", "_")

                /* init object key*/
                //1st level (Medical, Critcal Illness, Death)
                if (result[v.category] == null) {
                    result[v.category] = {
                        title: vm.getName(v.category),
                        total: 0,
                    }
                }
                //2st level (Need, have)
                if (result[v.category][v.need_have] == null) {
                    result[v.category][v.need_have] = {
                        title: v.need_have,
                        total: 0,
                        items: {},
                    }
                }
                //3st level (Item Group)
                if (
                    result[v.category][v.need_have]["items"][item_type] == null
                ) {
                    result[v.category][v.need_have]["items"][item_type] = {
                        title: vm.getName(v.type),
                        total: 0,
                    }
                }
                //4st level (Items)
                if (
                    result[v.category][v.need_have]["items"][item_type][
                        "items"
                    ] == null
                ) {
                    result[v.category][v.need_have]["items"][item_type][
                        "items"
                    ] = []
                }
                /* END OF init object key*/

                /* Start data maniputation for reporting*/
                result[v.category]["total"] += vm.calAmount(v)
                result[v.category][v.need_have]["total"] += vm.calAmount(v)
                result[v.category][v.need_have]["items"][item_type][
                    "total"
                ] += vm.calAmount(v)

                result[v.category][v.need_have]["items"][item_type][
                    "items"
                ].push(v)
                output[v.need_have] += vm.calAmount(v)
            })
            output.items = result
            return output
        },
    },
    methods: {
        getName(name, type) {
            if (name == "personal_medical") {
                return "PERSONAL MEDICAL"
            } else if (name == "medical") {
                return "MEDICAL"
            } else if (name == "ci") {
                return "CRITICAL ILLNESS"
            } else if (name == "insurance") {
                return "INSURANCE"
            } else if (name == "income_replacement") {
                return "Income Replacement"
            } else if (name == "others") {
                return "Others"
            } else if (name == "death") {
                return "Death / TPD"
            } else if (name == "final_expenses") {
                return "Final Expenses"
            } else if (name == "parents_allowance") {
                return "Parent Allowance"
            }
            return name
        },
        //percentage * amount
        calAmount(v) {
            if (v.incl == 1) {
                return (v.amount * v.percentage) / 100
            } else {
                return 0
            }
        },
        //get surplus or shortfall
        calAssuranceTotal(asn) {
            if (asn["have"]["total"] != null) {
                return asn["have"]["total"] - asn["need"]["total"]
            } else {
                return asn["have"] - asn["need"]
            }
        },
        getAssuranceText(asn) {
            return this.calAssuranceTotal(asn) >= 0 ? "Surplus" : "Shortfall"
        },
        onInclRecommendationChange(event, rec) {
            this.assurance_needs2.forEach(function (v, k) {
                if (v.insurance_id != null && v.insurance_id == rec.id) {
                    v.incl = event
                }
            })
        },
        getRecommendation() {
            axios
                .get("/vlife/my_contact/summary/get_recommendation", {
                    params: {
                        contact_id: this.contact_id,
                    },
                })
                .then((res) => {
                    this.recommendation = res.data
                })
        },
        getAssuranceNeeds() {
            axios
                .get("/vlife/my_contact/summary/get_assurance_needs", {
                    params: {
                        contact_id: this.contact_id,
                    },
                })
                .then((res) => {
                    this.assurance_needs2 = res.data
                })
        },
    },
    created() {
        this.contact_id = this.$route.params.id
        this.getRecommendation()
        this.getAssuranceNeeds()
    },
}
</script>


<style>
.asn-item-box {
    background: #f5f5f5;
    border-radius: 10px;
    padding: 5;
    margin-bottom: 9px;
}

.asn-item-box.not_include {
    opacity: 0.5;
}

div.sticky {
    position: -webkit-sticky;
    position: sticky;
    top: 50px;
    background-color: yellow;
    padding: 50px;
    font-size: 20px;
}
</style>