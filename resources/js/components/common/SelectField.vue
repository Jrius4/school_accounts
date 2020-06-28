<template>
  <div class="col">
      <v-select label="countryName"
      :options="countries" :value="countries[0]"
      @input="setSelected"
      />

      <v-select
      v-model="selected"
      :options="myNames" :value="myNames[0]"
      @input="setSelected"
      taggable multiple push-tags
        :selectable="() => selected.length<3"
      />

      <v-select label="countryName"
      multiple

      :options="countries"
      :selectable="option =>! option.countryName.includes('Uganda')"
      :reduce="countryName => countryName.meta.areaCode"
        @input="setSelected"
      />

      <v-select label="countryName"
      v-model="selected1"
      :options="countries"

      :reduce="countryName => countryName.meta.areaCode"
        @input="setSelected"
      >
        <template
            #search="{attributes,events}"
        >
            <input class="vs__search" :required="!selected1"
            v-bind="attributes"
            v-on="events"
            />
        </template>
      </v-select>
      <v-select
        taggable
        multiple
        label='title'
        :options="books"
        :create-option="book =>({
            title:book,
            author:{
                firstName:'',
                lastName:''
            }
        })"
        @input="setSelected"
        :reduce="book =>`${book.author.firstName} ${book.author.lastName}`"
      />

      <v-select label="testName"
        :options="paginated"
        @search="query => search = query"
        :filterable="false"

        placeholder="Search"
        @input="setSelected"
      >
        <li slot="list-footer"
         class="pagination"
        >
            <button
            class="btn btn-dark"
            @click="offset-=10"
            :disabled="!hasPrevPage"
            >Prev</button>
            <button class="btn btn-dark"
            @click="offset+=10"
            :disabled="!hasNextPage"
            >Next</button>
        </li>
      </v-select>
  </div>
</template>

<script>
var testData = new Array();
for (let index = 0; index < 20; index++) {
    testData.push(
        `name #${index}`
    )

}
export default {
    name:'SelectField',
    data(){
        return{
            testData,
            search:'',
            offset:0,
            limit:10,
            selected:'',
            selected1:'',
            books:[
                {
                    title:"JavaScript",
                    author:{
                        firstName:'Julius Junior',
                        lastName:'Kazibwe',
                    }
                }
            ],
            countries:[
        {
            countryName:'Uganda',
            code:'UG',
            citizen:'Julia',
            meta:{
                areaCode:'256'
            }
        },
        {
            countryName:'Tanzania',
            code:'Tz',
            citizen:'Rachel',
            meta:{
                areaCode:'252'
            }
        },
        {
            countryName:'Kenya',
            code:'ky',
            citizen:'Ojambo',
            meta:{
                areaCode:'257'
            }
        }
      ],
      myNames:[
          'kazibwe', 'Julius', 'Junior'
      ]
        };
    },
    methods:{
        setSelected(value){
            console.log(value)
        }
    },
    computed:{
        filtered(){
            return this.testData.filter(data =>data.includes(this.search));
        },
        paginated(){
            return this.filtered.slice(this.offset,this.limit+this.offset);
        },
        hasNextPage(){
            const nextOffset = this.offset + 10;
            return Boolean(this.filtered.slice(nextOffset,this.limit+nextOffset).length)
        },
        hasPrevPage(){
            const prevOffset = this.offset + 10;
            return Boolean(this.filtered.slice(prevOffset,this.limit+prevOffset).length)
        }
    }


}
</script>

<style>

.style-chooser .vs__search::placeholder,
.style-chooser .vs__dropdown-toggle,
.style-chooser .vs__dropdown-menu{
    background-color: #41444d;
    border:none;
    color: #e3e5ee;
    text-transform: lowercase;
    font-variant: small-caps;
}

.style-chooser .vs__clear,
.style-chooser .vs__open-indicator{
    fill: #394066;
}

.pagination{
    display: flex;
    margin: .25rem .25rem 0;
}
.pagination button{
    flex-grow: 1;
}
.pagination button:hover{
    cursor: pointer;
}

</style>
