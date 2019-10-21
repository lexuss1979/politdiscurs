<topic-filters inline-template :data='function(){
{{--    let window.dd_data =  {!! $data['filters'] !!};--}}
    let data = {!! $data['filters'] !!};
    this.console.log(data);
    return data;
}()'>
    <div class="filters">
        <section>
            <label>Показывать по:</label>
            <advanced-select v-model="sorts" @input="change"></advanced-select>

            <div class="themes">
                <label  class="bold">Темы:</label>
                <ul>
                    <li><check-box v-model="isAllTopicsSelected" @input="selectAllTopics" @input="change"></check-box><span>Все</span></li>
                    <li v-for="topic in topics"><check-box  @input="change" v-model="topic.on"></check-box><span v-text="topic.title"></span></li>
                </ul>

            </div>


        </section>
        <section>
            <label class="bold">Вид материала:</label>
            <ul>
                <li v-for="ctype in content_types"><check-box  v-model="ctype.on" @input="change"></check-box><span v-text="ctype.title"></span></li>
            </ul>
        </section>
        <section>
            <label class="bold">Авторы:</label>
            <advanced-select resetable v-model="authors" filterable @input="change"></advanced-select>
        </section>e
        <section>
            <label class="bold">Организация:</label>
            <advanced-select resetable search-type="contains" filterable  v-model="organisations" @input="change"></advanced-select>

        </section>
        <section>
            <label class="bold">Регион мира:</label>
            <advanced-select resetable v-model="regions" @input="change"></advanced-select>
        </section>
    </div>
</topic-filters>
