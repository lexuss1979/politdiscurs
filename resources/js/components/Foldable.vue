<template>
    <div class="foldable" v-cloak>
        <div class="content" :style="style">
            <slot></slot>
        </div>
        <div class="btn-fold" @click="toggle">{{btnText}}</div>
    </div>
</template>

<script>
    const defaults = {
        maxHeight: 300,
        onText: 'Показать все',
        offText: 'Свернуть'
    };
    export default {
        props:['height','text-on','text-off'],
        data(){
            return {
                folded: true,
                onText: this['text-on'] !== undefined ? this['text-on'] : defaults.onText,
                offText: this['text-off'] !== undefined ? this['text-off'] : defaults.offText,
            }
        },
        methods:{
            toggle(){
                this.folded = !this.folded;
            }
        },
        computed:{
            btnText(){
                return this.folded ? this.onText : this.offText;
            },
            style(){
                if(!this.folded) return {};
                return {
                    maxHeight: this.maxHeight,
                    overflow: 'hidden'
                };
            },
            maxHeight(){
                return this.height !== undefined ? this.height + 'px' : defaults.maxHeight + 'px';
            }
        }
    }
</script>

<style scoped lang="scss">
    .content{
        display:block;
        overflow: hidden;
        &.folded{

        }
    }
    .btn-fold{
        text-align: right;
        padding-top:20px;
        &:hover{
            color: #4a90e2;
            cursor:pointer;
        }
    }

</style>
