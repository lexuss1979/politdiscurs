<template>
    <div class="wrapper">
        <div class="container">
            <input type="text" :placeholder="placeholder" class="search-input" v-model="searchStr" @keydown.enter="doSearch">
            <div class="search-btn" @click="doSearch"></div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SearchInput",
        props: ['placeholder'],
        data(){
            return {
                searchStr:''
            }
        },
        methods:{
            doSearch(){
                this.$emit('on-do-search',this.searchStr)
            }
        }
    }
</script>

<style scoped lang="scss">
    .container{
        background-color: #e7e7e7;
        height: 37px;
        position: relative;
        &>input.search-input{
            width: 100%;
            padding: 0 40px 0 0;
            background-color: transparent;
            border: 0 !important;
            display: inline-block;
            width: 100%;
            font-size: 15px;
            height: 37px;
            line-height: 37px;
            color: rgba(0, 0, 0, 0.59);
            &::placeholder {
                color: rgba(0, 0, 0, 0.18);
            }
            &:focus{
                outline: none;
            }
        }
        .search-btn{
            position: absolute;
            background-color: #c6913c;
            width: 39px;
            height: 37px;
            top: 0;
            right: 0;
            cursor: pointer;
            &:after{
                content: url('/img/layout/search.svg');
                width: 32px;
                height: 32px;
                display: block;
                position: absolute;
                top: 2px;
                left: 2px;
            }
        }
    }
</style>
