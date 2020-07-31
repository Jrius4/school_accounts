<template>
    <v-app>
        <v-content>
            <v-container>
                <v-row>
                    <figure>
                        <v-menu bottom right>
                            <template v-slot:activator="{ on }">
                            <v-btn outlined v-on="on" small>
                                <span>{{ typeToLabel[type] }}</span>
                                <v-icon right>mdi-menu-down</v-icon>
                            </v-btn>
                            </template>
                            <v-list>
                                <v-list-item @click="typeSelected('daily')">
                                    <v-list-item-title>Daily</v-list-item-title>
                                </v-list-item>
                                <v-list-item @click="typeSelected('weekly')">
                                    <v-list-item-title>Weekly</v-list-item-title>
                                </v-list-item>
                                <v-list-item @click="typeSelected('monthly')">
                                    <v-list-item-title>Monthly</v-list-item-title>
                                </v-list-item>
                                <v-list-item @click="typeSelected('yearly')">
                                    <v-list-item-title>Yearly</v-list-item-title>
                                </v-list-item>
                                <v-list-item @click="typeSelected('interval')">
                                    <v-list-item-title>By Interval</v-list-item-title>
                                </v-list-item>
                            </v-list>
                        </v-menu>

                        <EchartMain
                            :options="getData"
                            :init-options="initOptions"
                            ref="bar"
                            theme="ovilia-green"
                            autoresize
                            @zr:click="handleZrClick"
                            @click="handleClick"
                        />
                    </figure>
                </v-row>
            </v-container>
        </v-content>


    </v-app>
</template>

<script>
import { mapState } from 'vuex';
// import Echarts from 'vue-echarts';
import qs from 'qs';
import EchartMain from './Echarts'
import echarts from 'echarts/lib/echarts';
import EChartsStat from "echarts-stat";
import "echarts-gl";
import 'echarts/lib/chart/bar'
import 'echarts/lib/chart/line'
import 'echarts/lib/component/tooltip'
import 'echarts/lib/component/legend'
import 'echarts/lib/component/title'
import 'echarts/lib/component/dataset'
import 'zrender/lib/svg/svg'
import 'echarts-liquidfill'
import 'echarts/theme/dark';
import 'echarts/dist/extension/dataTool'
import {toolbox as features} from "echarts/lib/langEN"



