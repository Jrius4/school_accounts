/**
                    else if(this.queryType === 'daily_by_group'){
                        var posList = [
                            'left', 'right', 'top', 'bottom',
                            'inside',
                            'insideTop', 'insideLeft', 'insideRight', 'insideBottom',
                            'insideTopLeft', 'insideTopRight', 'insideBottomLeft', 'insideBottomRight'
                        ];
                        var app = {};
                        var option = null;

                        let xAxisData = [];
                        let yAxisData = [];
                        let data1 = [];
                        let data2 = [];
                        let data3 = [];
                        let groups = [];

                        this.payments.forEach(item=>{
                            xAxisData.push(item.paid_day);
                            groups.push(item.paymentType);
                            data1.push((item.paymentType).toLowerCase() === 'student'?item.total_amount:null);
                            data2.push((item.paymentType).toLowerCase() === 'loan'?item.total_amount:null);
                            data3.push((item.paymentType).toLowerCase() === 'asset'?item.total_amount:null);
                        });

                        app.configParameters = {
                            rotate: {
                                min: -90,
                                max: 90
                            },
                            align: {
                                options: {
                                    left: 'left',
                                    center: 'center',
                                    right: 'right'
                                }
                            },
                            verticalAlign: {
                                options: {
                                    top: 'top',
                                    middle: 'middle',
                                    bottom: 'bottom'
                                }
                            },
                            position: {
                                options: echarts.util.reduce(posList, function (map, pos) {
                                    map[pos] = pos;
                                    return map;
                                }, {})
                            },
                            distance: {
                                min: 0,
                                max: 100
                            }
                        };



                        app.config = {
                            rotate: 90,
                            align: 'left',
                            verticalAlign: 'middle',
                            position: 'insideBottom',
                            distance: 15,
                            onChange: function () {
                                var labelOption = {
                                    normal: {
                                        rotate: app.config.rotate,
                                        align: app.config.align,
                                        verticalAlign: app.config.verticalAlign,
                                        position: app.config.position,
                                        distance: app.config.distance
                                    }
                                };
                                EchartMain.setOption({
                                    series: [{
                                        label: labelOption
                                    }, {
                                        label: labelOption
                                    }, {
                                        label: labelOption
                                    }, {
                                        label: labelOption
                                    }]
                                });
                            }
                        };


                        var labelOption = {
                            show: true,
                            position: app.config.position,
                            distance: app.config.distance,
                            align: app.config.align,
                            verticalAlign: app.config.verticalAlign,
                            rotate: app.config.rotate,
                            formatter: '{c}  {name|{a}}',
                            fontSize: 16,
                            rich: {
                                name: {
                                    textBorderColor: '#fff'
                                }
                            }
                        };

                        option = {
                            color: ['#003366', '#006699', '#4cabce', '#e5323e'],
                            tooltip: {
                                trigger: 'axis',
                                axisPointer: {
                                    type: 'shadow'
                                }
                            },
                            legend: {
                                data: groups
                            },
                            toolbox: {
                                show: true,
                                orient: 'vertical',
                                left: 'right',
                                top: 'center',
                                feature: {
                                    mark: {show: true},
                                    dataView: {show: true, readOnly: false},
                                    magicType: {show: true, type: ['line', 'bar', 'stack', 'tiled']},
                                    restore: {show: true},
                                    saveAsImage: {show: true}
                                }
                            },
                            xAxis: [
                                {
                                    type: 'category',
                                    axisTick: {show: false},
                                    data: xAxisData
                                }
                            ],
                            yAxis: [
                                {
                                    type: 'value'
                                }
                            ],
                            series: [
                                {
                                    name: 'student',
                                    type: 'bar',
                                    barGap: 0,
                                    label: labelOption,
                                    data: data1
                                },
                                {
                                    name: 'loan',
                                    type: 'bar',
                                    label: labelOption,
                                    data: data2
                                },
                                {
                                    name: 'asset',
                                    type: 'bar',
                                    label: labelOption,
                                    data: data3
                                },
                            ]
                        };

                        dataBar = option;
                    }
                */


               else if(this.queryType === ''){
                let xAxisData = [];
                let yAxisData = [];
                let data1 = [];
                let data2 = [];
                let data3 = [];
                let groups = [];

                this.payments.forEach(item=>{
                    xAxisData.push(item.paid_day);
                    groups.push(item.paymentType);
                    if((item.paymentType).toLowerCase() === 'student'){

                        data1.push(item.total_amount)
                    }
                    else if((item.paymentType).toLowerCase() === 'loan'){

                        data2.push(item.total_amount)
                    }
                    else if((item.paymentType).toLowerCase() === 'asset'){

                        data3.push(item.total_amount)
                    }
                });

                dataBar =   {
                    legend:{
                        data:groups,
                    },
                    grid:{
                        left:'3%',
                        right:'4%',
                        botton:'3%',
                        containLabel:true,
                    },
                    tooltip:{
                        trigger:'axis',
                        axisPointer:{
                            type:'shadow'
                        }
                    },
                    xAxis:[
                        {
                            // type:'category',
                            data:xAxisData,
                        }
                    ],
                    yAxis:[
                        {
                            type:'value'
                        }
                    ],
                    series:[
                        {
                            type:'bar',
                            name:'Student',
                            data:data1,
                        },
                        {
                            type:'bar',
                            name:'Loan',
                            data:data2,
                        },
                        {
                            type:'bar',
                            name:'Asset',
                            slack:'Slack',
                            data:data3,
                        },
                    ]
                }
            }

            else if(this.queryType === 'monthly'){
                let growth = [];
                for(let i = 0;i<=15;i++){
                    growth.push((Math.random()*(i/10)-0.2).toFixed(2));
                }
                let bins = EChartsStat.histogram(growth);

               let option = {
                   title:{
                       text:"Growth Of black Banana",
                       left:'center',
                       top:20
                   },
                   color:['rgb(25,183,207)'],
                   grid:{
                       left:"2%",
                       right:"3%",
                       bottom:"3%",
                       containLabel:true,
                   },
                   xAxis:[
                       {
                           type:'value',
                           scale:true
                       }
                   ],
                   yAxis:[
                       {
                           type:'value',
                       }
                   ],
                   series:[
                    {
                        name:'height',
                        type:'bar',
                        barWidth:'99.3%',
                        label:{
                            normal:{
                                show:true,
                                position:'insideTop',
                                formatter:function(params){
                                    return params.value[1]
                                }
                            }
                        },
                        data:bins.data
                    }
                   ]
               };

               dataBar = option;




            }


            else if(this.queryType === 'monthly_by_group'){
                let xAxisData = ['2015-02-01','2017-10-07','2018-08-17'];
                // let yAxisData = [10000,90000,78000,500,4500,150];
                option = {
                    legend:{},
                    tooltip:{
                        // trigger:'axis',
                    },
                    dataset:{
                        source:{
                            timestamp:xAxisData,
                            sensor1:[1,null,4],
                            sensor2:[5,3,2],
                        },
                    },
                    xAxis:{
                        type:'category'
                    },
                    yAxis:{},
                    series:[
                        {type:'bar'},{type:'bar'}
                    ]
                }

                dataBar = option;
            }


            else
            {
                var xAxisData = [];
                    var data1 = [];
                    var data2 = [];
                    for (var i = 0; i < 100; i++) {
                        xAxisData.push('degree' + i);
                        data1.push((Math.sin(i / 5) * (i / 5 -10) + i / 6) * 5);
                        data2.push((Math.cos(i / 5) * (i / 5 -10) + i / 6) * 5);
                    }

                    dataBar = {
                        title: {
                            text: 'Payments'
                        },
                        legend: {
                            data: ['bar', 'bar2']
                        },
                        toolbox: {
                            // y: 'bottom',
                            feature: {
                                magicType: {
                                    type: ['stack', 'tiled']
                                },
                                dataView: {},
                                saveAsImage: {
                                    pixelRatio: 2
                                }
                            }
                        },
                        tooltip: {},
                        xAxis: {
                            data: xAxisData,
                            splitLine: {
                                show: false
                            }
                        },
                        yAxis: {
                        },
                        series: [{
                            name: 'bar',
                            type: 'bar',
                            data: data1,
                            animationDelay: function (idx) {
                                return idx * 10;
                            }
                        }, {
                            name: 'bar2',
                            type: 'bar',
                            data: data2,
                            animationDelay: function (idx) {
                                return idx * 10 + 100;
                            }
                        }],
                        animationEasing: 'elasticOut',
                        animationDelayUpdate: function (idx) {
                            return idx * 5;
                        }
                    };

            }




