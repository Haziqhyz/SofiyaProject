<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>S & S</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <?php include 'navbar.php'; ?>

        <?php include 'sidebar.php'; ?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Input</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Input</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->

                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="col-md-6">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Upload Image</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body" style="display: block;">
                                <form id="imageForm" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="imageTitle">Image Title</label>
                                            <input type="text" class="form-control" id="imageTitle" name="imageTitle" placeholder="Enter image title" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="imageDate">Date</label>
                                            <input type="date" class="form-control" id="imageDate" name="imageDate" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="imageFile">Image File</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="imageFile" name="imageFile" accept="image/*" required>
                                                    <label class="custom-file-label" for="imageFile">Choose file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>




                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Uploaded Images</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-primary btn-sm" id="printPdfBtn">
                                    <i class="fas fa-print"></i> Generate PDF Report
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div id="imageGallery">
                                <div class="row" id="galleryContainer">
                                    <!-- Images will be displayed here -->
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

        <?php include 'footer.php'; ?>

    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>

    <script>
        // Display images from database
        function displayImages() {
            fetch('backend/get_images.php')
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('galleryContainer');
                    container.innerHTML = '';

                    if (data.images.length === 0) {
                        container.innerHTML = '<div class="col-12"><p class="text-center text-muted">No images uploaded yet</p></div>';
                        return;
                    }

                    data.images.forEach((image) => {
                        const imageCard = `
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="card">
                                    <img src="backend/uploads/${image.image_filename}" class="card-img-top" alt="${image.title}" style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title">${image.title}</h5>
                                        <p class="card-text text-muted">
                                            <small><i class="fas fa-calendar"></i> ${image.image_date}</small>
                                        </p>
                                        <button class="btn btn-sm btn-danger" onclick="deleteImage(${image.id})">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                        container.innerHTML += imageCard;
                    });
                })
                .catch(error => console.error('Error:', error));
        }

        // Handle form submission
        document.getElementById('imageForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            
            fetch('backend/upload_image.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Image uploaded successfully!');
                    document.getElementById('imageForm').reset();
                    document.getElementById('imageFile').parentElement.querySelector('.custom-file-label').textContent = 'Choose file';
                    displayImages();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while uploading.');
            });
        });

        // Delete image
        function deleteImage(id) {
            if (confirm('Are you sure you want to delete this image?')) {
                fetch('backend/delete_image.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({id: id})
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayImages();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }

        // Generate PDF report
        document.getElementById('printPdfBtn').addEventListener('click', function() {
            fetch('backend/generate_pdf.php')
                .then(response => response.blob())
                .then(blob => {
                    const url = window.URL.createObjectURL(blob);
                    const link = document.createElement('a');
                    link.href = url;
                    link.download = 'image-report.pdf';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    window.URL.revokeObjectURL(url);
                })
                .catch(error => console.error('Error:', error));
        });

        // Update file label on file selection
        document.getElementById('imageFile').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name || 'Choose file';
            this.parentElement.querySelector('.custom-file-label').textContent = fileName;
        });

        // Initial display
        displayImages();
    </script>
</body>

</html>