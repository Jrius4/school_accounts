<template>
    <div class="container-fluid">
        <div class="row">
            <div class="card col-12">
                <div class="card-title">
                    <h3 class="text-center">{{heading}}</h3>
                </div>
                <div class="card-body">
                    <v-chart :options="polar"/>
                </div>
            </div>


        </div>
    </div>
</template>

<script>
import Echarts from 'vue-echarts';
import 'echarts/lib/chart/line';
import 'echarts/lib/component/polar';

    export default {
        components:{'v-chart':Echarts},
        props:['heading'],
        data(){
            let data = [];
            for (let i=0;i<=360;i++){
                let t = i/180*Math.PI;
                let r = Math.sin(2*t)*Math.cos(2*t);
                data.push([r,i]);
            }

            return {
                polar: {
                    title: {
                        text: '极坐标双数值轴'
                    },
                    legend: {
                    data: ['line']
                    },
                    polar: {
                    center: ['50%', '54%']
                    },
                    tooltip: {
                    trigger: 'axis',
                    axisPointer: {
                        type: 'cross'
                    }
                    },
                    angleAxis: {
                    type: 'value',
                    startAngle: 0
                    },
                    radiusAxis: {
                    min: 0
                    },
                    series: [
                    {
                        coordinateSystem: 'polar',
                        name: 'line',
                        type: 'line',
                        showSymbol: false,
                        data: data
                    }
                    ],
                    animationDuration: 2000
                }
            }
        },


    }
</script>

<style lang="scss" scoped>

</style>
