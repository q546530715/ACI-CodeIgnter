<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>男朋友拼图游戏排行板</title>
        <link href="<?php echo base_url('css/bootstrap.min.css') ?>" rel="stylesheet">
        <script src="<?php echo base_url('/scripts/lib/jquery.js') ?>" ></script>
        <script src="<?php echo base_url('/scripts/lib/bootstrap.min.js') ?>" ></script>
    </head>
    <body>
        <style>

            table tr td{
                font-size:12px;
            }
        </style>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 text-center bg-primary" style="height:50px;line-height:50px;">拼图游戏排名    

                    <a href="http://mp.npy520.com/index.php/oauth/index/mp.npy520.comZindex.phpZoauthZcallback/jigsaw" class="btn btn-info " >我要挑战</a>

                </div>
                <div class="col-xs-12 text-center" style="height:50px;padding:15px;">
                    <?php if ($rank_key == 0): ?>
                        您当前还没有排名哦,快去挑战看看吧..
                    <?php elseif ($rank_key <= 10) : ?>
                        <p>您当前的排名为: &nbsp;<span style="color:red;font-size:18px;"><b><?php echo $rank_key; ?></b></span></p>
                    <?php else: ?>
                        您此时的排名在千里之外!千里之外!!千里之外!!!
                    <?php endif; ?>

                </div>
                <div class="col-xs-12">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th class="text-center">排名</th>
                                <th class="text-center">头像</th>
                                <th class="text-center">姓名 / 闯关时间</th>
                                <th class="text-center">闯过关卡</th>
                                <th class="text-center">总时间</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rank as $k => $v): ?>
                                <tr>
                                    <td style="vertical-align:middle;"><?php echo $k + 1; ?></td>
                                    <td style="vertical-align:middle;" ><img src="<?php echo $v['headimgurl']; ?>" width="30" height="30" /></td>
                                    <td style="vertical-align:middle;"><p class="text-left"><?php echo $v['nickname']; ?>  </p><p  class="text-left">换个姿势玩,分数会更高</p></td>
                                    <td style="vertical-align:middle;"><?php echo $v['checkpoint']; ?> </td>
                                    <td style="vertical-align:middle;"><?php echo $v['g_rank']; ?> "</td>
                                </tr>
                            <?php endforeach; ?>


                        </tbody>
                    </table>  
                    <div class="text-center">
                        <a href="http://mp.npy520.com/index.php/oauth/index/mp.npy520.comZindex.phpZoauthZcallback/jigsaw" class="btn btn-info" style="padding:10px;">哼!我要挑战更高分数</a>
                    </div>
                </div>
            </div> 
        </div>

    </body>
</html>