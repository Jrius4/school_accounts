export default {
    namespaced:true,
    state:{
        status:'',
        title:'',
        message:'',
        open:false,
    },
    mutations:{
        ALERT(state,payload){
            state.open = payload.open || false;
            state.title = payload.title || '';
            state.message = payload.message || '';
            state.status = payload.status || '';
        }

    },
    actions:{
        ALERT_ACTION(context,payload){
            let data = {};

            data = {
                open : payload.open || false,
                title : payload.title || '',
                message : payload.message || '',
                status : payload.status || ''
            }
            context.commit('ALERT',data);
            setTimeout(()=>{
                data ={
                    open : false,
                    title : '',
                    message : '',
                    status : ''
                }
                context.commit('ALERT',data);

            },4000);

        }

    }
}
