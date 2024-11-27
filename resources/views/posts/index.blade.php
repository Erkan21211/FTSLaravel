<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ttg Pagina</title>
    <!-- Voeg Bootstrap CDN toe voor styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-..." crossorigin="anonymous">
</head>
<body class="font-sans antialiased">
<div class="container mt-4">
    <h1 class="mb-4" style="padding: 15px">Welcome to the Blog Page</h1>

    <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">Create New Post</a>


    <table class="table table-bordered">
        <thead class="table-dark">
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>User Name</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($posts as $post) <!-- Iterate through each post -->
        <tr>
            <td>{{ $post->title }}</td>
            <td>{{ $post->content ?? 'No description available' }}</td>
            <td>{{ $post->user ? $post->user->name : 'No user found' }}</td>
            <td>
                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning btn-sm">Update</a>
                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this post?');">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>

<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-..." crossorigin="anonymous"></script>
</body>
</html>
