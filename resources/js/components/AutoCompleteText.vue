<template>
    <div>
        <input type="text" v-model="company_name" autocomplete="off" @input="getData" class="form-control input-lg" name="company_name" :disabled="disabled" style="width:100%"/>
        <div class="panel-footer" v-if="search_data.length">
            <ul class="list-group" id="ul-company" style="z-index:100;">
                <li class="list-group-item" v-for="(data1, index) in search_data" v-bind:key="index" @click="getName(data1.name)">{{data1.name}}</li>
            </ul>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: 'AutoCompleteText',
        components: {
            
        },
        props:['companyName', 'disabled'],
        data() {
            return{
                company_name: "",
                search_data: [],
                loading: false
            }
        },
        methods:{
            getData: function(){
                if (this.loading) return;
                
                this.search_data = [];
                this.loading = true;

                axios.get('/device/searchCompanyName', {
                    params: {
                       name : this.company_name,
                    }
                })
                .then( response => response.data )
                .then( response => {
                    if (response.success) {
                        this.search_data = response.data;
                    }
                })
                .finally(() => {
                    this.loading = false;
                })
            },
            getName:function(name){
                this.search_data = [];
                this.company_name = name;
            },
        },
        mounted() {
            this.company_name = this.companyName;
        },
        watch: {
            // company_name: function(newVal, oldVal) {
            //     if (newVal !== oldVal) {
            //         this.getData();
            //     }
            // },
            companyName: function(newVal) {
                console.log("xxx");
                this.company_name = newVal
            }
        }
    }
</script>

<style>
    #ul-company {
        list-style: none;
        position: absolute;
        background-color:#ffffff; 
        padding:10px;
        border-color: gray;
        border: solid;
        border-width: thin;
    }
    #ul-company li {
        cursor: pointer;
    }
</style>
