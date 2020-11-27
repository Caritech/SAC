<template>
    <div class="">
        <h1 class="title-cyan">Assurance Needs</h1>
        <div class="row mb-5">
            <div class="col-8">

                <div
                    class="card mb-4"
                    v-for="(asn,asn_key) in assurance_need"
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

                            <template
                                v-for="(type,type_key) in ['need','have']"
                                v-if="asn[type].length > 0"
                            >
                                <h4>{{type.toUpperCase()}}</h4>
                                <div
                                    class="card mb-2"
                                    v-for="(ele,ele_key) in (asn[type])"
                                >
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-1">
                                                <b-btn
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
                                            <div
                                                class="row"
                                                v-for="item in ele.items"
                                            >
                                                <div class="col-1">
                                                    <b-form-checkbox
                                                        size="lg"
                                                        value="1"
                                                    />
                                                </div>
                                                <div class="col-8 text-left">{{item.title}}</div>
                                                <div class="col-3 text-right">{{moneyFormat(item.amount)}}</div>
                                            </div>
                                        </div>
                                    </b-collapse>
                                </div>
                            </template>

                        </div>
                    </b-collapse>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-8">Total Need</div>
                            <div class="col-4 text-right">{{ moneyFormat(asn.total_need)}}</div>
                        </div>
                        <div class="row">
                            <div class="col-8">Total Have</div>
                            <div class="col-4 text-right">{{moneyFormat(asn.total_have)}}</div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                Total
                                <span v-if="asn.total_have>asn.total_need">Surplus</span>
                                <span>Shortfall</span>
                            </div>
                            <div class="col-4 text-right">{{moneyFormat(asn.total_have - asn.total_need)}}</div>
                        </div>
                    </div>
                </div>

                <div class="card h3">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-8">Total Need</div>
                            <div class="col-4 text-right">234</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-8">Total Have</div>
                            <div class="col-4 text-right">234423</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-8">
                                Total
                                <span v-if="true">Surplus</span>
                                <span>Shortfall</span>
                            </div>
                            <div class="col-4 text-right">23432</div>
                        </div>
                    </div>

                </div>

            </div>
            <div class="col-4">
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
                                    @change="inclRecommendation($event,rec)"
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
            assurance_need: {
                medical: {
                    title: "MEDICAL",
                    total_need: 1000,
                    total_have: 1000,
                    need: [],
                    have: [],
                },
                critical_illness: {
                    title: "CRITICAL ILLNESS",
                    total_need: 1000,
                    total_have: 1000,
                    need: [],
                    have: [],
                },
                death_tpd: {
                    title: "DEATH / TPD",
                    total_need: 1000,
                    total_have: 1000,
                    need: [
                        {
                            title: "Final Expenses",
                            total: 50000,
                            items: [
                                {
                                    title: "To Pay For Final Expense",
                                    amount: 5000,
                                },
                            ],
                        },
                    ],
                    have: [
                        {
                            title: "WAWA",
                            total: 50000,
                            items: [
                                {
                                    title: "GEL 152151",
                                    amount: 15000,
                                },
                            ],
                        },
                    ],
                },
            },
        }
    },
    methods: {
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
    },
    created() {
        this.contact_id = this.$route.params.id
        this.getRecommendation()
    },
}
</script>