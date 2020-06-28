<template>
    <div class="container">
         <h4>Web Sockets</h4>
            <div class="col-md-8 mx-auto d-block" v-for="(comment,index) in comments" :key="index">
                <h4> {{comment.user.name}}...</h4>
                <p>
                    {{comment.body}}
                    <br/>
                    <small>on {{comment.created_at | moment}}</small>
                </p>

            </div>
            <div class="col-md-8 mx-auto form-group d-block" v-if="user">
                <textarea row="3" name="body" placeholder="Leave a comment" v-model="commentBox" class="form-control col-12"></textarea>
                <button class="btn btn-block btn-dark" v-on:click="postComment">Save Comment</button>
            </div>
            <div class="col-md-8 mx-auto form-group d-block" v-else>
                <h4>You must logged in to submit a comment</h4>
                <a href='/' class="btn btn-block btn-success">Login Now &gt;&gt;&gt;</a>
            </div>
    </div>
</template>

<script>
Echo.channel('home')
    .listen('NewMessage',e=>{
        console.log(e.message)
    })
    export default {
        props:['user'],
        data(){
            return {
            comments:{},
            commentBox:'',
        };
        },
        mounted(){
            this.getComments();
            this.listen();
        },
        methods:{
            getComments(){
                axios.get('/api/comments/').then((response)=>{

                    this.comments = response.data
                }).catch(err=>console.log(err))
            },
            postComment(){

                axios.post('/api/comment',{body:this.commentBox}
                ,{
                    header:{
                        Authorization:`Bearer ${localStorage.getItem('access_token')}`
                    },
                }
                ).then((response)=>{

                    this.comments.unshift(response.data);
                    this.commentBox = '';
                }).catch(err=>console.log({err}))
            },
            listen(){
                Echo.channel('comments')
                .listen('NewComment',(comment)=>{
                    this.comments.unshift(comment);
                });
            }
        },
        filters: {

            moment: function (date) {

                return moment(date).format('MMMM Do YYYY, h:mm:ss a');

            }

        }
    }
</script>

<style lang="stylus" scoped>

</style>
