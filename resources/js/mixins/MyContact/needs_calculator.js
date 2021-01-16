export default ({

    methods: {

        getNeedsCalculatorItems() { },

        removeRow(type, field, index) {
            this[type][field].splice(index, 1)
        },
        getFVInputArray() {
            let arr_fv = [];
            return arr_fv;
        },
        getAmountOnlyInputArray() {
            let arr_normal = [
                'personal_medical',
                'final_expenses',
                'estate_execution',
                'children_education',
                'children_competition_capital',
                'credit_card',
                'other_loan',
                'personal_loan',
            ];
            return arr_normal
        },
        getPVInputArray() {
            // SUB TYPE Category
            let arr_pv = [
                'income_replacement',
                'others',
                'mortgage_loan',
                'car_loan',
                'study_loan',
                'parents_allowance',
                'spouse_allowance',
                'spouse_retirement',
                'children_allowance',
                'special_wish',
                'business_loan'
            ];
            return arr_pv;
        }



    },
    created() {

    }
})