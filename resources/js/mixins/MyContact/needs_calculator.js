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
        getInterestInputArray() {
            let arr_normal = [
                'mortgage_loan',
                'car_loan',
                'study_loan',
                'business_loan'
            ];
            return arr_normal
        },
        getPVInputArray() {
            // SUB TYPE Category
            let arr_pv = [
                'income_replacement',
                'others',
                'parents_allowance',
                'spouse_allowance',
                'spouse_retirement',
                'children_allowance',
                'special_wish',

            ];
            return arr_pv;
        }



    },
    created() {

    }
})