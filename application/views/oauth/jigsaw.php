<?php
if (empty($userinfo['openid'])):
    ?>
    <script language="javascript" type="text/javascript">
        window.location.href = "http://mp.npy520.com/index.php/oauth/index/mp.npy520.comZindex.phpZoauthZcallback/jigsaw"
    </script> 
<?php endif; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta content="yes" name="apple-mobile-web-app-capable">
        <meta content="yes" name="apple-touch-fullscreen">
        <meta content="telephone=no" name="format-detection">
        <meta content="black" name="apple-mobile-web-app-status-bar-style">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" >
        <title>拼图小游戏</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('static/oauth/index.css'); ?>">    
        <style type="text/css">
            .mask{
                position:absolute;
                z-index:99;
                background-color:black;
                top:0px;
                left:0px;
                width:100%;
                height:100%;
                opacity:.8;
                display:none;
            }
            #gameresult{
                position:absolute;
                z-index:100;
                top:25%;
                left:0%;
                width:100%;
                height:100%;
                display:none;
            }
            .resultcontainer{
                width:80%;
                margin:auto;
                color:white;
                text-align:center;
                padding:20px;
            }
            .resultinfo{
                margin-bottom:40px;
                font-size:20px;
            }
            .resultinfo em{
                color:red;
            }
            .btngroup{
                height:60px;
            }
            .btn1{
                padding:8px 15px;
                background-color:#1a1c29;
                border-radius:5px;
                margin-right: 5px;
            }
            .hide{
                display:none;
            }
            .kapics{
                text-align:center;
            }
        </style>




    </head>

    <body>
        <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
        <script>

    var mebtnopenurl = 'http://mp.npy520.com/index.php/oauth/index/mp.npy520.comZindex.phpZoauthZcallback/jigsaw';
    window.shareData = {
        "imgUrl": "<?php echo base_url('static/oauth/images/1.jpg'); ?>",
        "timeLineLink": "http://mp.npy520.com/index.php/oauth/index/mp.npy520.comZindex.phpZoauthZcallback/jigsaw",
        "tTitle": "测试眼力和手速的拼图游戏.",
        "tContent": "好玩的拼图游戏，骚年还不赶紧来一发。"
    };

    wx.config({
        debug: false,
        appId: '<?php echo $signPackage["appId"]; ?>',
        timestamp: '<?php echo $signPackage["timestamp"]; ?>',
        nonceStr: '<?php echo $signPackage["nonceStr"]; ?>',
        signature: '<?php echo $signPackage["signature"]; ?>',
        jsApiList: [
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
                    // 所有要调用的 API 都要加到这个列表中
        ]
    });
    wx.ready(function () {

        // 在这里调用 API
        // 发送给朋友.
        wx.onMenuShareTimeline({
            title: window.shareData.tTitle, // 分享标题
            link: window.shareData.timeLineLink, // 分享链接
            imgUrl: window.shareData.imgUrl, // 分享图标
            success: function () {
                // 用户确认分享后执行的回调函数
                alert('分享成功');
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数
            }
        });
        // 分享到朋友圈
        wx.onMenuShareAppMessage({
            title: window.shareData.tTitle, // 分享标题
            desc: window.shareData.tContent, // 分享描述
            link: window.shareData.timeLineLink, // 分享链接
            imgUrl: window.shareData.imgUrl, // 分享图标
            type: '', // 分享类型,music、video或link，不填默认为link
            dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
            success: function () {
                // 用户确认分享后执行的回调函数
                alert('分享成功');
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数
            }
        });
        wx.error(function (res) {
            alert(res.errMsg);
        });

    });


        </script>
        <form method="post" id="form_list">
            <!-- 分享时候的图片 -->
            <div class="shareImg" style="display:none">
                <img src="<?php echo base_url('static/oauth/images/1.jpg'); ?>" alt="">
            </div>
            <p style="width:100%;text-align:center"> <b>总计时:</b> <span id="counttime" style="color:#666" > 0.0.0"</span> </p>
            <!--页面集合-->
            <div id="pageWrapper">  
                <div id="pages">

                    <div id="page_default" class="pagemodel">

                        <div class="initloading">

                            <span class="normal-loading"></span>
                        </div>

                    </div>
                </div>

            </div>
            <input type="hidden" name="checkpoint" id="checkpoint" value="" >
            <input type="hidden" name="counttime" id="ctime" value="" >
            <input type="hidden" name="openid" value="<?php echo $userinfo['openid']; ?>" >

            <input type="hidden" name="access_token" value="<?php echo $userinfo['access_token']; ?>" >

            <script type="text/javascript">

                var cpro_id = "u1640842";
            </script>

            <div class="mask"></div>
            <div id="gameresult">
                <div class="resultcontainer">
                    <div class="resultinfo">

                    </div>
                    <div style="height:60px;"><a class="btn1" style="background-color:red" id="submit">提交成绩</a></div>

                    <div class="btngroup">

                        <a class="btn1 hide" id="againgame">再玩一次</a>
                        <a class="btn1 hide" id="restartgame">再来一次</a>

                        <a class="btn1" id="continuegame">下一关</a>
                        <a class="btn1" id="sharegame" onclick="dp_share();">炫耀一下</a>
                    </div>
                    <!-- <div class="btngroup">
                            <a class="btn1" onclick="clickMore();">更多游戏</a>
                    </div> -->
                </div>
            </div>
            <script type="text/template" style="display:none;" id="pageTemplate">
                <div id="<%= id%>" class="pagemodel">
                <div class="initloading" >
                <span class="normal-loading"></span>
                </div>
                </div>
            </script>

            <script type="text/template" style="display:none;" id="jigsawTemplate">
                <div class="drag-content">
                <div class="play-container">
                <div class="drag-box">
                </div>
                <div class="masker">
                <div class="load">
                <div class="first-layer"></div>
                <div class="second-layer"></div>
                <div class="third-layer"></div>
                <div class="count-down" >
                <div class="play-button play-button-ready playbtn" id="playbtns"></div>
                <ul>
                <li>3</li>
                <li>2</li>
                <li>1</li>
                </ul>
                </div>
                </div>
                </div>
                <span class="done">done</span>
                </div>
                <div class="timer">
                <div class="timer-con">
                <span class="timer-icon"></span>
                <span class="t counter">00.000''</span>
                </div>

                <div class="kapics">1/1
                </div>
                </div>

                <div class="play-info">
                <div class="first-guide">
                <div>挑战失败！共成功挑战XX关</div>

                </div>
                <div class="playing-state" style="display:none;">
                <span>暂停</span>
                </div>
                <div class="playing-over"  style="display:none;">
                <span class="restart" style="display:none;" onclick="window.reload();">重新开始</span>
                <span class="nextpic">下一关</span>
                <span class="continuepic">继续挑战</span>
                <span class="oldshare">分享</span>
                // <span class="moregame">更多游戏</span>
                </div>
                </div>
                </div>
            </script>

            <script type="text/template" style="display:none;" id="jigsawLayoutTemplate">
                <% for(var i = 0 ; i < list.length;i++){%>
                <div class="item" sort="<%=list[i].sort%>" dragitem='1' style="width:<%=list[i].w%>px;height:<%=list[i].h%>px;background:url(<%=img%>) no-repeat;background-position:<%=list[i].x%>px <%=list[i].y%>px;background-size:<%=width%>px <%=height%>px;"></div>
                <%}%>
            </script>
            <script type="text/template" style="display:none;" id="showNextKaTemplate">
                <div class="shownextka">
                <div class="lastpic">
                <img src="<%=pic%>">
                </div>
                <div class="msg">
                <p><%=first%></p>
                <p><%=second%></p>
                <p>耗时<%=time%></p>
                </div>
                <div class="opera">
                <span class="red next">第<%=next%>关&gt;</span>
                <span class="playagain">再玩一遍</span>
                <span class="share">分享</span>
                </div>
                </div>
            </script>

            <script type="text/javascript" src="<?php echo base_url('static/oauth/js/common.js'); ?>"></script>
            <script type="text/javascript">
                            $(document).ready(function () {
                                $.getScript("<?php echo base_url('static/oauth/js/index.js'); ?>", function () {
                                })
                            });
            </script>
            <script language="javascript">


                function goHome() {
                    window.location = mebtnopenurl;
                }

                function dp_share() {
                    document.getElementById("share").style.display = "";

                }
                function dp_Ranking() {
                    window.location = mebtnopenurl;
                }

                function showAd() {
                }
                function hideAd() {
                }
                document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {

                    WeixinJSBridge.on('menu:share:appmessage', function (argv) {
                        WeixinJSBridge.invoke('sendAppMessage', {
                            "img_url": window.shareData.imgUrl,
                            "link": window.shareData.timeLineLink,
                            "desc": window.shareData.tContent,
                            "title": window.shareData.tTitle
                        }, onShareComplete);
                    });

                    WeixinJSBridge.on('menu:share:timeline', function (argv) {
                        WeixinJSBridge.invoke('shareTimeline', {
                            "img_url": window.shareData.imgUrl,
                            "img_width": "640",
                            "img_height": "640",
                            "link": window.shareData.timeLineLink,
                            "desc": window.shareData.tContent,
                            "title": window.shareData.tTitle
                        }, onShareComplete);
                    });
                }, false);
            </script>
            <div id="share" style="display: none">
                <img width="100%" src="<?php echo base_url('static/oauth/images/share.png'); ?>" style="position: fixed; z-index: 9999; top: 0; left: 0; display: " ontouchstart="document.getElementById(&#39;share&#39;).style.display=&#39;none&#39;;">
            </div>
            <div style="display: none;">
                <script type="text/javascript">
                    var myData = {gameid: "mspt"};
                    function dp_submitScore(score) {
                        myData.score = parseInt(score);
                        myData.scoreName = "闯了" + score + "关";
                        document.title = "我在男朋友拼图中连闯了" + score + "关，骚年们快来挑战我吧！";
                        window.shareData.tTitle = document.title;

                    }
                </script>

                <script type="text/javascript" src="<?php echo base_url('static/oauth/js/jquery-1.8.3.min.js'); ?>"></script>

                <!-- 禁止屏幕拖动的代码 -->
                <script>
                    document.body.addEventListener('touchmove', function (e) {
                        // e.stopPropagation();
                        e.preventDefault();
                    });


                    var t_c = 0
                    var t_t
                    function timedCounts()
                    {
                        hour = parseInt(t_c / 3600);// 小时数
                        min = parseInt(t_c / 60);// 分钟数
                        if (min >= 60) {
                            min = min % 60
                        }
                        lastsecs = t_c % 60;
                        document.getElementById('counttime').innerHTML = hour + '.' + min + '.' + lastsecs + '"';
                        t_c = t_c + 1
                        t_t = setTimeout("timedCounts()", 1000)

                    }

                    $('#submit').click(function () {

                        $("#form_list").attr("action", "/oauth/addresults/");
                        $("#form_list").submit();
                    })

                </script>
                </script>

        </form>



    </body>
</html>