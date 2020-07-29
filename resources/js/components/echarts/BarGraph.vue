<template>
    <div class="container-fluid">
        <div class="row">
            <div class="card col-12">
                <div class="card-title">
                    <h3 class="text-center">{{heading}}</h3>
                </div>
                <div class="card-body">
                    <figure>
                        <v-chart
                            :options="bar"
                            :init-options="initOptions"
                            ref="bar"
                            theme="dark"
                            autoresize
                            @zr:click="handleZrClick"
                            @click="handleClick"
                        />
                    </figure>
                    <p v-if="seconds <= 0">
                        <small>Loaded...</small>
                    </p>
                    <p v-else>
                        <small>
                            Data coming in <b>{{seconds}}</b>
                            second {{seconds > 1?'s':''}}...
                        </small>
                    </p>
                    <p>
                        <button @click="refresh"
                            :disabled="seconds > 0">Refresh</button
                        >
                    </p>
                </div>
            </div>


        </div>
    </div>
</template>

<script>
import Echarts from 'vue-echarts';
import echarts from 'echarts/lib/echarts';
import 'echarts/lib/chart/bar';
import 'zrender/lib/svg/svg';
import 'echarts/lib/theme/dark';
import qs from 'qs';
import theme from './theme.json';
echarts.registerTheme('ovilia-green', theme);
export default {
    props:['heading','sourceInput','categorial'],
    components:{'v-chart':Echarts},
    data(){
        let data = [];
        const options = qs.parse(location.search, { ignoreQueryPrefix: true })
        return {
            options,
            data,
            seconds:-1,
            bar:this.getData(),
            initOptions: {
                renderer: options.renderer || 'canvas'
            },
        }

    },
    mounted(){

        console.log(this.sourceInput);
    },
    methods:{
        getData(){
            return {
                legend:{},
                tooltip:{},
                dataset:{
                    source:[
                        ['Product','2015','2016','2017'],
                        ['Katongo', ...this.randomize()],
                        ['Milk Coffee', ...this.randomize()],
                        ['Cheese Cocoa', ...this.randomize()],
                    ]
                },
                xAxis: this.categorial === 'true'?{type: 'category'}: {},
                yAxis: {
                    type:'value'
                },
                series:[
                    {type:'bar'},
                    {type:'bar'},
                    {type:'bar'},
                ],

            }
        },
        randomize(){
            return [0,0,0].map(v=>{
                return Math.round(450+Math.random()*650)/10
            });
        },
        refresh () {
            // simulating async data from server
            this.seconds = 3
            const bar = this.$refs.bar
            bar.showLoading({
                text: 'Loading…',
                color: '#4ea397',
                maskColor: 'rgba(255, 255, 255, 0.4)'
            });
            const timer = setInterval(() => {
                this.seconds--
                if (this.seconds === 0) {
                clearTimeout(timer)
                bar.hideLoading()
                this.bar = this.getData()
                }
            }, 1000)
        },
    toggleRenderer () {
      if (this.initOptions.renderer === 'canvas') {
        this.initOptions.renderer = 'svg'
      } else {
        this.initOptions.renderer = 'canvas'
      }
    },

        handleClick () {
            console.log('click from echarts')
        },
        handleZrClick () {
            console.log('click from zrender')
        },

    }
}
</script>

<style>

</style>
