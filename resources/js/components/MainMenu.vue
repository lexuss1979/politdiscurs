<template>
    <div class="main-menu-wrapper" @mouseleave="closeMenu">
        <div class="main-menu">
            <div v-for="rootItem in rootTopics()" class="root-menu">
                <span @click="showLevel2(rootItem.id)" :class="['main-menu-btn',{'active':rootItem.id==level1activeId}]">{{rootItem.title}}</span>
            </div>
        </div>
        <div class="sub-menu-wrapper">
            <div :class="['sub-menu',subMenuType]">
                <div class="level-2"  v-if="level2.length>0">
                    <div class="wrapper">
                        <div class="line" v-for="item in level2" @mouseover="showLevel3(item.id, item.bgcolor)" :style="'background-color:' +  convertHex(item.bgcolor,71)">
                            <div :class="['arrow',{'active':item.id==level2activeId}]"><a :href="'topics/'+item.id">{{item.title}}</a></div>
                        </div>
                    </div>

                </div>
                <div class="level-3"  v-if="level3.length>0">
                    <div :class="['wrapper', {'sm': level3lowLineHeight}]" :style="'background-color:' + convertHex(level3bgcolor,71) ">
                        <div class="line"  v-for="item in level3" ><a :href="'topics/'+item.parent+'?topics[]='+item.id">{{item.title}}</a></div>
                    </div>

                </div>
            </div>
        </div>

    </div>

</template>

