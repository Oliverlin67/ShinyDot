<!--TopBar-->
<div class="topbar fixed-top">
    <div class="r">
        <div class="b1">
            <button type="button" class="menu-btn" data-toggle="modal" data-target="#board-list"><i class="fas fa-bars"></i></button>
            <a title="ShinyDot" class="logo" href="https://forum.coyu.cc">
                <img title="ShinyDot" src="https://forum.coyu.cc/logo.png" alt="ShinyDot">
            </a>
        </div>
        <div role="navigation" class="b2">
            <?if($page == "view/global/board/BoardShow" && isset($_SESSION["user"])){?>
                <a class="item" title="新增貼文" href="https://forum.coyu.cc/p/new">
                    <i class="fas fa-pencil-alt"></i>
                </a>
            <?}?>
            <a class="item" title="搜尋" data-toggle="modal" data-target="#searchModal">
                <i class="fas fa-search"></i>
            </a>
            <a class="item" title="個人資料" role="button" href="https://forum.coyu.cc/u/<? echo $user_info["user_name"];?>">
                <i class="fas fa-user-circle"></i>
            </a>
        </div>
    </div>
</div>