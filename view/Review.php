

<!DOCTYPE HTML>
<!--Siashunfu-->
<!--This is Review.php-->

<html>
    <head>
        <meta charset="utf-8" />
        <title>Review & Rating To Our System</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>

        <style>
            .progress-label-left {
                float: left;
                margin-right: 0.5em;
                line-height: 1em;
            }
            .progress-label-right {
                float: right;
                margin-left: 0.3em;
                line-height: 1em;
            }
            .star-light {
                color: #e9ecef;
            }
            .star-warning {
                color: #ffc107;
            }
            a {
                 text-decoration: none;
                 display: inline-block;
                padding: 5px 10px;
              }

            a:hover {
                color: black;
                 text-decoration: none;
                }
                ul {
                 list-style-type: none;
                 margin: 0;
                padding: 0;
                overflow: hidden;
                background-color: #F0F0F0;
                }

                li {
                float: left;
                }

                li a:hover {
                background-color: #ddd;
                }
        </style>
    </head>
    <body>
    <ul>
  <li>
  <a href="index.php" class="previous" >Home Page</a>
  </li>
</ul> 
        <div class="container">
            <h1 class="mt-5 mb-5">Villain Review</h1>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4 text-center">
                            <h1 class="text-warning mt-4 mb-4">
                                <b><span id="average_rating">0.0</span> / 5</b>
                            </h1>
                            <div class="mb-3">
                                <i class="fas fa-star star-light mr-1 main_star"></i>
                                <i class="fas fa-star star-light mr-1 main_star"></i>
                                <i class="fas fa-star star-light mr-1 main_star"></i>
                                <i class="fas fa-star star-light mr-1 main_star"></i>
                                <i class="fas fa-star star-light mr-1 main_star"></i>
                            </div>
                            <h3><span id="total_review">0</span> Reviews</h3>
                        </div>
                        <div class="col-sm-4">
                            <!-- Star Rating Progress Bars -->
                            <p>
                            <div class="progress-label-left"><b>5</b> <i class="fas fa-star text-warning"></i></div>
                            <div class="progress-label-right">(<span id="total_five_star_review">0</span>)</div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="five_star_progress"></div>
                            </div>
                            </p>
                            <p>
                            <div class="progress-label-left"><b>4</b> <i class="fas fa-star text-warning"></i></div>
                            <div class="progress-label-right">(<span id="total_four_star_review">0</span>)</div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="four_star_progress"></div>
                            </div>
                            </p>
                            <p>
                            <div class="progress-label-left"><b>3</b> <i class="fas fa-star text-warning"></i></div>
                            <div class="progress-label-right">(<span id="total_three_star_review">0</span>)</div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="three_star_progress"></div>
                            </div>
                            </p>
                            <p>
                            <div class="progress-label-left"><b>2</b> <i class="fas fa-star text-warning"></i></div>
                            <div class="progress-label-right">(<span id="total_two_star_review">0</span>)</div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="two_star_progress"></div>
                            </div>
                            </p>
                            <p>
                            <div class="progress-label-left"><b>1</b> <i class="fas fa-star text-warning"></i></div>
                            <div class="progress-label-right">(<span id="total_one_star_review">0</span>)</div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="one_star_progress"></div>
                            </div>
                            </p>
                        </div>
                        <div class="col-sm-4 text-center">
                            <h3 class="mt-4 mb-3">Write Review Here</h3>
                            <button type="button" name="add_review" id="add_review" class="btn btn-primary">Review</button>
                        </div>

                    </div>
                </div>
            </div>
            
            <div class="mt-5" id="review_content"></div>
