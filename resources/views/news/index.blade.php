@extends('layouts.app')

@section('title', 'News')

@section('content')
    <div class="flex justify-between items-center mb-12">
        <div>
            <h1 class="text-5xl font-extralight tracking-tight text-gray-900 dark:text-white mb-2">Latest News</h1>
            <p class="text-gray-500 dark:text-gray-400 font-light flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Stay updated with fitness trends and tips
            </p>
        </div>

        @auth
            <a class="group inline-flex items-center gap-2 px-6 py-3 bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-lg transition-all duration-300 hover:bg-gray-800 dark:hover:bg-gray-100 hover:shadow-lg hover:-translate-y-0.5 font-medium text-sm" href="{{ route('news.create') }}">
                <svg class="w-4 h-4 transition-transform group-hover:rotate-90 duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Create News
            </a>
        @endauth
    </div>

    <!-- Search Bar -->
    <div class="mb-8">
        <form method="GET" action="{{ route('news.index') }}" class="relative">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search news by title or content..." class="w-full px-5 py-3 pl-12 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white font-light focus:border-gray-900 dark:focus:border-gray-400 focus:ring-2 focus:ring-gray-900 dark:focus:ring-gray-400 transition-all">
            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            @if(request('search'))
                <a href="{{ route('news.index') }}" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </a>
            @endif
        </form>
        @if(request('search'))
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 font-light">
                Showing results for "<span class="font-medium">{{ request('search') }}</span>"
            </p>
        @endif
    </div>

    @if(isset($tags) && $tags->count() > 0)
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-4">
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                <h2 class="text-lg font-light text-gray-900 dark:text-white">Filter by Tag</h2>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('news.index') }}" class="inline-flex items-center px-4 py-2 rounded-full text-sm font-light transition-all {{ !request('tag') ? 'bg-gray-900 dark:bg-white text-white dark:text-gray-900' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                    All
                </a>
                @foreach($tags as $tag)
                    <a href="{{ route('news.index', ['tag' => $tag->id]) }}" class="inline-flex items-center px-4 py-2 rounded-full text-sm font-light transition-all {{ request('tag') == $tag->id ? 'bg-gray-900 dark:bg-white text-white dark:text-gray-900' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                        {{ $tag->name }}
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($news as $item)
            <article class="group bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden transition-all hover:border-gray-400 dark:hover:border-gray-500 hover:shadow-2xl hover:-translate-y-1 duration-300 cursor-pointer news-item" data-news-id="{{ $item->id }}">
                @if($item->image_path)
                    <div class="relative h-56 overflow-hidden bg-gray-100 dark:bg-gray-900">
                        <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" src="{{ asset('storage/' . $item->image_path) }}" alt="News image">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                @endif

                <div class="p-6">
                    <div class="text-xl font-light text-gray-900 dark:text-white transition-colors mb-3 line-clamp-2 group-hover:text-gray-700 dark:group-hover:text-gray-200">
                        {{ $item->title }}
                    </div>

                    <div class="flex items-center gap-3 text-xs text-gray-500 dark:text-gray-400 mb-4 pb-4 border-b border-gray-100 dark:border-gray-700">
                        @if($item->published_at) 
                            <time class="flex items-center gap-1" datetime="{{ $item->published_at->toIso8601String() }}">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $item->published_at->format('M d, Y') }}
                            </time>
                        @endif
                        <span class="opacity-50">•</span>
                        <span class="flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            {{ $item->user->username ?? $item->user->name }}
                        </span>
                    </div>

                    @if($item->tags->count() > 0)
                        <div class="flex flex-wrap gap-1.5 mb-4">
                            @foreach($item->tags as $tag)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-light bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    @endif

                    <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed line-clamp-3 font-light">
                        {{ \Illuminate\Support\Str::limit($item->content, 120) }}
                    </p>
                </div>
            </article>
        @empty
            <p class="text-gray-600 dark:text-gray-300">No news yet.</p>
        @endforelse
    </div>

    @if($news->count() > 0)
        <div class="mt-12 flex justify-center">
            {{ $news->links() }}
        </div>
    @endif

    <!-- Modal para mostrar detalles de la noticia -->
    <div id="newsModal" class="fixed inset-0 bg-black/60 z-50 hidden items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-900 rounded-lg max-w-4xl w-full max-h-[90vh] overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="sticky top-0 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 p-6 flex justify-between items-center z-10">
                <h2 id="modalTitle" class="text-2xl font-light text-gray-900 dark:text-white"></h2>
                <div class="flex items-center gap-3">
                    @auth
                        <button id="deleteNewsBtn" onclick="openDeleteNewsModal()" class="hidden text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 transition-colors p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    @endauth
                    <button onclick="closeNewsModal()" class="text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="overflow-y-auto max-h-[calc(90vh-80px)]">
                <div id="modalImage" class="w-full bg-gray-100 dark:bg-gray-800"></div>
                
                <div class="p-8">
                    <div id="modalMeta" class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400 mb-6 pb-6 border-b border-gray-200 dark:border-gray-700"></div>
                    
                    <div id="modalContent" class="prose dark:prose-invert prose-lg max-w-none text-gray-700 dark:text-gray-300 whitespace-pre-wrap leading-relaxed font-light"></div>
                    
                    <!-- Sección de comentarios -->
                    <div id="modalCommentsSection" class="mt-10 pt-8 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-3 mb-6">
                            <svg class="w-6 h-6 text-gray-900 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <h3 class="text-xl font-light text-gray-900 dark:text-white">Comments</h3>
                            <span id="commentsCount" class="ml-auto text-sm text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-full"></span>
                        </div>

                        @auth
                            <div class="mb-8 bg-white dark:bg-gray-900 p-6 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 hover:border-gray-400 dark:hover:border-gray-500 transition-all duration-300">
                                <form id="commentForm" class="space-y-4">
                                    @csrf
                                    <input type="hidden" id="newsIdInput" name="news_id">
                                    <div>
                                        <textarea name="body" id="commentBody" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white font-light focus:border-gray-900 dark:focus:border-gray-400 focus:ring-2 focus:ring-gray-900 dark:focus:ring-gray-400 text-sm resize-none transition-all" rows="3" required maxlength="1000" placeholder="Write a comment..."></textarea>
                                    </div>
                                    <div class="flex justify-end">
                                        <button type="submit" class="group bg-gray-900 dark:bg-white hover:bg-gray-800 dark:hover:bg-gray-100 text-white dark:text-gray-900 px-6 py-2.5 rounded-lg transition-all duration-300 text-sm font-light shadow-md hover:shadow-xl hover:-translate-y-0.5">
                                            <span class="flex items-center gap-2">
                                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-0.5 duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                                </svg>
                                                Post Comment
                                            </span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @else
                            <div class="mb-8 bg-white dark:bg-gray-900 p-6 rounded-xl border border-gray-300 dark:border-gray-600 text-center">
                                <p class="text-gray-700 dark:text-gray-300 text-sm font-light">
                                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    Please <a href="{{ route('login') }}" class="font-medium text-gray-900 dark:text-white hover:underline">login</a> to comment
                                </p>
                            </div>
                        @endauth

                        <div id="commentsList" class="space-y-4"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación para borrar comentario -->
    <div id="deleteModal" class="fixed inset-0 bg-black/60 z-[60] hidden items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-900 rounded-lg max-w-md w-full p-6 border border-gray-200 dark:border-gray-700 shadow-2xl">
            <div class="flex items-center gap-3 mb-4">
                <div class="p-2 bg-red-100 dark:bg-red-900/30 rounded-full">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Delete Comment</h3>
            </div>
            <p class="text-gray-600 dark:text-gray-400 mb-6 font-light">
                Are you sure you want to delete this comment? This action cannot be undone.
            </p>
            <div class="flex gap-3 justify-end">
                <button onclick="closeDeleteModal()" class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors font-light">
                    Cancel
                </button>
                <button id="confirmDeleteBtn" class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white transition-colors font-light">
                    Delete
                </button>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación para borrar post -->
    <div id="deleteNewsModal" class="fixed inset-0 bg-black/60 z-[70] hidden items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-900 rounded-lg max-w-md w-full p-6 border border-gray-200 dark:border-gray-700 shadow-2xl">
            <div class="flex items-center gap-3 mb-4">
                <div class="p-2 bg-red-100 dark:bg-red-900/30 rounded-full">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Delete News Post</h3>
            </div>
            <p class="text-gray-600 dark:text-gray-400 mb-6 font-light">
                Are you sure you want to delete this news post? This will also delete all comments. This action cannot be undone.
            </p>
            <div class="flex gap-3 justify-end">
                <button onclick="closeDeleteNewsModal()" class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors font-light">
                    Cancel
                </button>
                <button id="confirmDeleteNewsBtn" class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white transition-colors font-light">
                    Delete Post
                </button>
            </div>
        </div>
    </div>

    <script>
        let currentNewsId = null;
        const currentUserId = {!! auth()->id() ?? 'null' !!};
        const isAdmin = {{ auth()->check() && auth()->user()->is_admin ? 'true' : 'false' }};

        function openNewsModal(newsId) {
            const modal = document.getElementById('newsModal');
            currentNewsId = newsId;
            
            // Mostrar el modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            // Hacer petición para obtener los detalles
            fetch(`/news/${newsId}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('modalTitle').textContent = data.title;
                document.getElementById('modalMeta').innerHTML = `
                    <time class="font-medium">${data.published_at}</time>
                    <span>•</span>
                    <span class="font-medium">${data.user.name}</span>
                `;
                
                if (data.image_path) {
                    document.getElementById('modalImage').innerHTML = `
                        <img src="/storage/${data.image_path}" 
                             alt="News image" 
                             class="w-full object-cover max-h-[400px]">
                    `;
                } else {
                    document.getElementById('modalImage').innerHTML = '';
                }
                
                document.getElementById('modalContent').textContent = data.content;
                
                // Actualizar contador de comentarios
                document.getElementById('commentsCount').textContent = `${data.comments_count} ${data.comments_count === 1 ? 'Comment' : 'Comments'}`;
                
                // Actualizar input oculto con el news_id
                const newsIdInput = document.getElementById('newsIdInput');
                if (newsIdInput) {
                    newsIdInput.value = newsId;
                }
                
                // Mostrar/ocultar botón de eliminar post
                const deleteNewsBtn = document.getElementById('deleteNewsBtn');
                if (deleteNewsBtn && currentUserId !== null) {
                    if (isAdmin || data.user.id === currentUserId) {
                        deleteNewsBtn.classList.remove('hidden');
                    } else {
                        deleteNewsBtn.classList.add('hidden');
                    }
                }
                
                // Renderizar comentarios
                renderComments(data.comments, data.user.id);
            })
            .catch(error => {
                console.error('Error loading news:', error);
                closeNewsModal();
            });
        }

        function renderComments(comments, newsAuthorId) {
            const commentsList = document.getElementById('commentsList');
            const currentUserId = {!! auth()->id() ?? 'null' !!};
            const isAdmin = {!! auth()->check() && auth()->user()->can('admin') ? 'true' : 'false' !!};
            
            if (comments.length === 0) {
                commentsList.innerHTML = `
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <p class="text-gray-500 dark:text-gray-400 font-light">No comments yet</p>
                        <p class="text-sm text-gray-400 dark:text-gray-500 mt-1 font-light">Be the first to comment!</p>
                    </div>
                `;
                return;
            }
            
            commentsList.innerHTML = comments.map(comment => {
                const canDelete = currentUserId && (currentUserId === comment.user.id || isAdmin);
                const deleteButton = canDelete ? `
                    <button onclick="deleteComment(${comment.id})" class="text-xs text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 font-medium flex items-center gap-1 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Delete
                    </button>
                ` : '';
                
                return `
                    <div class="group bg-white dark:bg-gray-800 rounded-xl p-6 hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700 hover:border-gray-400 dark:hover:border-gray-500">
                        <div class="flex gap-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-full bg-gray-900 dark:bg-white flex items-center justify-center text-white dark:text-gray-900 font-light text-sm shadow-md">
                                    ${comment.user.name.substring(0, 2).toUpperCase()}
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-2">
                                        <span class="font-light text-gray-900 dark:text-white">${comment.user.name}</span>
                                        <span class="text-gray-400 dark:text-gray-500">•</span>
                                        <time class="text-xs text-gray-500 dark:text-gray-400 font-light">${comment.created_at}</time>
                                    </div>
                                    ${deleteButton}
                                </div>
                                <p class="text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-wrap font-light">${comment.body}</p>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
        }

        @auth
        // Manejar envío de comentario
        document.getElementById('commentForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitButton = this.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.innerHTML;
            
            submitButton.disabled = true;
            submitButton.innerHTML = '<span class="flex items-center gap-2"><svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Posting...</span>';
            
            fetch(`/news/${currentNewsId}/comments`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Limpiar formulario
                    document.getElementById('commentBody').value = '';
                    
                    // Recargar los datos del modal
                    openNewsModal(currentNewsId);
                }
            })
            .catch(error => {
                console.error('Error posting comment:', error);
                alert('Error posting comment. Please try again.');
            })
            .finally(() => {
                submitButton.disabled = false;
                submitButton.innerHTML = originalButtonText;
            });
        });

        let commentToDelete = null;

        function openDeleteModal(commentId) {
            commentToDelete = commentId;
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeDeleteModal() {
            commentToDelete = null;
            const modal = document.getElementById('deleteModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function deleteComment(commentId) {
            openDeleteModal(commentId);
        }

        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (!commentToDelete) return;
            
            fetch(`/news-comments/${commentToDelete}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeDeleteModal();
                    // Recargar los datos del modal
                    openNewsModal(currentNewsId);
                }
            })
            .catch(error => {
                console.error('Error deleting comment:', error);
                alert('Error deleting comment. Please try again.');
                closeDeleteModal();
            });
        });

        // Cerrar modal al hacer click fuera
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        // Funciones para modal de borrar post
        function openDeleteNewsModal() {
            const modal = document.getElementById('deleteNewsModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeDeleteNewsModal() {
            const modal = document.getElementById('deleteNewsModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        document.getElementById('confirmDeleteNewsBtn').addEventListener('click', function() {
            if (!currentNewsId) return;
            
            fetch(`/news/${currentNewsId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeDeleteNewsModal();
                    closeNewsModal();
                    // Recargar la página para actualizar la lista
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error deleting news:', error);
                alert('Error deleting news post. Please try again.');
                closeDeleteNewsModal();
            });
        });

        // Cerrar modal de borrar post al hacer click fuera
        document.getElementById('deleteNewsModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteNewsModal();
            }
        });
        @endauth

        function closeNewsModal() {
            const modal = document.getElementById('newsModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            currentNewsId = null;
        }

        // Cerrar modal al hacer clic fuera del contenido
        document.getElementById('newsModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeNewsModal();
            }
        });

        // Cerrar modal con la tecla Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeNewsModal();
            }
        });

        // Agregar event listener a todos los artículos de noticias
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.news-item').forEach(item => {
                item.addEventListener('click', function() {
                    const newsId = this.dataset.newsId;
                    openNewsModal(newsId);
                });
            });
        });
    </script>
@endsection
