<template>
<div>
    <ul class="nav nav-pills justify-content-center">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="pill" href="#medical">Medical</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="pill" href="#critical_illness">Critical Illness</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="pill" href="#death_tpd">Death/TPD</a>
        </li>
        <li class="nav-item">
            <!-- <a class="nav-link" data-toggle="pill" href="#retirement">Retirement</a> -->
            <button class="btn btn-secondary" disabled style="font-size: initial;">Retirement</button>
        </li>
        <li class="nav-item">
            <!-- <a class="nav-link" data-toggle="pill" href="#other">Other</a> -->
            <button class="btn btn-secondary" disabled style="font-size: initial;">Other</button>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane container active" id="medical">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-10">
                            <span class="title-cyan">MEDICAL</span> - To pay for unforeseen medical bill(s).
                        </div>
                        <div class="col-md-2">
                            <input type="number" min="0" step="0.01" class="form-control float-right field-bold" v-model="contact_nc_data.nc_medical">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h5><strong>How much do you think is sufficient?</strong></h5>
                    <table>
                        <tr>
                            <td>
                                <b-form-checkbox v-model="contact_nc_data.nc_medical_follow" @change="follow_benchmark('nc_medical')"></b-form-checkbox>
                            </td>
                            <td>Follow the recommended industry minimum benchmark</td>
                        </tr>
                    </table>
                    <hr>
                    <h5>I want</h5>
                    <div class="table-responsive" v-for="(tdata,tindex) in medical">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">
                                        <i class="btn btn-secondary clickable fas fa-chevron-down" data-toggle="collapse" :data-target="'#'+tindex" @click="collapseClick($event)"></i>
                                    </th>
                                    <th>{{ capitalizeFirstLetter(tindex) }}</th>
                                    <th class="fit">
                                        <i class="fas fa-plus btn btn-primary float-right" @click="addField('medical',tindex)"> Add</i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody :id="tindex" class="collapse show table-td-padding">
                                <tr v-for="(data,index) in tdata">
                                    <td align="center">
                                        <i class="fas fa-lg fa-minus-circle text-danger icon-button" style="padding-top: 2px;" @click="removeRow('medical',tindex,index)"></i>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" v-model="data.description">
                                    </td>
                                    <td align="right">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="number" class="form-control" v-model="data.total_amount">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row form-group-sm">
                        <div class="col-md-12 text-right">
                            <button class="btn btn-success" @click="saveNCMedical">
                                <i class="fa fa-save"></i>
                                Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane container fade" id="critical_illness">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-10">
                            <span class="title-cyan">CRITICAL ILLNESS</span> - To replace income to maintain lifestyle & basic living.
                        </div>
                        <div class="col-md-2">
                            <input type="number" min="0" step="0.01" class="form-control float-right field-bold" v-model="contact_nc_data.nc_critical_illness">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h5><strong>How much do you think is sufficient?</strong></h5>
                    <table>
                        <tr>
                            <td>
                                <b-form-checkbox v-model="contact_nc_data.nc_critical_illness_follow" @change="follow_benchmark('nc_critical_illness')"></b-form-checkbox>
                            </td>
                            <td>Industry's Recommendation (ROT - 5 years of annual income).</td>
                        </tr>
                    </table>
                    <hr>
                    <h5>I want</h5>
                    <div class="table-responsive" v-for="(tdata,tindex) in critical_illness">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">
                                        <i class="btn btn-secondary clickable fas fa-chevron-down" data-toggle="collapse" :data-target="'#'+tindex" @click="collapseClick($event)"></i>
                                    </th>
                                    <th colspan="5">{{ capitalizeFirstLetter(tindex) }}</th>
                                    <th>
                                        <i class="fas fa-plus btn btn-primary float-right" @click="addField('critical_illness',tindex)"> Add</i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody :id="tindex" class="collapse show table-td-padding">
                                <tr v-for="(data,index) in tdata">
                                    <td align="center">
                                        <i class="fas fa-lg fa-minus-circle text-danger icon-button" style="padding-top: 2px;" @click="removeRow('critical_illness',tindex,index)"></i>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" v-model="data.description">
                                    </td>
                                    <td align="right" class="fit">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="number" class="form-control" v-model="data.amount">
                                        </div>
                                    </td>
                                    <td class="fit">
                                        <input type="number" class="form-control" v-model="data.year">
                                    </td>
                                    <td class="fit">
                                        <input type="number" class="form-control" v-model="data.return_percent">
                                    </td>
                                    <td class="fit">
                                        <input type="number" class="form-control" v-model="data.inflation">
                                    </td>
                                    <td class="fit">
                                        <input type="number" class="form-control" v-model="data.total_amount">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row form-group-sm">
                        <div class="col-md-12 text-right">
                            <button class="btn btn-success" @click="saveNC">
                                <i class="fa fa-save"></i>
                                Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane container fade" id="death_tpd">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-10">
                            <span class="title-cyan">DEATH / TPD</span> - To sustain dependant(s) & payoff debt(s).
                        </div>
                        <div class="col-md-2">
                            <input type="number" min="0" step="0.01" class="form-control float-right field-bold" v-model="contact_nc_data.nc_death_tpd">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h5><strong>How much do you think is sufficient?</strong></h5>
                    <table>
                        <tr>
                            <td>
                                <b-form-checkbox v-model="contact_nc_data.nc_death_tpd_follow" @change="follow_benchmark('nc_death_tpd')"></b-form-checkbox>
                            </td>
                            <td>Industry's Recommendation (ROT - 10 years of annual income).</td>
                        </tr>
                    </table>
                    <hr>
                    <h5>I want</h5>
                    <div class="table-responsive" v-for="(tdata,tindex) in death_tpd">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">
                                        <i class="btn btn-secondary clickable fas fa-chevron-down" data-toggle="collapse" :data-target="'#'+tindex" @click="collapseClick($event)"></i>
                                    </th>
                                    <th :colspan="countObjElement(tdata)">{{ capitalizeFirstLetter(tindex) }}</th>
                                    <th>
                                        <i class="fas fa-plus btn btn-primary float-right" @click="addField('death_tpd',tindex)"> Add</i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody :id="tindex" class="collapse show table-td-padding">
                                <tr v-for="(data,index) in tdata">
                                    <td align="center">
                                        <i class="fas fa-lg fa-minus-circle text-danger icon-button" style="padding-top: 2px;" @click="removeRow('death_tpd',tindex,index)"></i>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" v-model="data.description">
                                    </td>
                                    <td align="right" class="fit" v-if="typeof(data.amount) != 'undefined' && data.amount !== null">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="number" class="form-control" v-model="data.amount">
                                        </div>
                                    </td>
                                    <td align="right" class="fit" v-if="typeof(data.installment) != 'undefined' && data.installment !== null">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="number" class="form-control" v-model="data.installment">
                                        </div>
                                    </td>
                                    <td align="right" class="fit" v-if="typeof(data.year) != 'undefined' && data.year !== null">
                                        <input type="number" class="form-control" v-model="data.year">
                                    </td>
                                    <td align="right" class="fit" v-if="typeof(data.return_percent) != 'undefined' && data.return_percent !== null">
                                        <input type="number" class="form-control" v-model="data.return_percent">
                                    </td>
                                    <td align="right" class="fit" v-if="typeof(data.inflation) != 'undefined' && data.inflation !== null">
                                        <input type="number" class="form-control" v-model="data.inflation">
                                    </td>
                                    <td align="right" class="fit" v-if="typeof(data.interest) != 'undefined' && data.interest !== null">
                                        <input type="number" class="form-control" v-model="data.interest">
                                    </td>
                                    <td align="right" class="fit" v-if="typeof(data.total_amount) != 'undefined' && data.total_amount !== null">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="number" class="form-control" v-model="data.total_amount">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="row form-group-sm">
                        <div class="col-md-12 text-right">
                            <button class="btn btn-success" @click="saveNC">
                                <i class="fa fa-save"></i>
                                Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane container fade" id="retirement">

        </div>
        <div class="tab-pane container fade" id="other">

        </div>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            id: '',
            vlife_setting: {},
            contact_nc_data: {},
            medical: {
                personal_medical: [{
                    description: "",
                    total_amount: "",
                } ]
            },
            critical_illness: {
                income_replacement: [{
                    description: "To replace 3x years basic living expenses.",
                    amount: "9000",
                    year: "3",
                    return_percent: "4.0",
                    inflation: "4.0",
                    total_amount: "324000",
                }],
                others: [{
                    description: "To hire a maid to take care the necessily.",
                    amount: "2000",
                    year: "3",
                    return_percent: "0",
                    inflation: "10.0",
                    total_amount: "79200",
                }, ]
            },
            death_tpd: {
                final_expenses: [{
                    description: "To pay for final expenses.",
                    total_amount: "30000",
                }, ],
                parents_allowance: [{
                    description: "RM1k/mth for mother till her age 80",
                    amount: "1000",
                    year: "16",
                    return_percent: "4.0",
                    inflation: "4.0",
                    total_amount: "192000",
                }],
                spouse_allowance: [{
                    description: "RM1k/mth till youngest child age 25",
                    amount: "1000",
                    year: "23",
                    return_percent: "4.0",
                    inflation: "4.0",
                    total_amount: "276000",
                }],
                children_allowance: [{
                        description: "Phak Jin: RM1k/mth till age 25",
                        amount: "1000",
                        year: "21",
                        return_percent: "4.0",
                        inflation: "4.0",
                        total_amount: "252000",
                    },
                    {
                        description: "Khai Jin: RM1k/mth till age 25",
                        amount: "1000",
                        year: "23",
                        return_percent: "4.0",
                        inflation: "4.0",
                        total_amount: "276000",
                    }
                ],
                children_education: [{
                        description: "Phak Jin: To have at least RM100000 at age 18",
                        total_amount: "100000",
                    },
                    {
                        description: "Khai Jin: To have at least RM100000 at age 18",
                        total_amount: "100000",
                    }
                ],
                children_competition_capital: [],
                mortgage_loan: [{
                        description: "PEN Jay Series (Own Stay)",
                        installment: "1800",
                        year: "25",
                        interest: "4.5",
                        total_amount: "300000",
                    },
                    {
                        description: "KUL Summer Suites",
                        installment: "1800",
                        year: "25",
                        interest: "4.5",
                        total_amount: "300000",
                    },
                ],
                car_loan: [{
                    description: "Toyota Vios PPA 1234",
                    installment: "",
                    year: "",
                    interest: "",
                    total_amount: "30000",
                }, ],
                study_loan: [],
                credit_card: [],
                personal_loan: [],
                business_personal_guarantor_loan: [{
                    description: "Toyota Vios PPA 1234",
                    installment: "",
                    year: "",
                    interest: "",
                    total_amount: "30000",
                }, ],
                other_loan: [],
                special_wish: [{
                    description: "One-Off RM100k for dad.",
                    installment: "",
                    year: "",
                    interest: "",
                    total_amount: "100000",
                }, ]
            },
        };
    },
    methods: {
        checkEmpty(val) {
            if (!val) {
                val = '-';
            }
            return val;
        },
        collapseClick(event) {
            if ($(event.target).hasClass('fa-chevron-down')) {
                $(event.target).addClass('fa-chevron-up').removeClass('fa-chevron-down');
            } else {
                $(event.target).addClass('fa-chevron-down').removeClass('fa-chevron-up');
            }
        },
        removeRow(type, field, index) {
            this[type][field].splice(index, 1);
        },
        addField(type, field) {
            switch (type) {
                case "medical":
                    if (field == 'personal_medical') {
                        var empty_obj = {
                            description: "",
                            total_amount: "",
                        }
                    }
                    break;
                case "critical_illness":
                    if (field == 'income_replacement' || field == 'others') {
                        var empty_obj = {
                            description: "",
                            amount: "",
                            year: "",
                            return_percent: "",
                            inflation: "",
                            total_amount: "",
                        }
                    }
                    break;
                case "death_tpd":
                    if (field == 'final_expenses' || field == 'children_education' || field == 'children_competition_capital') {
                        var empty_obj = {
                            description: "",
                            total_amount: "",
                        }
                    } else if (field == 'parents_allowance' || field == 'spouse_allowance' || field == 'children_allowance') {
                        var empty_obj = {
                            description: "",
                            amount: "",
                            year: "",
                            return_percent: "",
                            inflation: "",
                            total_amount: "",
                        }
                    } else if (
                        field == 'mortgage_loan' ||
                        field == 'car_loan' ||
                        field == 'study_loan' ||
                        field == 'credit_card' ||
                        field == 'personal_loan' ||
                        field == 'business_personal_guarantor_loan' ||
                        field == 'other_loan'
                    ) {
                        var empty_obj = {
                            description: "",
                            installment: "",
                            year: "",
                            interest: "",
                            total_amount: "",
                        }
                    } else if (field == 'special_wish') {
                        var empty_obj = {
                            description: "",
                            installment: "",
                            year: "",
                            interest: "",
                            total_amount: "",
                        }
                    }
                    break;
            }
            this[type][field].push(empty_obj);
        },
        capitalizeFirstLetter(str) {
            var str = str.replace(/_/g, " ");
            var parts = str.split(' '),
                len = parts.length,
                i, words = [];
            for (i = 0; i < len; i++) {
                var part = parts[i];
                var first = part[0].toUpperCase();
                var rest = part.substring(1, part.length);
                var word = first + rest;
                words.push(word);
            }
            words = words.join(' ');
            if (words == 'Business Personal Guarantor Loan') {
                return 'Business Personal / Guarantor Loan'
            }
            return words;
        },
        countObjElement(tdata) {
            var counter = 0;
            $.each(tdata, function (index, value) {
                $.each(value, function (index, v) {
                    counter++;
                });
                return false;
            });
            return counter - 1;
        },
        follow_benchmark(type) {
            if (!this.contact_nc_data.type + '_follow') {
                this.contact_nc_data.type = this.vlife_setting[type];
            } else {
                this.contact_nc_data[type] = '';
            }
        },
        saveNCMedical() {
            /*alert(this.medical);
            console.log(this.medical.personal_medical);*/
            axios.post("/vlife/my_contact/need_calculation/medical/save", {
                    personal_medicals: this.medical.personal_medical,
                    contact_id:this.id

                })
                .then((response) => {
                    var data = response.data;
                    if (data.errors != null) {
                        Vue.swal("Validation Error", data.error_message, "error");
                    } else {
                        Vue.swal("Success", "Record has been saved", "success");
                        this.$router.replace("/my_contact/" + data + "/edit/needs_calculator/medical");
                    }
                });

        },
        calculateCI_income_replacement(rate,month,pmt){
            let result = 0;
            if(rate == 0){
                result = (pmt * month);
            }else{
                let pow_rate = Math.pow( 1 + rate,  month);
                result = (pmt * (( pow_rate - 1 ) / rate) / pow_rate);
            }
            return Math.round(result);
        },
        saveNC(){

        }
    },
    created() {
        var vm = this;
        vm.id = vm.$route.params.id;
        axios.get('/get_vlife_setting').then(response => {
            vm.vlife_setting = response.data
        });
        // console.log(vm.medical.personal_medical);
        axios.get('/vlife/get_nc_data/'+vm.id).then(response => {
            vm.medical.personal_medical = response.data.medical.personal_medicals;
            console.log(vm.medical.personal_medical);
        });

    }
};
</script>
