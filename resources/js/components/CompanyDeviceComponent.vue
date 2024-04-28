<template v-slot:default>
    <div>
        <main>
            <div class="inner">
                <section class="top_20 bottom_20">
                    <h2 class="font_25 text_c">{{company.name}}</h2>
                </section>

                <company-header :company_id="company.id" path="1"></company-header>

                <device-component :company_id="company.id"></device-component>

            </div>
        </main>

    </div>
</template>

<script>
    import axios from 'axios';
    import Loading from './Loading';
    import CompanyHeader from "./CompanyHeader";
    import Pager from './Pager';
    import DeviceComponent from "./DeviceComponent";
    import HistoryComponent from "./HistoryComponent";

    export default {
        name: 'CompanyDeviceComponent',
        components: {
            HistoryComponent,
            CompanyHeader,
            Loading,
            Pager,
            DeviceComponent
        },
        data() {
            return {
                modal_type: 'update',
                password_changed: false,
                password: '',
                login_id: this.company.user.login_id,
                loading: false,
            }
        },
        props: {
            'company':{
                type: Object,
                required: true,
            }
        },
        methods: {
        },
        mounted() {
        }
    }
</script>