import theme from './themes/theme.json'
// registering custom theme
EchartMain.registerTheme('ovilia-green', theme)

    export default {
        name:'IncomeStatementsCharts',
        components:{
            EchartMain
        },
        data(){
            let data = [];
            const options = qs.parse(location.search, { ignoreQueryPrefix: true })
            return {
                type: 'daily',
                typeToLabel: {
                    daily: 'Daily',
                    weekly: 'Weekly',
                    monthly: 'Monthly',
                    yearly: 'Yearly',
                    day: 'Day',
                    interval: 'Interval',

                },
                data,
                seconds:-1,
                inputStartEnd:false,
                startDate:null,
                endDate:null,
                loadingData:false,
                amountArray:[],
                options,
                initOptions: {
                    renderer: options.renderer || 'canvas'
                },
                }
        },
        computed:{
            ...mapState({
                payments:state=>state.incomeStatementsModule.payments,
                paymentPagination:state=>state.incomeStatementsModule.paymentPagination.page,
                totalpayments:state=>state.incomeStatementsModule.totalpayments,
                paymentSortRowsBy:state=>state.incomeStatementsModule.paymentSortRowsBy,
                period:state=>state.incomeStatementsModule.period,
            }),
            getData(){
                let dataBar = {};
                if(this.period === 'daily'){
                    var xAxisData = [];
                    var data1 = [];
                    var data2 = [];
                    var data3 = [];

                    this.payments.forEach(item=>{
                        xAxisData.push(item.p_date);
                        data1.push(item.inflow);
                        data2.push(item.outflow);
                        data3.push(item.diff);
                    });

                        dataBar = {
                            color:['#0f852e','orangered','#40bef8'],

                            grid:{
                                left:"2%",
                                right:"3%",
                                bottom:"3%",
                                containLabel:true,
                            },

                            title: {
                                text: 'Daily Overview',
                                left:'center',
                                top:20
                            },
                            legend: {
                                data: ['inflow','outflow','difference']
                            },
                            toolbox: {
                                // y: 'bottom',
                                feature: {
                                    magicType: {
                                        title:{stack:'stack', tiled:'tiled'},
                                        type: ['stack', 'tiled']
                                    },
                                    dataView: {
                                        show:true,
                                        lang:['data view','turn off','refresh'],
                                        title:'Data View',
                                    },
                                    saveAsImage: {
                                        title:'save image',
                                        pixelRatio: 2
                                    }
                                }
                            },
                            tooltip: {},
                            xAxis: {
                                data: xAxisData,
                                splitLine: {
                                    show: true
                                }
                            },
                            yAxis: {
                            },
                            series: [{
                                name: 'inflow',
                                type: 'bar',
                                data: data1,
                                animationDelay: function (idx) {
                                    return idx * 10;
                                }
                            },
                            {
                                name: 'outflow',
                                type: 'bar',
                                data: data2,
                                animationDelay: function (idx) {
                                    return idx * 10;
                                }
                            },
                            {
                                name: 'difference',
                                type: 'bar',
                                data: data3,
                                animationDelay: function (idx) {
                                    return idx * 10;
                                }
                            }
                            ],
                            animationEasing: 'elasticOut',
                            animationDelayUpdate: function (idx) {
                                return idx * 5;
                            }
                        };

                }


                else if(this.period === 'weekly')
                {
                    let xAxisData = [];
                    let data1 = [];
                    let data2 = [];
                    let data3 = [];

                    this.payments.forEach(item=>{
                        xAxisData.push(item.p_week+"W "+item.p_month+"/"+item.p_year);
                        data1.push(item.inflow);
                        data2.push(item.outflow);
                        data3.push(item.diff);
                    });


                    dataBar = {
                        color:['#0f852e','orangered','#40bef8'],
                        title:{
                            text:"Weekly Income Statements",
                            left:'center',
                            top:20
                        },

                        grid:{
                            left:"2%",
                            right:"3%",
                            bottom:"3%",
                            containLabel:true,
                        },

                        legend:{
                            data: ['inflow','outflow','difference']
                        },

                        toolbox: {
                                feature: {
                                    magicType: {
                                        title:{stack:'stack', tiled:'tiled'},
                                        type: ['stack', 'tiled']
                                    },
                                    dataView: {
                                        show:true,
                                        lang:['data view','turn off','refresh'],
                                        title:'Data View',
                                    },
                                    saveAsImage: {
                                        title:'save image',
                                        pixelRatio: 2
                                    }
                                }
                            },
                            tooltip: {},
                            xAxis: [{
                                // type:'category',
                                data: xAxisData,
                                splitLine: {
                                    show: true
                                }
                            }],
                            yAxis:[
                                    {
                                        type:'value',
                                    }
                                ],
                            series: [{
                                name: 'inflow',
                                type: 'bar',
                                data: data1,
                                animationDelay: function (idx) {
                                    return idx * 10;
                                }
                            }, {
                                name: 'outflow',
                                type: 'bar',
                                data: data2,
                                animationDelay: function (idx) {
                                    return idx * 10 + 100;
                                }
                            },{
                                name: 'difference',
                                type: 'bar',
                                data: data3,
                                animationDelay: function (idx) {
                                    return idx * 10 + 100;
                                }
                            }],
                            animationEasing: 'elasticOut',
                            animationDelayUpdate: function (idx) {
                                return idx * 5;
                            }
                    }


                }


                else if(this.period === 'monthly')
                {
                    let xAxisData = [];
                    let data1 = [];
                    let data2 = [];
                    let data3 = [];

                    this.payments.forEach(item=>{
                        xAxisData.push(item.p_month+"/"+item.p_year);
                        data1.push(item.inflow);
                        data2.push(item.outflow);
                        data3.push(item.diff);
                    });


                    dataBar = {
                        color:['#0f852e','orangered','#40bef8'],
                        title:{
                            text:"Monthly Income Statements",
                            left:'center',
                            top:20
                        },

                        grid:{
                            left:"2%",
                            right:"3%",
                            bottom:"3%",
                            containLabel:true,
                        },

                        legend:{
                            data: ['inflow','outflow','difference']
                        },

                        toolbox: {
                                feature: {
                                    magicType: {
                                        title:{stack:'stack', tiled:'tiled'},
                                        type: ['stack', 'tiled']
                                    },
                                    dataView: {
                                        show:true,
                                        lang:['data view','turn off','refresh'],
                                        title:'Data View',
                                    },
                                    saveAsImage: {
                                        title:'save image',
                                        pixelRatio: 2
                                    }
                                }
                            },
                            tooltip: {},
                            xAxis: [{
                                // type:'category',
                                data: xAxisData,
                                splitLine: {
                                    show: true
                                }
                            }],
                            yAxis:[
                                    {
                                        type:'value',
                                    }
                                ],
                            series: [{
                                name: 'inflow',
                                type: 'bar',
                                data: data1,
                                animationDelay: function (idx) {
                                    return idx * 10;
                                }
                            }, {
                                name: 'outflow',
                                type: 'bar',
                                data: data2,
                                animationDelay: function (idx) {
                                    return idx * 10 + 100;
                                }
                            },{
                                name: 'difference',
                                type: 'bar',
                                data: data3,
                                animationDelay: function (idx) {
                                    return idx * 10 + 100;
                                }
                            }],
                            animationEasing: 'elasticOut',
                            animationDelayUpdate: function (idx) {
                                return idx * 5;
                            }
                    }


                }


                else if(this.period === 'yearly')
                {
                    let xAxisData = [];
                    let data1 = [];
                    let data2 = [];
                    let data3 = [];

                    this.payments.forEach(item=>{
                        xAxisData.push(item.p_year);
                        data1.push(item.inflow);
                        data2.push(item.outflow);
                        data3.push(item.diff);
                    });


                    dataBar = {
                        color:['#0f852e','orangered','#40bef8'],
                        title:{
                            text:"Yearly Income Statements",
                            left:'center',
                            top:20
                        },

                        grid:{
                            left:"2%",
                            right:"3%",
                            bottom:"3%",
                            containLabel:true,
                        },

                        legend:{
                            data: ['inflow','outflow','difference']
                        },

                        toolbox: {
                                feature: {
                                    magicType: {
                                        title:{stack:'stack', tiled:'tiled'},
                                        type: ['stack', 'tiled']
                                    },
                                    dataView: {
                                        show:true,
                                        lang:['data view','turn off','refresh'],
                                        title:'Data View',
                                    },
                                    saveAsImage: {
                                        title:'save image',
                                        pixelRatio: 2
                                    }
                                }
                            },
                            tooltip: {},
                            xAxis: [{
                                // type:'category',
                                data: xAxisData,
                                splitLine: {
                                    show: true
                                }
                            }],
                            yAxis:[
                                    {
                                        type:'value',
                                    }
                                ],
                            series: [{
                                name: 'inflow',
                                type: 'bar',
                                data: data1,
                                animationDelay: function (idx) {
                                    return idx * 10;
                                }
                            }, {
                                name: 'outflow',
                                type: 'bar',
                                data: data2,
                                animationDelay: function (idx) {
                                    return idx * 10 + 100;
                                }
                            },{
                                name: 'difference',
                                type: 'bar',
                                data: data3,
                                animationDelay: function (idx) {
                                    return idx * 10 + 100;
                                }
                            }],
                            animationEasing: 'elasticOut',
                            animationDelayUpdate: function (idx) {
                                return idx * 5;
                            }
                    }


                }




                return dataBar
            },
        },

        methods:{
            toggleRenderer () {
                if (this.initOptions.renderer === 'canvas') {
                    this.initOptions.renderer = 'svg'
                } else {
                    this.initOptions.renderer = 'canvas'
                }
            },

            randomize(){
                return [0,0,0].map(v=>{
                    return Math.round(450+Math.random()*650)/10
                });
            },

            getPayments(){
                this.loadingData = true

                let pagination = {
                        val:null,
                        page:null,
                        sortRowsBy:null,
                        rowsPerPage:31,
                        sortDesc:null,
                        period:this.type,
                        start:this.startDate,
                        end:this.endDate,
                        }

                this.$store.dispatch('incomeStatementsModule/GET_ITEMS_ACTION',pagination).finally(()=>{
                    this.loadingData = false;
                    this.startDate = '';
                    this.endDate = '';
                });
            },
            typeSelected(val){
                this.type = val;
                if(val === 'interval' || val === 'interval_by_group'){
                    this.inputStartEnd = true;
                }
                else{
                    this.getPayments();
                }
            },
            refresh () {
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
        },
        mounted(){
            this.getPayments();
        },
        watch: {
            connected: {
                handler (value) {
                    EchartMain[value ? 'connect' : 'disconnect']('radiance')
                },
                immediate: true
            },
            'initOptions.renderer' (value) {
                this.options.renderer = value === 'svg' ? value : undefined
                let query = qs.stringify(this.options)
                query = query ? '?' + query : ''
                history.pushState(
                    {},
                    document.title,
                    `${location.origin}${location.pathname}${query}${location.hash}`
                );
            }
        },
    }
</script>


<style lang="stylus" scoped>
*,
*::before,
*::after
  box-sizing border-box

html
  scroll-behavior smooth

body
  margin 0
  padding 0 0 0
  font-family "Source Sans Pro", "Helvetica Neue", Arial, sans-serif
  color #666
  text-align center


a
  color inherit
  text-decoration none

h1
  margin-bottom 1em
  font-family Dosis, "Source Sans Pro", "Helvetica Neue", Arial, sans-serif

h1,
h2
  color #2c3e50
  font-weight 300

h2
  margin-top 2em
  padding-top 1em
  font-size 1.2em

  button
    margin-left 1em
    vertical-align middle

.desc
  margin-bottom 3em
  color #7f8c8d

h2 small
  opacity .7

p small
  font-size .8em
  color #7f8c8d

p
  line-height 1.5

pre
  display inline-block
  padding .8em
  background-color #f9f9f9
  box-shadow 0 1px 2px rgba(0,0,0,.125)
  line-height 1.1
  color #2973b7

pre,
code
  font-family "Roboto Mono", Monaco, courier, monospace

pre code
  font-size .8em

.attr
  color #e96900

.val
  color #42b983

footer
  margin 5em 0 3em
  font-size .5em
  vertical-align middle

  a
    display inline-block
    margin 0 5px
    padding 3px 0 6px
    color #7f8c8d
    font-size 2em
    text-decoration none

  a:hover
    padding-bottom 3px
    border-bottom 3px solid #42b983

button
  border 1px solid #4fc08d
  border-radius 2em
  background-color #fff
  color #42b983
  cursor pointer
  font inherit
  transition opacity .3s

  &:focus
    outline none
    box-shadow 0 0 1px #4fc08d

  &:active
    background rgba(79, 192, 141, .2)

  &[disabled]
    opacity .5
    cursor not-allowed

  &.round
    width 1.6em
    height 1.6em
    position relative

    &::before,
    &::after
      content ""
      position absolute
      top 50%
      left 50%
      transform translate(-50%, -50%)
      width 9px
      height 1px
      background-color #42b983

    &::after
      width 1px
      height 9px

    &.expand::after
      display none

button,
label
  font-size .75em

figure
  display inline-block
  position relative
  margin 2em auto
  border 1px solid rgba(0, 0, 0, .1)
  border-radius 8px
  box-shadow 0 0 45px rgba(0, 0, 0, .2)
  padding 1.5em 2em
  min-width: calc(40vw + 4em)

  .echarts
    // width 40vw
    width 100%
    min-width 400px
    height 300px

#logo
  display inline-block
  width 128px
  height 128px
  pointer-events none

.modal
  display none
  position fixed
  top 0
  right 0
  bottom 0
  left 0
  background-color rgba(0, 0, 0, .2)
  z-index 1

  &.open
    display block

  img
    position absolute
    top 50%
    left 50%
    transform translate(-50%, -50%)
    background-color #404a59
    max-width 80vw
    border 2px solid #fff
    border-radius 3px
    box-shadow 0 0 30px rgba(0, 0, 0, .2)

@media (min-width 980px)
  figure.half
    padding 1em 1.5em
    min-width calc(240px + 3em)

    .echarts
      width 28vw
      min-width 240px
      height 180px

    &:not(:last-child)
      margin-right 15px

@media (max-width 980px)
  p
    display flex
    justify-content center

    select
      text-indent calc(50% - 1em)

    select,
    label
      border 1px solid #4fc08d
      border-radius 2em
      background-color #fff
      color #42b983
      cursor pointer
      transition opacity .3s

    button,
    input,
    select,
    label
      flex 1 0
      margin 0 .5em
      padding 0
      line-height 2.4em
      max-width 40vw
      border-radius 2px
      font-size .8em

    select
      -webkit-appearance none

    input[type="checkbox"]
      display none

      &:checked + label
        background #42b983
        color #fff

  figure
    width 100vw
    margin 1em auto
    padding 0 1em
    border none
    border-radius 0
    box-shadow none

    .echarts
      width 100%
      min-width 0
      height 75vw

.renderer
  position fixed
  top 10px
  left 10px
  font-size 12px
  text-align center

  button
    float left
    position relative
    width 48px
    border-radius 4px

    &.active
      z-index 1
      background-color #4fc08d
      color #fff

    &:first-child
      border-top-right-radius 0
      border-bottom-right-radius 0

    &:last-child
      left -1px
      border-top-left-radius 0
      border-bottom-left-radius 0
</style>


