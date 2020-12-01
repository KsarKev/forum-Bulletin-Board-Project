<?php
    require_once './includes/function/functions.php';
    incrementTopicViews();
// postedit.php?postedit_id=34
?>

<?php include 'includes/1head.php'; ?>
    <head>
        <link rel="stylesheet" href="css/simplemde.min.css">
        <script src="https://kit.fontawesome.com/ad9205c9ea.js" crossorigin="anonymous"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
        <script type="text/javascript" src="js/functions.js"></script>
        <script src="js/simplemde.min.js"></script>
    </head>
    <body>
        
        <?php include('includes/header.php'); ?>
        <main class="pr-sm-5 pl-sm-5">
            <div class="container-fluid shadow rounded-lg" id="content">
                <div class="row">
                    <div class="col-12">
                        <?php include('includes/breadcrumb.php'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-9 col-md-8">
                        <section id="comments" class="mb-3 pl-md-5">
                            <div class="row">
                                <div class="col">
                                    <h2>Topic Read</h2>
                                    <div class="alert alert-danger" role="alert">
                                    <p>Forum rules</p>
                                        <ol>
                                            <li>No Spam / Advertising / Self-promote in the forums.</li>
                                            <li>Do not post copyright-infringing material.</li>
                                            <li>Do not post “offensive” posts, links or images.</li>
                                            <li>Do not cross post questions.</li>
                                            <li>Do not PM users asking for help.</li>
                                            <li>Remain respectful of other members at all times.</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>

                            <?php require('includes/posts_pagination_reply.php'); ?>
                            <div class="row bg-light rounded-lg pb-3">
                                <div class="col">
                                    <?php
                                        $req = getBreadcrumbs();
                                        while($post = $req->fetch()) {
                                    ?>
                                    <div class="card border-0 shadow-sm rounded-lg mt-3" id="<?php echo $post['post_id']; ?>">
                                        <div class="card-body row">
                                            <div class="col-12 col-sm-5 col-md-3 col-lg-2">
                                                <div class="row mb-2 text-md-center">
                                                    <div class="col-4 col-md-3 col-lg-12">
                                                        <img class="avatar-sm rounded-circle" src="<?= $post['user_image'] ?>" alt="<?= htmlspecialchars($post['user_name']) ?>'s Avatar Picture" width="90">
                                                    </div>
                                                    <div class="col-8 col-md-9 col-lg-12">
                                                        <p class="mt-3 mb-0"><a href="member.php?view_user_id=<?php echo $post['user_id'] ;?>"><strong><?= htmlspecialchars($post['user_name']) ?></strong></a></p>
                                                        <p>Posts: <strong>43</strong></p>
                                                        <?php 
                                                        if(($post[post_by] == $_SESSION[user_id]) AND ($post[post_deleted] == 0)){
                                                            echo '<a href="postedit.php?postedit_id='. $post[post_id] .'">
                                                            <button  class="btn btn-secondary btn-rounded" >Edit/Delete</button>
                                                            </a>';
                                                        } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-7 col-md-9 col-lg-10">
                                                <p class="text-secondary">
                                                <?php
                                                    $date = new DateTime($post['post_date']);
                                                    echo $date->format('D M d, Y H:i:s');
                                                ?></p>
                                                <p class="post-content"><?php if( $post[post_deleted] == 0 ) {?> <?= htmlspecialchars($post['post_content']);} else { echo 'deleted'; }; ?></p>
                                                <hr>
                                                <p class="small"><?= htmlspecialchars($post['user_sign']) ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php 
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <a href="#" onclick="window.history.go(-1); return false;"><i class="fas fa-chevron-left"></i> Return to the topic section</a>
                            </div>
                            <?php require('includes/posts_pagination_reply.php'); ?>
                        </section>
                        
                    </div>
                    <div class="col-xl-3 col-md-4 d-none d-md-block">
                        <?php include('includes/search.php'); ?>
                        <?php include('includes/signin.php'); ?>
                        <?php include('includes/last-posts.php'); ?>
                        <?php include('includes/last-active-user.php'); ?>
                    </div>
                </div>
            </div>
        </main>
        
        <?php include('includes/footer.php'); ?>
        
        <div id="scroll-up-btn" class="d-flex justify-content-center align-items-center" data-toggle="tooltip" data-placement="top" title="Go back to the top">
            <a href="#top"><i class="fas fa-arrow-up scroll-up-btn__icon"></i></a>
        </div>
        
        <script type="text/javascript" src="scroll-up-btn.js"></script>
        <script type="text/javascript" src="./node_modules/marked/marked.min.js"></script>
        <script type="text/javascript" src="./node_modules/dompurify/dist/purify.min.js"></script>
        <script type="text/javascript">
            let posts = document.getElementsByClassName('post-content');
            
            Array.from(posts).forEach(post => {
                const comment = post.innerHTML;
                const cleanComment = DOMPurify.sanitize(comment)
                post.innerHTML = marked(cleanComment);
            });
        </script>
        
    </body>
</html>