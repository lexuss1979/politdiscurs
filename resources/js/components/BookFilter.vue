

<script>
    import AdvancedSelect from "./AdvancedSelect";
    export default {
        name: "BookFilter",
        props: ['data','topicId','sort'],
        components: {AdvancedSelect},
        data(){
            return {
                defaultSortId: 1,
                topics: {
                    level1: null,
                    level2: null,
                    level3: null,
                    items:[],
                    selected: null

                },
                sorts:[
                    {id:1, title: 'Названию',on: 1 === parseInt(this.sort) || this.sort === undefined},
                    {id:2, title: 'Автору',on: 2 === parseInt(this.sort)},
                    {id:3, title: 'Году',on: 3 === parseInt(this.sort)},
                ]
            }
        },
        mounted(){
            this.topics.items = this.data;
            if(this.topicId !== undefined){
                let selected = this.topics.items.filter((item) => {return item.id === parseInt(this.topicId)})[0];
                if(selected){
                    if(selected.level === 2){
                        this.topics.level1 = selected.parent;
                        this.topics.level2 = selected.id;

                    } else if(selected.level === 3) {
                        this.topics.level1 = this.getTopicById(selected.parent).parent;
                        this.topics.level2 = selected.parent;
                        this.topics.level3 = selected.id;

                    } else if(selected.level === 1) {
                        this.topics.level1 = selected.id;

                    }
                }
            }
        },
        methods:{
          change(e){
              let selected = e.filter((item) => {return item.on === true})[0];
              let topicID = selected.id !== null ? '/'+selected.id : '';
                  window.location.href="/books"+topicID;
          },
          changeSort(e){
            let newSort = e.filter((item) => {return item.on === true})[0].id;
            this.reloadWithSort(newSort);
          },

          reloadWithSort(sort){
              let url = '/books' + ( this.topicId !== undefined ? '/' + this.topicId : '');
              url = url + (sort !== this.defaultSortId ? '?sort='+sort : '' );
              window.location.href=url;
          },
          getTopicById(topicID){
              return this.topics.items.filter( (item) => {return item.id === topicID})[0];
          }
        },

       computed:{
            level1(){
                let topics = [ {id:null, title: 'Все', on: false}];
                this.topics.items.filter( (item) => { return item.level === 1 })
                    .map((item) => {
                        item.on = this.topics.level1===item.id;
                        topics.push(item); })
                ;
                return topics;
            },
            level2(){
                let topics = [ {id:this.topics.level1, title: 'Все', on: false} ];
                this.topics.items.filter( (item) => {
                    return item.level === 2 && item.parent === this.topics.level1
                }).map((item) => {
                    item.on = this.topics.level2===item.id;
                    topics.push(item);
                });
                return topics;
            },
           level3(){
               let topics = [ {id:this.topics.level2, title: 'Все', on: false} ];
               this.topics.items.filter(
                   (item) => {
                       return item.level === 3 && item.parent === this.topics.level2
                   })
                   .map((item) => { item.on = this.topics.level3===item.id; topics.push(item); });
               return topics;
           }
       }
    }
</script>

<style scoped>

</style>
