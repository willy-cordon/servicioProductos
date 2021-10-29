@extends('layouts.master')
@section('main-content')
    <div class="breadcrumb">
        <h1>Sample</h1>
        <ul>
            <li><a href="">Demos</a></li>
            <li>Sample</li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row">
        <div class="col-lg-6 col-md-12">
            <!-- CARD ICON -->
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-icon mb-4">
                        <div class="card-body text-center">
                            <i class="i-Data-Upload"></i>
                            <p class="text-muted mt-2 mb-2">Today's Upload</p>
                            <p class="text-primary text-24 line-height-1 m-0">21</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-icon mb-4">
                        <div class="card-body text-center">
                            <i class="i-Add-User"></i>
                            <p class="text-muted mt-2 mb-2">New Users</p>
                            <p class="text-primary text-24 line-height-1 m-0">21</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-icon mb-4">
                        <div class="card-body text-center">
                            <i class="i-Money-2"></i>
                            <p class="text-muted mt-2 mb-2">Total sales</p>
                            <p class="text-primary text-24 line-height-1 m-0">4021</p>
                        </div>
                    </div>
                </div>


                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-icon-big mb-4">
                        <div class="card-body text-center">
                            <i class="i-Money-2"></i>
                            <p class="line-height-1 text-title text-18 mt-2 mb-0">4021</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-icon-big mb-4">
                        <div class="card-body text-center">
                            <i class="i-Gear"></i>
                            <p class="line-height-1 text-title text-18 mt-2 mb-0">4021</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-icon-big mb-4">
                        <div class="card-body text-center">
                            <i class="i-Bell"></i>
                            <p class="line-height-1 text-title text-18 mt-2 mb-0">4021</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-12">
            <div class="card mb-4">
                <div class="card-body p-0">
                    <h5 class="card-title m-0 p-3">Sales</h5>
                    <div id="echart4" style="height: 300px"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-js')
    <script src="{{asset('assets/js/vendor/echarts.min.js')}}"></script>
    <script>
        'use strict';
        var echartOptions = {
            get smoothLine() {
                return {
                    type: 'line',
                    smooth: true
                }
            },
            get lineShadow() {
                return {
                    shadowColor: 'rgba(0, 0, 0, .2)',
                    shadowOffsetX: -1,
                    shadowOffsetY: 8,
                    shadowBlur: 10
                }
            },
            get gridNoAxis() {
                return {
                    show: false,
                    top: 5,
                    left: 0,
                    right: 0,
                    bottom: 0
                }
            },
            get pieRing() {
                return {
                    radius: ['50%', '60%'],
                    selectedMode: true,
                    selectedOffset: 0,
                    avoidLabelOverlap: false,
                }
            },
            get pieLabelOff() {
                return {
                    label: { show: false },
                    labelLine: { show: false, emphasis: { show: false } },
                }
            },
            get pieLabelCenterHover() {
                return {
                    normal: {
                        show: false,
                        position: 'center'
                    },
                    emphasis: {
                        show: true,
                        textStyle: {
                            fontWeight: 'bold'
                        }
                    }
                }
            },
            get pieLineStyle() {
                return {
                    color: 'rgba(0,0,0,0)',
                    borderWidth: 2,
                    ...this.lineShadow
                }
            },
            get pieThikLineStyle() {
                return {
                    color: 'rgba(0,0,0,0)',
                    borderWidth: 12,
                    ...this.lineShadow
                }
            },
            get gridAlignLeft() {
                return {
                    show: false,
                    top: 6,
                    right: 0,
                    left: '-6%',
                    bottom: 0
                }
            },
            get defaultOptions() {
                return {
                    grid: {
                        show: false,
                        top: 6,
                        right: 0,
                        left: 0,
                        bottom: 0
                    },
                    tooltip: {
                        show: true,
                        backgroundColor: 'rgba(0, 0, 0, .8)'
                    },
                    xAxis: {
                        type: 'category',
                        data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                        show: true
                    },
                    yAxis: {
                        type: 'value',
                        show: false
                    }
                }
            },
            get lineFullWidth() {
                return {
                    grid: {
                        show: false,
                        top: 0,
                        right: '-9%',
                        left: '-8.5%',
                        bottom: 0
                    },
                    tooltip: {
                        show: true,
                        backgroundColor: 'rgba(0, 0, 0, .8)'
                    },
                    xAxis: {
                        type: 'category',
                        show: true
                    },
                    yAxis: {
                        type: 'value',
                        show: false,
                    }
                }
            },
            get lineNoAxis() {
                return {
                    grid: this.gridNoAxis,
                    tooltip: {
                        show: true,
                        backgroundColor: 'rgba(0, 0, 0, .8)'
                    },
                    xAxis: {
                        type: 'category',
                        axisLine: {
                            show: false
                        },
                        axisLabel: {
                            textStyle: {
                                color: '#ccc'
                            }
                        }
                    },
                    yAxis: {
                        type: 'value',
                        splitLine: {
                            lineStyle: {
                                color: 'rgba(0, 0, 0, .1)'
                            }
                        },
                        axisLine: {
                            show: false
                        },
                        axisTick: {
                            show: false
                        },
                        axisLabel: {
                            textStyle: {
                                color: '#ccc'
                            }
                        }
                    }
                }
            }
        };
        $(document).ready(function () {
            // Chart in Dashboard version 2
            let echartElem4 = document.getElementById('echart4');
            if (echartElem4) {
                let echart4 = echarts.init(echartElem4);
                echart4.setOption({
                    ...echartOptions.lineNoAxis,
                    ... {
                        series: [{
                            data: [40, 80, 20, 90, 30, 80, 40],
                            lineStyle: {
                                color: 'rgba(102, 51, 153, .86)',
                                width: 3,
                                shadowColor: 'rgba(0, 0, 0, .2)',
                                shadowOffsetX: -1,
                                shadowOffsetY: 8,
                                shadowBlur: 10
                            },
                            label: { show: true, color: '#212121' },
                            type: 'line',
                            smooth: true,
                            itemStyle: {
                                borderColor: 'rgba(69, 86, 172, 0.86)'
                            }
                        }]
                    },
                    xAxis: { data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] }
                });
                $(window).on('resize', function() {
                    setTimeout(() => {
                        echart4.resize();
                    }, 500);
                });
            }
        })
    </script>
@endsection
