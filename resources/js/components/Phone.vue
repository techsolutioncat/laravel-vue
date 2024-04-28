<template>
    <div>
        <span class="right_5">番号</span>
        <input type="text"
               class="w_110"
               name="phones[]"
               v-model="phone_number"
               autocomplete="off"
               v-bind:disabled="!editable">
        <span class="right_5 left_10">名称</span>
        <input type="text"
               class="w_190"
               autocomplete="off"
               name="phone_names[]"
               v-model="phone_name"
               v-bind:disabled="!editable">
    </div>
</template>

<script>
    export default {
        name: "Phone",
        props:{
            phone: {
                required: false,
                type: Object,
            },
            editable: {
                required: false,
                type: Boolean,
            },
        },
        // data: function () {
        //     return {
        //         phone_number: this.phone !== undefined  ? this.phone.phone : null,
        //         phone_name: this.phone !== undefined  ? this.phone.name : null,
        //     }
        // }
        computed: {
            phone_number: {
                get: function() {
                    return this.phone !== undefined  ? this.phone.phone : null;
                },
                set: function(newValue) {

                }
            },
            phone_name: {
                get: function() {
                    return this.phone !== undefined  ? this.phone.name : null;
                },
                set: function(value) {}
            }
        }
    }
</script>

<style scoped>

</style>
