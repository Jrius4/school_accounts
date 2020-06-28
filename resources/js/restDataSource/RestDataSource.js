import Axios from "axios";

const citiesUrl = "/api/vue-cities";
const userUrl = "/api/get-user";

export class RestDataSource{
    constructor(bus){
        this.eventBus = bus;
    }
    // async getUser(){
    //     return(await this.sendRequest('GET',userUrl)).data;
    // }
    async getCities(){
        return (await this.sendRequest('GET',citiesUrl)).data.data;
    }

    async saveCity(city){
        return (await this.sendRequest('POST',citiesUrl,city)).data.data;
    }

    async updateCity(city){
        return (await this.sendRequest("PUT",`${citiesUrl}/${city.id}`,city)).data.data;
    }
    async deleteCity(city){
        await this.sendRequest("DELETE",`${citiesUrl}/${city.id}`,city);
    }

    async sendRequest(httpMethod,url,city)
    {
        try {
            return await Axios.request({
                method:httpMethod,
                url:url,
                data:city
            });
        } catch (err) {
            if(err.response){
                this.eventBus.$emit("httpError",
                `${err.response.statusText}-${err.response.status}`);

            }else{
                this.eventBus.$emit("httpError","HTTP Error");
            }
            throw err;

        }
    }
}
