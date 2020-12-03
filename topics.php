<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/function/functions.php'); 
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/connect.php'); 
$GetBoardName = $conn->query("SELECT board_name FROM boards WHERE board_id = '$_GET[id]' LIMIT 1");
$GetBoardName_result=$GetBoardName->fetch();
include($_SERVER['DOCUMENT_ROOT'].'/includes/1head.php'); ?>
    <head>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script type="text/javascript" src="node_modules/bootstrap/dist/js/bootstrap.js"></script>
    </head>

    <body>
        <?php include($_SERVER['DOCUMENT_ROOT'].'/includes/header.php'); ?>
        <main class="pr-sm-5 pl-sm-5">
            <div class="container-fluid shadow rounded-lg" id="content">
                <div class="row">
                    <div class="col-12">
                        <?php include($_SERVER['DOCUMENT_ROOT'].'/includes/breadcrumb.php'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-9 col-md-8">

                        <section class="mb-3" id="topics">
                            
                            <article class="container-fluid">
                                <div class="row">
                                    <div class="col">
                                        <h2>Board : <?php
                                    echo $GetBoardName_result[board_name];
                                    ?></h2>
                                    <div class="alert alert-danger" role="alert">
                                    <p data-toggle="modal" data-target="#ModalRules"><i class="fab fa-readme"></i> Forum rules </i> </p>

                                                <!-- Modal Rules Start -->
                                                <div class="d-flex justify-content-start">
        <div class="mr-3">

            <div class="modal fade" id="ModalRules" tabindex="1" role="dialog" data-backdrop="false" aria-labelledby="ModalRulesLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document" style="z-index: 10">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ModalRulesLabel">Forum rules </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        <?php include($_SERVER['DOCUMENT_ROOT'].'/includes/rules.php'); ?>
                        </div>
                    </div>
                </div>
            </div>
        
        <script type="text/javascript">
            let posts = document.getElementsByClassName('post-content');
            
            Array.from(posts).forEach(post => {
                const comment = post.innerHTML;
                const cleanComment = DOMPurify.sanitize(comment)
                post.innerHTML = marked(cleanComment);
            });
        </script>


        <!-- Modal Rules END -->

                                    </div>
                                </div>
                            </div>

                                <div class="btn-and-search row">
                                    <a href="newtopic.php?boardID=<?= $_GET[id];?>"> <div class="p-3 btn btn-primary btn-block rounded-pill"> New Topic <i class="fas fa-pencil-alt"></i> </div></a>
                                    <div class="col-2"> <?php include('includes/search.php'); ?> </div>
                                </div>

                                <div class="container-fluid bg-light rounded-lg m-2">
                                    <div class="gradient-header row d-flex align-items-center">
                                        <div class="card-header__element col-7">
                                            <p class="h6 mb-1">Announcements</p>
                                        </div>
                                        <div class="card-header__element col-2"> <i class="fas fa-comments"></i> </div>
                                        <div class="card-header__element col-1"> <i class="far fa-eye"></i> </div>
                                        <div class="card-header__element col-2"> <i class="far fa-clock"></i> </div>
                                    </div>

                                    <div id="announce-list" class="card-body">
                                    <?php
                                        $req_announce = getAnnounces();
                                            while ($ann = $req_announce->fetch())
                                            { 
                                            ?>
                                            <div class="card border-0 m-1">
                                                <div class="ann-list-item card-body w-100 d-flex align-items-center">
                                                    <div class="col-7">
                                                        <?php echo '<a href="./announce.php?id=' . $ann['ann_id'] . '">' . $ann['ann_subject'] . '</a>'?>
                                                    </div>
                                                    <div class="ann-details col-2">
                                                        <!-- COMMENTS -->
                                                        <?= getAnnounces()->rowCount(); ?>
                                                    </div>
                                                    <div class="ann-details col-1">
                                                        <!-- VIEWS -->
                                                        <?= $ann['ann_views']; ?>
                                                    </div>
                                                    <div class="ann-details col-2">
                                                        <!-- DATE -->
                                                        <?php 
                                                            $req_user = getLastAnnouce();
                                                            while($user = $req_user->fetch()) {
                                                        ?>
                                                        <div class="d-flex">
                                                            <div class="font-weight-light pr-1">by </div>
                                                            
                                                            <a href="member.php?view_user_id=<?= $user['user_id']; ?>" >
                                                            <strong> 
                                                                    <?= ucwords($user['user_name']); ?>
                                                            </strong>
                                                            </a>
                                                        </div>
                                                        <div class="font-weight-light">
                                                            <?php
                                                                $annDate = new DateTime($ann['ann_date']);
                                                                echo $annDate->format('D M d, H:i');
                                                            ?>
                                                        </div>
                                                        <?php
                                                            }
                                                            $req_user->closeCursor();
                                                            ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            }
                                        $req_announce->closeCursor();
                                        ?>
                                    </div>
                                </div>

                                <div class="container-fluid bg-light rounded-lg m-2 pb-3">
                                    <div class="gradient-header row d-flex">
                                        <div class="col-7">
                                            <p class="h6 mb-1">Topics' List</p>
                                        </div>
                                        <div class="col-2"> <i class="fas fa-comments"></i> </div>
                                        <div class="col-1"> <i class="far fa-eye"></i> </div>
                                        <div class="col-2"> <i class="far fa-clock"></i> </div>
                                    </div>

                                    <div id="topics-list" class="card-body">
                                        <?php
                                        $req_topics = getTopics($_GET['id']);
                                        while ($topic = $req_topics->fetch())
                                        { 
                                        ?>
                                        <div class="card border-0 m-1">
                                            <div class="topic-list-item card-body w-100 d-flex align-items-center">
                                                <div class="col-7">
                                                    <?php echo '<a href="./comments.php?id=' . $topic['topic_id'] . '">' . $topic['topic_subject'] . '</a>'?>
                                                </div>
                                                <div class="topic-details col-2">
                                                    <!-- COMMENTS -->
                                                    <?php
                                                        $req_posts = getPosts($topic['topic_id']);
                                                        $posts_cnt = $req_posts->rowCount();
                                                        echo $posts_cnt;
                                                        $req_posts->closeCursor();
                                                    ?>
                                                </div>
                                                <div class="topic-details col-1">
                                                    <!-- VIEWS -->
                                                    <?= $topic['topic_views']; ?>
                                                </div>
                                                <div class="topic-details col-2">
                                                    <!-- DATE -->
                                                    <div class="d-flex">
                                                        <div class="font-weight-light pr-1">by</div>
                                                        <?php
                                                            $req_lastPosts = getLastPost($topic['topic_id']);
                                                            while($lastPost = $req_lastPosts->fetch()) {
                                                        ?>
                                                        <a href="member.php?view_user_id=<?= $lastPost['user_id']; ?>" >
                                                        <strong class="text-danger"> 
                                                            <?= ucwords($lastPost['user_name']); ?>
                                                        </strong></a>
                                                    </div>
                                                    <div class="font-weight-light">
                                                        <?php
                                                            $postDate = new DateTime($lastPost['post_date']);
                                                            echo $postDate->format('D M d, H:i');
                                                        }
                                                        $req_lastPosts->closeCursor();
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        }
                                        $req_topics->closeCursor();
                                        ?>
                                    </div>
                                </div>
                            </article>
                            
                        </section>
                    </div>
                    <div class="col-xl-3 col-md-4 d-none d-md-block">
                        <?php include('includes/search.php'); ?>
                        <?php include('includes/signin.php'); ?>
                        <?php include('includes/sidebutton2.php'); ?>
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

        <script type="text/javascript" src="js/scroll-up-btn.js"></script>
    </body>
</html>