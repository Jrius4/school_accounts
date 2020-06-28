    /**
        import app from './app';
        import router from './router';

        new Promise((resolve,reject)=>{
            router.push(url);
            router.onReady(()=>{
                const matchedComponents=router.getMatchedComponents();
                if(!matchedComponents.length){
                    return reject({code:404})
                }
                resolve(app);
            },reject);
        }).then(app=>{
            renderVueComponentToString(app,(err,res)=>{
                print(res);
            });
        }).catch((err)=>{
            print(err);
        })
    */

import createApp from "./app";
import renderToString from "vue-server-renderer/basic";

const app = createApp();

renderToString(app,(err,html)=>{
    if(err){
        throw new Error(err)
    }
    //dispatch the html to the client
});
