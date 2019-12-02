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
                        <div class="line" v-for="item in level2" @mouseover="showLevel3(item.id, item.bgcolor)" :style="'background-color:' +  convertHex(item.bgcolor,opacity)">
                            <div :class="['arrow',{'active':item.id==level2activeId}]"><a :href="'topics/'+item.id">{{item.title}}</a></div>
                        </div>
                    </div>

                </div>
                <div class="level-3"  v-if="level3.length>0">
                    <div :class="['wrapper', {'sm': level3lowLineHeight}]" :style="'background-color:' + convertHex(level3bgcolor,opacity) ">
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
                this.level3lowLineHeight = parseInt(id) === 12;
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
                opacity: 100,
                level2:[],
                level3bgcolor:null,
                level2activeId: null,
                level1activeId: null,
                level3:[],
                level3lowLineHeight: false,
                leftRootTopicID: 8,
                items: [

                    {
                        "id": 8,
                        "title": "Международные отношения",
                        "bgcolor": null,
                        "parent": null
                    },
                    {
                        "id": 1,
                        "title": "Внутренняя политика",
                        "bgcolor": null,
                        "parent": null
                    },
                    {
                        "id": 2,
                        "title": "Государство",
                        "bgcolor": "#DC9C6A",
                        "parent": 1
                    },
                    {
                        "id": 3,
                        "title": "Политика и экономика",
                        "bgcolor": "#B67DAE",
                        "parent": 1
                    },
                    {
                        "id": 4,
                        "title": "Гражданское общество",
                        "bgcolor": "#719368", //719368
                        "parent": 1
                    },
                    {
                        "id": 5,
                        "title": "Демократия и выборы",
                        "bgcolor": "#4cc4a8",
                        "parent": 1
                    },
                    {
                        "id": 6,
                        "title": "Федерализм и регионы",
                        "bgcolor": "#CD7794",
                        "parent": 1
                    },
                    {
                        "id": 7,
                        "title": "Культура и идеология",
                        "bgcolor": "#63A689",
                        "parent": 1
                    },
                    {
                        "id": 43,
                        "title": "Эволюция государственности",
                        "bgcolor": null,
                        "parent": 2
                    },
                    {
                        "id": 44,
                        "title": "Политические системы и режимы",
                        "bgcolor": null,
                        "parent": 2
                    },
                    {
                        "id": 45,
                        "title": "Феномен власти",
                        "bgcolor": null,
                        "parent": 2
                    },
                    {
                        "id": 46,
                        "title": "Президентство",
                        "bgcolor": null,
                        "parent": 2
                    },
                    {
                        "id": 47,
                        "title": "Парламентаризм",
                        "bgcolor": null,
                        "parent": 2
                    },
                    {
                        "id": 48,
                        "title": "Суверенитет",
                        "bgcolor": null,
                        "parent": 2
                    },
                    {
                        "id": 49,
                        "title": "Политическая экономия",
                        "bgcolor": null,
                        "parent": 3
                    },
                    {
                        "id": 50,
                        "title": "Социальные группы. Равенство и неравенство",
                        "bgcolor": null,
                        "parent": 3
                    },
                    {
                        "id": 51,
                        "title": "Государство и бизнес",
                        "bgcolor": null,
                        "parent": 3
                    },
                    {
                        "id": 52,
                        "title": "Экономическая политика центра и регионов",
                        "bgcolor": null,
                        "parent": 3
                    },
                    {
                        "id": 53,
                        "title": "Права человека и гуманитарные проблемы",
                        "bgcolor": null,
                        "parent": 4
                    },
                    {
                        "id": 54,
                        "title": "Элиты и общество",
                        "bgcolor": null,
                        "parent": 4
                    },
                    {
                        "id": 55,
                        "title": "Институты гражданского общества",
                        "bgcolor": null,
                        "parent": 4
                    },
                    {
                        "id": 56,
                        "title": "Группы интересов и лоббизм",
                        "bgcolor": null,
                        "parent": 4
                    },
                    {
                        "id": 57,
                        "title": "Политические аспекты СМИ",
                        "bgcolor": null,
                        "parent": 4
                    },
                    {
                        "id": 58,
                        "title": "Транзитные общества-революции и реформы",
                        "bgcolor": null,
                        "parent": 5
                    },
                    {
                        "id": 59,
                        "title": "Политические партии",
                        "bgcolor": null,
                        "parent": 5
                    },
                    {
                        "id": 60,
                        "title": "Выборы и электоральные процессы",
                        "bgcolor": null,
                        "parent": 5
                    },
                    {
                        "id": 61,
                        "title": "Политические технологии",
                        "bgcolor": null,
                        "parent": 5
                    },
                    {
                        "id": 62,
                        "title": "Политические процессы",
                        "bgcolor": null,
                        "parent": 5
                    },
                    {
                        "id": 63,
                        "title": "Политические конфликты",
                        "bgcolor": null,
                        "parent": 5
                    },
                    {
                        "id": 64,
                        "title": "Регионы России",
                        "bgcolor": null,
                        "parent": 6
                    },
                    {
                        "id": 65,
                        "title": "Централизация-децентрализация-сепаратизм",
                        "bgcolor": null,
                        "parent": 6
                    },
                    {
                        "id": 66,
                        "title": "Этнокультурное разнообразие",
                        "bgcolor": null,
                        "parent": 6
                    },
                    {
                        "id": 67,
                        "title": "Федерализм и унитаризм",
                        "bgcolor": null,
                        "parent": 6
                    },
                    {
                        "id": 68,
                        "title": "Идеологии",
                        "bgcolor": null,
                        "parent": 7
                    },
                    {
                        "id": 69,
                        "title": "Идентичность социальная и политическая",
                        "bgcolor": null,
                        "parent": 7
                    },
                    {
                        "id": 70,
                        "title": "Политическая психология",
                        "bgcolor": null,
                        "parent": 7
                    },
                    {
                        "id": 71,
                        "title": "Политическая коммуникация",
                        "bgcolor": null,
                        "parent": 7
                    },
                    {
                        "id": 72,
                        "title": "Политические культуры",
                        "bgcolor": null,
                        "parent": 7
                    },
                    {
                        "id": 73,
                        "title": "Мораль и политика",
                        "bgcolor": null,
                        "parent": 7
                    },
                    {
                        "id": 74,
                        "title": "Проблема политического насилия",
                        "bgcolor": null,
                        "parent": 7
                    },
                    {
                        "id": 9,
                        "title": "Миропорядок и мировая политика",
                        "bgcolor": "#5aa4d3",
                        "parent": 8
                    },
                    {
                        "id": 10,
                        "title": "Международная безопасность",
                        "bgcolor": "#e9ba50",//e9ba50
                        "parent": 8
                    },

                    {
                        "id": 11,
                        "title": "Внешняя политика России",
                        "bgcolor": "#84bd32",//84bd32
                        "parent": 8
                    },
                    {
                        "id": 12,
                        "title": "История международных отношений",
                        "bgcolor": "#a29f9c",//a29f9c
                        "parent": 8
                    },
                    {
                        "id": 13,
                        "title": "Международные организации",
                        "bgcolor": "#7677c5", //7677c5
                        "parent": 8
                    },
                    {
                        "id": 14,
                        "title": "Теория международных отношений",
                        "bgcolor": "#c77c49",
                        "parent": 8
                    },
                    {
                        "id": 15,
                        "title": "Глобальные мегатренды. Эволюция миропорядка",
                        "bgcolor": null,
                        "parent": 9
                    },
                    {
                        "id": 16,
                        "title": "Глобальные проблемы и вызовы",
                        "bgcolor": null,
                        "parent": 9
                    },
                    {
                        "id": 17,
                        "title": "Север-Юг",
                        "bgcolor": null,
                        "parent": 9
                    },
                    {
                        "id": 18,
                        "title": "Негосударственные акторы международных отношений",
                        "bgcolor": null,
                        "parent": 9
                    },
                    {
                        "id": 19,
                        "title": "Новые независимые государства и постсоветское пространство",
                        "bgcolor": null,
                        "parent": 9
                    },
                    {
                        "id": 20,
                        "title": "Восток-Запад",
                        "bgcolor": null,
                        "parent": 9
                    },
                    {
                        "id": 21,
                        "title": "Международные конфликты и миротворчество",
                        "bgcolor": null,
                        "parent": 10
                    },
                    {
                        "id": 22,
                        "title": "Международный терроризм",
                        "bgcolor": null,
                        "parent": 10
                    },
                    {
                        "id": 23,
                        "title": "Распространение оружия массового уничтожения",
                        "bgcolor": null,
                        "parent": 10
                    },
                    {
                        "id": 24,
                        "title": "Контроль над вооружениями",
                        "bgcolor": null,
                        "parent": 10
                    },
                    {
                        "id": 25,
                        "title": "Невоенные аспекты международной безопасности",
                        "bgcolor": null,
                        "parent": 10
                    },
                    {
                        "id": 26,
                        "title": "Политика России в дальнем зарубежье",
                        "bgcolor": null,
                        "parent": 11
                    },
                    {
                        "id": 27,
                        "title": "Политика России в международных организациях",
                        "bgcolor": null,
                        "parent": 11
                    },
                    {
                        "id": 28,
                        "title": "Политика России на постсоветском пространстве",
                        "bgcolor": null,
                        "parent": 11
                    },
                    {
                        "id": 29,
                        "title": "Доктринальные документы",
                        "bgcolor": null,
                        "parent": 11
                    },
                    {
                        "id": 30,
                        "title": "Постсоветское пространство",
                        "bgcolor": null,
                        "parent": 12
                    },
                    {
                        "id": 31,
                        "title": "Ближний Восток",
                        "bgcolor": null,
                        "parent": 12
                    },
                    {
                        "id": 32,
                        "title": "Восточная Азия- Южная Азия и АТР",
                        "bgcolor": null,
                        "parent": 12
                    },
                    {
                        "id": 33,
                        "title": "Европа",
                        "bgcolor": null,
                        "parent": 12
                    },
                    {
                        "id": 34,
                        "title": "Центральная Азия",
                        "bgcolor": null,
                        "parent": 12
                    },
                    {
                        "id": 35,
                        "title": "Африка",
                        "bgcolor": null,
                        "parent": 12
                    },
                    {
                        "id": 36,
                        "title": "Америка",
                        "bgcolor": null,
                        "parent": 12
                    },
                    {
                        "id": 38,
                        "title": "Европа-Америка",
                        "bgcolor": null,
                        "parent": 12
                    },
                    {
                        "id": 41,
                        "title": "ООН и глобальное управление",
                        "bgcolor": null,
                        "parent": 13
                    },
                    {
                        "id": 42,
                        "title": "Международные организации и интеграционные объединения",
                        "bgcolor": null,
                        "parent": 13
                    },
                    {
                        "id": 39,
                        "title": "Методы изучения международных отношений",
                        "bgcolor": null,
                        "parent": 14
                    },
                    {
                        "id": 40,
                        "title": "Школы и направления в международных исследованиях",
                        "bgcolor": null,
                        "parent": 14
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
                        line-height: 1.7;
                    }
                }
            }

            .line{
                font-size: 16px;
                line-height: 1.95;
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
