<template>
    <input type="text" @click="onclick" class="main-element" v-model="search">
</template>

<script>
    export default {
        name: "InputTest",
        data(){
            return {
                search: 'my value'
            }
        },
        methods:{
            onclick(){
                alert('input value is' + this.search);
            }
        }
    }
</script>

<style scoped>
    .main-element{

    }
</style>
