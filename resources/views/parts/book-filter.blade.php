<book-filter inline-template :data='function(){return {!! $data['topics'] !!};}()'
              @isset($topic->id) topic-id="{{$topic->id}}" @endisset @isset($sort) sort="{{$sort}}" @endisset>
    <div class="filters">
        <section>
            <label class="bold">Показать по:</label>
            <advanced-select v-model="sorts" @input="changeSort"></advanced-select>
        </section>
        <section>


            <div class="themes">
                <label class="bold">Части:</label>
                <advanced-select :value="level1" @input="change"></advanced-select>
            </div>
            <div class="themes mt-3">
                <label class="bold">Разделы:</label>
                <advanced-select :value="level2" @input="change" :disable="topics.level1 === null"></advanced-select>
            </div>
            <div class="themes mt-3">
                <label class="bold">Темы:</label>
                <advanced-select :value="level3" @input="change"  :disable="topics.level2 === null"></advanced-select>
            </div>
        </section>
    </div>
</book-filter>
