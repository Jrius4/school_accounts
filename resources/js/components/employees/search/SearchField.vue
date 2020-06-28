<template>
  <div class="form-group">
      <select class="form-control d-block col-12 text-center" name="employee" v-model="employee" id="employee">
        <option value="">Search Student By Name</option>
        <option v-for="(employee,index) in employees" :key="index">
            {{employee.username}} - {{student.name}}
        </option>
    </select>
  </div>
</template>
<script>
var token = localStorage.getItem('access_token');
export default {
    data(){
        return {
            employee:'',
            employees : [],
        }
    },
    methods:{
        employeeSelected(){
            let selElem = this.$el.querySelector('#employee');
            console.log({selElem})
        }
    },
    computed:{

    },
    watch:{
        employeeSelected(){
            let selElem = this.$el.querySelector('#employee');
            console.log({selElem})
        }
    }
}
// require('../../../../../public');
require('../../../../../public/schools/plugins/select2/css/select2.min.css');
require('../../../../../public/schools/plugins/select2/js/select2.full.min.js');

$(function(){
        $.ajaxSetup({
            headers: {
                "Authorization": "Bearer "+ token,
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#employee").select2({
        placeholder: "Select employee(s)",
        allowClear: true,
        ajax: {
            url: "/api/v1/getEmployees",
            dataType: 'json',
            delay:250,
            data:function(params){
                console.log({params})
                var query = {
                    query:params.term,
                    page:params.page
                };
                return query;
            },
            processResults: function (data, params) {
                params.page = params.page||1;
                console.log({data,params})

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
