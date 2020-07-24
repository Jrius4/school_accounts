let str1 = "KAZIBWE_JULIUS_JUNIOR";
let arr1 = str1.split("_");
let arr2 =[];
let aa3 =   "KAZIBWE_JULIUS_JUNIOR".split("_").map((item)=>{
             return item.toLowerCase();
            }).join("_");

console.log({str1,arr1,arr2,aa3})
