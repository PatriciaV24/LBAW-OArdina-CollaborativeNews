<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return !($user->is_banned || $user->is_deleted);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Comment $comment
     *
     * @return mixed
     */
    public function view(?User $user, Comment $comment)
    {
        if ($comment->content->author->is_banned || $comment->content->author->is_deleted) {
            return Response::deny('The user that created this comment is either banned or deleted.');
        } else {
            return !(optional($user)->is_banned || optional($user)->is_deleted);
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return !($user->is_banned || $user->is_deleted);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Comment $comment
     *
     * @return mixed
     */
    public function update(User $user, Comment $comment)
    {
        return $user->id === $comment->content->author_id && !($user->is_banned || $user->is_deleted);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Comment $comment
     *
     * @return mixed
     */
    public function delete(User $user, Comment $comment)
    {
        // Only a news author can delete it or a admin
        return ($user->id === $comment->content->author_id && !($user->is_banned || $user->is_deleted)) || ($user->is_admin && !($user->is_banned || $user->is_deleted));
    }

}
