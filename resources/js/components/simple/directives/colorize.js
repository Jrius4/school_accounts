export default {
    // bind(el,binding){
    //     if(binding.value){
    //         el.classList.add("bg-danger","text-white");
    //     }else{
    //         el.classList.remove("bg-danger","text-white");
    //     }
    // },
    update(el,binding){
        const bgClass = binding.arg || "bg-danger";
        const noMods = Object.keys(binding.modifiers).length == 0;
        if(binding.value){
            if(noMods || binding.modifiers.bg){
                el.classList.add(bgClass);
            }
            if(noMods || binding.modifiers.text){
                el.classList.add("text-white");
            }
        }
        else{
            el.classList.remove(bgClass,"text-white");
        }
    }
}
/**
 *
 * export default{
    update(el,binding){

        if(binding.value<=100){
            el.classList.remove("bg-danger","text-white");
            el.classList.remove("bg-warning","text-dark");
            el.classList.remove("bg-info","text-white");
            el.classList.add("bg-success","text-white");

        }
        else if(binding.value=== true){
            el.classList.remove("bg-warning","text-dark");
            el.classList.remove("bg-success","text-white");
            el.classList.remove("bg-danger","text-white");
            el.classList.add("bg-danger","text-white");
        }
        else if(binding.value>100 && binding.value<=1000){
            el.classList.remove("bg-danger","text-white");
            el.classList.remove("bg-success","text-white");
            el.classList.remove("bg-info","text-white");
            el.classList.add("bg-warning","text-dark");
        }
        else if(binding.value>1000){
            el.classList.remove("bg-warning","text-dark");
            el.classList.remove("bg-success","text-white");
            el.classList.remove("bg-info","text-white");
            el.classList.add("bg-danger","text-white");

        }
        else{
            el.classList.remove("bg-warning","text-dark");
            el.classList.remove("bg-success","text-white");
            el.classList.remove("bg-danger","text-white");
            el.classList.add("bg-info","text-white");
        }

    }
}
 *
*/
