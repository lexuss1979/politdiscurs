<template>
    <div :class="['select-wrapper',{'disable':disable}]" ref="wrapper" v-click-outside="closeDropdown">
        <div class="overlay"></div>
        <div class="select-container">
            <div :class="['active-text', { 'has-value': hasSelectedItem , 'resetable':this.resetable !== undefined}]">
                <span v-text="this.activeText" @click="openDropdown" :title="this.activeText"></span>
                <input class="filter-input" ref="filterInput" v-model="filter" v-show="filterInputVisible"></input>
                <div class="reset-btn" @click="reset"></div>
                <div :class="['open-btn',{'opened': isDropdownOpen}]"  @click="toggleDropdown"></div>
            </div>
            <div class="dropdown" ref="dropdown" v-show="isDropdownOpen" v-cloak>
                <div class="dropdown-list">
                    <div class="dropdown-element" v-for="(item,index) in filteredItems" @click="select(item.id)">{{item.title}}</div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    let Vue = require('vue');
    const SEARCH_ANY = 'contains';
    const SEARCH_START = 'start';
    const NOT_DEFINED = -1;
    export default {
        name: "AdvancedSelect",
        props: ['placeholder','resetable','value','searchType','filterable','disable'],
        data(){
            return {
                placeholderText: 'Выберите',
                isDropdownOpen: false,
                filter:'',
                filterableProp: this.filterable !== undefined,
                searchTypeProp: this.searchType !== undefined && this.searchType === SEARCH_ANY ? SEARCH_ANY : SEARCH_START,
            }
        },
        mounted(){
            if(this.placeholder !==undefined) this.placeholderText  = this.placeholder;
        },
        methods:{
            reset(){
                this.select(null);
            },
            select(id){
                let newState = this.value.map((item, index) => {
                    item.on = item.id === id;
                    return item;
                });

                this.$emit('input',newState);
                this.closeDropdown();
            },
            openDropdown(){
                if(this.disabled) return;
                let width = this.$refs['wrapper'].clientWidth;
                this.$refs['dropdown'].style.minWidth = width + 'px';
                this.filter='';
                this.isDropdownOpen = true;
                this.$nextTick(() =>{
                    this.$refs.filterInput.focus();
                });

            },
            closeDropdown(){
                this.isDropdownOpen = false;
            },
            toggleDropdown(){
                if(this.isDropdownOpen) {
                    this.closeDropdown();
                } else {
                    this.openDropdown();
                }
            }
        },
        computed:{
            disabled(){
              return this.disable === true;
            },
            hasSelectedItem(){
                return this.selectedItemIndex !== NOT_DEFINED;
            },
            activeText(){
                return this.hasSelectedItem ?  this.value[this.selectedItemIndex].title : this.placeholderText;
            },
            selectedId(){
                return this.hasSelectedItem ?  this.value[this.selectedItemIndex].id : null;
            },
            selectedItemIndex(){
               if(!this.value) return NOT_DEFINED;
              let selected = this.value.findIndex((item)=>{return item.on === true});
              return selected !== undefined ? selected : NOT_DEFINED;
            },
            filteredItems(){
                if(this.filter == '') return this.value;
                let needle = this.filter.toLowerCase();
                function startBy(item){
                    return item.title.toLowerCase().search(needle) === 0;
                }
                function contains(item){
                    return item.title.toLowerCase().search(needle) > -1;
                }
                return this.value.filter(this.searchTypeProp === SEARCH_ANY ? contains : startBy);


            },
            filterInputVisible(){
                return this.filterableProp && this.isDropdownOpen;
            }
        }
    }
</script>

<style scoped lang="scss">
    .disable{
        .open-btn{
            opacity: 0.2;
        }
    }
    .select-container{
        width: 100%;
        min-width: 125px;
        height: 37px;
        .active-text{
            width:100%;
            background-color: #e7e7e7;
            color: rgba(0, 0, 0, 0.18);
            position: relative;
            height: 37px;
            &.has-value{
                color: rgba(0, 0, 0, 0.59);
                &.resetable{
                    .reset-btn{display: block;}
                    .open-btn{display: none;}
                }

            }
            .filter-input{
                position: absolute;
                top: 0;
                left: 0;
                padding: 0 10px;
                width: 80%;
                height: 37px;
                line-height: 37px;
                background-color: #e7e7e7;
                border: 0;
                &:focus{
                    outline: none;
                    padding: 0 10px;
                }
            }
            span{
                width: 100%;
                padding: 0 40px 0 10px;
                display: inline-block;
                height: 37px;
                line-height: 37px;
                font-size: 18px;
                white-space: nowrap;
                overflow-x: hidden;
                text-overflow: ellipsis;
            }
            .reset-btn{
                background-image: url('./img/select/select-reset.svg');
                position: absolute;
                top:0;
                right: 0;
                width: 37px;
                height: 37px;
                display: none;
                cursor: pointer;

            }
            .open-btn{
                transition: 0.3s ease-in-out;
                background-image: url('./img/select/select-open.svg');
                position: absolute;
                cursor: pointer;
                top:0;
                right: 0;
                width: 32px;
                height: 32px;
                display: block;

                &.opened{
                    transform: rotate(180deg);
                    top: 4px;
                }
            }
        }

        .dropdown{
            z-index: 10;
            position:absolute;
            .dropdown-list{
                max-height: 252px;
                box-shadow: 0 3px 4px 0 rgba(0, 0, 0, 0.25);
                border: solid 1px rgba(151, 151, 151, 0.25);
                background-color: #ffffff;
                overflow-y: auto;
                .dropdown-element{
                    cursor: pointer;
                    height: 38px;
                    line-height: 38px;
                    background-color: #fff;
                    opacity: 0.8;
                    font-size: 16px;
                    color: rgba(0, 0, 0, 0.78);
                    padding: 0 18px;
                    white-space: nowrap;

                    &:hover{
                        background-color: rgba(234, 231, 223, 0.8);
                    }
                }
            }
        }
    }
</style>
