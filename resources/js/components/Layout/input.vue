<template>
    <div class="form-floating mb-3">
        <input 
            :type=type 
            class="form-control form-control-lg" 
            :id=id
            :name=name
            :placeholder=placeholder 
            :value="value" 
            @input="$emit('update:value', $event.target.value)"
            :disabled=disabled
        />
        <label :for=id>{{ placeholder }}</label>
        <div class="text-danger" v-if="errors">{{ errors[0] }}</div>
    </div>
</template>

<script>
    //import Moment from 'moment';

    export default {
        props: {
            'type': String,
            'id': String,
            'name': String,
            'placeholder': String,
            'value': [String, Boolean],
            'disabled': Boolean,
            'errors': Array
        },
        
        data() {
            return {
                
            }
        },

        watch: {
            value: function (newValue) {
                if(this.type != "date"){
                    return "";
                }

                if(this.value == undefined || this.value == ""){
                    this.date = Moment().format('YYYY-MM-DD');
                }else{
                    this.date = this.value;
                }                
            },
        },

        methods: {
            
        },

        mounted(){

        }
    }
</script>

<style scoped>

</style>