<script>
    export default {
        methods:{
            closeMenu(){
                this.level2 =  [];
                this.level3 = [];
                this.level2activeId = null;
                this.level1activeId = null;
            },
            convertHex: function (color,opacity) {
                color = color.replace('#', '');
                let r = parseInt(color.substring(0, 2), 16);
                let g = parseInt(color.substring(2, 4), 16);
                let b = parseInt(color.substring(4, 6), 16);
                return 'rgba(' + r + ',' + g + ',' + b + ',' + opacity / 100 + ')';
            },
            showLevel2(id){
                this.subMenuType =  id !== this.leftRootTopicID ?'right':'left';
                this.level2 =  this.getChildren(id);
                this.level1activeId = id;
                this.level3 = [];
            },
            showLevel3(id, bgc){
                this.level2activeId = id;
                this.level3 =  this.getChildren(id);
                this.level3bgcolor = bgc;
                this.level3lowLineHeight = parseInt(id) === 7;
            },
            rootTopics(){
                return this.getChildren(null);
            },
            getChildren(id){
                return this.items.filter((item) => {
                   return item.parent === id;
                });
            }
        },
        data: function () {
            return {
                subMenuType: 'left',
                level2:[],
                level3bgcolor:null,
                level2activeId: null,
                level1activeId: null,
                level3:[],
                level3lowLineHeight: false,
                leftRootTopicID: 1,
                items: [


                    {
                        "id": 1,
                        "title": "Международные отношения",
                        "bgcolor": null,
                        "parent": null
                    },
                    {
                        "id": 8,
                        "title": "Внутренняя политика",
                        "bgcolor": null,
                        "parent": null
                    },
                    {
                        "id": 2,
                        "title": "Государство",
                        "bgcolor": "#da7144",
                        "parent": 8
                    },
                    {
                        "id": 3,
                        "title": "Политика и экономика",
                        "bgcolor": "#8fac6a",
                        "parent": 8
                    },
                    {
                        "id": 4,
                        "title": "Гражданское общество",
                        "bgcolor": "#635441",
                        "parent": 8
                    },
                    {
                        "id": 5,
                        "title": "Демократия и выборы",
                        "bgcolor": "#b3934d",
                        "parent": 8
                    },
                    {
                        "id": 6,
                        "title": "Федерализм и регионы",
                        "bgcolor": "#c68e89",
                        "parent": 8
                    },
                    {
                        "id": 7,
                        "title": "Культура и идеология",
                        "bgcolor": "#b7713a",
                        "parent": 8
                    },
                    {
                        "id": 15,
                        "title": "Эволюция государственности",
                        "bgcolor": null,
                        "parent": 2
                    },
                    {
                        "id": 16,
                        "title": "Политические системы и режимы",
                        "bgcolor": null,
                        "parent": 2
                    },
                    {
                        "id": 17,
                        "title": "Феномен власти",
                        "bgcolor": null,
                        "parent": 2
                    },
                    {
                        "id": 18,
                        "title": "Президентство",
                        "bgcolor": null,
                        "parent": 2
                    },
                    {
                        "id": 19,
                        "title": "Парламентаризм",
                        "bgcolor": null,
                        "parent": 2
                    },
                    {
                        "id": 20,
                        "title": "Суверенитет",
                        "bgcolor": null,
                        "parent": 2
                    },
                    {
                        "id": 21,
                        "title": "Государство и бизнес",
                        "bgcolor": null,
                        "parent": 3
                    },
                    {
                        "id": 22,
                        "title": "Политическая экономия",
                        "bgcolor": null,
                        "parent": 3
                    },
                    {
                        "id": 23,
                        "title": "Социальные группы. Равенство и неравенство",
                        "bgcolor": null,
                        "parent": 3
                    },
                    {
                        "id": 24,
                        "title": "Экономическая политика центра и регионов",
                        "bgcolor": null,
                        "parent": 3
                    },
                    {
                        "id": 25,
                        "title": "Права человека и гуманитарные проблемы",
                        "bgcolor": null,
                        "parent": 4
                    },
                    {
                        "id": 26,
                        "title": "Элиты и общество",
                        "bgcolor": null,
                        "parent": 4
                    },
                    {
                        "id": 27,
                        "title": "Институты гражданского общества",
                        "bgcolor": null,
                        "parent": 4
                    },
                    {
                        "id": 28,
                        "title": "Группы интересов и лоббизм",
                        "bgcolor": null,
                        "parent": 4
                    },
                    {
                        "id": 29,
                        "title": "Политические аспекты СМИ",
                        "bgcolor": null,
                        "parent": 4
                    },
                    {
                        "id": 30,
                        "title": "Политические процессы",
                        "bgcolor": null,
                        "parent": 5
                    },
                    {
                        "id": 31,
                        "title": "Транзитные общества-революции и реформы",
                        "bgcolor": null,
                        "parent": 5
                    },
                    {
                        "id": 32,
                        "title": "Политические партии",
                        "bgcolor": null,
                        "parent": 5
                    },
                    {
                        "id": 33,
                        "title": "Выборы и электоральные процессы",
                        "bgcolor": null,
                        "parent": 5
                    },
                    {
                        "id": 34,
                        "title": "Политические технологии",
                        "bgcolor": null,
                        "parent": 5
                    },
                    {
                        "id": 35,
                        "title": "Политические конфликты",
                        "bgcolor": null,
                        "parent": 5
                    },
                    {
                        "id": 36,
                        "title": "Федерализм и унитаризм",
                        "bgcolor": null,
                        "parent": 6
                    },
                    {
                        "id": 37,
                        "title": "Регионы России",
                        "bgcolor": null,
                        "parent": 6
                    },
                    {
                        "id": 38,
                        "title": "Централизация-децентрализация-сепаратизм",
                        "bgcolor": null,
                        "parent": 6
                    },
                    {
                        "id": 39,
                        "title": "Этнокультурное разнообразие",
                        "bgcolor": null,
                        "parent": 6
                    },
                    {
                        "id": 40,
                        "title": "Мораль и политика",
                        "bgcolor": null,
                        "parent": 7
                    },
                    {
                        "id": 41,
                        "title": "Идеологии",
                        "bgcolor": null,
                        "parent": 7
                    },
                    {
                        "id": 42,
                        "title": "Идентичность социальная и политическая",
                        "bgcolor": null,
                        "parent": 7
                    },
                    {
                        "id": 43,
                        "title": "Политическая психология",
                        "bgcolor": null,
                        "parent": 7
                    },
                    {
                        "id": 44,
                        "title": "Политическая коммуникация",
                        "bgcolor": null,
                        "parent": 7
                    },
                    {
                        "id": 45,
                        "title": "Политические культуры",
                        "bgcolor": null,
                        "parent":14
                    },
                    {
                        "id": 46,
                        "title": "Проблема политического насилия",
                        "bgcolor": null,
                        "parent": 14
                    },
                    {
                        "id": 9,
                        "title": "Миропорядок",
                        "bgcolor": "#b498a6",
                        "parent": 1
                    },
                    {
                        "id": 10,
                        "title": "Международная безопасность",
                        "bgcolor": "#73aba2",
                        "parent": 1
                    },
                    {
                        "id": 11,
                        "title": "Внешняя политика России",
                        "bgcolor": "#887da7",
                        "parent": 1
                    },
                    {
                        "id": 12,
                        "title": "История международных отношений",
                        "bgcolor": "#a29f9c",
                        "parent": 1
                    },
                    {
                        "id": 13,
                        "title": "Международные организации",
                        "bgcolor": "#8ea8c2",
                        "parent": 1
                    },
                    {
                        "id": 14,
                        "title": "Теория межденародных отношений",
                        "bgcolor": "#71aab9",
                        "parent": 1
                    }
                ]
            }
        }
    }
