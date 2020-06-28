<template>
    <div class="row">

        <div class="col-md-8 animated flipInY">
            <div class="card card-default elevation-2">
                <div class="card-header">Chat Room</div>
                <div class="card-body chatRoom p-0">
                    <ul class="list-unstyled" style="height:300px;overflow-y:scroll" v-chat-scroll>
                        <li class="p-2 card card-body p-0" v-for="(message,index) in messages" :key="index" :class="user.id === message.user.id?'inMessage MeUser ml-auto my-2 p-2   animated slideInRight':'inMessage OtherUser mr-auto my-2 p-2  animated slideInLeft'">
                            <strong>{{message.user.name}}</strong>
                            <p class="lead">
                                {{message.message}}
                            </p>
                        </li>
                    </ul>
                </div>
                <input
                    @keydown="sendTypingEvent"
                    @keyup.enter="sendMessage"
                    v-model="newMessage"
                    type="text"
                    name="message"
                    placeholder="Enter Your Message...."
                    class="form-control"
                />
            </div>
            <span class="text-muted" v-if="activeUser">
                {{activeUser.name}} is typing...
            </span>
        </div>

        <div class="col-md-4 card card-default elevation-2  animated flipInY">
            <div class="card-header">
                <div class="card-body">
                    <ul style="height:300px;width:100%;overflow-y:scroll">
                        <li class="py-2 row d-flex" v-for="(user , index) in users" :key="index">
                            <img width="15px" height="15px" v-show="user.image!==null" class="img-fluid col-4" :src="'/files/'+ user.image" alt='img-user'/>
                            <span class="col">{{user.name}}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    name:'ChatRoom',
    props:['user'],
    data(){
        return{
            messages:[],
            newMessage:'',
            users:[],
            activeUser:false,
            typingTimer:false,
			timeLinedUser:false
        }
    },
    created(){

        this.fetchMessages();
        Echo
		.join('chat')
		.here(user=>{
            this.users = user;
        }).joining(user=>{
            this.users.push(user);
        }).leaving(user=>{
            this.users = this.users.filter(u=>u.id !== user.id)
        }).listen('ChatEvent',(event)=>{
            this.messages.push(event.chat)
        }).listenForWhisper('typing',user=>{
            this.activeUser = user;
            if(this.typingTimer){
                clearTimeout(this.typingTimer);
            }
            this.typingTimer = setTimeout(()=>{
                this.activeUser = false;
            },1000)
        })
    },
    methods:{
        fetchMessages(){
            axios.get('/api/v1/messages').then(response=>{

			this.messages = response.data

			}
			).catch(err=>console.log(err));
        },
		sendMessage(){
			this.messages.push({
				user:this.user,
				message:this.newMessage
			});

			axios.post('/api/v1/messages',{message:this.newMessage}).then(

			).catch(err=>console.log(err));
			this.newMessage = '';
		},
		sendTypingEvent(){
			Echo.join('chat').whisper('typing',this.user);

		},
    }
}
</script>
<style>
	.chatRoom{
		background-color:rgb(3, 65, 56)
	}
	.inMessage{
		width:80%;
        font-size: medium;
        font-weight: 600;
	}
	.MeUser{
		background-color:rgb(90, 155, 230);
		color:black;

	}
	.OtherUser{
		background-color:rgb(111, 245, 178);
		color:black;
	}
</style>