<!--            <div class="text-center mt-4">
                <button id="load_more" class="btn btn-secondary">Load More Reviews</button>
            </div>-->
        </div>

        <!-- Review Modal -->
        <div id="review_modal" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Submit Review</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h4 class="text-center mt-2 mb-4">
                            <i class="fas fa-star star-light submit_star mr-1" id="submit_star_1" data-rating="1"></i>
                            <i class="fas fa-star star-light submit_star mr-1" id="submit_star_2" data-rating="2"></i>
                            <i class="fas fa-star star-light submit_star mr-1" id="submit_star_3" data-rating="3"></i>
                            <i class="fas fa-star star-light submit_star mr-1" id="submit_star_4" data-rating="4"></i>
                            <i class="fas fa-star star-light submit_star mr-1" id="submit_star_5" data-rating="5"></i>
                        </h4>
                        <div class="form-group">
                            <input type="text" name="user_name" id="user_name" class="form-control" placeholder="Enter Your Name" />
                        </div>
                        <div class="form-group">
                            <textarea name="user_review" id="user_review" class="form-control" placeholder="Type Review Here"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="file" name="user_image" id="user_image" class="form-control" />
                        </div>
                        <div class="form-group">
                            <div class="g-recaptcha" data-sitekey="6LfwdEQqAAAAALxthcLKsA8Lxc3rNoDBoyJG3Bin"></div>
                        </div>
                        <div class="form-group text-center mt-4">
                            <button type="button" class="btn btn-primary" id="save_review">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Review Modal -->
        <div class="modal fade" id="edit_review_modal" tabindex="-1" role="dialog" aria-labelledby="editReviewModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editReviewModalLabel">Edit Review</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="update_review_form" enctype="multipart/form-data">
                            <input type="hidden" id="edit_review_id" name="id">
                            <div class="form-group">
                                <label for="edit_user_review">Review</label>
                                <textarea class="form-control" id="edit_user_review" name="user_review" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="edit_user_rating">Rating</label>
                                <h4 class="text-center mt-2 mb-4">
                                    <i class="fas fa-star star-light edit_star mr-1" id="edit_star_1" data-rating="1"></i>
                                    <i class="fas fa-star star-light edit_star mr-1" id="edit_star_2" data-rating="2"></i>
                                    <i class="fas fa-star star-light edit_star mr-1" id="edit_star_3" data-rating="3"></i>
                                    <i class="fas fa-star star-light edit_star mr-1" id="edit_star_4" data-rating="4"></i>
                                    <i class="fas fa-star star-light edit_star mr-1" id="edit_star_5" data-rating="5"></i>
                                </h4>
                            </div>
                            <div class="form-group">
                                <label for="edit_user_image">Image</label>
                                <input type="file" class="form-control-file" id="edit_user_image" name="user_image">
                            </div>




                            <button type="submit" id= "update_review_button" class="btn btn-primary">Update Review</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>




            $(document).ready(function () {
                var rating_data = 0;
                var edit_rating_data = 0;
                var current_page = 1;




                // Handle edit button click
                $(document).on('click', '.edit_review', function () {
                    var reviewId = $(this).data('id');
                    $.ajax({
                        url: '../view/admin/fetch_review.php', 
                        type: 'POST',
                        data: {id: reviewId},
                        dataType: 'json',
                        success: function (response) {
                            var review = response;
                            
                             

                            $('#edit_review_modal').find('input[name="id"]').val(review.id);
                            $('#edit_review_modal').find('input[name="user_name"]').val(review.user_name);
                            $('#edit_review_modal').find('textarea[name="user_review"]').val(review.user_review);
                            $('#edit_review_modal').find('input[name="user_rating"]').val(review.user_rating);
                            // Update star rating display
                            $('.edit_star').removeClass('text-warning').addClass('star-light');


                            for (var i = 1; i <= review.user_rating; i++) {

                                $('#edit_star_' + i).removeClass('star-light').addClass('text-warning');

                            }
                            edit_rating_data = review.user_rating;
                            console.log(edit_rating_data);

                            $('#edit_review_modal').modal('show');
                        }
                    });
                });



     // Edit Star rating hover effect
                $(document).on('mouseenter', '.edit_star', function () {
                    var rating = $(this).data('rating');
                    edit_reset_background();
                    for (var count = 1; count <= rating; count++) {
                        $('#edit_star_' + count).addClass('text-warning');
                        
                    
                    }
                });
                $(document).on('mouseleave', '.edit_star', function () {
                    edit_reset_background();
                    if (edit_rating_data > 0) {
                        for (var count = 1; count <= edit_rating_data; count++) {
                            $('#edit_star_' + count).addClass('text-warning');
                        }
                    }
                });
                $(document).on('click', '.edit_star', function () {
                    edit_rating_data = $(this).data('rating');
                    $('#rating').val(edit_rating_data);
                    
                    console.log(edit_rating_data );
                });
                function edit_reset_background() {
                    $('.edit_star').addClass('star-light');
                    $('.edit_star').removeClass('text-warning');
                }




                // Handle update button click in the modal
                $(document).ready(function () {
                    $(document).on('click', '#update_review_button', function (e) {
                        e.preventDefault(); // Prevent default form submission

                        var reviewId = $('#edit_review_id').val();
                        var userReview = $('#edit_user_review').val();

                        var userImage = $('#edit_user_image').prop('files')[0] || null;
                        var formData = new FormData();

                        formData.append('id', reviewId);
                        formData.append('review', userReview);
                        formData.append('rating', edit_rating_data);

                        if (userImage) {
                            formData.append('user_image', userImage);
                        }


                        console.log(edit_rating_data);
                        console.log(reviewId);
                        console.log(userReview);


                        $.ajax({
                            url: '../controller/review_edit.php',
                            method: 'POST',
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function (response) {
                                alert('Review updated successfully.');
                                location.reload(); 
                                
                                
                            },
                            error: function (xhr, status, error) {
                                console.error('AJAX Error:', status, error);
                            }
                        });

                    });
                    loadReviews();
                });



                // Handle delete button click
                $(document).on('click', '.delete_review', function () {
                    var reviewId = $(this).data('id');
                    if (confirm('Are you sure you want to delete this review?')) {
                        $.ajax({
                            url: '../controller/review_delete.php',
                            type: 'POST',
                            data: {id: reviewId},
                            success: function (response) {
                                alert(response);
                                loadReviews(); 
                            }
                        });
                    }
                });

                // Function to reload reviews 
                function loadReviews() {
                    $.ajax({
                        url: '../controller/review_load.php',
                        type: 'POST',
                        data: {page: 1}, 
                        success: function (response) {
                            $('#review_content').html(response); 
                        }
                    });
                }
                // Open review modal
                $('#add_review').click(function () {
                    $('#review_modal').modal('show');
                    
                });


         $('#load_more').click(function () {
                    current_page++;
                    load_reviews(current_page);
                });

                load_reviews(current_page);
            });








                // Star rating hover effect
                $(document).on('mouseenter', '.submit_star', function () {
                    var rating = $(this).data('rating');
                    reset_background();
                    for (var count = 1; count <= rating; count++) {
                        $('#submit_star_' + count).addClass('text-warning');
                    }
                });

                $(document).on('mouseleave', '.submit_star', function () {
                    reset_background();
                    if (rating_data > 0) {
                        for (var count = 1; count <= rating_data; count++) {
                            $('#submit_star_' + count).addClass('text-warning');
                        }
                    }
                });
                $(document).on('click', '.submit_star', function () {
                    rating_data = $(this).data('rating');
                    $('#rating').val(rating_data);
                });

                function reset_background() {
                    $('.submit_star').addClass('star-light');
                    $('.submit_star').removeClass('text-warning');
                }


                $('#save_review').click(function () {
                    var user_name = $('#user_name').val();
                    var user_review = $('#user_review').val();
                    var user_image = $('#user_image').prop('files')[0] || null;
                    var captcha_response = grecaptcha.getResponse();

                    if (captcha_response.length === 0) {
                        alert('Please complete the reCAPTCHA');
                        return;
                    }
                    // Validate image size (max 2MB) and type
                    if (user_image) {
                        var allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                        if (allowedTypes.indexOf(user_image.type) === -1) {
                            alert('Only JPG, JPEG, and PNG formats are allowed.');
                            return;
                        }
                        if (user_image.size > 2 * 1024 * 1024) { // 2MB limit
                            alert('Image size should not exceed 2MB.');
                            return;
                        }
                    }
                    var formData = new FormData();
                    formData.append('user_name', user_name);
                    formData.append('user_review', user_review);
                    if (user_image) {
                        formData.append('user_image', user_image);
                    }
                    formData.append('rating_data', rating_data);
                    formData.append('captcha_response', captcha_response);


                    $.ajax({
                        url: '../controller/review_process.php',
                        method: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            if (data === 'Your Review & Rating Successfully Submitted') {
                                alert('Review Submitted Successfully!');
                                 location.reload();
                                $('#review_modal').modal('hide');
                                $('#review_content').html('');  
                                current_page = 1;  

                                // Reload the page after a short delay to ensure the modal has closed
                                setTimeout(function () {
                                    location.reload();
                                }, 500);  // Delay in milliseconds (500ms = 0.5s)
                            } else {
                                alert(' ' + data);
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('AJAX Error:', status, error);
                            alert('An error occurred while submitting the review.');
                        }
                    });

                });
                
                
                function load_reviews(page) {
                    $.ajax({
                        url: '../controller/review_load.php',
                        method: 'POST',
                        data: {page: page},
                        success: function (data) {
                            
                            // Extract rating information from the data if it's included
                            var $data = $(data);
                            var average_rating = $data.find('#average_rating').text();
                            var total_five_star_review = parseInt($data.find('#total_five_star_review').text());
                            var total_four_star_review = parseInt($data.find('#total_four_star_review').text());
                            var total_three_star_review = parseInt($data.find('#total_three_star_review').text());
                            var total_two_star_review = parseInt($data.find('#total_two_star_review').text());
                            var total_one_star_review = parseInt($data.find('#total_one_star_review').text());
                            var total_reviews = total_five_star_review + total_four_star_review + total_three_star_review + total_two_star_review + total_one_star_review;

                            // Update rating information
                            $('#average_rating').text(average_rating);
                            $('#total_five_star_review').text(total_five_star_review);
                            $('#total_four_star_review').text(total_four_star_review);
                            $('#total_three_star_review').text(total_three_star_review);
                            $('#total_two_star_review').text(total_two_star_review);
                            $('#total_one_star_review').text(total_one_star_review);
                            $('#total_review').text(total_reviews); // Display total reviews
                            // Update progress bars
                            function calculate_percentage(count) {
                                return total_reviews === 0 ? 0 : (count / total_reviews) * 100;
                            }
                            $('#five_star_progress').css('width', calculate_percentage(total_five_star_review) + '%');
                            $('#four_star_progress').css('width', calculate_percentage(total_four_star_review) + '%');
                            $('#three_star_progress').css('width', calculate_percentage(total_three_star_review) + '%');
                            $('#two_star_progress').css('width', calculate_percentage(total_two_star_review) + '%');
                            $('#one_star_progress').css('width', calculate_percentage(total_one_star_review) + '%');

                            // Update review content
                            if (page === 1) {
                                $('#review_content').html(data);  
                            } else {
                                $('#review_content').append(data);  
                            }
                            
                        },
                        error: function (xhr, status, error) {
                            console.error('AJAX Error: ' + status + error);
                            alert('An error occurred while loading reviews.');
                        }
                    });
                }

        
        </script>

    </body>
</html>