</script>

<style scoped lang="scss">
    .main-menu-wrapper{
        position: relative;
    }
    .sub-menu-wrapper{
        position: absolute;
        top: 78px;
        width: 1200px;
        left: 0;
        z-index: 100;
        box-shadow: 0 2px 7px 0 rgba(0, 0, 0, 0.5);
    }
    .sub-menu{
        position: relative;
        .level-2{
            display: block;
            .wrapper{
                width: 100%;
                height: 100%;
                background-color: #fff;
            }
            .line{
                display: block;
                width: 100%;
                height: 37px;
                line-height: 37px;
                font-size: 14px;
                color: #3d3d3d;
                border-top: solid 1px rgba(78, 54, 13, 0.2);

                .arrow{
                    display: inline-block;
                    width: 270px;
                    height: 37px;
                    position: relative;

                    &.active{
                        a{
                            color: #fff;
                        }

                    }

                }
                a {
                    color: #3d3d3d;


                    &:hover{
                        text-decoration: none;
                    }
                }

            }
        }
        .level-2{
            text-transform: uppercase;
        }
        .level-3{
            position: absolute;
            width: 710px;
            top:0;
            height: 222px;
            opacity: 1 !important;
            background-color: #fff;



            .wrapper{
                width: 100%;
                height: 100%;
                padding: 0 30px;

                &.sm{
                    .line{
                        line-height: 2.25;
                    }
                }
            }

            .line{
                font-size: 14px;
                line-height: 2.5;
                letter-spacing: normal;
                color: #ffffff;

                a{
                    color: #ffffff;

                }
            }
        }

        &.left{
            .level-2{

                .arrow{
                    width: 300px !important;
                }
                .arrow:after{

                    transition: 0.3s ease-in-out;
                    content: url("/img/layout/send-ico-light.svg");
                    width: 16px;
                    height: 16px;
                    display: block;
                    transform: rotate(-90deg);
                    padding: 2px;
                    position: absolute;
                    top: 10px;
                    right: -10px;
                }
                &  .line{
                    padding-left: 127px;

                    .arrow.active{
                        &:after{
                            right: -33px;
                        }
                    }

                }
            }

            .level-3{
                right: 0;
            }
        }
        &.right{
            .level-3 {
                left: 0;
                text-align: right;
            }
            .level-2{
                .arrow{
                    width: 270px;
                    &:before{

                        transition: 0.3s ease-in-out;
                        content: url("/img/layout/send-ico-light.svg");
                        width: 16px;
                        height: 16px;
                        display: block;
                        transform: rotate(90deg);
                        padding: 2px;
                        position: absolute;
                        top: 10px;
                        left: -20px;
                    }
                }

                &  .line{
                    padding-left: 770px;
                    text-align: left;
                    .arrow.active{

                        &:before{
                            left: -33px;
                        }
                    }

                }
            }
        }
    }
    .main-menu{
        width: 100%;
        height: 78px;
        background-color: #eae7df;
        display: flex;
        & > div.root-menu{
            width:50%;
            text-align: center;
            line-height: 78px;
            position: relative;
        }
        &-btn{
            text-align: center;
            font-size: 20px;
            color: #3d3d3d;
            cursor: pointer;
            transition: 0.3s ease-in-out;
            text-transform: uppercase;
            &.active{
                font-size: 22px;
                font-weight: bold;
                color: #000000;
                border-bottom:  solid 4px #c6913c;
            }
        }
    }

</style>
