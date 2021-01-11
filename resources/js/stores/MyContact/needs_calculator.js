import MixinNeedsCalculator from "../../Mixins/MyContact/needs_calculator"
let MixinNC = MixinNeedsCalculator.methods;

export default ({
    namespaced: true,
    state: {
        id: "",
        contact_id: null,
        industry_recommendation: {},
        contact_nc_data: {},
        nc_data: {}




    },
    /*
        Mutation is use to set data to state
    */
    mutations: {
        setId(state, v) {
            state.contact_id = v;
        },
        setNCData(state, val) {
            state.nc_data = val
        },
        setNCDataFieldDeleted(state, params) {
            let nc_type = params['nc_type'];
            let data = params['data'];

            let nc_data_by_type = state.nc_data[nc_type];
            let index = nc_data_by_type.indexOf(data)

            if (data.id != null) {

                Vue.set(nc_data_by_type[index], 'deleted', 1)
            } else {
                Vue.delete(nc_data_by_type, index)
            }

        },

        setNCFollowBenchmark(state, params) {
            let type = params.nc_type;
            let preference = state.nc_data.preference;
            let vlife_setting = state.vlife_setting;

            if (preference[type + '_follow'] == 1) {
                preference[type] = vlife_setting[type];
            } else {
                preference[type] = 0;
            }
        },

        resetNCDataField(state, params) {
            let type = params.nc_type;
            let nc_data_type = state.nc_data[type]

            for (let i in nc_data_type) {
                let d = state.nc_data[type][i];
                Vue.set(d, 'deleted', 1)
            }
        },

        //insert new row to nc data
        addNCDataField(state, params) {
            let type = params.nc_type;
            let obj = params.object;
            state.nc_data[type].push(obj);
        },


        setIndustryRecommendation(state, data) {
            state.industry_recommendation = data
        }
    },
    /*

    */
    actions: {
        getNeedsCalculatorData(store) {
            let id = store.state.contact_id;

            axios.get("/vlife/get_nc_data/" + id).then((res) => {
                let data = res.data;
                store.commit('setNCData', data)
            })
        },
        getIndustryRecommendation(store) {
            let contact_id = store.state.contact_id;
            axios.get('/vlife/my_contact/' + contact_id + '/get_nc_industry_recommendation').then(res => {
                let data = res.data
                store.commit('setIndustryRecommendation', data);
            })
        },
        addNCDataField(store, params) {
            let field = params['nc_sub_type'];
            let obj;

            let arr_fv = MixinNC.getFVInputArray();
            let arr_normal = MixinNC.getAmountOnlyInputArray();
            let arr_pv = MixinNC.getPVInputArray();

            //PV or FV Calculation
            if (arr_fv.includes(field) || arr_pv.includes(field)) {
                obj = {
                    'description': '',
                    'amount': 0,
                    'year': 0,
                    'return_percent': 0,
                    'inflation': 0,
                    'total_amount': 0,
                }
            }
            // NORMAL Calculation
            if (arr_normal.includes(field)) {
                obj = {
                    'description': '',
                    'total_amount': 0
                }
            }

            //set type to objet
            obj.type = field; // because  data are not grouped

            //using old params with additional object to mutation
            let new_params = params;
            new_params.object = obj;
            store.commit('addNCDataField', new_params)

        },
        onChangeNCFollowBenchmark(store, params) {

            let type = params.nc_type;
            let total_amount = store.state.industry_recommendation[type]

            let params2 = { 'nc_type': type };
            store.commit('resetNCDataField', params2)

            axios.get('/vlife/my_contact/get_nc_industry_recommendation_distribution', {
                params: {
                    'category': type,
                    'total': total_amount
                }
            }).then(res => {
                let data = res.data;

                for (let i in data) {
                    let d = data[i]
                    let params3 = {
                        nc_type: type,
                        object: {
                            'type': d.type,
                            'description': d.description,
                            'amount': 0,
                            'year': 0,
                            'return_percent': 0,
                            'inflation': 0,
                            'total_amount': d.total_amount,
                        }
                    }

                    store.commit('addNCDataField', params3)
                }
            })
        },
        saveNC(store) {
            let contact_id = store.state.contact_id;
            let nc_data = store.state.nc_data

            axios
                .post("/vlife/my_contact/need_calculation/save_nc", {
                    nc_data: nc_data,
                    contact_id: contact_id,
                })
                .then((response) => {
                    var data = response.data
                    if (data.errors != null) {
                        Vue.swal(
                            "Validation Error",
                            data.error_message,
                            "error"
                        )
                    } else {
                        store.dispatch('getNeedsCalculatorData')
                        Vue.swal("Success", "Record has been saved, Reloading Data ...", "success")

                    }
                })
        },
    }
})