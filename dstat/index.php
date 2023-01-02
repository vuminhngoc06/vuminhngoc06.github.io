<?php
require 'config/config.php';
$dataName = ($zone == 'EU') ? (($lang == 'FR') ? "Octets" : "Bytes") : 'Bits';
$requestLang = ($lang == 'FR') ? 'Requetes' : 'Requests';
$perSecondLang = ($lang == 'FR') ? 'par seconde' : 'per second';
?>
<title><?php echo $sitename; ?></title>

<html style="background-color:#121212;">
<head>
    <?php error_log(" \r\n", 3, 'data/layer7-logs'); ?>
</head>
<body>
<div id="layer7"></div>
<br/>
<div id="layer4"></div>
<br/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
        integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/8.2.2/highcharts.js"
        integrity="sha512-PpL09bLaSaj5IzGNx6hsnjiIeLm9bL7Q9BB4pkhEvQSbmI0og5Sr/s7Ns/Ax4/jDrggGLdHfa9IbsvpnmoZYFA=="
        crossorigin="anonymous"></script>
<script
        src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/8.2.2/modules/exporting.min.js"
        integrity="sha512-DuFO4JhOrZK4Zz+4K0nXseP0K/daLNCrbGjSkRzK+Zibkblwqc0BYBQ1sTN7mC4Kg6vNqr8eMZwLgTcnKXF8mg=="
        crossorigin="anonymous"
></script>

<script id="source" language="javascript" type="text/javascript">
    $(document).ready(function () {
        Highcharts.createElement(
            "link",
            {
                href: "https://fonts.googleapis.com/css?family=Unica+One",
                rel: "stylesheet",
                type: "text/css",
            },
            null,
            document.getElementsByTagName("head")[0]
        );

        let layer7 = new Highcharts.Chart({
            chart: {
                renderTo: "layer7",
                defaultSeriesType: "spline",
                events: {
                    load: requestData(0),
                },
                backgroundColor: {
                            linearGradient: { x1: 0, y1: 0, x2: 1, y2: 0 },
                            stops: [
                                [0, '#121212'],
                                [1, '#121212']
                            ]
                },
                 style: {
                            fontFamily: "'Unica One', sans-serif"
                        },
                        plotBorderColor: '#606063'
                },
            title: {
                text: "<?php echo $Layer7Title;?>",
                style: {
                            color: '#E0E0E3',
                            textTransform: 'uppercase',
                            fontSize: '20px'
                        }
                        },
            plotOptions: {
                        series: {
                            dataLabels: {
                                color: '#B0B0B3'
                            },
                            marker: {
                                lineColor: '#333'
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
                        },
                        area: {
                            fillColor: {
                                linearGradient: {
                                    x1: 0,
                                    y1: 0,
                                    x2: 0,
                                    y2: 1
                                },
                                stops: [
                                    [0, '#FF0000'],
                                    [1, Highcharts.Color('#FF0000').setOpacity(0).get('rgba')]
                                ]
                            },
                            marker: {
                                radius: 2
                            },
                            lineWidth: 1,
                            states: {
                                hover: {
                                    lineWidth: 1
                                }
                            },
                            threshold: null
                        }
                        },
            xAxis: {
                type: "datetime",
                tickPixelInterval: 150,
                maxZoom: 20 * 1000,
                gridLineColor: '#707073'
            },
            yAxis: {
                minPadding: 0.2,
                maxPadding: 0.2,
                title: {
                    text: "<?php echo $requestLang;?> <?php echo $perSecondLang;?>",
                    margin: 80,
                },
            },
            series: [
                {
                    name: "<?php echo $requestLang;?>/s",
                    data: [],
                },
            ],
        });
        function requestData(type) {
            $.ajax({
                url: "data/" + (!type ? "layer7" : "layer4") + ".php",
                success: function (point) {
                    var series = (!type ? layer7 : layer4).series[0],
                        shift = series.data.length > 40;
                    series.addPoint(point, true, shift);
                    setTimeout(() => requestData(type), 1000);
                },
                cache: false,
            });
        }
    });
</script>
<style type="text/css" media="screen">
a:link { color:#ffffff; text-decoration: none; }
a:visited { color:#ffffff; text-decoration: none; }
a:hover { color:#ffffff; text-decoration: none; }
a:active { color:#ffffff; text-decoration: underline; }
.circle-container {
	position: fixed;
	bottom: 76px;
	right: 14px;
	height: 48px;
	width: 48px;
	border-radius: 48px;
	box-shadow: 0 4px 32px 0 rgba(0, 0, 0, .175);
	transition: transform .15s ease-in-out, box-shadow .15s ease-in-out;
	cursor: pointer;
	z-index: 999
}

.circle-container:hover {
	transform: scale(1.05);
	box-shadow: 0 4px 42px 0 rgba(0, 0, 0, .25)
}

.circle-icon-discord {
	background-image: url(https://i.imgur.com/zbaKre7.png);
	background-color: #7186cc;
	display: block;
	width: 100%;
	height: 100%;
	border-radius: 60px;
	background-size: cover;
	background-repeat: no-repeat
}

.header-logo-image-footer {
	position: absolute;
top: -5px;
left: -45px;
height: 140px;
}

@media screen and (min-width:560px) {
	.circle-container {
		height: 60px;
		width: 60px;
		border-radius: 60px;
		bottom: 104px;
		right: 24px
	}
}

</style>
    </head>
<body>
<center>
<div id="container" style="max-width: 1px; height: 1px; margin: 0 auto; margin-top: 15px;"></div>
<MARQUEE WIDTH="20px" direction="right"><font color="red">>></font></MARQUEE>
<font color="white">hit <?php echo $Layer7Title;?>/</font>
<MARQUEE WIDTH="20px" direction="left"><font color="red"><<</font></MARQUEE>
<br>
<a href='https://bmh.ovh'><img height=50px width=50px src='https://images-ext-1.discordapp.net/external/3jMX2loqMZeChZUnlfHEfQntqnYc447Ib1a1zM6uJNU/%3Fsize%3D2048/https/cdn.discordapp.com/avatars/849596577793441822/97a5a30c9cb342f81a3a2cfa6f10fa87.png'/>
<br>
<font color="red">COPYRIGHT:<font color="white"> bmhien </a></font></font><br /><br />
</html>

