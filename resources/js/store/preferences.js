export default{
    namespaced:true,
    state:{
        stripedTable:true,
        infoEditButton:false,
        dangerDeleteButton:false,
    },
    getters:{
        editClass(state){
            return state.infoEditButton?"btn-info":"btn-secondary";
        },
        deleteClass(state){
            return state.dangerDeleteButton?"btn-danger":"btn-secondary";
        },
        tableClass(state,payload,rootState){
            return rootState.cities.length>0
            && rootState.cities[0].country.includes("a")?"table-striped":""
        },

    },
    mutations:{
           setEditButtonColor(currentState,info){
               currentState.infoEditButton = info;
           },
           setDeleteButtonColor(currentState,danger){
            currentState.dangerEditButton = danger;
           }
    }
}
