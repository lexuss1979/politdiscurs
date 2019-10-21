<template>
    <div class="group-container">
        <div><check-box v-model="allChecked"  @input="toggleAll"></check-box>Все</div>
        <div v-for="(item, index) in state" >
            <check-box v-model="state[index].on" :name="item.id" @input="change"></check-box>{{item.name}}
        </div>
    </div>

</template>

<script>
    import CheckBox from './CheckBox.vue';
    export default {
        name: "CheckBoxGroup",
        props: ["initData"],
        components: {CheckBox},
        data(){
            return{
                state: [],
                allCheckedStatus: false
            }
        },
        mounted() {
            this.state=this.initData;
            this.allCheckedStatus = this.allChecked;
        },
        methods:{
            change(e){
                console.log(this.items);
                this.$emit('input', this.items);
                this.allCheckedStatus = this.allChecked;
                console.log(this.allChecked);
            },
            toggleAll(){
                this.state.map((item,i) => {
                    console.log(i);
                    this.state[i].on = true;
                });

            }
        },
        computed:{
            items(){
                return JSON.parse(JSON.stringify(this.state))
            },
            allChecked(){
                this.state.map((item) => {
                    if(item.on !== true) {
                        return false;
                    }
                });
                return true;
            }
        }
    }
</script>

<style scoped>

</style>
