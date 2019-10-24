<template>
    <div>
        <div :class="['chbox', {'on':value}]" @click="toggle"></div>
        <span class="chbox-label" @click="toggle"><slot></slot></span>
    </div>

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
        cursor: pointer;
        &.on{
            background: url('./img/checkbox/on.svg');
        }
    }
    .chbox-label{
        display: inline-block;
        cursor: pointer;
        max-width: 80%;
        vertical-align: top;
        color: rgba(0, 0, 0, 0.59);
    }
</style>
