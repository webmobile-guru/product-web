var chartsJsLoaded = false;
var url = $('base').attr('href');
function loadChart(){

    loadExchangeSettings();
    $('#chartContainer').append('<div class="loading_graph"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i></div>');

    $.ajax({
        url:url + '/last-price?pair='+currencyPair,
        type:'GET',
        dataType:'json',
        beforeSend:function(){
            $('#chartContainer .loading_graph').remove();
        },
        success:function(data) {
            //console.log(data);
        },
        error:function(data){
            console.log(data);
        }
    }).done(function(data){
        chartsJsLoaded = true;
        var ohlc = [],volume = [],dataLength;
        dataLength = data.length,
            groupingUnits = [[
                'week',                         // unit name
                [1]                             // allowed multiples
            ], [
                'month',
                [1, 2, 3, 4, 6]
            ]],
            i = 0;

        for (i; i < dataLength; i += 1) {
            ohlc.push([
                parseFloat(data[i].intervals), // the date
                parseFloat(data[i].open), // open
                parseFloat(data[i].high), // high
                parseFloat(data[i].low), // low
                parseFloat(data[i].close) // close
            ]);

            volume.push([
                parseFloat(data[i].intervals), // the date
                parseFloat(data[i].volume) // the volume
            ]);
        }
        Highcharts.createElement('link', {
            href: 'https://fonts.googleapis.com/css?family=Unica+One',
            rel: 'stylesheet',
            type: 'text/css'
        }, null, document.getElementsByTagName('head')[0]);
        
        Highcharts.theme = {
            colors: ['#ff0066', '#70a800', '#f45b5b', '#7798BF', '#aaeeee', '#ff0066',
                '#eeaaee', '#55BF3B', '#DF5353', '#7798BF', '#aaeeee'],
            chart: {
                backgroundColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 1, y2: 1 },
                    stops: [
                        [0, '#fff'],
                        [1, '#fff']
                    ]
                },
                style: {
                    fontFamily: '\'Unica One\', sans-serif'
                },
                plotBorderColor: '#606063'
            },
            title: {
                style: {
                    color: '#E0E0E3',
                    textTransform: 'uppercase',
                    fontSize: '20px'
                }
            },
            subtitle: {
                style: {
                    color: '#E0E0E3',
                    textTransform: 'uppercase'
                }
            },
            xAxis: {
                gridLineColor: 'rgb(230, 230, 230)',
                labels: {
                    style: {
                        color: '#E0E0E3'
                    }
                },
                lineColor: 'rgb(230, 230, 230)',
                minorGridLineColor: '#505053',
                tickColor: 'rgb(230, 230, 230)',
                title: {
                    style: {
                        color: '#A0A0A3'
        
                    }
                }
            },
            yAxis: {
                gridLineColor: 'rgb(230, 230, 230)',
                labels: {
                    style: {
                        color: '#E0E0E3'
                    }
                },
                lineColor: 'rgb(230, 230, 230)',
                minorGridLineColor: '#505053',
                tickColor: 'rgb(230, 230, 230)',
                tickWidth: 1,
                title: {
                    style: {
                        color: '#A0A0A3'
                    }
                }
            },
            tooltip: {
                backgroundColor: 'rgb(247, 247, 247)',
                style: {
                    color: 'rgb(153, 153, 153)'
                }
            },
            plotOptions: {
                series: {
                    dataLabels: {
                        color: 'rgb(153, 153, 153)',
                        style: {
                            fontSize: '13px'
                        }
                    },
                    marker: {
                        lineColor: 'rgb(230, 230, 230)'
                    }
                },
                boxplot: {
                    fillColor: '#505053'
                },
                candlestick: {
                    lineColor: 'white'
                },
                errorbar: {
                    color: 'white'
                }
            },
            legend: {
                backgroundColor: 'rgba(0, 0, 0, 0.5)',
                itemStyle: {
                    color: '#E0E0E3'
                },
                itemHoverStyle: {
                    color: '#FFF'
                },
                itemHiddenStyle: {
                    color: '#606063'
                },
                title: {
                    style: {
                        color: '#C0C0C0'
                    }
                }
            },
            credits: {
                style: {
                    color: '#666'
                }
            },
            labels: {
                style: {
                    color: '#707073'
                }
            },
        
            drilldown: {
                activeAxisLabelStyle: {
                    color: '#F0F0F3'
                },
                activeDataLabelStyle: {
                    color: '#F0F0F3'
                }
            },
        
            navigation: {
                buttonOptions: {
                    symbolStroke: '#DDDDDD',
                    theme: {
                        fill: 'rgb(247, 247, 247)'
                    }
                }
            },
        
            // scroll charts
            rangeSelector: {
                buttonTheme: {
                    fill: 'rgb(247, 247, 247)',
                    stroke: '#000000',
                    style: {
                        color: '#CCC'
                    },
                    states: {
                        hover: {
                            fill: '#707073',
                            stroke: '#000000',
                            style: {
                                color: 'white'
                            }
                        },
                        select: {
                            fill: '#000003',
                            stroke: '#000000',
                            style: {
                                color: 'white'
                            }
                        }
                    }
                },
                inputBoxBorderColor: '#505053',
                inputStyle: {
                    backgroundColor: '#333',
                    color: 'silver'
                },
                labelStyle: {
                    color: 'silver'
                }
            },
        
            navigator: {
                handles: {
                    backgroundColor: '#666',
                    borderColor: '#AAA'
                },
                outlineColor: '#CCC',
                maskFill: 'rgba(255,255,255,0.1)',
                series: {
                    color: '#7798BF',
                    lineColor: '#A6C7ED'
                },
                xAxis: {
                    gridLineColor: '#505053'
                }
            },
        
            scrollbar: {
                barBackgroundColor: '#808083',
                barBorderColor: '#808083',
                buttonArrowColor: '#CCC',
                buttonBackgroundColor: '#606063',
                buttonBorderColor: '#606063',
                rifleColor: '#FFF',
                trackBackgroundColor: '#404043',
                trackBorderColor: '#404043'
            }
        };
        Highcharts.setOptions(Highcharts.theme);
        Highcharts.stockChart('chartContainer', {
            rangeSelector: {
                selected: 4,
                inputEnabled: false,
                buttons: [{
                    type: 'hour',
                    count: 1,
                    text: '1h'
                },{
                    type: 'day',
                    count: 1,
                    text: '1d'
                }, {
                    type: 'month',
                    count: 1,
                    text: '1m'
                }, {
                    type: 'year',
                    count: 1,
                    text: '1y'
                }, {
                    type: 'all',
                    text: 'All'
                }]
            },

            title: {
                text: ''
            },

            yAxis: [{
                labels: {
                    align: 'right',
                    x: -3
                },
                title: {
                    text: ''
                },
                height: '60%',
                lineWidth: 2
            }, {
                labels: {
                    align: 'right',
                    x: -3
                },
                title: {
                    text: ''
                },
                top: '65%',
                height: '35%',
                offset: 0,
                lineWidth: 2
            }],

            tooltip: {
                split: true
            },
            plotOptions: {
                candlestick: {
                    lineColor: '#ff0066',
                    upLineColor: '#70a800', // docs
                    upColor: '#70a800'
                }
            },

            series: [{
                type: 'candlestick',
                name: '',
                data: ohlc,
                dataGrouping: {
                    units: groupingUnits
                }
            }, {
                type: 'column',
                name: 'Volume',
                data: volume,
                yAxis: 1,
                dataGrouping: {
                    units: groupingUnits
                }
            }]
        });
    });
}