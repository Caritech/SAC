<template>
    <div>
        <ul class="nav nav-pills justify-content-center">
            <li
                class="nav-item"
                v-for="type in ['overview','insurance','assurance_needs','remarks']"
            >
                <a
                    class="nav-link "
                    :class="{active:anchor==type}"
                    data-toggle="pill"
                    :href="'#summary_'+type"
                    @click="setAnchor(type)"
                >{{kebabCaseToString(type)}}</a>
            </li>
        </ul>
        <div class="tab-content">

            <!-- Total Insurance-->
            <div
                class="tab-pane container"
                v-for="type in ['overview','insurance','assurance_needs','remarks']"
                :class="{active:anchor==type}"
                :id="'summary_'+type"
            >
                <template v-if="type=='overview'">
                    <OverviewComponent />
                </template>
                <template v-if="type=='insurance'">
                    <InsuranceComponent />
                </template>
                <template v-if="type=='assurance_needs'">
                    <AssuranceNeedsComponent />
                </template>
                <template v-if="type=='remarks'">
                    <RemarkComponent />
                </template>
            </div>

        </div>
    </div>
</template>

<script>
import AssuranceNeedsComponent from "../../../components/Summary/AssuranceNeedsComponent"
import InsuranceComponent from "../../../components/Summary/InsuranceComponent"
import OverviewComponent from "../../../components/Summary/OverviewComponent"
import RemarkComponent from "../../../components/Summary/RemarkComponent"
export default {
    components: {
        OverviewComponent,
        AssuranceNeedsComponent,
        InsuranceComponent,
        RemarkComponent,
    },
    data() {
        return {
            anchor: null,
        }
    },
    methods: {},
    created() {
        var vm = this
        vm.id = vm.$route.params.id

        let window_hash = window.location.hash
        let available_hash = [
            "#overview",
            "#insurance",
            "#assurance_needs",
            "#remarks",
        ]
        if (available_hash.includes(window_hash)) {
            this.anchor = window.location.hash.replace("#", "")
        }

        if (!available_hash.includes(window_hash)) {
            this.anchor = "overview"
            this.$store.commit("updateViewState")
        }
    },
}
</script>
