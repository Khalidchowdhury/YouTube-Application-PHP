<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouTube Video Search</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/style.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">
            <a href="index.php">
                <img src="./assets/youtube.jpg" alt="You Tube" width="250" height="120">
            </a>
        </h1>

        <form id="searchForm" class="search-bar">
            <input type="text" id="query" name="query" placeholder="Search for videos" required>
            <button type="submit"><i class="bi bi-search"></i></button>
        </form>

        <div id="videos" class="row mt-4"></div>
        <div class="text-center">
            <button id="loadMore" class="btn btn-secondary" style="display: none;">Load More</button>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <script>
        let nextPageToken = '';
        let query = '';
        let totalVideosLoaded = 0;
        const maxResultsPerPage = 50;
        const maxVideosToLoad = 100;

        function fetchVideos(loadMore = false) {
            if (!loadMore) {
                $('#videos').empty();
                nextPageToken = '';
                totalVideosLoaded = 0;
            }

            $.ajax({
                url: 'load_videos.php',
                method: 'GET',
                data: {
                    query: query,
                    pageToken: nextPageToken
                },
                success: function(response) {
                    const data = JSON.parse(response);
                    nextPageToken = data.nextPageToken;
                    totalVideosLoaded += data.items.length;

                    data.items.forEach(video => {
                        const videoCard = `
                            <div class="col-md-4 mb-4">
                                <div class="card video-card h-100">
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/${video.id.videoId}" allowfullscreen></iframe>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">${video.snippet.title}</h5>
                                        <p class="card-text">${video.snippet.description.substring(0, 100)}...</p>
                                    </div>
                                </div>
                            </div>
                        `;
                        $('#videos').append(videoCard);
                    });

                    if (nextPageToken && totalVideosLoaded < maxVideosToLoad) {
                        $('#loadMore').show();
                    } else {
                        $('#loadMore').hide();
                    }
                }
            });
        }

        function loadInitialVideos() {
            query = 'Laravel';  // Default query to load initially
            fetchVideos();
        }

        $('#searchForm').submit(function(e) {
            e.preventDefault();
            query = $('#query').val();
            fetchVideos();
        });

        $('#loadMore').click(function() {
            fetchVideos(true);
        });

        // Load initial videos on page load
        $(document).ready(function() {
            loadInitialVideos();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
