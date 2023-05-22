<?php include('server/connection.php');

    if (isset($_GET['blog_id'])){
        $blog_id = $_GET['blog_id'];

        $query_blog = "SELECT b.blog_title AS title, b.blog_tags AS tags, 
        b.blog_date AS b_date, b.blog_description AS b_description, 
        b.blog_quotes AS quotes, b.blog_quotes_writer AS quote_writer,
        b.blog_image2 AS big_blog_image, a.admin_name AS writer, 
        a.admin_photo AS photo 
        FROM blogs b, admins a 
        WHERE blog_id=$blog_id AND b.admin_id = a.admin_id";

        $stmt_blog = $conn->prepare($query_blog);
        $stmt_blog->execute();
        $blog_detail = $stmt_blog->get_result();

    } else {
        header('location: index.php');
    }

    include("layout/header.php");
?>
    <?php while($row = $blog_detail->fetch_assoc()) { ?>
    <!-- Blog Details Hero Begin -->
        <section class="blog-hero spad">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-9 text-center">
                        <div class="blog__hero__text">
                            <h2><?= $row['title']; ?></h2>
                            <ul>
                                <li>By <?= $row['writer']; ?></li>
                                <li><?= date('d F Y', strtotime($row['b_date'])); ?></li>
                                <li>8 Comments</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <!-- Blog Details Hero End -->

    <!-- Blog Details Section Begin -->
    <section class="blog-details spad">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-12">
                    <div class="blog__details__pic">
                        <img src="img/blog/details/<?= $row['big_blog_image']; ?>" alt="">
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="blog__details__content">
                        <div class="blog__details__share">
                            <span>share</span>
                            <ul>
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#" class="twitter"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#" class="youtube"><i class="fa fa-youtube-play"></i></a></li>
                                <li><a href="#" class="linkedin"><i class="fa fa-linkedin"></i></a></li>
                            </ul>
                        </div>
                        <div class="blog__details__text">
                            <p><?= $row['b_description'] ?></p>
                          </div>
                        <div class="blog__details__quote">
                            <i class="fa fa-quote-left"></i>
                            <p><?= $row['quotes'] ?></p>
                            <h6><?= $row['quote_writer'] ?></h6>
                        </div>
                        <div class="blog__details__option">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="blog__details__author">
                                        <div class="blog__details__author__pic">
                                            <img src="img/blog/details/<?= $row['photo'] ?>" alt="">
                                        </div>
                                        <div class="blog__details__author__text">
                                            <h5><?= $row['writer'] ?></h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="blog__details__tags">
                                        <a href="#"><?= $row['tags']; ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="blog__details__btns">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <a href="" class="blog__details__btns__item">
                                        <p><span class="arrow_left"></span> Previous Pod</p>
                                        <h5>It S Classified How To Utilize Free Classified Ad Sites</h5>
                                    </a>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <a href="" class="blog__details__btns__item blog__details__btns__item--next">
                                        <p>Next Pod <span class="arrow_right"></span></p>
                                        <h5>Tips For Choosing The Perfect Gloss For Your Lips</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="blog__details__comment">
                            <h4>Leave A Comment</h4>
                            <form action="#">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        <input type="text" placeholder="Name">
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <input type="text" placeholder="Email">
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <input type="text" placeholder="Phone">
                                    </div>
                                    <div class="col-lg-12 text-center">
                                        <textarea placeholder="Comment"></textarea>
                                        <button type="submit" class="site-btn">Post Comment</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Details Section End -->

    <?php } ?>

    <?php include 'layout/footer.php'; ?>
