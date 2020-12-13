export default ({

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
            } else if (name == "estate_execution") {
                return "Estate Execution"
            } else if (name == "spouse_retirement") {
                return "Spouse Retirement"
            } else if (name == "children_allowance") {
                return "Children Allowance"
            } else if (name == "children_education") {
                return "Children Education"
            } else if (name == "children_competition_capital") {
                return "Children Competition Capital"
            } else if (name == "mortgage_loan") {
                return "Mortgage Loan"
            } else if (name == "car_loan") {
                return "Car Loan"
            } else if (name == "study_loan") {
                return "Study Loan"
            } else if (name == "credit_card") {
                return "Credit Card"
            } else if (name == "personal_loan") {
                return "Personal Loan"
            } else if (name == "business_loan") {
                return "Business Loan / Personal Guarantor"
            } else if (name == "other_loan") {
                return "Other Loan"
            } else if (name == "special_wish") {
                return "Special Wish"
            } else if (name == "spouse_allowance") {
                return "Spouse Allowance"
            }
            return name
        },
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
                'estate_execution',
                'car_loan',
                'study_loan',
                'parents_allowance',
                'spouse_allowance',
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