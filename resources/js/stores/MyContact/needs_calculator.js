import MixinNeedsCalculator from "../../Mixins/MyContact/needs_calculator"
let MixinNC = MixinNeedsCalculator.methods;

export default ({
    namespaced: true,
    state: {
        id: "",
        contact_id: null,
        vlife_setting: {},
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
            Vue.set(nc_data_by_type[index], 'deleted', 1)
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

        //insert new row to nc data
        addNCDataField(state, params) {
            let type = params.nc_type;
            let obj = params.object;
            state.nc_data[type].push(obj);
        },


        setVLifeSettingData(state, data) {
            state.vlife_setting = data
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
        getVLifeSetting(store) {
            axios.get('/get_vlife_setting').then(res => {
                let data = res.data
                store.commit('setVLifeSettingData', data);
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
                        Vue.swal("Success", "Record has been saved", "success")

                    }
                })
        },
    }
})