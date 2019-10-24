
<script>
    import CheckBox from "./CheckBox";
    import AdvancedSelect from "./AdvancedSelect";
    export default {
        name: "TopicFilters",
        components: {CheckBox, AdvancedSelect},
        props:['data'],
        data(){
            return{
                allTopicsSelected: this.isAllTopicsSelected,
                filters: [],
                topics:[],
                sorts:[],
                content_types:[],
                authors:[],
                organisations:[],
                regions:[],
            }
        },
        methods:{
            reset(){
                this.topics.map((item,index) => {
                    this.topics[index].on = true;
                });
                this.content_types.map((item,index) => {
                    this.content_types[index].on = true;
                });
                this.authors.map((item,index) => {
                    this.authors[index].on = false;
                });
                this.organisations.map((item,index) => {
                    this.organisations[index].on = false;
                });
                this.regions.map((item,index) => {
                    this.regions[index].on = false;
                });
                this.sorts.map((item,index) => {
                    this.sorts[index].on = false;
                });
                this.reload();
            },
            change(){
                this.$nextTick(
                    ()=>{
                        this.reload();
                    }
                );
                console.log('state is', this.getFilters());
            },
            reload(){
                let url = window.location.href;
                if(url.indexOf('?') > -1){
                    url = url.substr(0,url.indexOf('?'));
                }
                // alert(url+this.getQueryString());
                window.location.href=url+this.getQueryString();
            },
            getFilters(){
            },
            selectAllTopics(){

                this.topics.map((item,index) => {
                   this.topics[index].on = true;
                });
                this.reload();
            },
            getQueryString(){
                let query = this.getSortStr() + this.getTopicsStr() + this.getAuthorsStr() + this.getOrgStr()+this.getContentTypeStr()+this.getRegStr();
                return  query !='' ? '?' + query.substr(1) : '';
            },
            getSortStr(){
              let sort = this.sorts.find((item) => {return item.on});
              return  sort ? '&sort='+sort.id : '';
            },
            getTopicsStr(){
                if(this.isAllTopicsSelected) return '';
                let topics = '';
                this.topics.map((t) => {
                   if(t.on) topics += '&topics[]='+t.id;
                });

                return  topics.length> 0 ? topics : '';
            },
            getAuthorsStr(){
                let author = this.authors.find((item) => {return item.on});
                return  author ? '&author='+author.id : '';
            },
            getOrgStr(){
                let org = this.organisations.find((item) => {return item.on});
                return  org ? '&org='+org.id : '';
            },
            getRegStr(){
                let reg = this.regions.find((item) => {return item.on});
                return  reg ? '&reg='+reg.id : '';
            },
            getContentTypeStr(){
                if(this.isAllTypesSelected) return '';
                let types = '';
                this.content_types.map((t) => {
                    if(t.on) types += '&types[]='+t.id;
                });

                return  types.length> 0 ? types : '';
            }
        },
        computed:{
            isAllTopicsSelected(){
                return !this.topics.some((item) => {return item.on === false})
            },
            isAllTypesSelected(){
                return !this.content_types.some((item) => {return item.on === false})
            }
        },
        mounted() {
            this.topics = this.data.topics;
            this.sorts = this.data.sorts;
            this.content_types = this.data.content_types;
            this.authors = this.data.authors;
            this.organisations = this.data.organisations;
            this.regions = this.data.regions;
        }
    }
</script>

<style scoped>

</style>
