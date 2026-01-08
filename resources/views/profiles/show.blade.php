@extends('layouts.app')

@section('title', $user->username ?? $user->name)

@section('content')
    <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 max-w-2xl mx-auto mb-8 transition-colors duration-300">
        <div class="flex flex-col items-center text-center">
            @if($user->profile_photo_path)
                <img
                    src="{{ asset('storage/' . $user->profile_photo_path) }}"
                    class="w-32 h-32 rounded-full object-cover border-4 border-gray-50 dark:border-gray-700 shadow-sm mb-4"
                    alt="Profile photo"
                >
            @else
                <div class="w-32 h-32 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mb-4 text-gray-400 dark:text-gray-500 text-4xl font-bold">
                    {{ substr($user->username ?? $user->name, 0, 1) }}
                </div>
            @endif

            <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white mb-2">
                {{ $user->username ?? $user->name }}
            </h1>

            @if($user->birthday)
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                    Born {{ $user->birthday->format('F j, Y') }}
                </p>
            @endif

            @if($user->bio)
                <p class="text-gray-600 dark:text-gray-300 max-w-lg leading-relaxed">{{ $user->bio }}</p>
            @endif

            <!-- User Statistics -->
            <div class="mt-6 flex items-center gap-6 text-center">
                <div class="flex flex-col">
                    <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->profilePosts->count() }}</span>
                    <span class="text-xs text-gray-500 dark:text-gray-400 font-light">Wall Posts</span>
                </div>
                <div class="w-px h-8 bg-gray-300 dark:bg-gray-600"></div>
                <div class="flex flex-col">
                    <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->newsComments->count() }}</span>
                    <span class="text-xs text-gray-500 dark:text-gray-400 font-light">Comments</span>
                </div>
                <div class="w-px h-8 bg-gray-300 dark:bg-gray-600"></div>
                <div class="flex flex-col">
                    <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->news->count() }}</span>
                    <span class="text-xs text-gray-500 dark:text-gray-400 font-light">News Posts</span>
                </div>
            </div>

            <div class="mt-4 text-xs text-gray-500 dark:text-gray-400 font-light flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Member since {{ $user->created_at->format('F Y') }}
            </div>

            @auth
                @if(auth()->id() === $user->id)
                    <a class="mt-6 inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:focus:ring-gray-400 transition-colors"
                       href="{{ route('profiles.edit') }}">
                        Edit profile
                    </a>
                @endif
            @endauth
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 max-w-2xl mx-auto transition-colors duration-300">
        <div class="flex items-center gap-3 mb-6">
            <svg class="w-6 h-6 text-gray-900 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
            </svg>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Profile Wall</h2>
            <span class="ml-auto text-sm text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-full">{{ $user->profilePosts->count() }}</span>
        </div>

        @auth
            <div class="mb-8 bg-white dark:bg-gray-900 p-6 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 hover:border-gray-400 dark:hover:border-gray-500 transition-all duration-300">
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 rounded-full bg-gray-900 dark:bg-white flex items-center justify-center text-white dark:text-gray-900 font-light text-sm shadow-md">
                            {{ strtoupper(substr(auth()->user()->username ?? auth()->user()->name, 0, 2)) }}
                        </div>
                    </div>
                    <form method="POST" action="{{ route('profiles.posts.store', $user) }}" class="flex-1 space-y-4">
                        @csrf
                        <div>
                            <textarea name="body" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white font-light focus:border-gray-900 dark:focus:border-gray-400 focus:ring-2 focus:ring-gray-900 dark:focus:ring-gray-400 text-sm resize-none transition-all" rows="3" required maxlength="1000"
                                      placeholder="Leave a message on {{ $user->username ?? $user->name }}'s wall...">{{ old('body') }}</textarea>
                            @error('body') <p class="text-red-600 dark:text-red-400 text-sm mt-2 flex items-center gap-1"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>{{ $message }}</p> @enderror
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-500 dark:text-gray-400 font-light flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                Say something nice!
                            </span>
                            <button type="submit" class="group bg-gray-900 dark:bg-white hover:bg-gray-800 dark:hover:bg-gray-100 text-white dark:text-gray-900 px-6 py-2.5 rounded-lg transition-all duration-300 text-sm font-light shadow-md hover:shadow-xl hover:-translate-y-0.5">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-0.5 duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                    Post Message
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @else
            <div class="mb-8 bg-white dark:bg-gray-900 p-6 rounded-xl border border-gray-300 dark:border-gray-600 text-center">
                <p class="text-gray-700 dark:text-gray-300 text-sm font-light">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    Please <a href="{{ route('login') }}" class="font-medium text-gray-900 dark:text-white hover:underline">login</a> to leave a message
                </p>
            </div>
        @endauth

        <div class="space-y-4">
            @forelse($user->profilePosts as $p)
                <div class="group bg-white dark:bg-gray-800 rounded-xl p-6 hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700 hover:border-gray-400 dark:hover:border-gray-500 cursor-pointer profile-post-item" data-post-id="{{ $p->id }}">
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-gray-900 dark:bg-white flex items-center justify-center text-white dark:text-gray-900 font-light text-sm shadow-md group-hover:shadow-lg transition-shadow">
                                {{ strtoupper(substr($p->author->username ?? $p->author->name, 0, 2)) }}
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-gray-900 dark:text-white">{{ $p->author->username ?? $p->author->name }}</span>
                                    <span class="text-gray-400 dark:text-gray-500">•</span>
                                    <time class="text-xs text-gray-500 dark:text-gray-400" datetime="{{ $p->created_at->toIso8601String() }}">
                                        {{ $p->created_at->diffForHumans() }}
                                    </time>
                                    @auth
                                        @if(auth()->id() === $p->author_user_id)
                                            <span class="ml-2 text-xs bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300 px-2 py-0.5 rounded-full font-medium">You</span>
                                        @endif
                                    @endauth
                                </div>
                                
                                @auth
                                    @if(auth()->user()->can('admin') || auth()->id() === $p->author_user_id || auth()->id() === $p->profile_user_id)
                                        <form method="POST" action="{{ route('profiles.posts.destroy', $p) }}" onsubmit="return confirm('Delete this message?');" onclick="event.stopPropagation();">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 font-medium flex items-center gap-1 transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-wrap">{{ $p->body }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400 font-medium">No messages yet</p>
                    <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Be the first to leave a message!</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Modal para mostrar detalles del post -->
    <div id="postModal" class="fixed inset-0 bg-black/60 z-50 hidden items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-900 rounded-lg max-w-2xl w-full max-h-[90vh] overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="sticky top-0 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 p-6 flex justify-between items-center z-10">
                <h2 class="text-xl font-light text-gray-900 dark:text-white">Wall Post</h2>
                <button onclick="closePostModal()" class="text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="overflow-y-auto max-h-[calc(90vh-80px)]">
                <div class="p-6">
                    <div class="flex gap-4 mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                        <div id="modalAvatar" class="flex-shrink-0"></div>
                        <div class="flex-1">
                            <div id="modalAuthor" class="font-medium text-lg text-gray-900 dark:text-white"></div>
                            <div id="modalTime" class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-2 mt-1"></div>
                        </div>
                    </div>
                    
                    <div id="modalBody" class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 whitespace-pre-wrap text-base leading-relaxed mb-8 bg-gray-50 dark:bg-gray-800 p-6 rounded-lg border border-gray-200 dark:border-gray-700 font-light"></div>

                    <!-- Comments Section -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            Comments
                            <span id="commentsCount" class="text-sm bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 px-3 py-1 rounded-full font-medium border border-gray-200 dark:border-gray-700"></span>
                        </h3>

                    @auth
                        <form id="commentForm" class="mb-6 bg-gray-50 dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                            @csrf
                            <input type="hidden" id="postIdInput" name="post_id">
                            <div class="flex gap-3">
                                <textarea name="body" id="commentBody" rows="2" class="flex-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-gray-900 dark:focus:border-white focus:ring-1 focus:ring-gray-900 dark:focus:ring-white text-sm" placeholder="Add a comment..." required maxlength="1000"></textarea>
                                <button type="submit" class="self-start bg-gray-900 dark:bg-white text-white dark:text-gray-900 px-5 py-2.5 rounded-md transition-all duration-200 text-sm font-medium hover:bg-gray-800 dark:hover:bg-gray-100">
                                    Post
                                </button>
                            </div>
                        </form>
                    @endauth

                    <div id="commentsList" class="space-y-3"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentPostId = null;

        function openPostModal(postId) {
            currentPostId = postId;
            const modal = document.getElementById('postModal');
            
            // Mostrar el modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            loadPostData(postId);
        }

        function loadPostData(postId) {
            // Hacer petición para obtener los detalles
            fetch(`/posts/${postId}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                const initials = data.author.name.substring(0, 2).toUpperCase();
                document.getElementById('modalAvatar').innerHTML = `
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-orange-400 to-red-500 flex items-center justify-center text-white font-bold text-xl shadow-lg ring-4 ring-orange-100 dark:ring-orange-900">
                        ${initials}
                    </div>
                `;
                
                document.getElementById('modalAuthor').textContent = data.author.name;
                document.getElementById('modalTime').innerHTML = `
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <time datetime="${data.created_at}">${data.created_at_human}</time>
                    <span class="mx-2">•</span>
                    <span>${data.created_at}</span>
                `;
                
                document.getElementById('modalBody').textContent = data.body;
                document.getElementById('commentsCount').textContent = data.comments.length;
                document.getElementById('postIdInput').value = postId;
                
                // Render comments
                renderComments(data.comments);
            })
            .catch(error => {
                console.error('Error loading post:', error);
                closePostModal();
            });
        }

        function renderComments(comments) {
            const commentsList = document.getElementById('commentsList');
            
            if (comments.length === 0) {
                commentsList.innerHTML = '<div class="text-center py-8 bg-gray-50 dark:bg-gray-900 rounded-xl"><svg class="w-12 h-12 mx-auto text-gray-300 dark:text-gray-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg><p class="text-sm text-gray-500 dark:text-gray-400 font-medium">No comments yet</p><p class="text-xs text-gray-400 dark:text-gray-500">Be the first to comment!</p></div>';
                return;
            }

            commentsList.innerHTML = comments.map(comment => {
                const initials = comment.user.name.substring(0, 2).toUpperCase();
                return `
                    <div class="bg-gradient-to-r from-gray-50 to-white dark:from-gray-900 dark:to-gray-800 rounded-xl p-4 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow">
                        <div class="flex gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-white font-bold text-sm flex-shrink-0 shadow-md">
                                ${initials}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-bold text-sm text-gray-900 dark:text-white">${comment.user.name}</span>
                                    <div class="flex items-center gap-3">
                                        <time class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            ${comment.created_at_human}
                                        </time>
                                        ${comment.can_delete ? `
                                            <button onclick="deleteComment(${comment.id})" class="text-xs text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 font-semibold flex items-center gap-1 hover:bg-red-50 dark:hover:bg-red-900/20 px-2 py-1 rounded transition-colors">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                Delete
                                            </button>
                                        ` : ''}
                                    </div>
                                </div>
                                <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap leading-relaxed">${comment.body}</p>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
        }

        @auth
        // Handle comment submission
        document.getElementById('commentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const postId = currentPostId;
            const body = document.getElementById('commentBody').value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            
            fetch(`/profile-posts/${postId}/comments`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ body: body })
            })
            .then(response => response.json())
            .then(data => {
                // Reload post data to show new comment
                loadPostData(postId);
                document.getElementById('commentBody').value = '';
            })
            .catch(error => {
                console.error('Error posting comment:', error);
                alert('Error posting comment. Please try again.');
            });
        });
        @endauth

        function deleteComment(commentId) {
            if (!confirm('Delete this comment?')) return;
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            
            fetch(`/profile-post-comments/${commentId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Reload post data to update comments
                loadPostData(currentPostId);
            })
            .catch(error => {
                console.error('Error deleting comment:', error);
                alert('Error deleting comment. Please try again.');
            });
        }

        function closePostModal() {
            const modal = document.getElementById('postModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Cerrar modal al hacer clic fuera del contenido
        document.getElementById('postModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closePostModal();
            }
        });

        // Cerrar modal con la tecla Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closePostModal();
            }
        });

        // Agregar event listener a todos los posts de perfil
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.profile-post-item').forEach(item => {
                item.addEventListener('click', function() {
                    const postId = this.dataset.postId;
                    openPostModal(postId);
                });
            });
        });
    </script>
@endsection
