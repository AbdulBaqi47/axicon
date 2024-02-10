@if (count($comments) > "0")

    @foreach ($comments as $comment)

        <div class="card mb-3">
            <div class="card-body">
                <div class="media">
                    <img src="{{ asset('storage/photos/avatars/'.$comment->user_avatar) }}" draggable="false" alt="User logo" class="d-block ui-w-40 rounded-circle">
                    <div class="media-body ml-4">
                        <div class="float-right text-muted small">{{ $comment->created_at->diffForHumans() }}</div>
                        <div>{{ $comment->user_name }}</div>
                        <div class="text-muted small">{{ $comment->user_role }}</div>
                        <div class="mt-2">
                            {!! htmlspecialchars_decode($comment->comment) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endforeach
    
@endif