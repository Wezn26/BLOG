<?php /*var_dump($list);die();*/?>
<header class="masthead" style="background-image: url('/public/images/home-bg.jpg')">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="site-heading">
                    <h1>PHP BLOG</h1>
                    <span class="subheading">simple php - oop - mvc - blog</span>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <?php if (empty($list)): ?>
                <p>Post list is empty</p>
            <?php else: ?>
                <?php foreach ($list as $val): ?>
                    <div class="post-preview">
                        <a href="/post/<?php echo $val['id']; ?>">
                            <h2 class="post-title"><?php echo htmlspecialchars($val['name'], ENT_QUOTES); ?></h2>
                            <h5 class="post-subtitle"><?php echo htmlspecialchars($val['description'], ENT_QUOTES); ?></h5>
                        </a>
                        <p><?php echo htmlspecialchars($val['text'], ENT_QUOTES); ?></p>
                        <?php if (!empty('/public/uploaded/' . $val['id'] . '.jpg')): ?>
                         <img alt="image" src="/public/uploaded/<?php echo $val['id'] . '.jpg' ?>">
                        <?php endif; ?>
                        <p class="post-meta">Date: <?php echo htmlspecialchars($val['date'], ENT_QUOTES); ?></p>
                        <p class="post-meta">This post ID <?php echo $val['id']; ?></p>
                    </div>
                    <hr>
                <?php endforeach; ?>
                <div class="clearfix">
                    <?php echo $pagination; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>