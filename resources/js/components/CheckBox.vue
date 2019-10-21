<template>
    <div :class="['chbox', {'on':value}]" @click="toggle"></div>
</template>

<script>
    export default {
        name: "CheckBox",
        props: ['value'],
        data(){
            return {
            }
        },
        methods:{
            toggle(){
                this.$emit('input', !this.value);
            }
        },
    }
</script>

<style scoped lang="scss">
    .chbox{
        width: 24px;
        height: 24px;
        background: url('./img/checkbox/off.svg');
        display: inline-block;
        vertical-align: middle;
        &.on{
            background: url('./img/checkbox/on.svg');
        }
    }
</style>
