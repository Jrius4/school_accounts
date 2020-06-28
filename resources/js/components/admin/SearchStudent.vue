<template>
    <div>
        <div class="container d-block col-md-8 mx-auto my-1">
            <input class="form-control d-block col-12 text-center" type="text" v-model="keywords" v-model.lazy="keywords" placeholder="search student by name"/>
            <ul class="list-group" v-if="results.length > 0 && keywords!==null && keywords!==''">
                <li class="list-group-item" v-for="result in results" :key="result.id" v-text="result.name+' '+result.roll_number">
                </li>
            </ul>

            <select multiple class="form-control d-block col-12 text-center" name="student" id="student">
                <option value="">Search Student By Name</option>
                <option v-for="student in students" :key="student.id">
                    {{student.name}} - {{student.roll_number}}
                </option>
            </select>

        </div>
    </div>

</template>

<script>
var token = localStorage.getItem('access_token');
export default {
    data(){return {
        keywords:null,
        results:[],
        students:[],
        object: {
                title: 'How to do lists in Vue',
                author: 'Jane Doe',
                publishedAt: '2016-04-10'
            }
    }},
    watch:{
        keywords(after,before){
            this.fetch();
        }
    },
    methods:{
        fetch(){
            axios.get('/api/search-student',{
                headers:{
                            Authorization: "Bearer "+this.$store.state.token
                        },
                params:{
                    keywords:this.keywords
                }
            }).then((response) => {
                this.results = response.data.data
            }).catch((err) => {
                console.err
            });
        },
        highlight(text){
            return text.replace(new RegExp(this.keywords,'gi'),'<span class="highlighted">$&</span>')
        }
    },
    mounted(){
            axios.get('/api/search-student',{
                headers:{
                            Authorization: "Bearer "+this.$store.state.token
                        },
                params:{
                    keywords:this.keywords
                }
            }).then((response) => {
                this.students = response.data.data
            }).catch((err) => {
                console.err
            });
    }
}

require('../../../../public/schools/plugins/select2/css/select2.min.css');
require('../../../../public/schools/plugins/select2/js/select2.full.min.js');

$(function(){
        $.ajaxSetup({
            headers: {
                "Authorization": "Bearer "+ token,
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#student").select2({
        placeholder: "Select student(s)",
        allowClear: true,
        ajax: {
            url: "/api/search-student",
            dataType: 'json',
            delay:250,
            data:function(params){
                var query = {
                    keywords:params.term,
                    page:params.page
                };
                return query;
            },
            processResults: function (data, params) {
                params.page = params.page||1;

                return {
                    results: data.data,
                    pagination: {
                        more: (params.page * 10) < data.total
                    }
                };
            },
            success:function(data)
            {
            },
            error:function(data)
            {
            },
            cache:true,


        },
        minimumInputLength:1,
        templateResult:formatRepo,
        templateSelection:formatRepoSelection
    });

    function formatRepo(repo){
        if(repo.loading){
            return repo.text
        }

        var $container =$("<span>"+repo.name+"</span>");
        return $container;
    }
    function formatRepoSelection(repo)
    {
        return repo.name;
    }
})
</script>

<style>

</style>
