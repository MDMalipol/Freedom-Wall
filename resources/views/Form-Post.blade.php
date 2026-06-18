<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ShareSpace - Post Your Story</title>
    <link rel="stylesheet" href="{{ asset('css/Post.css') }}">
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>NU FREEDOM SPACE</h1>
            <p>Share your Experiences</p>
        </div>

        <form class="post-form" id="postForm" method="POST" action="{{ route('content.store') }}"
            enctype="multipart/form-data">
            @csrf


            <div class="form-group">
                <label for="name">Your Name (optional)</label>
                <input type="text" id="name" class="form-control" name="name"
                    placeholder="Enter your name or leave blank for anonymous">
            </div>
            <div class="form-group">
                <label for="title">Subject</label>
                <input type="text" id="title" name="title" class="form-control"
                    placeholder="Enter the subject of your post">
            </div>

            <div class="form-group">
                <label for="body">What's on your mind?</label>
                <textarea id="body" class="form-control" name="body" required
                    placeholder="Share your thoughts, experiences, or stories..."></textarea>
            </div>

            <div class="form-group">
                <label>Add Media</label>
                <div class="file-input-wrapper">
                    <input 
                        type="file" 
                        id="media" 
                        class="file-input" 
                        multiple 
                        accept="image/*" 
                        name="media[]"
                        onchange="previewMedia(event)">
                    <label for="media" class="file-input-label">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Click to add images
                    </label>
                </div>

                <div id="uploadMessage" style="margin-top: 10px; color: green; display: none;"></div>

                <div id="mediaPreview" class="media-preview" style="display: none;">
                    <div id="mediaList" style="display: flex; flex-wrap: wrap; gap: 10px;"></div>
                </div>
            </div>

            <script>
                // Store files in an array for further use (e.g. formData)
                let mediaFiles = [];

                function previewMedia(event) {
                    const files = Array.from(event.target.files);
                    const previewContainer = document.getElementById('mediaPreview');
                    const mediaList = document.getElementById('mediaList');
                    const uploadMessage = document.getElementById('uploadMessage');

                    mediaList.innerHTML = '';
                    uploadMessage.style.display = 'none';
                    mediaFiles = []; // reset previous selection

                    if (files.length > 0) {
                        // Store files in mediaFiles array
                        mediaFiles = files;

                        // Show message
                        uploadMessage.style.display = 'block';
                        uploadMessage.textContent = `${files.length} image${files.length > 1 ? 's are' : ' is'} selected`;

                        // Show preview
                        previewContainer.style.display = 'block';
                        files.forEach(file => {
                            if (file.type.startsWith('image')) {
                                const img = document.createElement('img');
                                img.src = URL.createObjectURL(file);
                                img.style.maxWidth = '150px';
                                img.style.maxHeight = '150px';
                                img.style.objectFit = 'cover';
                                img.style.marginRight = '10px';
                                mediaList.appendChild(img);
                            }
                        });
                    } else {
                        previewContainer.style.display = 'none';
                    }
                }
            </script>



            <div class="form-actions" style="display: flex; gap: 10px;">
                <button type="submit" class="submit-btn">Share Post</button>
                <a href="{{ route('wall') }}" class="cancel-btn"
                    style="display: inline-block; padding: 10px 20px; background: #f44336; color: #fff; border-radius: 4px; text-decoration: none; border: none; transition: background 0.2s; font-weight: 500; box-shadow: 0 2px 6px rgba(244,67,54,0.08);">Cancel</a>
            </div>

        </form>
</body>

</html>